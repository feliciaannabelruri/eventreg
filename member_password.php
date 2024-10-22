<?php include 'header.php'; ?>

<link href="assets/css/member_profil.css" rel="stylesheet">

<div class="container">
    <div class="row">
        <?php include 'member_menu.php'; ?>
        <div class="col-lg-9 col-md-12">
            <div>
                <div class="bg-white p-2 mb-4 rounded-5 shadow">
                    <h6 class="p-3" style="font-size: 25px; font-weight: bold">
                        Change Password
                    </h6>
                </div>

                <div class="form-container">
                    <?php
                    if (isset($_GET['alert'])) {
                        if ($_GET['alert'] == "sukses") {
                            echo "<div class='alert alert-success'>Password anda berhasil diganti!</div>";
                        } elseif ($_GET['alert'] == "short_password") {
                            echo "<div class='alert alert-danger'>Password terlalu pendek. Minimal 5 karakter.</div>";
                        }
                    }
                    ?>
                    <form action="member_password_act.php" method="post">
                        <div class="form-group mb-5">
                            <label style="font-size: 20px" for="">Masukkan Password Baru</label>
                            <input type="password" class="form-control" required="required" name="password" placeholder="Masukkan password .." minlength="5">
                        </div>

                        <div class="form-group text-right">
                            <input type="submit" class="btn btn-primary" value="Ganti Password" style="float: right;">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
