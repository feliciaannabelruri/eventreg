<?php include 'header.php'; ?>

<style>
    .kotakdisini {
        height: 535px;
        overflow-y: auto; /* Tambahkan scroll jika konten melebihi tinggi */
    }

    @media (max-width: 768px) {
        .kotakdisini {
            height: 730px;
        }
    }

    .alert-custom {
        display: none;
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 0.25rem;
        position: relative;
    }

    .alert-custom.success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
    }

    .alert-custom.error {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }

    .alert-custom .close {
        position: absolute;
        top: 10px;
        right: 15px;
        color: inherit;
    }
</style>

<div class="container">
    <div class="row">
        <?php include 'member_menu.php'; ?>
        <div class="col-lg-9 col-md-12">
            <div>
                <div class="bg-white p-2 mb-4 rounded-5 shadow">
                    <h6 class="p-3" style="font-size: 25px; font-weight: bold">
                        Cancel Event
                    </h6>
                </div>
                <div class="bg-white p-4 kotakdisini rounded-5 shadow">

                    <div class="row p-4">
                        <h5 style="font-weight: bold" class="mb-4">List Event yang Diikuti:</h5>

                        <?php
                        // Fetch the list of events the member has registered for
                        $event_list_query = mysqli_query($koneksi, "
                            SELECT e.event_id, e.event_nama, e.event_tanggal, e.event_lokasi, e.event_deskripsi, e.event_banner, e.event_image, er.registration_id
                            FROM event_registration er 
                            JOIN event e ON er.event_id = e.event_id 
                            WHERE er.member_id = '$id_member' AND e.event_tanggal >= CURDATE()
                            ORDER BY e.event_tanggal ASC");

                        if ($event_list_query) {
                            if (mysqli_num_rows($event_list_query) > 0) {
                                echo "<table class='table'>";
                                echo "<thead>
                                    <tr>
                                        <th>Judul Event</th>
                                        <th>Tanggal</th>
                                        <th>Tempat</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>";
                                while ($event = mysqli_fetch_assoc($event_list_query)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($event['event_nama']) . "</td>";
                                    echo "<td>" . htmlspecialchars(date('d-M-Y', strtotime($event['event_tanggal']))) . "</td>";
                                    echo "<td>" . htmlspecialchars($event['event_lokasi']) . "</td>";
                                    // Action buttons
                                    echo "<td>";
                                    echo "<button class='btn btn-danger btn-sm' data-toggle='modal' data-target='#cancelConfirmationModal' 
                                            data-registration-id='" . $event['registration_id'] . "'>Cancel</button> ";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody></table>";
                            } else {
                                echo "<div class='alert alert-info' role='alert'>Anda tidak mengikuti event apapun.</div>";
                            }
                        } else {
                            die("Database query failed: " . mysqli_error($koneksi));
                        }
                        ?>
                    </div>

                    <!-- Custom Alert for Cancellation -->
                    <div class="alert-custom success" id="alertMessage">
                        Event berhasil dihapus!
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>

                    <div class="alert-custom error" id="errorMessage">
                        Terjadi kesalahan saat membatalkan pendaftaran.
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>

                    <!-- Confirmation Modal for Cancellation -->
                    <div class="modal fade" id="cancelConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="cancelConfirmationModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="cancelConfirmationModalLabel">Batalkan Pendaftaran?</h5>
                                    <button type="button" class="btn btn-link" data-dismiss="modal" aria-label="Close">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="black" class="bi bi-x" viewBox="0 0 16 16">
                                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Anda yakin ingin membatalkan pendaftaran untuk event ini?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    <button type="button" class="btn btn-danger" id="confirmCancelButton">Batalkan Pendaftaran</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
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

        $('#cancelConfirmationModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var registrationId = button.data('registration-id'); // Extract info from data-* attributes

            // Set the confirmation button to use this ID
            var modal = $(this);
            modal.find('#confirmCancelButton').data('registration-id', registrationId);
        });

        $('#confirmCancelButton').on('click', function() {
            var registrationId = $(this).data('registration-id');

            // Make an AJAX request to cancel the registration
            $.ajax({
                url: 'cancel_registration.php', // URL to the cancellation script
                type: 'POST',
                data: { registration_id: registrationId },
                success: function(response) {
                    // Handle success (e.g., reload the page or remove the row)
                    location.reload(); // Reload the page to see changes
                },
                error: function(xhr, status, error) {
                    alert("An error occurred while cancelling the registration.");
                }
            });

            $('#cancelConfirmationModal').modal('hide'); // Hide the modal after confirming
        });
    });
</script>
