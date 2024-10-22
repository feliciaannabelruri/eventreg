<?php include 'header.php'; ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-1">
                <div class="card-header text-center p-3 bg-white text-black">
                    <h5 class="text-center" style="font-weight: bold">Daftar Member Baru</h5>
                </div>
                <div class="card-body">
                    <?php
                    if (isset($_GET['alert']) && $_GET['alert'] == "duplikat") {
                        echo '<div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert">
                                <span class="ml-2 row" style="font-weight: bold">Gagal!</span>
                                <span> Email sudah pernah digunakan, silahkan gunakan email yang lain!</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                                </svg>
                              </div>';
                    }
                    ?>

                    <form action="daftar_act.php" method="post">
                        <div class="form-group p-2">
                            <label class="mb-1" style="font-weight: bold" for="nama">Nama Lengkap:</label>
                            <input type="text" class="form-control" required name="nama" placeholder="Masukkan nama lengkap ..">
                        </div>

                        <div class="form-group p-2">
                            <label class="mb-1" style="font-weight: bold" for="email">Email:</label>
                            <input type="email" class="form-control" required name="email" placeholder="Masukkan email ..">
                        </div>

                        <div class="form-group p-2">
                            <label class="mb-1" style="font-weight: bold" for="hp">Nomor HP / Whatsapp:</label>
                            <input type="tel" class="form-control" required name="hp" placeholder="Masukkan nomor HP/Whatsapp ..">
                        </div>

                        <div class="form-group p-2">
                            <label class="mb-1" style="font-weight: bold" for="alamat">Alamat Lengkap:</label>
                            <input type="text" class="form-control" required name="alamat" placeholder="Masukkan alamat lengkap ..">
                        </div>

                        <div class="form-group p-2">
                            <label class="mb-1" style="font-weight: bold" for="password">Password:</label>
                            <input type="password" class="form-control" required name="password" placeholder="Masukkan password ..">
                            <small class="text-muted">Password ini digunakan untuk login ke akun anda.</small>
                        </div>

                        <div class="form-group">
                            <div class="form-group text-center">
                                <input type="submit" class="btn mt-3 mb-4 btn-dark btn-block" value="Daftar" style="padding: 10px 40px;">
                            </div>
                            <p class="text-center">
                                Belum punya akun? <strong><a href="masuk.php" style="color: black; text-decoration: none;">Login</a></strong>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
