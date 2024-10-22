<?php include 'header.php'; ?>

<div class="content-wrapper">

  <section class="content-header">
    <h1>
      Event Management
      <small>Tambah Event Baru</small>
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
            <h3 class="box-title">Tambah Event</h3>
            <a href="event.php" class="btn btn-info btn-sm pull-right"><i class="fa fa-reply"></i> &nbsp; Kembali</a> 
          </div>
          <div class="box-body">
            <form action="event_act.php" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label>Nama Event</label>
                <input type="text" class="form-control" name="nama_event" required>
              </div>

              <div class="form-group">
                <label>Tanggal</label>
                <input type="date" class="form-control" name="tanggal" required>
              </div>

              <div class="form-group">
                <label>Waktu</label>
                <input type="time" class="form-control" name="waktu" required>
              </div>

              <div class="form-group">
                <label>Lokasi</label>
                <input type="text" class="form-control" name="lokasi" required>
              </div>

              <div class="form-group">
                <label>Deskripsi</label>
                <textarea class="form-control" name="deskripsi" required></textarea>
              </div>

              <div class="form-group">
                <label>Max Partisipan</label>
                <input type="number" class="form-control" name="max_partisipan" required>
              </div>

              <div class="form-group">
                <label>Status</label>
                <select class="form-control" name="status" required>
                  <option value="open">Open</option>
                  <option value="closed">Closed</option>
                  <option value="canceled">Canceled</option>
                </select>
              </div>

              <div class="form-group">
                <label>Banner Event</label>
                <input type="file" name="banner" required>
              </div>

              <div class="form-group">
                <label>Image Event</label>
                <input type="file" name="image" required>
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
