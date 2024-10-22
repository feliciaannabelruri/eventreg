<?php include 'header.php'; ?>

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
                }
            }
            ?>

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
                <h3 class="mb-3 mb-md-0">Daftar Event</h3>
                <div>
                    <button class="btn btn-secondary mb-md-0 me-2" data-toggle="modal" data-target="#pastEventsModal">Event Terlewat</button>
                    <button class="btn btn-info text-white" data-toggle="modal" data-target="#registeredEventsModal">Event Terdaftar</button>
                </div>
            </div>


            <div class="row">
                <?php
                // Get current user's ID (assuming session is started and user ID is stored)
                $userId = $_SESSION['member_id'];

                // Pagination setup
                $halaman = 9;  // jumlah event per halaman, bisa diatur ke 9, atau lebih
                $page = isset($_GET["halaman"]) ? (int)$_GET["halaman"] : 1;
                $mulai = ($page > 1) ? ($page * $halaman) - $halaman : 0;

                // Ambil total jumlah event yang belum didaftarkan oleh pengguna
                $result = mysqli_query($koneksi, "
                    SELECT * FROM event 
                    WHERE event_id NOT IN (SELECT event_id FROM event_registration WHERE member_id = $userId)
                ");
                $total = mysqli_num_rows($result);
                $pages = ceil($total / $halaman);


                // Ambil data event terbaru yang belum didaftarkan
                $data = mysqli_query($koneksi, "
                    SELECT * FROM event 
                    WHERE event_id NOT IN (SELECT event_id FROM event_registration WHERE member_id = $userId)
                    AND event_tanggal >= CURDATE()  -- Menambahkan kondisi untuk tanggal hari ini dan ke atas
                    ORDER BY event_tanggal ASC  -- Mengurutkan dari yang terdekat
                    LIMIT $mulai, $halaman
                ");


                // Ambil data event terbaru yang sudah didaftarkan
                $registeredEventsQuery = mysqli_query($koneksi, "
                    SELECT e.* FROM event e
                    JOIN event_registration er ON e.event_id = er.event_id
                    WHERE er.member_id = $userId
                ");

                // Prepare the registered events
                $registeredEvents = [];
                while ($event = mysqli_fetch_array($registeredEventsQuery)) {
                    $registeredEvents[] = $event;
                }

                // Fetch all past events for the current user
                $today = date('Y-m-d'); // Get today's date
                $pastEventsQuery = mysqli_query($koneksi, "
                    SELECT * FROM event 
                    WHERE event_tanggal < '$today'
                ");

                // Prepare the past events
                $pastEvents = [];
                while ($event = mysqli_fetch_array($pastEventsQuery)) {
                    $pastEvents[] = $event;
                }

                // Fetching the member ID from the session (optional)
                $id_member = isset($_SESSION['member_id']) ? $_SESSION['member_id'] : null;

                // Check if there are any events
                if (mysqli_num_rows($data) > 0) {
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
                } else {
                    // Display message when there are no events
                    echo "<div class='col-12 text-center'><h5>Tidak ada Event tersedia untuk saat ini</h5></div>";
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

<!-- Past Events Modal -->
<div class="modal fade" id="pastEventsModal" tabindex="-1" role="dialog" aria-labelledby="pastEventsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pastEventsModalLabel">Event Terlewat</h5>
                <button type="button" class="btn btn-link" data-dismiss="modal" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="black" class="bi bi-x" viewBox="0 0 16 16">
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="row" id="pastEventsContainer">
                    <!-- Past events cards will be injected here via JavaScript -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>


<!-- Registered Events Modal -->
<div class="modal fade" id="registeredEventsModal" tabindex="-1" role="dialog" aria-labelledby="registeredEventsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registeredEventsModalLabel">Event Terdaftar</h5>
                <button type="button" class="btn btn-link" data-dismiss="modal" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="black" class="bi bi-x" viewBox="0 0 16 16">
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="row" id="registeredEventsContainer">
                    <!-- Registered events cards will be injected here via JavaScript -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
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

    // Show registered events in the modal
    $('#registeredEventsModal').on('show.bs.modal', function () {
        var registeredEventsContainer = $('#registeredEventsContainer');
        registeredEventsContainer.empty(); // Clear previous content

        // PHP variable to provide registered events data to JS
        var registeredEvents = <?php echo json_encode($registeredEvents); ?>;

        // Check if there are registered events
        if (registeredEvents.length === 0) {
            registeredEventsContainer.append(`
            <div class="col-12 text-center">
                <p>Tidak ada Event tersedia untuk saat ini.</p>
            </div>
        `);
        } else {
            // Generate cards for registered events
            registeredEvents.forEach(function(event) {
                var card = `
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <img class="card-img-top" src="gambar/event/${event.event_image}" alt="Event image" style="max-height: 180px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">${event.event_nama}</h5>
                            <p class="card-text">${event.event_deskripsi.substring(0, 80)}...</p>
                            <p class="card-text">
                                <small class="text-muted">
                                    ${new Date(event.event_tanggal).toLocaleDateString('id-ID', {
                    weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
                })}
                                </small>
                            </p>
                        </div>
                    </div>
                </div>`;
                registeredEventsContainer.append(card);
            });
        }
    });


    // Show past events in the modal
    $('#pastEventsModal').on('show.bs.modal', function () {
        var pastEventsContainer = $('#pastEventsContainer');
        pastEventsContainer.empty(); // Clear previous content

        // PHP variable to provide past events data to JS
        var pastEvents = <?php echo json_encode($pastEvents); ?>;

        // Check if there are past events
        if (pastEvents.length === 0) {
            pastEventsContainer.append(`
            <div class="col-12 text-center">
                <p>Tidak ada Event tersedia untuk saat ini.</p>
            </div>
        `);
        } else {
            // Generate cards for past events
            pastEvents.forEach(function(event) {
                var card = `
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <img class="card-img-top" src="gambar/event/${event.event_image}" alt="Event image" style="max-height: 180px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">${event.event_nama}</h5>
                            <p class="card-text">${event.event_deskripsi.substring(0, 80)}...</p>
                            <p class="card-text">
                                <small class="text-muted">
                                    ${new Date(event.event_tanggal).toLocaleDateString('id-ID', {
                    weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
                })}
                                </small>
                            </p>
                        </div>
                    </div>
                </div>`;
                pastEventsContainer.append(card);
            });
        }
    });


});
</script>
