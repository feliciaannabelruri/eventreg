<?php include 'header.php'; ?>

<div class="content-wrapper">

  <section class="content-header">
    <h1>
      Dashboard
      <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <section class="content">

    <div class="row">

      <div class="col-lg-6 col-xs-12">
        <div class="small-box bg-green">
          <div class="inner">
            <?php 
            // Query to count total events
            $eventCountQuery = mysqli_query($koneksi, "SELECT COUNT(*) as total_events FROM event");
            $eventCount = mysqli_fetch_assoc($eventCountQuery)['total_events'];
            ?>
            <h3><?php echo $eventCount; ?></h3>
            <p>Jumlah Event</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
        </div>
      </div>

      <div class="col-lg-6 col-xs-12">
        <div class="small-box bg-aqua">
          <div class="inner">
            <?php 
            // Query to count total registrants per event
            $registrantCountQuery = mysqli_query($koneksi, "
                SELECT COUNT(*) as total_registrants 
                FROM event_registration 
                GROUP BY event_id
            ");
            $totalRegistrants = 0;

            // Sum the counts of registrants for each event
            while ($row = mysqli_fetch_assoc($registrantCountQuery)) {
                $totalRegistrants += $row['total_registrants'];
            }
            ?>
            <h3><?php echo $totalRegistrants; ?></h3>
            <p>Jumlah Pendaftar per Event</p>
          </div>
          <div class="icon">
            <i class="ion ion-android-list"></i>
          </div>
        </div>
      </div>

    </div>

    <div class="row">    
      <section class="col-lg-7">

        <div class="box box-info">
          <div class="box-header">
            <h3 class="box-title">Detail Login</h3>
          </div>
          <div class="box-body">
            <table class="table table-bordered">
              <tr>
                <th width="30%">Nama</th>
                <td><?php echo $_SESSION['nama']; ?></td>
              </tr>
              <tr>
                <th>Username</th>
                <td><?php echo $_SESSION['username']; ?></td>
              </tr>
              <tr>
                <th>Level Hak Akses</th>
                <td>
                  <span class="label label-success text-uppercase"><?php echo $_SESSION['status']; ?></span>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </section>
    </div>

  </section>

</div>
<?php include 'footer.php'; ?>
