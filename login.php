<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>LOGIN - ADMIN</title>
  <link href="gambar/sistem/weeboding.png" rel="icon" type="image/png">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <link href="assets_forum/assets/vendor/nucleo/css/nucleo.css" rel="stylesheet">
  <link href="assets_forum/assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link type="text/css" href="assets_forum/assets/css/argon.css?v=1.1.0" rel="stylesheet">
</head>

<body class="bg-gradient-default">

  <main>
    <section class="section section-shaped section-lg">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-4">

            <b>
              <div style="text-align:center">
                <?php 
                if(isset($_GET['alert'])){
                  if($_GET['alert'] == "gagal"){
                    echo "<div class='alert alert-danger'>LOGIN GAGAL! <br/> Username dan Password salah!</div>";
                  }else if($_GET['alert'] == "logout"){
                    echo "<div class='alert alert-success'>Anda telah logout</div>";
                  }else if($_GET['alert'] == "belum_login"){
                    echo "<div class='alert alert-warning'>Anda harus login untuk mengakses halaman admin</div>";
                  }
                }
                ?>
              </div>
            </b>

            <div class="card bg-secondary shadow border-0">
              <div class="card-header bg-white">

                <div class="text-muted text-center mb-1">
                <img src="gambar/sistem/weeboding.png" height="50px">
                  <h5>Event Registration System</h5>
                </div>

              </div>
              <div class="card-body">
                <div class="text-center text-muted mb-4">
                  <small>LOGIN ADMIN</small>
                </div>
                <form action="periksa_login.php" method="POST">
                  <div class="form-group mb-3">
                    <div class="input-group input-group-alternative">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                      </div>
                      <input class="form-control" name="username" placeholder="username" type="username">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group input-group-alternative">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                      </div>
                      <input class="form-control" name="password" placeholder="Password" type="password">
                    </div>
                  </div>

                  <div class="text-center">
                    <input type="submit" class="btn btn-primary my-4 btn-block" value="Login">
                    <a class="btn btn-link btn-block" href="index.php">Kembali Ke Forum</a>
                  </div>
                </form>
              </div>

            </div>
          </div>
        </div>
      </div>
    </section>
  </main>


  <script src="assets_forum/assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets_forum/assets/vendor/popper/popper.min.js"></script>
  <script src="assets_forum/assets/vendor/bootstrap/bootstrap.min.js"></script>
  <script src="assets_forum/assets/vendor/headroom/headroom.min.js"></script>
  <script src="assets_forum/assets/js/argon.js?v=1.1.0"></script>
</body>

</html>
