<?php include 'header.php'; ?>

<div class="content-wrapper">

  <section class="content-header">
    <h1>
      Member
      <small>Data Member</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <section class="content">
    <div class="row">
      <section class="col-lg-10 col-lg-offset-1">
        <div class="box box-info">

          <div class="box-header">
            <h3 class="box-title">Member</h3>
            <a href="member_tambah.php" class="btn btn-info btn-sm pull-right"><i class="fa fa-plus"></i> &nbsp Tambah Member Baru</a>              
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table class="table table-bordered table-striped" id="table-datatable">
                <thead>
                  <tr>
                    <th width="1%">NO</th>
                    <th>NAMA</th>
                    <th>EMAIL</th>
                    <th>HP/WA</th>
                    <th>ALAMAT</th>
                    <th width="10%">OPSI</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  include '../koneksi.php';
                  $no=1;
                  $data = mysqli_query($koneksi,"SELECT * FROM member");
                  while($d = mysqli_fetch_array($data)){
                    ?>
                    <tr>
                      <td><?php echo $no++; ?></td>
                      <td>
                       <?php 
                       if($d['member_foto'] == ""){
                        ?>
                        <img class="img-fluid rounded-circle shadow" style="width: 25px;height: 25px" src="../gambar/sistem/member.png">
                        <?php
                      }else{
                        ?>
                        <img class="img-fluid rounded-circle shadow" style="width: 25px;height: 25px" src="../gambar/member/<?php echo $d['member_foto'] ?>">
                        <?php
                      }
                      ?>
                      &nbsp;
                      <?php echo $d['member_nama']; ?>
                    </td>
                    <td><?php echo $d['member_email']; ?></td>
                    <td><?php echo $d['member_hp']; ?></td>
                    <td><?php echo $d['member_alamat']; ?></td>
                    <td>                        
                      <a class="btn btn-warning btn-sm" href="member_edit.php?id=<?php echo $d['member_id'] ?>"><i class="fa fa-cog"></i></a>
                      <a class="btn btn-danger btn-sm" href="member_hapus_konfir.php?id=<?php echo $d['member_id'] ?>"><i class="fa fa-trash"></i></a>
                    </td>
                  </tr>
                  <?php 
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </section>
  </div>
</section>

</div>
<?php include 'footer.php'; ?>