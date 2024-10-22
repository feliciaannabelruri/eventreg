<?php include 'header.php'; ?>

<style>
    .kotakdisini{
        height: 535px;
    }

    @media (max-width: 768px) {
        .kotakdisini{
            height: 730px
        }
    }

    .arrow-button {
        background: none;
        border: none;
        font-size: 24px; /* Ukuran font yang lebih besar untuk panah */
        cursor: pointer; /* Ubah kursor saat hover */
    }
    .arrow-button:disabled {
        color: grey; /* Ubah warna tombol saat dinonaktifkan */
        cursor: not-allowed; /* Ubah kursor saat tombol dinonaktifkan */
    }



</style>

<div class="container">
    <div class="row">
        <?php include 'member_menu.php'; ?>
        <div class="col-lg-9 col-md-12">
            <div>
                <div class="bg-white p-2 mb-4 bg-white rounded-5 shadow">
                    <h6 class="p-3" style="font-size: 25px; font-weight: bold">
                        Dashboard
                    </h6>
                </div>
                <div class="bg-white p-4 bg-white kotakdisini rounded-5 shadow">
                    <div class="row p-2">
                        <div class="col-lg-6 my-1 col-md-6 col-sm-12">
                            <div class="card card-body rounded-3 shadow bg-primary text-white">
                                <?php
                                $id_member = $_SESSION['member_id'];

                                // Fetching the number of events the member has joined
                                $events_count_query = mysqli_query($koneksi, "SELECT COUNT(*) as total_events FROM event_registration WHERE member_id='$id_member'");

                                if ($events_count_query) {
                                    $events_count = mysqli_fetch_assoc($events_count_query)['total_events'];
                                } else {
                                    die("Database query failed: " . mysqli_error($koneksi));
                                }
                                ?>
                                <h4 class="text-white"><?php echo $events_count; ?></h4>
                                <small>Jumlah Event yang Diikuti</small>
                            </div>
                        </div>
                        <div class="col-lg-6 my-1 col-md-6 col-sm-12">
                            <div class="card card-body shadow bg-info text-white">
                                <?php
                                // Fetching the number of events happening today for the member
                                $today_date = date('Y-m-d'); // Get the current date in YYYY-MM-DD format
                                $today_events_query = mysqli_query($koneksi, "
                                    SELECT COUNT(*) as today_events 
                                    FROM event_registration er
                                    JOIN event e ON er.event_id = e.event_id 
                                    WHERE er.member_id='$id_member' AND e.event_tanggal = '$today_date'");

                                if ($today_events_query) {
                                    $today_events_count = mysqli_fetch_assoc($today_events_query)['today_events'];
                                } else {
                                    die("Database query failed: " . mysqli_error($koneksi));
                                }
                                ?>
                                <h4 class="text-white"><?php echo $today_events_count; ?></h4>
                                <small>Jumlah Event Hari Ini</small>
                            </div>
                        </div>
                        <div class="col-lg-6 my-1 col-md-6 col-sm-12">
                            <div class="card card-body rounded-3 shadow bg-primary text-white position-relative">
                                <?php
                                // Fetch the count of past events
                                $past_events_query = mysqli_query($koneksi, "
                                    SELECT COUNT(*) as total_past_events 
                                    FROM event_registration er
                                    JOIN event e ON er.event_id = e.event_id 
                                    WHERE er.member_id='$id_member' AND e.event_tanggal < CURDATE()");

                                if ($past_events_query) {
                                    $past_events_count = mysqli_fetch_assoc($past_events_query)['total_past_events'];
                                } else {
                                    die("Database query failed: " . mysqli_error($koneksi));
                                }
                                ?>
                                <h4 class="text-white"><?php echo $past_events_count; ?></h4>
                                <small>Event yang Sudah Berlalu</small>

                                <!-- Button to trigger the modal -->
                                <button class="btn btn-light position-absolute" data-toggle="modal" data-target="#pastEventsModal" style="top: 10px; right: 10px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="black" class="bi bi-info-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="col-lg-6 my-1 col-md-6 col-sm-12">
                            <div class="card card-body rounded-3 shadow bg-info text-white position-relative">
                                <?php
                                // Fetch the count of upcoming events
                                $upcoming_events_query = mysqli_query($koneksi, "
                                    SELECT COUNT(*) as total_upcoming_events 
                                    FROM event_registration er
                                    JOIN event e ON er.event_id = e.event_id 
                                    WHERE er.member_id='$id_member' AND e.event_tanggal >= CURDATE()");

                                if ($upcoming_events_query) {
                                    $upcoming_events_count = mysqli_fetch_assoc($upcoming_events_query)['total_upcoming_events'];
                                } else {
                                    die("Database query failed: " . mysqli_error($koneksi));
                                }
                                ?>
                                <h4 class="text-white"><?php echo $upcoming_events_count; ?></h4>
                                <small>Event yang Akan Datang</small>

                                <!-- Button to trigger the modal for upcoming events -->
                                <button class="btn btn-light position-absolute" data-toggle="modal" data-target="#upcomingEventsModal" style="top: 10px; right: 10px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="black" class="bi bi-info-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                                    </svg>
                                </button>
                            </div>
                        </div>


                    </div>

                    <div class="row p-3">
                        <div class="card card-body p-3 rounded-3 shadow text-white shadow-sm" style="background-color: #f8f9fa;">
                            <div class="d-flex mb-1 justify-content-between align-items-center mt-2">
                                <h5 class="text-black">List Event Hari Ini:</h5>
                                <div>
                                    <?php if ($events_count > 1): ?>
                                        <button class="arrow-button" id="prevButton" onclick="navigateEvent(-1)">
                                            &#10094; <!-- Left arrow -->
                                        </button>
                                        <span style="margin: 0 10px;"></span> <!-- Jarak 10px -->
                                        <button class="arrow-button" id="nextButton" onclick="navigateEvent(1)">
                                            &#10095; <!-- Right arrow -->
                                        </button>
                                    <?php else: ?>
                                        <button class="arrow-button" id="prevButton" disabled>
                                            &#10094; <!-- Left arrow -->
                                        </button>
                                        <span style="margin: 0 10px;"></span> <!-- Jarak 10px -->
                                        <button class="arrow-button" id="nextButton" disabled>
                                            &#10095; <!-- Right arrow -->
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="row" style='height: 165px;'>
                                <?php
                                $event_list_query = mysqli_query($koneksi, "
                                    SELECT e.event_id, e.event_nama, e.event_tanggal, e.event_lokasi, e.event_deskripsi, e.event_banner, e.event_image, er.registration_id
                                    FROM event_registration er 
                                    JOIN event e ON er.event_id = e.event_id 
                                    WHERE er.member_id = '$id_member' AND e.event_tanggal = CURDATE()
                                    LIMIT 4"); // Limit to 4 events

                                if ($event_list_query && mysqli_num_rows($event_list_query) > 0) {
                                    setlocale(LC_TIME, 'id_ID.utf8', 'id_ID', 'Indonesian_indonesia.1252');
                                    while ($event = mysqli_fetch_assoc($event_list_query)) {
                                        // Format tanggal event
                                        $event_date = strftime('%A, %d %B %Y', strtotime($event['event_tanggal']));
                                        $event_date = ucfirst($event_date);

                                        echo "<div class='col-md-3 mb-2'>";
                                        echo "<div class='card h-100' style='height: 250px;'>";
                                        echo "<div class='card-body p-3'>";
                                        echo "<h6 class='card-title mb-1'>" . htmlspecialchars($event['event_nama']) . "</h6>";
                                        echo "<p class='card-text mb-1'>" . htmlspecialchars($event_date) . "</p>";
                                        echo "<p class='card-text mb-1'>" . htmlspecialchars($event['event_lokasi']) . "</p>";
                                        echo "<div class='d-flex justify-content-between align-items-center mt-2'>";
                                        echo "<button class='btn btn-danger btn-sm' data-toggle='modal' data-target='#cancelConfirmationModal' 
                                                    data-registration-id='" . $event['registration_id'] . "'>Cancel</button>";
                                        echo "<a href='#' class='text-primary' data-toggle='modal' data-target='#eventDetailModal'
                                                    data-id='" . $event['event_id'] . "' 
                                                    data-name='" . htmlspecialchars($event['event_nama']) . "' 
                                                    data-description='" . htmlspecialchars($event['event_deskripsi']) . "' 
                                                    data-date='" . $event_date . "' 
                                                    data-location='" . htmlspecialchars($event['event_lokasi']) . "' 
                                                    data-banner='" . htmlspecialchars($event['event_banner']) . "' 
                                                    data-image='" . htmlspecialchars($event['event_image']) . "'>
                                                    <svg xmlns='http://www.w3.org/2000/svg' width='18' height='18' fill='black' class='bi bi-info-circle' viewBox='0 0 16 16'>
                                                        <path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16'/>
                                                        <path d='m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0'/>
                                                    </svg>
                                                </a>";
                                        echo "</div></div></div></div>";
                                    }
                                } else {
                                    echo "<p class='text-sm text-black text-lg-center'>Tidak ada event yang akan datang.</p>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>


                    <!-- Modal for Upcoming Events Details -->
                    <div class="modal fade" id="upcomingEventsModal" tabindex="-1" role="dialog" aria-labelledby="upcomingEventsModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="upcomingEventsModalLabel">Event Yang Akan Datang</h5>
                                    <button type="button" class="btn btn-link" data-dismiss="modal" aria-label="Close">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="black" class="bi bi-x" viewBox="0 0 16 16">
                                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="modal-body" style="max-height: 60vh; overflow-y: auto;">
                                    <div class="row" id="upcomingEventsContainer">
                                        <?php
                                        $past_events_list_query = mysqli_query($koneksi, "
                                            SELECT e.event_id, e.event_nama, e.event_tanggal, e.event_lokasi, e.event_deskripsi, e.event_banner, e.event_image, er.registration_id
                                            FROM event_registration er 
                                            JOIN event e ON er.event_id = e.event_id 
                                            WHERE er.member_id = '$id_member' AND e.event_tanggal >= CURDATE()
                                            ORDER BY e.event_tanggal ASC");

                                        if ($past_events_list_query && mysqli_num_rows($past_events_list_query) > 0) {
                                            setlocale(LC_TIME, 'id_ID.utf8', 'id_ID', 'Indonesian_indonesia.1252');

                                            while ($event = mysqli_fetch_assoc($past_events_list_query)) {
                                                $event_date = strftime('%A, %d %B %Y', strtotime($event['event_tanggal']));
                                                $event_date = ucfirst($event_date);
                                                ?>
                                                <div class="col-md-4 mb-3">
                                                    <div class="card shadow-sm">
                                                        <img src="./gambar/event/<?php echo htmlspecialchars($event['event_image']); ?>" class="card-img-top" alt="Event Image" style="height: 200px; object-fit: cover;">
                                                        <div class="card-body">
                                                            <h5 class="card-title"><?php echo htmlspecialchars($event['event_nama']); ?></h5>
                                                            <p class="card-text">
                                                                <strong>Tanggal:</strong> <?php echo htmlspecialchars($event_date); ?><br>
                                                                <strong>Lokasi:</strong> <?php echo htmlspecialchars($event['event_lokasi']); ?>
                                                            </p>
                                                            <a type="button" class=" event-detail-button"
                                                                    data-id="<?php echo $event['event_id']; ?>"
                                                                    data-name="<?php echo htmlspecialchars($event['event_nama']); ?>"
                                                                    data-description="<?php echo htmlspecialchars($event['event_deskripsi']); ?>"
                                                                    data-date="<?php echo $event_date; ?>"
                                                                    data-location="<?php echo htmlspecialchars($event['event_lokasi']); ?>"
                                                                    data-banner="<?php echo htmlspecialchars($event['event_banner']); ?>"
                                                                    data-image="<?php echo htmlspecialchars($event['event_image']); ?>"
                                                                    data-registration-id="<?php echo $event['registration_id']; ?>">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="black" class="bi bi-info-circle" viewBox="0 0 16 16">
                                                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                                                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        } else {
                                            echo "<p class='text-center'>Belum ada event yang akan datang.</p>";
                                        }
                                        ?>

                                    </div>
                                    <div id="eventDetailContainer" style="display: none;">
                                        <div class="text-center">
                                            <img id="eventBanner" src="" style="max-height: 300px; max-width: 100%;" alt="Event Banner" class="img-fluid mx-auto">
                                            <img id="eventImage" src="" style="max-height: 300px; max-width: 100%;" alt="Event Image" class="img-fluid mx-auto">
                                        </div>
                                        <div style="margin-left: 60px; margin-right: 60px" class="bg-white p-3 bg-white my-3 rounded-3 shadow">
                                            <h5 id="eventName"></h5>
                                            <p id="eventDescription"></p>
                                            <p><strong>Tanggal:</strong> <span id="eventDate"></span></p>
                                            <p><strong>Lokasi:</strong> <span id="eventLocation"></span></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" id="modalBackButton">Kembali</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                </div>
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
                                        <?php
                                        // Fetch the list of past events ordered by date (most recent first)
                                        $past_events_list_query = mysqli_query($koneksi, "
                                            SELECT e.event_nama, e.event_tanggal, e.event_lokasi 
                                            FROM event_registration er 
                                            JOIN event e ON er.event_id = e.event_id 
                                            WHERE er.member_id = '$id_member' AND e.event_tanggal < CURDATE()
                                            ORDER BY e.event_tanggal DESC");

                                        if ($past_events_list_query && mysqli_num_rows($past_events_list_query) > 0) {
                                            // Set locale to Indonesian for date formatting
                                            setlocale(LC_TIME, 'id_ID.utf8', 'id_ID', 'Indonesian_indonesia.1252');

                                            while ($event = mysqli_fetch_assoc($past_events_list_query)) {
                                                // Format the date in Indonesian with day and month names
                                                $event_date = strftime('%A, %d %B %Y', strtotime($event['event_tanggal']));
                                                $event_date = ucfirst($event_date);
                                                ?>
                                                <div class="col-md-6 mb-3">
                                                    <div class="card shadow-sm">
                                                        <div class="card-body">
                                                            <h5 class="card-title"><?php echo htmlspecialchars($event['event_nama']); ?></h5>
                                                            <p class="card-text">
                                                                <strong>Tanggal:</strong> <?php echo htmlspecialchars($event_date); ?><br>
                                                                <strong>Lokasi:</strong> <?php echo htmlspecialchars($event['event_lokasi']); ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        } else {
                                            echo "<p class='text-center'>Belum ada event yang terlewat.</p>";
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Event Detail Modal -->
<div class="modal fade" id="eventDetailModal" tabindex="-1" role="dialog" aria-labelledby="eventDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventDetailModalLabel">Event Details</h5>
                <button type="button" class="btn btn-link" data-dismiss="modal" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="black" class="bi bi-x" viewBox="0 0 16 16">
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body text-center">
                <img id="eventBanner" src="" alt="Event Banner" style="max-width: 100%; height: auto; margin-bottom: 15px;">
                <img id="eventImage" src="" alt="Event Image" style="max-width: 100%; height: auto; margin-bottom: 15px;">
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


<?php include 'footer.php'; ?>

<!-- Include jQuery and Bootstrap JS if not already included -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function () {
        var isDetailView = false;

        // Menangani klik pada tombol detail di modal upcoming
        $('.event-detail-button').click(function () {
            var button = $(this);
            var name = button.data('name');
            var description = button.data('description');
            var date = button.data('date');
            var location = button.data('location');
            var banner = button.data('banner');
            var image = button.data('image');
            var registrationId = button.data('id');

            $('#eventName').text(name);
            $('#eventDescription').text(description);
            $('#eventDate').text(date);
            $('#eventLocation').text(location);
            $('#eventBanner').attr('src', './gambar/event/' + banner);
            $('#eventImage').attr('src', './gambar/event/' + image);
            $('#cancelButton').data('registration-id', registrationId);

            $('#upcomingEventsContainer').hide();
            $('#eventDetailContainer').show();
            isDetailView = true;
            $('#modalBackButton').text('Kembali');
        });

        // Menangani klik tombol kembali
        $('#modalBackButton').click(function () {
            if (isDetailView) {
                $('#eventDetailContainer').hide();
                $('#upcomingEventsContainer').show();
                $('#modalBackButton').text('Kembali');
                isDetailView = false;
            } else {
                $('#upcomingEventsModal').modal('hide');
            }
        });
    });
</script>
