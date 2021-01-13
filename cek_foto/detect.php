<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
       
    </style>
</head>
<body>
    <h1>
    <?php 
        $file = "../assets/check/".$_GET["message"];
        
        // echo $file;
        $test = shell_exec("python ./face_detection.py -i $file");
        // $gambar = shell_exec("python ./face_detection.py -i $file");
        
        
        // echo $test;
        if ($test == 1){
            shell_exec("python ./face_detection.py -i $file");
            echo "Diterima";
            
            copy("../assets/check/".$_GET['message'] , "../assets/uploads/".$_GET['message']);
            unlink("../assets/check/".$_GET['message']);

            echo '<button> <a  href = "../index.php" > back </a> </button>';
        }

        // echo $test;
        if ($test == 0) {
            echo "tidak Diterima";
            unlink("../assets/check/".$_GET['message']);
        }

        // echo $gambar;
    ?>
    </h1>
</body>
</html>
