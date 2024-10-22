<!-- ASIDE -->
<div class="col-md-3 bg-white p-2 mb-4 bg-white rounded-5 shadow" style="max-height: 650px">


	<?php
	$id_member = $_SESSION['member_id'];
	$member = mysqli_query($koneksi,"select * from member where member_id='$id_member'");
	$c = mysqli_fetch_assoc($member);

	if($c['member_foto'] == ""){
		?>
		<div style="text-align:center">
            <img class="img-fluid rounded shadow mt-4" src="gambar/sistem/member.png">
        </div>
		<?php
	}else{
		?>
		<div style="text-align:center">
            <img class="img-fluid rounded shadow mt-4" src="gambar/member/<?php echo $c['member_foto'] ?>">
        </div>
		<?php
	}
	?>

	<div style="text-align:center">
		<h5 class="my-4"><?php echo $c['member_nama'];  ?></h5>
</div>

    <div class="menu p-3">
        <ul class="list-group">
            <li class="list-group-item mb-3 shadow-sm" style="background-color: #f8f9fa; border-radius: 8px;">
                <a class="text-decoration-none d-block py-2" href="cancel_page.php" style="color: #303030;">
                    <i class="fa fa-trash"></i> &nbsp; <b>Cancel Event</b>
                </a>
            </li>
            <li class="list-group-item mb-3 shadow-sm" style="background-color: #f8f9fa; border-radius: 8px;">
                <a class="text-decoration-none d-block py-2" href="member_profil.php" style="color: #303030;">
                    <i class="fa fa-user"></i> &nbsp; <b>Profil Saya</b>
                </a>
            </li>
            <li class="list-group-item mb-3 shadow-sm" style="background-color: #f8f9fa; border-radius: 8px;">
                <a class="text-decoration-none d-block py-2" href="member_password.php" style="color: #303030;">
                    <i class="fa fa-lock"></i> &nbsp; <b>Ganti Password</b>
                </a>
            </li>
            <li class="list-group-item shadow-sm" style="background-color: #f8f9fa; border-radius: 8px;">
                <a class="text-decoration-none d-block py-2" href="member_logout.php" style="color: #303030;">
                    <i class="fa fa-sign-out"></i> &nbsp; <b>Keluar</b>
                </a>
            </li>
        </ul>
    </div>


</div>
<!-- /ASIDE -->
