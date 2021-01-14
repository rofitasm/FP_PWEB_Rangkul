<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="assets/img/basic/favicon.ico" type="image/x-icon">
    <title>Admin Page</title>
    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="stylesheet" href="assets/css/sweetalert.css">
    <style>
        .loader {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: #F5F8FA;
            z-index: 9998;
            text-align: center;
        }

        .plane-container {
            position: absolute;
            top: 50%;
            left: 50%;
        }
    </style>
    <script>(function(w,d,u){w.readyQ=[];w.bindReadyQ=[];function p(x,y){if(x=="ready"){w.bindReadyQ.push(y);}else{w.readyQ.push(x);}};var a={ready:p,bind:p};w.$=w.jQuery=function(f){if(f===d||f===u){return a}else{p(f)}}})(window,document)</script>
</head>

<?php
// Create database connection using config file
include_once("Config/condb.php");

// Fetch all users data from database
$result = mysqli_query($mysqli, "SELECT * FROM organisasi ORDER BY o_id DESC");
?>

<body class="light sidebar-collapse sidebar-offCanvas-lg">
<!-- Pre loader -->
<div id="loader" class="loader">
    <div class="plane-container">
        <div class="preloader-wrapper small active">
            <div class="spinner-layer spinner-blue">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div><div class="gap-patch">
                <div class="circle"></div>
            </div><div class="circle-clipper right">
                <div class="circle"></div>
            </div>
            </div>

            <div class="spinner-layer spinner-red">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div><div class="gap-patch">
                <div class="circle"></div>
            </div><div class="circle-clipper right">
                <div class="circle"></div>
            </div>
            </div>

            <div class="spinner-layer spinner-yellow">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div><div class="gap-patch">
                <div class="circle"></div>
            </div><div class="circle-clipper right">
                <div class="circle"></div>
            </div>
            </div>

            <div class="spinner-layer spinner-green">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div><div class="gap-patch">
                <div class="circle"></div>
            </div><div class="circle-clipper right">
                <div class="circle"></div>
            </div>
            </div>
        </div>
    </div>
</div>
<div id="app">
<div class="page">
    <header class="indigo lighten-2 relative shadow pb-5">
        <div class="navbar navbar-expand navbar-dark d-flex justify-content-between bd-navbar">
        <div class="relative offset-9" style="height: 50px;">
                <form action="Controller/authController.php" method="post">
                    <span class="text-white">Hello Admin!</span>
                    <input type="hidden" name="act" value="logout">
                    <input type="submit" class="btn btn-danger" value="Logout">
                </form>
            </div>
        </div>
        <div class="container text-white pb-5">
            <div class="mb-4">
                <h4>
                    <i class="icon-list"></i>
                    Data Organisasi
                </h4>
            </div>
        </div>
    </header>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="Controller/organisasiController.php" method="post">
                <div class="modal-body">
                    <label for="nama">Nama Organisasi</label>
                    <div class="form-group has-icon"><i class="icon-text_fields"></i>
                        <input type="text" name="nama" class="form-control form-control-lg"
                                placeholder="Nama Organisasi" id="nama">
                    </div>
                    <label for="telp">No Telepon</label>
                    <div class="form-group has-icon"><i class="icon-phone"></i>
                        <input type="text" name="telp" class="form-control form-control-lg"
                                placeholder="No Telepon" id="telp">
                    </div>
                    <label for="tglBerdiri">Tanggal Berdiri</label>
                    <div class="form-group has-icon"><i class="icon-calendar"></i>
                        <input type="date" name="tglBerdiri" class="form-control form-control-lg" id="tglBerdiri">
                    </div>
                    <label for="deskripsi">Deskripsi Organisasi</label>
                    <div class="form-group">
                        <input type="text" name="deskripsi" class="form-control form-control-lg"
                                placeholder="deskripsi" id="deskripsi">
                    </div>
                    <label for="web">Alamat Website</label>
                    <div class="form-group has-icon"><i class="icon-id-card"></i>
                        <input type="text" name="web" class="form-control form-control-lg"
                                placeholder="Alamat Website" id="web">
                    </div>
                    <label for="lokasi">Alamat Lokasi</label>
                    <div class="form-group has-icon"><i class="icon-map-marker"></i>
                        <input type="text" name="lokasi" class="form-control form-control-lg"
                                placeholder="Alamat Lokasi" id="lokasi">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <input type="hidden" id="id" name="id" value="">
                    <input type="hidden" id="act" name="act" value="">
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container relative animatedParent animateOnce pull-up-lg">
      <div class="animated fadeInUpShort my-3 mb-5">
          <div class="card my-3 no-b">
              <div class="card-body">
                  <div class="col-sm-12"style="margin-bottom: 15px">
                      <a href="registerOrganisasi.php">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal" id="btnAdd">
                        <i class="icon-add"></i>
                          Tambah data
                        </button>
                      </a>
                  </div>
                  <table class="table table-bordered table-hover data-tables"
                         data-options='{"searching":true}' id="datatable">
                      <thead>
                      <tr>
                          <th>Nama Organisasi</th>
                          <th>No Telepon</th>
                          <th>Tanggal Berdiri</th>
                          <th>Alamat Lokasi</th>
                          <th>Alamat Website</th>
                          <th>Deskripsi Organisasi</th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php 
                      $result = mysqli_query($mysqli, "SELECT * FROM organisasi ORDER BY o_id DESC");
    
                      while($user_data = mysqli_fetch_array($result)){?>
                      <tr>
                          
                          <input class="id" type="hidden" value="<?= $user_data['O_ID']; ?>">
                          <td class="nama"><span class="badge badge-secondary"><?= $user_data['O_NAMA']; ?></span></td>
                          <td class="telp"><span class="badge badge-primary r-3 blink"><?= $user_data['O_TELP']; ?></span></td>
                          <td class="tglBerdiri"><?= $user_data['O_TGL_BERDIRI']; ?></td>
                          <td class="lokasi"><?= $user_data['O_LOKASI']; ?></td>
                          <td class="web"><?= $user_data['O_WEB']; ?></td>
                          <td class="deskripsi"><?= $user_data['O_DESKRIPSI']; ?></td>
                          <td>
                              <button type="button" class="btn btn-warning btn-sm" id="btnEdit" data-toggle="modal" data-target="#exampleModal">
                                  <i class="icon-pencil"></i>
                              </button>
                              <button type="button" class="btn btn-danger btn-sm" id="btnDelete">
                                  <i class="icon-trash"></i>
                              </button>
                          </td>
                      </tr>
                      <?php }
                      mysqli_close($mysqli);
                      ?>
                      </tfoot>
                  </table>
              </div>
          </div>
      </div>
    </div>
</div>
</div>
<script src="assets/js/app.js"></script>
<script src="assets/js/sweetalert.min.js"></script>
<script>(function($,d){$.each(readyQ,function(i,f){$(f)});$.each(bindReadyQ,function(i,f){$(d).bind("ready",f)})})(jQuery,document)</script>
<script>
    $(document).ready(function() {

//         $('#btnAdd').click(function () {
//             $("#name").val('');
//             $("#email").val('');
//             $("#address").val('');
//             $("#city").val('');
//             $("#msg").val('');
//             $("#id").val('');
//             $("#act").val('add');
//             $('.modal-title').text('Tambah Data');
//         });
// nama
// telp
// tglBerdiri
// lokasi
// web
// deskripsi


        $('#datatable').on('click', '[id^=btnEdit]', function() {
            var $item = $(this).closest("tr");
            $("#nama").val($.trim($item.find(".nama").text()));
            $("#telp").val($.trim($item.find(".telp").text()));
            $("#tglBerdiri").val($.trim($item.find(".tglBerdiri").text()));
            $("#lokasi").val($.trim($item.find(".lokasi").text()));
            $("#web").val($.trim($item.find(".web").text()));
            $("#deskripsi").val($.trim($item.find(".deskripsi").text()));
            $("#id").val($.trim($item.find(".id").val()));
            $("#act").val('edit');
            $('.modal-title').text('Edit Data');
        });

        $('#datatable').on('click', '[id^=btnDelete]', function() {
            var $item = $(this).closest("tr");
            var ID = $.trim($item.find(".id").val());
            var name = $.trim($item.find(".nama").text());

            swal({
                    title: "Ingin menghapus data?",
                    text: "Data dengan Nama " + name + " akan dihapus",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#26C6DA",
                    confirmButtonText: "Ya, hapus!",
                    cancelButtonText: "Tidak, batalkan!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm){
                    if (isConfirm) {
                        window.location.href = "Controller/organisasiController.php?act=delete&id=" + ID;
                    } else {
                        swal("Dibatalkan", "Data tidak jadi dihapus", "error");
                    }
                });
        });
    });
</script>
</body>
</html>