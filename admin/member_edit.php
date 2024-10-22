<?php include 'header.php'; ?>

<div class="content-wrapper">

  <section class="content-header">
    <h1>
      Member
      <small>Edit Member</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <section class="content">
    <div class="row">
      <section class="col-lg-6 col-lg-offset-3">       
        <div class="box box-info">

          <div class="box-header">
            <h3 class="box-title">Edit Member</h3>
            <a href="member.php" class="btn btn-info btn-sm pull-right"><i class="fa fa-reply"></i> &nbsp Kembali</a> 
          </div>
          <div class="box-body">


            <?php 
            $id = $_GET['id'];
            $data = mysqli_query($koneksi,"select * from member where member_id='$id'");
            while($d = mysqli_fetch_array($data)){
              ?>
              <form action="member_update.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label>Nama</label>
                  <input type="hidden" name="id" value="<?php echo $d['member_id']; ?>">
                  <input type="text" class="form-control" name="nama" required="required" placeholder="Masukkan Nama member.." value="<?php echo $d['member_nama']; ?>">
                </div>

                <div class="form-group">
                  <label>Email</label>
                  <input type="text" class="form-control" name="email" required="required" placeholder="Masukkan email member.." value="<?php echo $d['member_email']; ?>">
                </div>

                <div class="form-group">
                  <label>HP / WA</label>
                  <input type="number" class="form-control" name="hp" required="required" placeholder="Masukkan hp member.." value="<?php echo $d['member_hp']; ?>">
                </div>

                <div class="form-group">
                  <label>Alamat</label>
                  <input type="text" class="form-control" name="alamat" required="required" placeholder="Masukkan alamat member.." value="<?php echo $d['member_alamat']; ?>">
                </div>

                <div class="form-group">
                  <label>Password</label>
                  <input type="password" class="form-control" name="password" placeholder="Masukkan password member..">
                  <small class="text-muted">Kosongkan jika tidak ingin mengganti password</small>
                </div>

                <div class="form-group">
                  <label>Foto Profil</label>
                  <input type="file" name="foto">
                  <small class="text-muted">Kosongkan jika tidak ingin mengganti foto profil</small>
                </div>

                <div class="form-group">
                  <input type="submit" class="btn btn-sm btn-primary" value="Simpan">
                </div>
              </form>
              <?php 
            }
            ?>

          </div>

        </div>
      </section>
    </div>
  </section>

</div>
<?php include 'footer.php'; ?>