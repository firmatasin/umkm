<?php session_start(); ?>
<?php require_once "support/myfunction.php"; ?>
<?php

$tabel          = "pembuatan"; // nama tabel
$index          = "id"; // index / primary key
$fileutama      = "pembuatan.php"; // fil utama dari program kerja
$fileupdate     = "pembuatanform.php"; // file untuk update data
$caption        = "PEMBUATAN"; // caption ack
$captionTambah  = $caption . " Baru"; // captio tambah

// refernsi
$tabelRef = "tb_pokja";   // tabel referensi
$indexRef = "id_pokja";   // index pokja

$tombol_caption = null;
$mode = null;

// ambil tipe data dan field tabel berita
$labelarr = load_field_data($tabel);
$datatype = load_type_of_data($tabel);
$dataarr = null;
$total = count($labelarr);

//var_dump($datatype);

// proses edit atau tambah
if (isset($_GET['mode'])) {
  if ($_GET["mode"] == "edit") {
    // prosses untuk menampilkan data untuk update
    $mode = "edit";
    $dataarr = load_data_from_speisifk_tabel($tabel, $index, $_GET["id"]);
    $tombol_caption = "Update Data";
  }else if($_GET["mode"] == "tambah"){
    // persiapan variabel untuk tambah data
    $mode = "tambah";
    $tombol_caption = "Tambah Data";
  }else if($_GET["mode"] == "hapus") {
    $namagambar = get_nama_file($labelarr, $tabel, $index, $_GET["id"]);
    $status = proses_hapus_data($tabel, $index, $_GET["id"]);

    if ($status) {
      // hapus image
      unlink('images/' . $namagambar);
      echo "message: data berhasil dihapus..";
      header("location: " . $fileutama);
      exit();
    }
  }
}

// seluruh proses data baik update maupun tambah data
if (isset($_POST["proses"])) {
  if ($_POST["proses"] == "update")
  {
    $status = proses_update_data( $tabel, 
                                  $_POST["myname"], 
                                  $labelarr, 
                                  $_POST["myname"][0], 
                                  $index, 1);
                                  // jika menggunakan gambar,
                                  // masukkan $exclude = 1

    if ($status) {
      // jika sukses update data
      // maka upload data dan update foto
      proses_update_foto($tabel, $_FILES["fileToUpload"], $index, $_POST["myname"][0], "update");
      header("location: " . $fileutama);
      exit();
    }
  }else if($_POST["proses"] == "tambah") {
    $status = proses_tambah_data($_POST["myname"], $labelarr, $tabel, 1); // gunakan 1 exclude

    if ($status) {
      // ambil gambar
      // jika menggunakan gambar aktifkan kedua fungsi ini
      $lastid = get_last_id($tabel, $index);
      proses_update_foto($tabel, $_FILES["fileToUpload"], $index, $lastid);
      // aktifkan fungsi datas
      header("location: " . $fileutama);
      exit();
    }
  }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PENGATURAN DATA PEMBUATAN</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">

  <!-- link css boostrat -->
  <link rel="stylesheet" href="plugins/bootstrap5.3.3/css/bootstrap.min.css" />

  <!-- link jquery dan javascript -->
  <script src="plugins/bootstrap5.3.3/js/bootstrap.min.js"></script>

  <!--DATA TABLE -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!--/*DATA TABLE -->

</head>

<body class="hold-transition sidebar-mini">
  <!-- Site wrapper -->
  <div class="wrapper">
    <!-- Navbar -->
    <?php include ('support/_navbar.php'); ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include ('support/_sidebar.php'); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Pembuatan</h1>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <!-- Default box -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Pengaturan Data Pembuatan</h3>
            <div class="float-right">
              <a href="<?php echo $fileutama; ?>" type="button" class="btn btn-primary">Back to <?php echo $caption; ?></a>
            </div>
          </div>
          <div class="card-body">
            <!-- ISI KONTEN -->
            <div class="container">
              <!-- form -->
              <form action="#" method="POST" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
                <div class="modal-header">
                </div>
                <div class="modal-body">

                <!-- Form Dinamis: awal -->
                <?php make_dynamic_form ( $labelarr, 
                                          $datatype, 
                                          $dataarr,
                                          array(),
                                          array(),
                                          $total, 
                                          $index); ?>
                <!-- From Dinamis: akhir -->

                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-primary"><?php echo $tombol_caption; ?></button>
                  <input type="hidden" name="mode" value="<?php echo $mode; ?>" />
                  <input type="hidden" name="proses" value="<?php if ($mode == "edit") { echo "update"; }else{ echo "tambah"; }; ?>" />
                </div>
              </form>

            </div>
            <!-- /*ISI KONTEN -->
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            Pembuatan
          </div>
          <!-- /.card-footer-->
        </div>
        <!-- /.card -->

      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php footer(); ?>

  </div>
  <!-- ./wrapper -->

  <?php include ('support/_script.php'); ?>

  <!--DATA TABLE-->
  <!-- DataTables  & Plugins -->
  <script src="plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="plugins/jszip/jszip.min.js"></script>
  <script src="plugins/pdfmake/pdfmake.min.js"></script>
  <script src="plugins/pdfmake/vfs_fonts.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

  <script>
    $(function () {
      $("#tabel").DataTable({
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      }).buttons().container().appendTo('#tabel_wrapper .col-md-6:eq(0)');
    });
  </script>
  <!--/*DATA TABLE-->

<!-- toast -->
  <div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <img src="..." class="rounded me-2" alt="...">
      <strong class="me-auto">Bootstrap</strong>
      <small>11 mins ago</small>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      data berhasil di update
    </div>
  </div>
</div>

<script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(() => {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }

      form.classList.add('was-validated')
    }, false)
  })
})()
</script>

</body>

</html>

