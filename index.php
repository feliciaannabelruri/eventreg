<?php include 'header.php'; ?>

<link href="assets/css/index.css" rel="stylesheet">

<div class="bg-white p-5 bg-white rounded-5 shadow h-100 container">
    <div class="row">
        <div class="col-lg-12">
            <?php
            // Check for alert messages
            if (isset($_GET['alert'])) {
                if ($_GET['alert'] == "event_created") {
                    echo "<div class='alert alert-success text-center'>Event baru berhasil diterbitkan.</div>";
                } elseif ($_GET['alert'] == "registered_success") {
                    echo "<div class='alert alert-success text-center'>Pendaftaran event berhasil.</div>";
                } elseif ($_GET['alert'] == "already_registered") {
                    echo "<div class='alert alert-warning text-center'>Anda sudah mendaftar untuk event ini.</div>";
                } elseif ($_GET['alert'] == "failed") {
                    echo "<div class='alert alert-danger text-center'>Pendaftaran event gagal. Silakan coba lagi.</div>";
                } elseif ($_GET['alert'] == "belum_login") {
                    echo "<div class='alert alert-warning text-center'>Anda harus login terlebih dahulu.</div>";
                } elseif ($_GET['alert'] == "no_event") {
                    echo "<div class='alert alert-danger text-center'>Event tidak ditemukan.</div>";
                } elseif ($_GET['alert'] == "event_full") { // New check for full event alert
                    echo "<div class='alert alert-danger text-center'>Kapasitas event sudah penuh.</div>";
                }
            }


            // Ambil informasi event dari database
            $event_id = isset($_GET['id']) ? (int)$_GET['id'] : 0; // Ambil ID event dari GET parameter
            if ($event_id) {
                $query = "SELECT event_max_partisipan, current_participants FROM event WHERE event_id = ?";
                $stmt = $koneksi->prepare($query);
                $stmt->bind_param("i", $event_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $event = $result->fetch_assoc();
                    $eventMaxParticipants = $event['event_max_partisipan'];
                    $currentParticipants = $event['current_participants'];

                    if ($currentParticipants >= $eventMaxParticipants) {
                        echo "<script>
                                document.getElementById('eventCapacityAlert').classList.remove('d-none');
                                document.getElementById('currentParticipants').innerText = '$currentParticipants/$eventMaxParticipants';
                              </script>";
                    }
                }
            }
            ?>

            <h3 class="mb-4">Daftar Event</h3>

            <div class="row">
                <?php
                // Pagination setup
                $halaman = 9;  // jumlah event per halaman
                $page = isset($_GET["halaman"]) ? (int)$_GET["halaman"] : 1;
                $mulai = ($page > 1) ? ($page * $halaman) - $halaman : 0;

                // Get the current date
                $currentDate = date('Y-m-d');

                // Ambil total jumlah event yang belum terlewat (dari hari ini dan seterusnya)
                $result = mysqli_query($koneksi, "SELECT * FROM event WHERE event_tanggal >= '$currentDate' LIMIT 20");
                $total = mysqli_num_rows($result);
                $pages = ceil($total / $halaman);

                // Ambil data event terbaru dengan pagination
                $data = mysqli_query($koneksi, "SELECT * FROM event WHERE event_tanggal >= '$currentDate' ORDER BY event_tanggal DESC LIMIT $mulai, $halaman");

                // Fetching the member ID from the session (optional)
                $id_member = isset($_SESSION['member_id']) ? $_SESSION['member_id'] : null;

                // Tampilkan event dalam bentuk card
                while ($d = mysqli_fetch_array($data)) {
                    // Check if the user is already registered for this event
                    $event_id = $d['event_id'];
                    $is_registered = false; // Default to not registered
                    $total_participants = 0; // Variable for counting total participants

                    // Only check registration if the user is logged in
                    if ($id_member) {
                        $registration_query = mysqli_query($koneksi, "SELECT * FROM event_registration WHERE member_id='$id_member' AND event_id='$event_id'");
                        $is_registered = mysqli_num_rows($registration_query) > 0; // true if registered
                    }

                    // Count total participants for this event
                    $participant_count_query = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM event_registration WHERE event_id='$event_id'");
                    if ($participant_count_query) {
                        $total_participants = mysqli_fetch_assoc($participant_count_query)['total'];
                    }

                    // Check the max participants
                    $max_participants = $d['event_max_partisipan'];

                    ?>
                    <div class="col-md-4 col-lg-3 mb-4">
                        <div class="card shadow-sm h-100">
                            <img class="card-img-top" src="gambar/event/<?php echo $d['event_image']; ?>" alt="Event image" style="max-height: 180px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?php echo $d['event_nama']; ?></h5>
                                <p class="card-text">
                                    <?php echo substr($d['event_deskripsi'], 0, 80); ?>...
                                </p>
                                <p class="card-text">
                                    <small class="text-muted">
                                        <?php
                                        setlocale(LC_TIME, 'id_ID.utf8');
                                        echo strftime('%A, %d %B %Y', strtotime($d['event_tanggal']));
                                        ?>
                                    </small>
                                </p>
                                <p class="text-muted">
                                    <?php echo $total_participants . '/' . $max_participants; ?>
                                </p>
                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <?php if ($total_participants >= $max_participants): ?>
                                        <?php if ($is_registered): ?>
                                            <span class="btn btn-secondary" disabled>Sudah Terdaftar</span>
                                        <?php else: ?>
                                            <span class="btn btn-secondary" disabled>Ruang Penuh</span>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <?php if ($is_registered): ?>
                                            <span class="btn btn-secondary" disabled>Sudah Terdaftar</span>
                                        <?php else: ?>
                                            <a href="#" class="btn btn-success" onclick="confirmRegistration(<?php echo $event_id; ?>, '<?php echo htmlspecialchars($d['event_nama']); ?>')">
                                                Daftar Event
                                            </a>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <a href="#" class="text-primary" data-toggle="modal" data-target="#eventDetailModal"
                                       data-id="<?php echo $event_id; ?>"
                                       data-name="<?php echo htmlspecialchars($d['event_nama']); ?>"
                                       data-description="<?php echo htmlspecialchars($d['event_deskripsi']); ?>"
                                       data-date="<?php echo strftime('%A, %d %B %Y', strtotime($d['event_tanggal'])); ?>"
                                       data-location="<?php echo htmlspecialchars($d['event_lokasi']); ?>"
                                       data-banner="<?php echo $d['event_banner']; ?>"
                                       data-image="<?php echo $d['event_image']; ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="black" class="bi bi-info-circle" viewBox="0 0 16 16">
                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>


            <!-- Pagination -->
            <?php if ($pages > 1): ?>
                <nav aria-label="...">
                    <ul class="pagination justify-content-center">
                        <?php for ($i = 1; $i <= $pages; $i++) { ?>
                            <li class="page-item <?php if ($page == $i) echo 'active'; ?>">
                                <a class="page-link" href="?halaman=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Event Detail Modal -->
<div class="modal fade" id="eventDetailModal" tabindex="-1" role="dialog" aria-labelledby="eventDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventDetailModalLabel">Event Details</h5>
                <button type="button" class="btn btn-link" data-dismiss="modal" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="black" class="bi bi-x" viewBox="0 0 16 16">
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body text-center" style="max-height: 70vh; overflow-y: auto;">
                <img id="eventBanner" src="" alt="Event Banner" style="max-width: 200px; height: auto; margin-bottom: 15px;">
                <img id="eventImage" src="" alt="Event Image" style="max-width: 200px; height: auto; margin-bottom: 15px;">
                <h1 id="eventName"></h1>
                <p class="lead" id="eventDescription"></p>
                <p><strong>Date:</strong> <span id="eventDate"></span></p>
                <p><strong>Location:</strong> <span id="eventLocation"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="registrationConfirmModal" tabindex="-1" role="dialog" aria-labelledby="registrationConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registrationConfirmModalLabel">Konfirmasi Pendaftaran</h5>
                <button type="button" class="btn btn-link" data-dismiss="modal" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="black" class="bi bi-x" viewBox="0 0 16 16">
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin mendaftar untuk event <strong id="confirmEventName"></strong>?</p>
                <p><em>Semua informasi terkait pendaftaran diambil dari data profil Anda.</em></p>
                <div id="eventCapacityAlert" class="alert alert-danger d-none" role="alert">
                    Kapasitas Event sudah penuh! <strong id="currentParticipants"></strong>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="confirmRegistrationButton">Daftar</button>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<script>
    $(document).ready(function() {
        // Show event details in the modal
        $('#eventDetailModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var id = button.data('id'); // Extract info from data-* attributes
            var name = button.data('name');
            var description = button.data('description');
            var date = button.data('date');
            var location = button.data('location');
            var banner = button.data('banner'); // Add banner image
            var image = button.data('image');   // Add event image

            // Update the modal's content
            var modal = $(this);
            modal.find('#eventName').text(name);
            modal.find('#eventDescription').text(description);
            modal.find('#eventDate').text(date);
            modal.find('#eventLocation').text(location);

            // Update images in the modal
            modal.find('#eventBanner').attr('src', './gambar/event/' + banner);
            modal.find('#eventImage').attr('src', './gambar/event/' + image);
        });

        // Show confirmation modal for registration
        window.confirmRegistration = function(eventId, eventName) {
            $('#confirmEventName').text(eventName); // Set event name in confirmation modal
            $('#registrationConfirmModal').modal('show'); // Show the modal

            // Handle registration confirmation
            $('#confirmRegistrationButton').off('click').on('click', function() {
                window.location.href = 'daftar_event.php?id=' + eventId; // Redirect to registration
            });
        };
    });
</script>
