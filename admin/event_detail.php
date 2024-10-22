<?php 
include 'header.php'; 
include '../koneksi.php';

// Ambil ID dari URL
$id = $_GET['id'];

// Ambil data event berdasarkan ID
$query = mysqli_query($koneksi, "SELECT * FROM event WHERE event_id = '$id'");
$event = mysqli_fetch_array($query);

// Query untuk mengambil data anggota yang mendaftar pada event ini
$registrants_query = mysqli_query($koneksi, "SELECT m.member_id, m.member_nama, er.registration_date FROM event_registration er JOIN member m ON er.member_id = m.member_id WHERE er.event_id = '$id'");

?>

<div class="content-wrapper">

  <section class="content-header">
    <h1>
      Detail Event
      <small><?php echo $event['event_nama']; ?></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="event.php">Event Management</a></li>
      <li class="active"><?php echo $event['event_nama']; ?></li>
    </ol>
  </section>

  <section class="content">
    <div class="row">
      <section class="col-lg-10 col-lg-offset-1">
        <div class="box box-info">
          <div class="box-header">
            <h3 class="box-title">Informasi Detail Event</h3>
            <a href="event.php" class="btn btn-info btn-sm pull-right"><i class="fa fa-reply"></i> &nbsp; Kembali</a> 
          </div>
          <div class="box-body">
            <h4>Nama Event: <?php echo $event['event_nama']; ?></h4>
            <p><strong>Tanggal:</strong> <?php echo $event['event_tanggal']; ?></p>
            <p><strong>Waktu:</strong> <?php echo $event['event_waktu']; ?></p>
            <p><strong>Lokasi:</strong> <?php echo $event['event_lokasi']; ?></p>
            <p><strong>Max Participant:</strong> <?php echo $event['event_max_partisipan']; ?></p>
            <p><strong>Status:</strong> <?php echo $event['event_status']; ?></p>
            <p><strong>Deskripsi:</strong> <?php echo $event['event_deskripsi']; ?></p>

            <!-- Menampilkan Banner Event -->
            <p><strong>Banner:</strong></p>
            <?php if (!empty($event['event_banner'])): ?>
              <img src="../gambar/event/<?php echo $event['event_banner']; ?>" alt="Banner Event" style="max-width: 100%; height: auto;">
            <?php else: ?>
              <p>Tidak ada banner yang tersedia.</p>
            <?php endif; ?>

            <!-- Menampilkan Gambar Event -->
            <p><strong>Gambar Event:</strong></p>
            <?php if (!empty($event['event_image'])): ?>
              <img src="../gambar/event/<?php echo $event['event_image']; ?>" alt="Gambar Event" style="max-width: 100%; height: auto;">
            <?php else: ?>
              <p>Tidak ada gambar yang tersedia.</p>
            <?php endif; ?>

            <!-- Tabel Pendaftar -->
            <h3>Daftar Anggota yang Mendaftar</h3>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>ID Anggota</th>
                  <th>Nama Anggota</th>
                  <th>Tanggal Pendaftaran</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($registrant = mysqli_fetch_array($registrants_query)): ?>
                  <tr>
                    <td><?php echo $registrant['member_id']; ?></td>
                    <td><?php echo $registrant['member_nama']; ?></td>
                    <td><?php echo $registrant['registration_date']; ?></td>
                  </tr>
                <?php endwhile; ?>
                <?php if (mysqli_num_rows($registrants_query) == 0): ?>
                  <tr>
                    <td colspan="3">Belum ada anggota yang mendaftar untuk event ini.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>

          </div>
        </div>
      </section>
    </div>
  </section>

</div>

<?php include 'footer.php'; ?>
