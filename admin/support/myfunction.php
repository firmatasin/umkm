<?php

require_once "config.inc.php";

function get_koneksi()
{
    $koneksi = mysqli_connect(
        PARAM_HOST,
        PARAM_USER,
        PARAM_PASS,
        PARAM_DB,
        PARAM_PORT
    );

    // Check connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }

    return $koneksi;
}

function do_destroy_koneksi()
{
    mysqli_close(get_koneksi());
}

function cek_jika_belum_login()
{
    if (!isset($_SESSION["log"])) {
        echo "<br />";
        echo "<div class=\"card\">
            <div class=\"card-body\">
                Maaf, anda belum melakukan login. <a href=\"login.php\">Silahkan login dahulu</a>.
            </div>
        </div>";
        exit();
    }
}

function logout()
{
    $_SESSION["log"] = false;
    unset($_SESSION["log"]);
    session_destroy();
    header('location:../index.php');
    exit;
}

function footer()
{
    echo "<footer class=\"main-footer\">
        <div class=\"float-right d-none d-sm-block\">
            <b>" . FOOTER_VERSI . "</b> " . FOOTER_VERSI_APLIAKSI . " 
        </div>
        <strong>" . FOOTER_COPYRIGHT . " " . FOOTER_COPYRIGHT_TAHUN . " <a href=\"https:ti.polnustar.ac.id\">" . FOOTER_COPYRIGHT_NAMA .
        "</a>.</strong> SENTRA BAMBU BATIK BOWONGKU.";

}

function login($user, $pass)
{
    // Cek Login, terdaftar atau tidak
    if (get_koneksi()) {
        if (!empty($user) && !empty($pass)) {
            $username = $user; //$_POST['username'];
            $password = $pass; //$_POST['password'];

            // Perlakukan input untuk mencegah SQL injection
            $username = mysqli_real_escape_string(get_koneksi(), $username);
            $password = mysqli_real_escape_string(get_koneksi(), $password);

            // Query SQL untuk mencari data user
            $sql = "SELECT * FROM akun WHERE username='$username' AND password=sha1('$password')";
            $query = mysqli_query(get_koneksi(), $sql);
            $result = mysqli_fetch_assoc($query);

            // Hitung jumlah data yang ditemukan
            $hitung = mysqli_num_rows($query);

            if ($hitung > 0) {
                $_SESSION['log'] = true; // Gunakan boolean true, bukan string 'true'

                // ambil hak akses
                $_SESSION["hakakses"] = $result["hak_akses"];

                // close connection
                do_destroy_koneksi();

                // jumper
                header('location:index.php');
                exit; // Penting: setelah header location, pastikan untuk exit
            } else {
                // close connection
                do_destroy_koneksi();

                header('location:login.php');
                exit;
            }
        }
    }
}

function jump_if_login_sucess()
{
    if (isset($_SESSION['log'])) {
        header('location:index.php');
        exit;
    }
}


function load_data_from_speisifk_tabel($tabel, $key, $id)
{
    if (get_koneksi()) {
        $data_arr = array();

        $sql = "select * from " . $tabel . " where " . $key . " = " . $id;
        $query = mysqli_query(get_koneksi(), $sql);
        $result = mysqli_fetch_array($query);

        while ($info = mysqli_fetch_field($query)) {
            $data_arr[] = $result[$info->name];
        }

        mysqli_free_result($query);
        do_destroy_koneksi();

        return $data_arr;
    }

}

function load_field_data($tabel)
{
    if (get_koneksi()) {
        $arr_label = array();
        $sql = "select * from " . $tabel;
        $query = mysqli_query(get_koneksi(), $sql);
        $result = mysqli_fetch_array($query);

        while ($info = mysqli_fetch_field($query)) {
            $arr_label[] = $info->name;
        }

        mysqli_free_result($query);
        do_destroy_koneksi();

        return $arr_label;
    }
}


function get_data_type($number)
{
    $numbertostr = null;
    switch ($number) {
        case 16:    //"BIT";
        case 1:     //"TINYINT or BOOL";
        case 2:     //"SMALLINT";
        case 9:     //"MEDIUMINT";
        case 3:     //"INT";
        case 8:     //"BIGINT or SERIAL";
        case 4:     //"FLOAT";
        case 5:     //"DOUBLE";
        case 246:   //"NUMERIC or DECIMAL or FIXED";
            $numbertostr = "NUMBER";
            break;

        case 10:    //"DATE";
        case 12:    //"DATETIME";
        case 11:    //"TIME";
        case 13:    //"YEAR";
            $numbertostr = "DATE";
            break;

        case 254:   //"CHAR or ENUM or SET or BINARY";
            $numbertostr = "ENUM";
            break;

        case 253:   //"VARCHAR or VARBINARY";
            $numbertostr = "VARCHAR";
            break;

        case 252:   //"TINYBLOB or BLOB or MEDIUMBLOB or TEXT or MEDIUM TEXT or LONGTEXT";
            $numbertostr = "TEXT";
            break;
    }

    return $numbertostr;
}

function get_number_type_to_string($number)
{
    $numbertostr = null;
    switch ($number) {
        case 16:
            $numbertostr = "BIT";
            break;
        case 1:
            $numbertostr = "TINYINT or BOOL";
            break;
        case 2:
            $numbertostr = "SMALLINT";
            break;
        case 9:
            $numbertostr = "MEDIUMINT";
            break;
        case 3:
            $numbertostr = "INT";
            break;
        case 8:
            $numbertostr = "BIGINT or SERIAL";
            break;
        case 4:
            $numbertostr = "FLOAT";
            break;
        case 5:
            $numbertostr = "DOUBLE";
            break;
        case 246:
            $numbertostr = "NUMERIC or DECIMAL or FIXED";
            break;
        case 10:
            $numbertostr = "DATE";
            break;
        case 12:
            $numbertostr = "DATETIME";
            break;
        case 11:
            $numbertostr = "TIME";
            break;
        case 13:
            $numbertostr = "YEAR";
            break;
        case 254:
            $numbertostr = "CHAR or ENUM or SET or BINARY";
            break;
        case 253:
            $numbertostr = "VARCHAR or VARBINARY";
            break;
        case 252:
            $numbertostr = "TINYBLOB or BLOB or MEDIUMBLOB or TEXT or MEDIUM TEXT or LONGTEXT";
            break;
    }

    return $numbertostr;
}

function load_type_of_data($tabel)
{
    if (get_koneksi()) {
        $arr_type = array();
        $sql = "select * from " . $tabel;
        $query = mysqli_query(get_koneksi(), $sql);
        $total = mysqli_num_fields($query);

        while ($info = mysqli_fetch_field($query)) {
            $arr_type[] = get_data_type($info->type); //get_number_type_to_string($info->type);
        }

        mysqli_free_result($query);
        do_destroy_koneksi();

        return $arr_type;
    }
}


function konversi_string_to_int($string)
{
    $benar = (int) trim($string);

    if ($benar) {
        // berarti number
        return (int) $string;
    } else {
        // bukan number;
        return (string) $string;
    }
}

function get_data_info($tabel, $primary_key, $dt = array(), $gotofile, $key)
{
    if (get_koneksi()) {
        $sql = "SELECT * FROM " . $tabel . " order by " . $primary_key . " DESC";
        $query = mysqli_query(get_koneksi(), $sql);

        $field = $dt;

        echo "<table id='tabel' class='table table-bordered table-striped'>";
        echo "<thead>";
        echo "<tr>";

        foreach ($field as $head) {
            echo "<th>";
            echo $head;
            echo "</th>";
        }

        echo "<th>Aksi</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        while ($data = mysqli_fetch_array($query)) {
            echo "<tr>";
            foreach ($field as $index => $head) {
                if ($field[$index] == "gambar") {
                    // tampilkan gambar
                    echo "<td>";
                    echo "<img src='images/" . $data['gambar'] . "' width='25%' class='img-thumbnail'>";
                    echo "</td>";
                } else {
                    // tampilkan data biasa
                    echo "<td>";
                    echo $data[$head];
                    echo "</td>";
                }
            }
            echo "<td>";

            echo "<a href=" . $gotofile . "?mode=edit&id=" . $data[$key] . " type='button' class= ";
            if ($_SESSION["hakakses"] != SUPERADMIN) {
                echo " 'btn btn btn-outline-secondary disabled' ";
            } else {
                echo " 'btn btn-success'";
            }
            echo " >Edit</a> ";

            echo "<a href=" . $gotofile . "?mode=hapus&id=" . $data[$key] . " type='button' class=";
            if ($_SESSION["hakakses"] != SUPERADMIN) {
                echo " 'btn btn btn-outline-secondary disabled' ";
            } else {
                echo " 'btn btn-danger' ";
            }
            echo " >Hapus</a>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";

        mysqli_free_result($query);
        do_destroy_koneksi();
    }
}

function proses_update_data($tabel, $source = array(), $labelarr = array(), $key, $labelkey, $exclude)
{
    if (get_koneksi()) {
        // build sql
        $sql1 = "";
        $total = count($labelarr);

        foreach ($source as $i => $dt) {
            $data = "";

            if (is_numeric($dt)) {
                $data = $dt;
            } else if (is_string($dt)) {
                $data = "'" . mysqli_real_escape_string(get_koneksi(), $dt) . "'";
            }

            if ($labelarr[$i] != $labelkey) {
                // build sql
                if (strtolower($labelarr[$i]) == "password") {
                    $sql1 .= $labelarr[$i];
                    $sql1 .= "=";
                    $sql1 .= "'" . sha1($data) . "'";
                } else {
                    $sql1 .= $labelarr[$i];
                    $sql1 .= "=";
                    $sql1 .= $data;
                }

                if ($i < $total - 1 - $exclude) {
                    $sql1 .= " , ";
                }
            }
        }

        $sql = "update " . $tabel . " set " . $sql1;
        $sql .= " where " . $labelkey . " = " . $key;
        $query = mysqli_query(get_koneksi(), $sql);

        //echo $sql;
        do_destroy_koneksi();

        if ($query) {
            return true;
        } else {
            return false;
        }
    }
}

function proses_update_foto($tabel, $foto, $key, $id, $mode = "none")
{
    if (isset($foto)) {
        $target_dir = "images/";
        $target_file = $target_dir . basename($foto["name"]);
        ; //basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {
            $check = getimagesize($foto["tmp_name"]);
            if ($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            //echo "Maaf, file sudah ada";
            $uploadOk = 0;
        }

        // Check file size
        if ($foto["size"] > 5000000) {
            //echo "Maaf, file terlalu besar";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            //"Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk != 0) {
            $fieldName = load_field_data($tabel);

            if (move_uploaded_file($foto["tmp_name"], $target_file)) {
                $file = htmlspecialchars(basename($foto["name"]));
                //echo "The file " . $file . " has been uploaded.";
                // hapus file yang lama
                if ($mode == "update") {
                    $img = get_nama_file($fieldName, $tabel, $key, $_POST["myname"][0]);
                    if ($img != "none") {
                        unlink('images/' . $img);
                    }
                }
                // update databsae tb_berita
                // untuk mengupdae nama gambar
                $sql = "update " . $tabel . " set gambar = '" . $file . "' where " . $key . " = " . $id;
                mysqli_query(get_koneksi(), $sql);

                do_destroy_koneksi();

            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
}

function get_nama_file($labelarr, $tabel, $key, $id)
{
    $keyArray = array_search("gambar", $labelarr);

    if (get_koneksi()) {
        if (!empty($keyArray)) {
            $sql = " SELECT gambar FROM " . $tabel . " where " . $key . " = " . $id;
            $query = mysqli_query(get_koneksi(), $sql);
            $result = mysqli_fetch_assoc($query);

            do_destroy_koneksi();
            return $result["gambar"];
        } else {
            return "none";
        }
    }
}

function proses_tambah_data($source = array(), $labelarr = array(), $tabel, $exclude)
{
    if (get_koneksi()) {
        $sql = "";
        // index=0, merupakan id_berita yang otomotasi dibuat
        // oleh mysql
        $sql1 = "";
        $val1 = "";
        $total = count($labelarr);

        foreach ($source as $index => $dt) {
            $data = "";

            if (is_numeric($dt)) {
                $data = $dt;
            } else if (is_string($dt)) {
                $data = "'" . mysqli_real_escape_string(get_koneksi(), $dt) . "'";
            }

            if ($index > 0) {
                // build sql
                echo "label: " . $labelarr[$index];
                echo "<br />";

                if (strtolower($labelarr[$index]) == "password") {
                    $sql1 .= $labelarr[$index];
                    $val1 .= "'" . sha1($data) . "'";
                } else {
                    $sql1 .= $labelarr[$index];
                    $val1 .= $data;
                }

                if ($index < ($total - 1 - $exclude)) {
                    $sql1 .= " , ";
                    $val1 .= " , ";
                }
            }
        }

        $sql = "insert into " . $tabel . " ( " . $sql1 . ") values (" . $val1 . ")";
        $query = mysqli_query(get_koneksi(), $sql);

        echo $sql;
        do_destroy_koneksi();

        if ($query) {
            return true;
        } else {
            return false;
        }
    }
}

function get_last_id($tabel, $index)
{
    if (get_koneksi()) {
        $sql = "select * from " . $tabel . " order by " . $index . " DESC limit 1 ";
        $query = mysqli_query(get_koneksi(), $sql);
        $result = mysqli_fetch_assoc($query);
        $lastid = $result[$index];

        do_destroy_koneksi();

        return $lastid;
    }
}

function proses_hapus_data($tabel, $key, $id)
{
    if (get_koneksi()) {
        $fieldName = load_field_data($tabel);
        // hapus berdasarkan tabel, key dan id
        $sql = "delete from  " . $tabel . " where " . $key . " = " . $id;
        $query = mysqli_query(get_koneksi(), $sql);

        do_destroy_koneksi();

        if ($query) {
            return true;
        } else {
            return false;
        }
    }
}


function make_dynamic_form(
    $labelarr = array(),    // array label
    $datatype = array(),    // array tipe data
    $dataarr = array(),     // array data
    $enumdata = array(),    // array enumerasu jika anda. jika tidak maka gunakan array kosong
    $linkToRef = array(),   // array untuk link ke referensi
    $total,                 // total data array
    $index                  // index atau primary key
) {

    //var_dump ($datatype);
    for ($i = 0; $i < $total; $i++) {
        echo "<div class='form-group'>";
        echo "<label>" . ucwords(str_replace("_", " ", $labelarr[$i])) . "</label>";

        if ($datatype[$i] != "DATE") {

            if ($datatype[$i] != "TEXT") {

                if (strtolower($labelarr[$i]) != "gambar") {

                    if (strtoupper($datatype[$i]) != "ENUM") {

                        $proses = null;

                        if (empty($linkToRef)) {
                            $proses = false;
                            $item = false;
                        } else {
                            $proses = true;
                            $item = (strtolower($labelarr[$i]) != $linkToRef[1]) ? true : false;
                        }

                        if ($proses && $item) {
                            // maka tampilkan data input biasa
                            echo "<input type='" . strtolower($datatype[$i]) . "' name='myname[]' class='form-control' value='";
                            if ($_GET["mode"] == "edit") {
                                echo konversi_string_to_int($dataarr[$i]); // asli
                            }
                            echo "' ";
                            echo " placeholder='" . ucwords(str_replace("_", " ", $labelarr[$i])) . "'";
                            if (strtolower($labelarr[$i]) == $index) {
                                echo " readonly ";
                            }
                            echo " required >";
                        } else {
                            // ambil data id_ kedalam tabel ini
                            if (empty($linkToRef)) {
                                // akan menamppilkan angka 1 jika benar - benar kosong
                                // maka tampilkan data input biasa
                                echo "<input type='" . strtolower($datatype[$i]) . "' name='myname[]' class='form-control' value='";
                                if ($_GET["mode"] == "edit") {
                                    if ($labelarr[$i] != "password") {
                                        echo konversi_string_to_int($dataarr[$i]);
                                    } else {
                                        echo "";
                                    }
                                }
                                echo "' ";
                                echo " placeholder='" . ucwords(str_replace("_", " ", $labelarr[$i])) . "'";
                                if (strtolower($labelarr[$i]) == $index) {
                                    echo " readonly ";
                                }
                                echo " required >";
                            } else {
                                if (!empty($dataarr[$i])) {
                                    get_link_to_ref($linkToRef, $dataarr[$i]);
                                } else {
                                    get_link_to_ref($linkToRef, "none");
                                }
                            }
                        }

                    } else {
                        // jika enum maka masukkan link pulldown
                        // buat list disini
                        // ini berlaku untuk tipe data ENUM dan Referensi Foregign Key
                        echo "<select class='form-select' aria-label='Default select example' name='myname[]'>";
                        echo "<option selected>Open this select menu</option>";
                        foreach ($enumdata[$labelarr[$i]] as $sts) {
                            echo "<option value='$sts' ";
                            if (
                                $_GET["mode"] == "edit" &&
                                $dataarr[$i] == $sts
                            ) {
                                echo " selected ";
                            }
                            echo " >$sts</option>";
                        }
                        echo "</select>";
                    }
                } else {
                    // jika field gambar tampilkan form upload gambar --->
                    echo "<br />";

                    if (!empty($dataarr[$i])) {
                        echo "<img src='images/";
                        echo $dataarr[$i] . "' ";
                        echo " width='50%' height='50%' class='img-thumbnail'>";
                    }

                    echo "<div class='input-group mb-3'>";
                    echo "<input type='file' class='form-control' name='fileToUpload' id='fileToUpload'>";
                    echo "<label class='input-group-text' for='fileToUpload'>Upload</label>";
                    echo "</div>";

                }
            } else {
                echo "<div class='mb-3'>";
                echo "<textarea class='form-control' id='deskripsi' rows='6' name='myname[]' wrap='hard'  required >";
                if ($_GET["mode"] == "edit") {
                    echo trim(konversi_string_to_int($dataarr[$i]));
                }
                echo "</textarea>";
                echo "</div>";
            }
        } else {
            echo "<input type='date' class='form-control' name='myname[]' value='";
            if ($_GET["mode"] == "edit") {
                echo $dataarr[$i];
            } else {
                echo "";
            }
            echo "'>";
        }
        echo "</div>";
    }
}

function get_link_to_ref($array, $strdata)
{
    if (get_koneksi()) {
        $tabel = $array[0];
        $index = $array[1];

        $sql = "select " . $index . " from " . $tabel;
        $query = mysqli_query(get_koneksi(), $sql);

        echo "<select class='form-select' aria-label='Default select example' name='myname[]'>";
        echo "<option selected>Open this select menu</option>";
        while ($result = mysqli_fetch_assoc($query)) {
            if ($strdata == "none") {
                echo "<option value=$result[$index]>$result[$index]</option>";
            } else {
                echo "<option value=$result[$index] ";
                if (
                    ($_GET["mode"] == "edit")
                    && ($strdata == $result[$index])
                ) {
                    echo " selected ";
                }
                echo " >$result[$index]</option>";
                echo $result[$index];
            }
        }
        echo "</select>";
        do_destroy_koneksi();
    }
}

function get_sidebar_menu($status)
{
    $menu = array();
    $link = array();

    if ($status == "superadmin") {
        $menu = array("Akun", "Masyarakat", "Produk", "Pembuatan", "Ukuran", "Bahan");
        $link = array("akun.php", "masyarakat.php", "produk.php", "pembuatan.php", "ukuran.php", "bahan.php");
    } else if ($status == "operator") {
        $menu = array("Produk", "Ukuran", "Bahan");
        $link = array("produk.php", "ukuran.php", "bahan.php");
    }

    foreach ($menu as $index => $mn) {
        echo "<li class='nav-item'>";
        echo "<a href='" . $link[$index] . "' class='nav-link'>";
        echo "<i class='nav-icon far fa-newspaper'></i>";
        echo "<p>" . $mn . "</p></a>";
        echo "</li>";
    }
}


//***** fungsi untuk menampilkan data didashoboard */

function view_data($tabel, $index, $field = array())
{
    if (get_koneksi()) {
        $sql = "select * from " . $tabel . " order by " . $index . " DESC ";
        $query = mysqli_query(get_koneksi(), $sql);

        while ($result = mysqli_fetch_assoc($query)) {
            echo "<div class='card mb-3'>";
            echo "<div class='row g-0'>";
            echo "<div class='col-md-4'>";
            echo "<img src='images/";
            echo $result[$field[5]];
            echo "' class='img-fluid rounded-start rounded-end'>";
            echo "</div>";
            echo "<div class='col-md-8'>";
            echo "<div class='card-body'>";
            echo "<div class='card-title'><h3><bold>" . ucwords($result[$field[2]]) . "</bold></h3></div>";
            echo "<p class='card-text'>";
            //set_keterangan($result[$field[4]], 35);
            echo $result[$field[4]];
            echo "</p>";
            echo "<p class='card-text'>";
            echo "<small class='text-body-secondary'>Last updated 3 mins ago</small></p>";
            echo "<button type='button' class='btn btn-primary'>Selanjutnya</button>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }

        do_destroy_koneksi();
    }
}

function set_keterangan($keterangan, $pjg)
{
  
    $dt = explode(" ", $keterangan);
    for ($i = 0; $i < $pjg; $i++) {
        echo ucfirst($dt[$i]);
        echo " ";
    }
    echo "...";
}

function view_data_personal($tabel, $index, $field = array())
{

}