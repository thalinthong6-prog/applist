<?php
$nameErr = $usernameErr = $passwdErr = $positionErr = $addressErr = '';
$name = $username = $address = $position = '';

if (isset($_POST['name'], $_POST['username'], $_POST['passwd'], $_POST['position'], $_POST['address'], $_FILES['photo'])) {
    $photo = $_FILES['photo'];
    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $passwd = trim($_POST['passwd']);
    $position = trim($_POST['position']);
    $address = trim($_POST['address']);
    if (empty($name)) {
        $nameErr = 'Please input name!';
    }
    if (empty($username)) {
        $usernameErr = 'Please input username!';
    }
    if (empty($passwd)) {
        $passwdErr = 'Please input password!';
    }
    if (empty($position)) {
        $positionErr = 'Please input position!';
    }
    if (empty($address)) {
        $addressErr = 'Please input address!';
    }
    if (usernameExists($username)) {
        $usernameErr = 'Please choose another username !';
    }
    if (empty($nameErr) && empty($usernameErr) && empty($passwdErr) && empty($addressErr)) {
        try {
            if (createUser($name, $username, $passwd, $position, $address, $photo)) {
                $name = $username = $phone = $address = $position = '';
                echo '<div class="alert alert-success" role="alert">
            Create successful! <a href=".">go to list</a>
            </div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">
            Create failed! Please try again.
            </div>';
            }
        } catch (Exception $e) {
            echo '<div class="alert alert-danger" role="alert">
            ' . $e->getMessage() . '
            </div>';
        }
    }
}
?>


<form method="post" action="./?page=user/create" enctype="multipart/form-data" class="col-md-10 col-lg-6 mx-auto">
    <h3 style="font-weight: bold; text-align: center;">Create User</h3>
    <div class="d-flex justify-content-center">
        <input name="photo" type="file" id="profileUpload" hidden>
        <label role="button" for="profileUpload">
            <img src="./assets/images/Profile-PNG-Photo.png" class="rounded img-thumbnail" style="max-width:200px">
        </label>
    </div>
    <div class="mb-3">
        <label class="form-label">Name</label>
        <input name="name" value="<?php echo $name ?>" type="text" class="form-control
        <?php echo empty($nameErr) ? '' : 'is-invalid' ?>">
        <div class="invalid-feedback"><?php echo $nameErr ?></div>
    </div>
    <div class="mb-3">
        <label class="form-label">Username</label>
        <input name="username" value="<?php echo $username ?>" type="text" class="form-control
        <?php echo empty($usernameErr) ? '' : 'is-invalid' ?>">
        <div class="invalid-feedback"><?php echo $usernameErr ?></div>
    </div>
    <div class="mb-3">
        <label class="form-label">Position</label>
        <input name="position" value="<?php echo $position ?>" type="text" class="form-control
        <?php echo empty($positionErr) ? '' : 'is-invalid' ?>">
        <div class="invalid-feedback"><?php echo $positionErr ?></div>
    </div>

    <div class="mb-3">
        <label class="form-label">Address</label>
        <input name="address" value="<?php echo $address ?>" type="text" class="form-control
        <?php echo empty($addressErr) ? '' : 'is-invalid' ?>">
        <div class="invalid-feedback"><?php echo $addressErr ?></div>
    </div>
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input name="passwd" type="password" class="form-control
        <?php echo empty($passwdErr) ? '' : 'is-invalid' ?>">
        <div class="invalid-feedback"><?php echo $passwdErr ?></div>
    </div>
    
    <button type="submit" class="btn btn-primary">Submit</button>
</form>