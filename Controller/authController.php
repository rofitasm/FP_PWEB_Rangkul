<?php
// include database connection file
include_once("../Config/condb.php");

// Daftar Relawan
if ($_POST['act'] == "registerRelawan"){

    // echo "oke";
    // echo $_FILES['foto']['name'];
    // die();


    $nama = $_POST['nama'];
    $telp = $_POST['telp'];
    $tglLahir = $_POST['tglLahir'];
    $profesi = $_POST['profesi'];
    $kota = $_POST['kota'];
    $provinsi = $_POST['provinsi'];
    $email = $_POST['email'];
    $password = md5(trim($_POST['password']));
    
    
    $reg = mysqli_query($mysqli, "INSERT INTO login(email,password,role) VALUES('$email','$password','R')");
    $reg1 = mysqli_query($mysqli,"select * from login where email='".$email."'");
    
    $val = mysqli_fetch_assoc($reg1);
    $id = $val['ID_LOGIN'];   
    // echo $id;

    $name = str_replace(' ', '_', $nama);
    $image_name = "relawanProfil/".$name;

    $nm_file = $_FILES['foto']['name'];
    $tp_file = $_FILES['foto']['tmp_name'];
    $sz_file = $_FILES['foto']['size'];
    $ty_file = $_FILES['foto']['type'];
    $x = explode('.', $nm_file);
    $ekstensi = (end($x));
    
    $fullName = $image_name."_". date("YmdHis") . "." . $ekstensi;
    $fuckName = $name."_". date("YmdHis") . "." . $ekstensi;
    // dir save foto
    $dir = "C:/xampp/htdocs/FP_PWEB_Rangkul/assets/img/".$image_name;
    if (!is_dir($dir)){
        
        mkdir($dir, 0777, $rekursif = true);
        
    };

    // dir cek foto
    $dir_cek_foto = "C:/xampp/htdocs/FP_PWEB_Rangkul/Cek_foto/";
    if (!is_dir($dir_cek_foto)){
        
        mkdir($dir_cek_foto, 0777, $rekursif = true);
        
    };
    
    // dir and create new name for foto
    $name_cek_foto = "C:/xampp/htdocs/FP_PWEB_Rangkul/Cek_foto/" . $fullName;
    
    
    //cek and create directory
    
    // move file
    move_uploaded_file($tp_file, $name_cek_foto);

    // create check photo
    $file = $name_cek_foto;
    echo $file;

    $test = shell_exec("python face_detection.py -i $file");
    echo $test;
    // die();
    

    if($test == 1) {
        echo "benar";
         // insert data
        $reg2 = mysqli_query($mysqli, "INSERT INTO relawan(id_login,r_nama,r_telp,r_tgl_lahir,r_profesi,r_kota_dom,r_provinsi_dom,r_foto) 
        VALUES('$id','$nama','$telp','$tglLahir','$profesi','$kota','$provinsi','$fullName')");

        mysqli_close($mysqli);

        // new direct to put photo at asset
        $newdirect = $dir."/".$fuckName;
       
        copy($name_cek_foto , $newdirect);
        unlink($name_cek_foto);

        header("Location: ../registerRelawan.php");
        
        die();
       
    }
    
    else if ($test != 1) {
        echo "salah";
        die();
    }

   
}

else if ($_POST['act'] == "registerOrganisasi"){
    $nama = $_POST['nama'];
    $telp = $_POST['telp'];
    $tglBerdiri = $_POST['tglBerdiri'];
    $deskripsi = $_POST['deskripsi'];
    $web = $_POST['web'];
    $lokasi = $_POST['lokasi'];
    $email = $_POST['email'];
    $password = md5(trim($_POST['password']));

    $reg = mysqli_query($mysqli, "INSERT INTO login(email,password,role) VALUES('$email','$password','O')");
    $reg1 = mysqli_query($mysqli,"select * from login where email='".$email."'");

    $val = mysqli_fetch_assoc($reg1);
    $id = $val['ID_LOGIN'];   
    
    $reg2 = mysqli_query($mysqli, "INSERT INTO organisasi(id_login,o_nama,o_telp,o_tgl_berdiri,o_deskripsi,o_lokasi,o_web) 
                    VALUES('$id','$nama','$telp','$tglBerdiri','$deskripsi','$lokasi','$web')");

    mysqli_close($mysqli);

    header("Location: ../registerOrganisasi.php");
    die();
}

else if ($_POST['act'] == "login"){

    $email = $_POST['email'];
    $password = md5(trim($_POST['password']));

    $login = mysqli_query($mysqli,"select * from login where email='$email' and password='$password'");
    $cek = mysqli_num_rows($login);

    if($cek > 0){
        session_start();
        while($user_data = mysqli_fetch_array($login)){
            $_SESSION['id_login']   = $user_data['ID_LOGIN'];
            $_SESSION['email']      = $user_data['EMAIL'];
            $_SESSION['role']       = $user_data['ROLE'];

            if ($user_data['ROLE'] == 'A') {
                header("location: ../admin.php");
            }
            else if ($user_data['ROLE'] == 'O') {
                $data = mysqli_query($mysqli,"select * from organisasi where id_login='".$_SESSION['id_login']."'");

                while($row = mysqli_fetch_array($data)){
                    $_SESSION['o_id']           = $row['O_ID'];
                    $_SESSION['o_nama']         = $row['O_NAMA'];
                    $_SESSION['o_tgl_berdiri']  = $row['O_TGL_BERDIRI'];
                    $_SESSION['o_deskripsi']    = $row['O_DESKRIPSI'];
                    $_SESSION['o_lokasi']       = $row['O_LOKASI'];
                    $_SESSION['o_telp']         = $row['O_TELP'];
                    $_SESSION['o_web']          = $row['O_WEB'];
                }
              header("location: ../View/kegiatanView.php");
            }
            else if ($user_data['ROLE'] == 'R') {
                $data = mysqli_query($mysqli,"select * from relawan where id_login='".$_SESSION['id_login']."'");
                // echo var_dump($data);
                // die();

                while($row = mysqli_fetch_array($data)){
                    $_SESSION['r_id']           = $row['R_ID'];
                    $_SESSION['r_nama']         = $row['R_NAMA'];
                    $_SESSION['r_telp']         = $row['R_TELP'];
                    $_SESSION['r_tgl_lahir']  = $row['R_TGL_LAHIR'];
                    $_SESSION['r_profesi']    = $row['R_profesi'];
                    $_SESSION['r_provinsi_dom']       = $row['R_PROVINSI_DOM'];
                    $_SESSION['r_kota_dom']         = $row['R_KOTA_DOM'];
                    $_SESSION['r_foto']          = $row['R_FOTO'];
                    
                    // echo json_encode($_SESSION);
                    // die();
                }
                  header("location: ../View/kegiatanView.php"); 
            }
        }
        mysqli_close($mysqli);
    }else{
        mysqli_close($mysqli);
        header("location: ../index.php");
    }
    die();
}
else if ($_POST['act'] == "logout"){

    session_start();
    session_destroy();
    header("location: ../index.php");
    die();
}

?>