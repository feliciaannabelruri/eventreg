<?php include 'header.php'; ?>

<link href="assets/css/member_profil.css" rel="stylesheet">

<div class="container">
    <div class="row">
        <?php include 'member_menu.php'; ?>
        <div class="col-lg-9 col-md-12">
            <div>
                <div class="bg-white p-2 mb-4 rounded-5 shadow">
                    <h6 class="p-3" style="font-size: 25px; font-weight: bold">
                        My Profile
                    </h6>
                </div>
                <div class="form-container">
                    <div class="row">
                        <?php
                        include 'koneksi.php';

                        // Start session only if it's not already started
                        if (session_status() == PHP_SESSION_NONE) {
                            session_start();
                        }

                        // Check if member_id is set in the session
                        if (!isset($_SESSION['member_id'])) {
                            // Redirect to login or an appropriate page
                            header("Location: login.php");
                            exit();
                        }

                        // Assign member_id to $id
                        $id = $_SESSION['member_id'];

                        // Check for alerts in GET parameters
                        if (isset($_GET['alert'])) {
                            if ($_GET['alert'] == "berhasil") {
                                echo "<div class='alert alert-success'>Profil anda berhasil diubah.</div>";
                            } elseif ($_GET['alert'] == "gagal") {
                                echo "<div class='alert alert-danger'>Profil gagal diubah. File gambar tidak diizinkan.</div>";
                            } elseif ($_GET['alert'] == "gagal_upload") {
                                echo "<div class='alert alert-danger'>Terjadi kesalahan saat mengupload file gambar.</div>";
                            }
                        }

                        // Fetch member details
                        $member = mysqli_query($koneksi, "SELECT * FROM member WHERE member_id='$id'");
                        $i = mysqli_fetch_array($member);
                        ?>

                        <form action="member_profil_update.php" method="post" enctype="multipart/form-data" class="w-100">
                            <div class="form-group">
                                <label class="mb-1" for="nama">Nama:</label>
                                <input type="text" class="mb-2 form-control" required name="nama" placeholder="Masukkan nama .." value="<?php echo htmlspecialchars($i['member_nama']); ?>">
                            </div>

                            <div class="form-group">
                                <label class="mb-1" for="email">Email:</label>
                                <input type="email" class="mb-2 form-control" required name="email" placeholder="Masukkan email .." value="<?php echo htmlspecialchars($i['member_email']); ?>">
                            </div>

                            <div class="form-group">
                                <label class="mb-1" for="hp">HP:</label>
                                <input type="number" class="mb-2 form-control" required name="hp" placeholder="Masukkan no.hp .." value="<?php echo htmlspecialchars($i['member_hp']); ?>">
                            </div>

                            <div class="form-group">
                                <label class="mb-1" for="alamat">Alamat:</label>
                                <input type="text" class="mb-3 form-control" required name="alamat" placeholder="Masukkan alamat .." value="<?php echo htmlspecialchars($i['member_alamat']); ?>">
                            </div>

                            <div class="form-group mb-3">
                                <label class="mb-1" for="foto">Foto Profil:</label>
                                <input type="file" name="foto" accept="image/*" class="custom-file-input">
                                <i class="small-text"><small>Kosongkan jika tidak ingin mengubah foto profil.</small></i>
                            </div>

                            <div class="form-group text-right">
                                <input type="submit" class="btn btn-primary" value="Ubah Profil" style="float: right;">
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
