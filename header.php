<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Event Registration System</title>
    <link href="gambar/sistem/weeboding.png" rel="icon" type="image/png">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link href="assets_forum/assets/vendor/nucleo/css/nucleo.css" rel="stylesheet">
    <link href="assets_forum/assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/navbar.css" rel="stylesheet">
</head>

<body>

<?php
include 'koneksi.php';
session_start();
$file = basename($_SERVER['PHP_SELF']);

if (!isset($_SESSION['member_status'])) {
    $lindungi = ['member.php', 'member_logout.php', 'member_profil.php', 'member_password.php'];
    if (in_array($file, $lindungi)) {
        header("location:index.php");
    }
    if ($file == "posting.php") {
        header("location:masuk.php?alert=login-dulu");
    }
} else {
    $lindungi = ['masuk.php', 'daftar.php'];
    if (in_array($file, $lindungi)) {
        header("location:member.php");
    }
}
?>

<header>
    <nav class="navbar navbar-expand-lg navbar-light mb-5">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="gambar/sistem/weeboding.png" alt="Logo" height="40" class="me-2">
                Event Registration System
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION['member_status'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="member.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="list_event.php">Event List</a>
                        </li>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['member_status'])):
                        $id_member = $_SESSION['member_id'];
                        $member = mysqli_query($koneksi, "SELECT * FROM member WHERE member_id='$id_member'");
                        $c = mysqli_fetch_assoc($member);
                        ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link nav-link-icon" href="#" id="navbar-default_dropdown_1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php if ($c['member_foto'] == ""): ?>
                                    <img class="img-fluid rounded-circle shadow" style="width: 22px;height: 22px" src="gambar/sistem/member.png">
                                <?php else: ?>
                                    <img class="img-fluid rounded-circle shadow" style="width: 22px;height: 22px" src="gambar/member/<?php echo $c['member_foto'] ?>">
                                <?php endif; ?>
                                &nbsp; <?php echo $c['member_nama']; ?>
                                <i class="fa fa-caret-down"></i>
                                <span class="nav-link-inner--text d-lg-none">Settings</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbar-default_dropdown_1">
                                <a class="dropdown-item" href="member.php">Dashboard</a>
                                <a class="dropdown-item" href="member_profil.php">Profil</a>
                                <a class="dropdown-item" href="member_password.php">Ganti Password</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="member_logout.php">Logout</a>
                            </div>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link btn btn-custom" href="<?php echo ($file == 'masuk.php') ? 'daftar.php' : 'masuk.php'; ?>">
                                <?php echo ($file == 'masuk.php') ? 'Register' : 'Login'; ?>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
