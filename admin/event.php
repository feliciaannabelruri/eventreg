<?php include 'header.php'; ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Event Management
            <small>Daftar Event</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Event Management</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <section class="col-lg-10 col-lg-offset-1">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">Event List</h3>
                        <a href="event_tambah.php" class="btn btn-info btn-sm pull-right"><i class="fa fa-plus"></i> &nbsp; Tambah Event Baru</a>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="table-datatable">
                                <thead>
                                    <tr>
                                        <th width="1%">NO</th>
                                        <th>NAMA EVENT</th>
                                        <th>TANGGAL</th>
                                        <th>WAKTU</th>
                                        <th>LOKASI</th>
                                        <th>STATUS</th>
                                        <th>TOTAL PESERTA</th> <!-- New column for total participants -->
                                        <th width="10%">OPSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    include '../koneksi.php';
                                    $no = 1;
                                    // Update query to count registrations
                                    $data = mysqli_query($koneksi, "
                                        SELECT e.*, 
                                            (SELECT COUNT(*) FROM event_registration er WHERE er.event_id = e.event_id) AS current_participants 
                                        FROM event e
                                    ");
                                    while ($d = mysqli_fetch_array($data)) {
                                        // Get the current participants and max participants
                                        $currentParticipants = $d['current_participants'];
                                        $maxParticipants = $d['event_max_partisipan'];
                                        ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo $d['event_nama']; ?></td>
                                            <td><?php echo $d['event_tanggal']; ?></td>
                                            <td><?php echo $d['event_waktu']; ?></td>
                                            <td><?php echo $d['event_lokasi']; ?></td>
                                            <td><?php echo $d['event_status']; ?></td>
                                            <td><?php echo $currentParticipants . '/' . $maxParticipants; ?></td> <!-- Display current/max participants -->
                                            <td>
                                                <a class="btn btn-info btn-sm" href="event_detail.php?id=<?php echo $d['event_id']; ?>"><i class="fa fa-eye"></i></a>
                                                <a class="btn btn-warning btn-sm" href="event_edit.php?id=<?php echo $d['event_id']; ?>"><i class="fa fa-cog"></i></a>
                                                <a class="btn btn-danger btn-sm" href="#" onclick="openDeleteModal('<?php echo $d['event_id']; ?>')"><i class="fa fa-trash"></i></a>
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

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <h5 class="modal-title" id="deleteConfirmationLabel" style="margin: 0; text-align: left;">Konfirmasi Hapus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-left: auto;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus event ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <a id="confirmDeleteButton" class="btn btn-danger">Hapus</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<script>
    function openDeleteModal(id) {
        // Set ID event ke link hapus di modal
        const confirmButton = document.getElementById('confirmDeleteButton');
        confirmButton.href = "event_hapus.php?id=" + id;

        // Tampilkan modal
        $('#deleteConfirmationModal').modal('show');
    }
</script>
