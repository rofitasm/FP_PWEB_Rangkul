<?php
// include database connection file
include_once("../Config/condb.php");

if ($_POST['act'] == "register"){

    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = md5(trim($_POST['password']));

    // Insert user data into table
    $result = mysqli_query($mysqli, "INSERT INTO login(nama,email,password) VALUES('$nama','$email','$password')");
    mysqli_close($mysqli);

    header("Location: register.php");
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

            if ($user_data['ROLE'] == 'O') {
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
            }
            else if ($user_data['role'] == 'R') {
                $data = mysqli_query($mysqli,"select * from relawan where id_login='".$_SESSION['id_login']."'");
            }
        }
        mysqli_close($mysqli);
        header("location: ../View/kegiatanView.php");
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