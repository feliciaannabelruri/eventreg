<?php include 'header.php'; ?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-4">
            <div class="card border-1">
                <div class="card-header text-center p-3 bg-white text-black">
                    <h5>Login Member</h5>
                </div>
                <div class="card-body">

                    <?php
                    if (isset($_GET['alert'])) {
                        $alertMessages = [
                            "terdaftar" => "Pendaftaran Berhasil. Silahkan login!",
                            "gagal" => "Email dan Password salah! Coba lagi!",
                            "login-dulu" => "Silahkan login terlebih dulu untuk membuat diskusi baru!"
                        ];
                        $alertTypes = [
                            "terdaftar" => "success",
                            "gagal" => "danger",
                            "login-dulu" => "warning"
                        ];

                        $alertType = $alertTypes[$_GET['alert']] ?? null;
                        $alertMessage = $alertMessages[$_GET['alert']] ?? null;

                        if ($alertType && $alertMessage) {
                            echo '<div class="alert alert-' . $alertType . ' alert-dismissible fade show" role="alert">
                                    <strong>' . $alertMessage . '</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                  </div>';
                        }
                    }
                    ?>

                    <div class="text-center">
                        <a href="index.php">
                            <img src="gambar/sistem/weeboding.png" style="width:auto; height: 150px;">
                        </a>
                    </div>

                    <form action="masuk_act.php" method="post">
                        <div class="form-group p-2">
                            <label class="mb-1" style="font-weight: bold" for="email">Email:</label>
                            <input type="email" class="form-control" name="email" required placeholder="Masukkan email ..">
                        </div>

                        <div class="form-group p-2"">
                            <label class="mb-1" style="font-weight: bold" for="password">Password:</label>
                            <input type="password" class="form-control" name="password" required placeholder="Masukkan password ..">
                        </div>

                        <div class="form-group text-center">
                            <input type="submit" class="btn mt-3 mb-4 btn-dark btn-block" value="Login" style="padding: 10px 40px;">
                        </div>

                        <p class="text-center">
                            Belum punya akun? <strong><a href="daftar.php" style="color: black; text-decoration: none;">Daftar Sekarang</a></strong>
                        </p>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
