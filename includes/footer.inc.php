
<!--<button type="submit" name="uploadPhoto" 
        onclick="return confirm('Do you want to change your profile?')"
        class="btn btn-success">
    Upload
</button>-->
<script>
    document.addEventListener("DOMContentLoaded", function () {

        const uploadInput = document.getElementById("profileUpload");
        const previewImage = document.getElementById("previewImage");

        if (uploadInput) {
            uploadInput.addEventListener("change", function (event) {

                const reader = new FileReader();

                reader.onload = function () {
                    previewImage.src = reader.result;
                }

                reader.readAsDataURL(event.target.files[0]);
            });
        }
});

</script>

<script>
function confirmDelete() {
    return confirm("Do you want to delete your profile?");
}
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!--<script>
let cropper;
const image = document.getElementById('previewImage');
const fileInput = document.getElementById('profileUpload');
const cropBtn = document.getElementById('cropBtn');
const croppedInput = document.getElementById('croppedImage');

fileInput.addEventListener('change', function (e) {
    const files = e.target.files;
    const reader = new FileReader();

    reader.onload = function () {
        image.src = reader.result;

        if (cropper) {
            cropper.destroy();
        }

        cropper = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 1,
            movable: true,
            zoomable: true,
            scalable: true,
            cropBoxResizable: true,
        });
    };

    reader.readAsDataURL(files[0]);
});

cropBtn.addEventListener('click', function () {
    const canvas = cropper.getCroppedCanvas({
        width: 300,
        height: 300
    });

    const croppedImage = canvas.toDataURL("image/png");
    croppedInput.value = croppedImage;

    image.src = croppedImage;
});
</script>-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
</body>

</html>