<?php include 'header.php'; ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Event Registrations
            <small>Daftar Registrasi Event</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Event Registrations</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <section class="col-lg-10 col-lg-offset-1">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">Filter Registrasi Event</h3>
                    </div>
                    <div class="box-body">
                        <form method="GET" action="list_registration.php">
                            <div class="form-group">
                                <label for="event_id">Pilih Event:</label>
                                <select id="event_id" name="event_id" class="form-control" required>
                                    <option value="">-- Pilih Event --</option>
                                    <?php
                                    include '../koneksi.php';
                                    $eventData = mysqli_query($koneksi, "SELECT * FROM event");
                                    while ($event = mysqli_fetch_array($eventData)) {
                                        echo '<option value="' . $event['event_id'] . '">' . $event['event_nama'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-info">Tampilkan Registrasi</button>
                        </form>
                    </div>
                </div>

                <?php if (isset($_GET['event_id'])): ?>
                    <?php 
                    $selected_event_id = $_GET['event_id'];
                    $selected_event_query = mysqli_query($koneksi, "SELECT event_nama FROM event WHERE event_id = '$selected_event_id'");
                    $selected_event = mysqli_fetch_array($selected_event_query);
                    ?>
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title">Registrasi untuk Event: <?php echo $selected_event['event_nama']; ?></h3>
                            <a href="export_registration.php?event_id=<?php echo $selected_event_id; ?>" class="btn btn-success pull-right">Export to CSV</a>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID Anggota</th>
                                            <th>Nama Anggota</th>
                                            <th>HP Anggota</th>
                                            <th>Email Anggota</th>
                                            <th>Alamat Anggota</th>
                                            <th>Tanggal Pendaftaran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Query untuk mengambil data registrasi berdasarkan event_id
                                        $registrants_query = mysqli_query($koneksi, "
                                            SELECT m.member_id, m.member_nama, m.member_hp, m.member_email, m.member_alamat, er.registration_date 
                                            FROM event_registration er 
                                            JOIN member m ON er.member_id = m.member_id 
                                            WHERE er.event_id = '$selected_event_id'
                                        ");

                                        if (mysqli_num_rows($registrants_query) > 0) {
                                            while ($registrant = mysqli_fetch_array($registrants_query)) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $registrant['member_id']; ?></td>
                                                    <td><?php echo $registrant['member_nama']; ?></td>
                                                    <td><?php echo $registrant['member_hp']; ?></td>
                                                    <td><?php echo $registrant['member_email']; ?></td>
                                                    <td><?php echo $registrant['member_alamat']; ?></td>
                                                    <td><?php echo $registrant['registration_date']; ?></td>
                                                </tr>
                                                <?php 
                                            }
                                        } else {
                                            echo '<tr><td colspan="6">Belum ada anggota yang mendaftar untuk event ini.</td></tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </section>
        </div>
    </section>
</div>

<?php include 'footer.php'; ?>
