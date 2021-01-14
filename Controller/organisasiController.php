<?php
// include database connection file
include_once("../Config/condb.php");

if ($_POST['act'] == "edit"){

    $nama = $_POST['nama'];
    $telp = $_POST['telp'];
    $tglBerdiri = $_POST['tglBerdiri'];
    $lokasi = $_POST['lokasi'];
    $web = $_POST['web'];
    $deskripsi = $_POST['deskripsi'];
    $id = $_POST['id'];

    // Insert user data into table
    $result = mysqli_query($mysqli, "UPDATE organisasi SET 
    `o_nama`='$nama', `o_telp`='$telp', `o_tgl_berdiri`='$tglBerdiri', `o_lokasi`='$lokasi', `o_web`='$web', `o_deskripsi`='$deskripsi' WHERE `O_id`='$id'");

    mysqli_close($mysqli);

    header("Location: ../admin.php");
    die();
}
if($_GET['act'] == "delete"){
    $id = $_GET['id'];
    $result = mysqli_query($mysqli, "DELETE FROM organisasi WHERE `o_id` = '$id'");
    mysqli_close($mysqli);

    header("Location: ../admin.php");
    die();
}