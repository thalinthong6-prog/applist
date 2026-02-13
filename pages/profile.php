<?php
$oldPasswd = $newPasswd = $confirmNewPasswd = '';
$oldPasswdErr = $newPasswdErr = '';

if (isset($_POST['changePasswd'], $_POST['oldPasswd'], $_POST['newPasswd'], $_POST['confirmNewPasswd'])) {
    $oldPasswd = trim($_POST['oldPasswd']);
    $newPasswd = trim($_POST['newPasswd']);
    $confirmNewPasswd = trim($_POST['confirmNewPasswd']);
    if (empty($oldPasswd)) {
        $oldPasswdErr = 'please input your old password';
    }
    if (empty($newPasswd)) {
        $newPasswdErr = 'please input your new password';
    }
    if ($newPasswd !== $confirmNewPasswd) {
        $newPasswdErr = 'password does not match';
    } else {
        if (!isUserHasPassword($oldPasswd)) {
            $oldPasswdErr = 'password is incorrect';
        }
    }
    if (empty($oldPasswdErr) && empty($newPasswdErr)) {
        if (setUserNewPassowrd($newPasswd)) {
            unset($_SESSION['user_id']);
            echo '<div class="alert alert-success" role="alert">
                password changed successfully. <a href="./?page=login">click here</a> to login again.
                </div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">
                try aggain.
                </div>';
        }
    }
}
if (isset($_POST['uploadPhoto'])) {

    if (!isset($_FILES['photo']) || $_FILES['photo']['error'] == 4) {

        echo '<div class="alert alert-danger">Please input your photo.</div>';

    } elseif ($_FILES['photo']['error'] == 0) {

        $userId = $_SESSION['user_id'];
        $currentPhoto = getUserPhoto($userId);

        $targetDir = "uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileExt = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
        $fileName = "image_" . $userId . "." . $fileExt;
        $targetFile = $targetDir . $fileName;

        // Delete old photo if exists
        if (!empty($currentPhoto) && file_exists($targetDir . $currentPhoto)) {
            unlink($targetDir . $currentPhoto);
            $message = "Your profile was changed.";
        } else {
            $message = "You uploaded profile successfully.";
        }

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
            updateUserPhoto($userId, $fileName);
            echo '<div class="alert alert-success">'.$message.'</div>';
            
        }
    }
}


if (isset($_POST['deletePhoto'])) {

    $userId = $_SESSION['user_id'];
    $currentPhoto = getUserPhoto($userId);

    if (!isset($_POST['confirmDelete'])) {
        echo '
        <div class="alert alert-warning">
            Do you want to delete your profile?
            <form method="post">
                <button type="submit" name="deletePhoto" value="1" class="btn btn-danger btn-sm">Yes</button>
                <button type="button" onclick="location.href=\'./?page=profile\'" class="btn btn-secondary btn-sm">No</button>
                <input type="hidden" name="confirmDelete" value="yes">
            </form>
        </div>';
        return;
    }

    if (!empty($currentPhoto) && file_exists('./assets/images/Profile_PNG.png' . $currentPhoto)) {
        unlink('./assets/images/Profile_PNG.png' . $currentPhoto); // delete file
    }

    deleteUserPhoto($userId); // delete from database
    echo '<div class="alert alert-success">Your profile was deleted.</div>';
}

?>



<div class="row">
    <div class="col-6">
        <form method="post" action="./?page=profile" enctype="multipart/form-data">
            <div class="d-flex justify-content-center">
                <?php
                $photoPath = './assets/images/Profile_PNG.png';

                if (isset($_SESSION['user_id'])) {
                    $userPhoto = getUserPhoto($_SESSION['user_id']);

                    if (!empty($userPhoto) && file_exists('uploads/' . $userPhoto)) {
                        $photoPath = 'uploads/' . $userPhoto;
                    }
                }
                ?>
                <input type="file" name="photo" id="profileUpload" accept="image/*" hidden>
                <label for="profileUpload" style="cursor:pointer;">
                    <img id="previewImage" src="<?php echo htmlspecialchars($photoPath); ?>" alt="Profile" style="
                            width:250px;
                            height:250px;
                            object-fit:cover;
                            border-radius:50%;
                            border:3px solid white;
                            display:block;
                        ">
                </label>
            </div>
            <!--<div class="text-center mt-3">
                <button type="button" id="cropBtn" class="btn btn-primary">Crop & Save</button>
            </div>

            <input type="hidden" name="croppedImage" id="croppedImage">-->
            <div class="d-flex justify-content-center gap-3 mt-3">
                <button type="submit" name="deletePhoto" class="btn btn-danger" onclick="
                    return confirmDelete();">Delete</button>
                <button type="submit" name="uploadPhoto" class="btn btn-success">Upload</button>
            </div>
        </form>
    </div>

    <div class="col-6">
        <form method="post" action="./?page=profile" class="col-md-8 col-lg-6 mx-auto">
            <h3 style="font-weight: bold; text-align: center; color: White;">Change Password</h3>
            <div class="mb-3">
                <label class="form-label" style="font-weight: bold; color: white;">Old Password</label>
                <input value="<?php echo $oldPasswd ?>" name="oldPasswd" type="password" class="form-control 
                <?php echo empty($oldPasswdErr) ? '' : 'is-invalid' ?>">
                <div class="invalid-feedback">
                    <?php echo $oldPasswdErr ?>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label" style="font-weight: bold; color: white;">New Password</label>
                <input name="newPasswd" type="password" class="form-control 
                <?php echo empty($newPasswdErr) ? '' : 'is-invalid' ?>">
                <div class="invalid-feedback">
                    <?php echo $newPasswdErr ?>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label" style="font-weight: bold; color: white;">Confirm New Password</label>
                <input name="confirmNewPasswd" type="password" class="form-control">
            </div>
            <button type="submit" name="changePasswd" class="btn btn-success" style="font-weight: bold;">Change
                Password</button>
        </form>
    </div>
</div>