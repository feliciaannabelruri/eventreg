<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Event Registration System</title>
    <link href="gambar/sistem/weeboding.png" rel="icon" type="image/png">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/navbar.css" rel="stylesheet">
    <script src="assets_forum/assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets_forum/assets/vendor/popper/popper.min.js"></script>
    <script src="assets_forum/assets/vendor/bootstrap/bootstrap.min.js"></script>
    <script src="assets/bower_components/ckeditor/ckeditor.js"></script>
    <script src="assets_forum/assets/vendor/headroom/headroom.min.js"></script>
    <script src="assets_forum/assets/js/argon.js?v=1.1.0"></script>

    <link rel="stylesheet" href="assets_forum/summernote2/summernote-bs4.css">
    <script src="assets_forum/summernote2/summernote-bs4.js"></script>
</head>

<body>

<footer class="bg-dark w-100 mt-5">
    <div class="container py-5">
        <!-- Grid -->
        <div class="row text-center text-lg-start">
            <!-- Login Admin -->
            <div class="col-12 col-lg-3 mb-4">
                <a href="#" class="d-block h4 font-weight-bold text-white text-decoration-none" aria-label="Brand">Event Registration System</a>
                <ul class="list-unstyled mt-3">
                    <li>
                        <p class="mt-2 text-white">Register now to our event! Stay updated with the latest details. Don’t miss out!</p>
                    </li>
                    <li>

                    </li>
                </ul>

            </div>
            <a href="login.php" style="font-weight: bold" class="text-white text-decoration-none">Login Admin</a>
        </div>

        <!-- Copyright -->
        <div class="border-top border-secondary pt-4 mt-4 d-flex flex-column flex-sm-row justify-content-between align-items-center">
            <div class="text-center">
                <p class="text-white mb-0" style="font-size: 16px;">
                    <img src="gambar/sistem/weeboding.png" height="28px" alt="Logo">
                    © 2025 Event Registration System.
                </p>
            </div>
        </div>
    </div>
</footer>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        $('#editor_forum').summernote({
            height: '250px',
            callbacks: {
                onImageUpload: function(image) {
                    uploadImage(image[0]);
                },
                onMediaDelete: function(target) {
                    deleteImage(target[0].src);
                }
            }
        });

        function uploadImage(image) {
            var data = new FormData();
            data.append("file", image);
            $.ajax({
                url: 'summernote_upload.php',
                cache: false,
                contentType: false,
                processData: false,
                data: data,
                type: "post",
                success: function(url) {
                    var image = $('<img>').attr('src', 'http://' + url);
                    $('#editor_forum').summernote("insertNode", image[0]);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        function deleteImage(src) {
            $.ajax({
                data: { src: src },
                type: "POST",
                url: "summernote_delete.php",
                cache: false,
                success: function(response) {
                    console.log(response);
                }
            });
        }
    });
</script>
</body>

</html>
