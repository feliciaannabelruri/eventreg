<?php include 'header.php'; ?>
<?php include '../koneksi.php'; ?>

<div class="content-wrapper">

  <section class="content-header">
    <h1>
      Event Management
      <small>Edit Event</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Event Management</li>
    </ol>
  </section>

  <section class="content">
    <div class="row">
      <section class="col-lg-6 col-lg-offset-3">       
        <div class="box box-info">

          <div class="box-header">
            <h3 class="box-title">Edit Event</h3>
            <a href="event.php" class="btn btn-info btn-sm pull-right"><i class="fa fa-reply"></i> &nbsp; Kembali</a> 
          </div>
          <div class="box-body">
            <form action="event_update.php" method="post" enctype="multipart/form-data">
              <?php 
              $id = $_GET['id'];              
              $data = mysqli_query($koneksi, "SELECT * FROM event WHERE event_id='$id'");
              $d = mysqli_fetch_array($data);
              ?>

              <div class="form-group">
                <label>Nama Event</label>
                <input type="text" class="form-control" name="nama_event" value="<?php echo $d['event_nama'] ?>" required>
                <input type="hidden" class="form-control" name="id" value="<?php echo $d['event_id'] ?>" required>
              </div>

              <div class="form-group">
                <label>Tanggal</label>
                <input type="date" class="form-control" name="tanggal" value="<?php echo $d['event_tanggal'] ?>" required>
              </div>

              <div class="form-group">
                <label>Waktu</label>
                <input type="time" class="form-control" name="waktu" value="<?php echo $d['event_waktu'] ?>" required>
              </div>

              <div class="form-group">
                <label>Lokasi</label>
                <input type="text" class="form-control" name="lokasi" value="<?php echo $d['event_lokasi'] ?>" required>
              </div>

              <div class="form-group">
                <label>Deskripsi</label>
                <textarea class="form-control" name="deskripsi" required><?php echo $d['event_deskripsi'] ?></textarea>
              </div>

              <div class="form-group">
                <label>Max Partisipan</label>
                <input type="number" class="form-control" name="max_partisipan" value="<?php echo $d['event_max_partisipan'] ?>" required>
              </div>

              <div class="form-group">
                <label>Status</label>
                <select class="form-control" name="status" required>
                  <option value="open" <?php if($d['event_status'] == 'open') echo 'selected'; ?>>Open</option>
                  <option value="closed" <?php if($d['event_status'] == 'closed') echo 'selected'; ?>>Closed</option>
                  <option value="canceled" <?php if($d['event_status'] == 'canceled') echo 'selected'; ?>>Canceled</option>
                </select>
              </div>

              <div class="form-group">
                <label>Banner Event</label>
                <input type="file" name="banner">
                <small class="text-muted">Kosongkan jika tidak ingin diubah</small>
              </div>

              <div class="form-group">
                <label>Image Event</label>
                <input type="file" name="image">
                <small class="text-muted">Kosongkan jika tidak ingin diubah</small>
              </div>

              <div class="form-group">
                <input type="submit" class="btn btn-sm btn-primary" value="Simpan">
              </div>
            </form>
          </div>

        </div>
      </section>
    </div>
  </section>

</div>
<?php include 'footer.php'; ?>
