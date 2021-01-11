<?php
// include database connection file
include_once("../Config/condb.php");

session_start();

function uploadImage($mysqli){
    $limit = 10 * 1024 * 1024;
    $ekstensi =  array('png','jpg','jpeg','gif');
    $jumlahFile = count($_FILES['a_path']['name']);

    echo $jumlahFile;
    die();

    for($x=0; $x<$jumlahFile; $x++){
        $namafile = $_FILES['a_path']['name'][$x];
        $tmp = $_FILES['a_path']['tmp_name'][$x];
        $tipe_file = pathinfo($namafile, PATHINFO_EXTENSION);
        $ukuran = $_FILES['a_path']['size'][$x];
        if($ukuran > $limit){
            header("location: ../View/kegiatanView.php?msg=gagal_ukuran");
        }else{
            if(!in_array($tipe_file, $ekstensi)){
                header("Location: ../View/kegiatanView.php?msg=ekstensi_salah");
            }else{
                $nama_file = md5(date('d-m-Y').'-'.$namafile);
                move_uploaded_file($tmp, 'file/'.$nama_file);
//                $x = date('d-m-Y').'-'.$namafile;
//                mysqli_query($mysqli,"INSERT INTO gambar VALUES(NULL, '$x')");
                header("Location: ../View/kegiatanView.php");
            }
        }
    }
}

if (isset($_POST['act']) && $_POST['act'] == "add"){

    $o_id                   = $_SESSION['o_id'];
    $a_nama                 = $_POST['a_nama'];
    $a_lokasi               = $_POST['a_lokasi'];
    $a_batas_regis          = $_POST['a_batas_regis'];
    $a_detail               = $_POST['a_detail'];
    $a_kebutuhan_relawan    = $_POST['a_kebutuhan_relawan'];

    uploadImage($mysqli);

    // Insert user data into table
    $result = mysqli_query($mysqli, "
            INSERT INTO aktivitas(O_ID, A_NAMA, A_LOKASI, A_BATAS_REGIS, A_DETAIL, A_KEBUTUHAN_RELAWAN) 
            VALUES('$o_id', '$a_nama','$a_lokasi','$a_batas_regis','$a_detail', '$a_kebutuhan_relawan')");
}

else if (isset($_POST['act']) && $_POST['act'] == "edit"){

    $a_id                   = $_POST['a_id'];
    $a_nama                 = $_POST['a_nama'];
    $a_lokasi               = $_POST['a_lokasi'];
    $a_batas_regis          = $_POST['a_batas_regis'];
    $a_detail               = $_POST['a_detail'];
    $a_kebutuhan_relawan    = $_POST['a_kebutuhan_relawan'];

    // Insert user data into table
    $result = mysqli_query($mysqli, "
            UPDATE aktivitas 
            SET A_NAMA ='$a_nama', 
            A_LOKASI ='$a_lokasi', 
            A_BATAS_REGIS ='$a_batas_regis', 
            A_DETAIL ='$a_detail', 
            A_KEBUTUHAN_RELAWAN ='$a_kebutuhan_relawan' 
            WHERE A_ID ='$a_id'");

}
else if($_GET['act'] == "delete"){
    $id = $_GET['a_id'];
    $result = mysqli_query($mysqli, "DELETE FROM aktivitas WHERE `A_ID` = '$id'");
}

mysqli_close($mysqli);
header("Location: ../View/kegiatanView.php");
die();

?>