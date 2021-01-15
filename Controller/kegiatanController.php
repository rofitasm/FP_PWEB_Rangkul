<?php
// include database connection file
include_once("../Config/condb.php");

session_start();

//function uploadImageMultiple(){
//    $limit = 10 * 1024 * 1024;
//    $ekstensi =  array('png','jpg','jpeg','gif');
//    $jumlahFile = count($_FILES['a_path']['name']);
//
//    echo json_encode($_FILES['a_path']['name']);
//    die();
//
//    for($x=0; $x<$jumlahFile; $x++){
//        $namafile = $_FILES['a_path']['name'][$x];
//        $tmp = $_FILES['a_path']['tmp_name'][$x];
//        $tipe_file = pathinfo($namafile, PATHINFO_EXTENSION);
//        $ukuran = $_FILES['a_path']['size'][$x];
//        if($ukuran > $limit){
//            return 0;
//        }else{
//            if(!in_array($tipe_file, $ekstensi)){
//                return 0;
//            }else{
//                $nama_file = md5(date('d-m-Y').'-'.$namafile).".".$tipe_file;
//                move_uploaded_file($tmp, '../assets/img/kegiatan/'.$nama_file);
////                $x = date('d-m-Y').'-'.$namafile;
////                mysqli_query($mysqli,"INSERT INTO gambar VALUES(NULL, '$x')");
////                header("Location: ../View/kegiatanView.php");
//                return $nama_file;
//            }
//        }
//    }
//}

function uploadImage(){
    $limit = 10 * 1024 * 1024;
    $ekstensi =  array('png','jpg','jpeg','gif');

//    echo date('d-m-Y h:i:s');
//    die();

    $namafile = $_FILES['a_path']['name'];
    $tmp = $_FILES['a_path']['tmp_name'];
    $tipe_file = pathinfo($namafile, PATHINFO_EXTENSION);
    $ukuran = $_FILES['a_path']['size'];
    if($ukuran > $limit){
        return 0;
    }else{
        if(!in_array($tipe_file, $ekstensi)){
            return 0;
        }else{
            $nama_file = md5(date('d-m-Y h:i:s').'-'.$namafile).".".$tipe_file;
            move_uploaded_file($tmp, '../assets/img/kegiatan/'.$nama_file);
//                $x = date('d-m-Y').'-'.$namafile;
//                mysqli_query($mysqli,"INSERT INTO gambar VALUES(NULL, '$x')");
//                header("Location: ../View/kegiatanView.php");
            return $nama_file;
        }
    }
}

if (isset($_POST['act']) && $_POST['act'] == "add"){

    $o_id                   = $_SESSION['o_id'];
    $a_nama                 = $_POST['a_nama'];
    $a_lokasi               = $_POST['a_lokasi'];
    $a_batas_regis          = $_POST['a_batas_regis'];
    $a_detail               = addslashes($_POST['a_detail']);
    $a_kebutuhan_relawan    = $_POST['a_kebutuhan_relawan'];

    $a_path = uploadImage();

    if ($a_path != 0){
//        echo $o_id." ".$a_nama." ".$a_lokasi." ".$a_batas_regis." ".$a_detail." ".$a_kebutuhan_relawan. " ". $a_path;
//        die();
        // Insert user data into table
        $result = mysqli_query($mysqli, "
            INSERT INTO aktivitas(O_ID, A_NAMA, A_LOKASI, A_BATAS_REGIS, A_DETAIL, A_KEBUTUHAN_RELAWAN, A_PATH) 
            VALUES('$o_id', '$a_nama','$a_lokasi','$a_batas_regis','$a_detail', '$a_kebutuhan_relawan', '$a_path')");
    }
}

else if (isset($_POST['act']) && $_POST['act'] == "edit"){

    $a_id                   = $_POST['a_id'];
    $a_nama                 = $_POST['a_nama'];
    $a_lokasi               = $_POST['a_lokasi'];
    $a_batas_regis          = $_POST['a_batas_regis'];
    $a_detail               = addslashes($_POST['a_detail']);
    $a_kebutuhan_relawan    = $_POST['a_kebutuhan_relawan'];

    if(isset($_FILES['a_path']['name']) && $_FILES['a_path']['name'] != ""){

        $a_path = uploadImage();

        $result = mysqli_query($mysqli, "
            UPDATE aktivitas 
            SET A_NAMA ='$a_nama', 
            A_LOKASI ='$a_lokasi', 
            A_BATAS_REGIS ='$a_batas_regis', 
            A_DETAIL ='$a_detail', 
            A_PATH ='$a_path', 
            A_KEBUTUHAN_RELAWAN ='$a_kebutuhan_relawan' 
            WHERE A_ID ='$a_id'");
    }
    else{
        $result = mysqli_query($mysqli, "
            UPDATE aktivitas 
            SET A_NAMA ='$a_nama', 
            A_LOKASI ='$a_lokasi', 
            A_BATAS_REGIS ='$a_batas_regis', 
            A_DETAIL ='$a_detail', 
            A_KEBUTUHAN_RELAWAN ='$a_kebutuhan_relawan' 
            WHERE A_ID ='$a_id'");
    }
}

else if($_GET['act'] == "delete"){
    $id = $_GET['a_id'];
    $result = mysqli_query($mysqli, "DELETE FROM aktivitas WHERE `A_ID` = '$id'");
}

else if($_GET['act'] == "acc"){
    $r_id = $_GET['r_id'];
    $a_id = $_GET['a_id'];
    $result = mysqli_query($mysqli, "UPDATE gabung_relawan SET GR_STATUS = 'Diterima' WHERE R_ID = '$r_id' AND A_ID = '$a_id'");

    mysqli_close($mysqli);
    header("Location: ../View/listRelawanView.php?a_id=".$a_id);
    die();
}

else if($_GET['act'] == "tolak"){
    $r_id = $_GET['r_id'];
    $a_id = $_GET['a_id'];
    $result = mysqli_query($mysqli, "UPDATE gabung_relawan SET GR_STATUS = 'Ditolak' WHERE R_ID = '$r_id' AND A_ID = '$a_id'");

    mysqli_close($mysqli);
    header("Location: ../View/listRelawanView.php?a_id=".$a_id);
    die();
}


else if($_GET['act'] == "daftarKegiatan"){

    $r_id = $_SESSION['r_id'];
    $a_id = $_GET['a_id'];
    $gr_id = "NULL";
    $gr_status = "Menunggu";
    $gr_tgl_daftar = date('Y-m-d H-i-s');

    // $dupesql = "
    // SELECT A_ID , R_ID
    // FROM aktivitas 
    // WHERE A_ID = $a_id AND R_ID =$r_id";
    // $duperaw = mysqli_query($mysqli,$dupesql);
    // // $row = mysqli_num_rows($duperaw);

    // if ($duperaw) 
    // { 
    //     // it return number of rows in the table. 
    //     $row = mysqli_num_rows($duperaw); 
          
    //        if ($row) 
    //           { 
    //             echo $row."jancok"; 
    //             printf("Number of row in the table : " . $row); 
    //           } 
    //     // close the result. 
    //     die();
    //     mysqli_free_result($result); 
    // } 
    // // echo $row;
    // die();
    // if (mysqli_num_rows($duperaw) > 0) {
    // die();
    // }
    // else{        
        $result = mysqli_query($mysqli, "
        INSERT INTO gabung_relawan(GR_ID,R_ID,A_ID,GR_TGL_DAFTAR,GR_STATUS)
        VALUES('$gr_id','$r_id','$a_id','$gr_tgl_daftar','$gr_status')");
        
        mysqli_close($mysqli);
        header("Location: ../View/kegiatanView.php?a_id=".$a_id);
        die();
        // die();
    
}



mysqli_close($mysqli);
header("Location: ../View/kegiatanView.php");
die();

?>