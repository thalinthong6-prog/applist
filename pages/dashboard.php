<?php
// if(isset($_SESSION['user_id'])){
//     echo $_SESSION['user_id'];
// }

//echo 'LEVEL: '. (isAdmin() ? 'ADMIN':'USER');
?>

<h1 style="font-weight: bold; color: dark; text-align: center  ;">Select Your Role</h1>

<style>
    body {
        font-family: Arial;
        background: #f4f6f9;
        text-align: center;
    }

    .card {
        display: inline-block;
        width: 150px;
        padding: 20px;
        margin: 10px;
        border-radius: 10px;
        background: wheat;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        cursor: pointer;
    }

    .selected {
        border: 2px solid blue;
    }

    .check {
        font-size: 20px;
        color: green;
        display: none;
    }

    .selected .check {
        display: block;
    }

    button {
        margin-top: 20px;
        padding: 10px 30px;
        border: none;
        background: blue;
        color: white;
        border-radius: 5px;
        font-size: 16px;
    }
</style>

<div class="container">
    <form method="POST" action=".">
        <div id="userCard" class="card" onclick="selectRole('user')">
            <h3>User</h3>
            <i class="bi bi-person-fill"></i>
            <div class="check">✓</div>
        </div>

        <div id="adminCard" class="card" onclick="selectRole('admin')">
            <h3>Admin</h3>
            <i class="bi bi-person-fill"></i>
            <div class="check">✓</div>
        </div>

        <input type="hidden" name="role" id="role">
        <div>
            <button type="submit" class="btn btn-success">Submit</button>
        </div>
    </form>
</div>

<script>
    function selectRole(role) {
        document.getElementById('role').value = role;

        document.getElementById('userCard').classList.remove('selected');
        document.getElementById('adminCard').classList.remove('selected');

        if (role === 'user') {
            document.getElementById('userCard').classList.add('selected');
        } else {
            document.getElementById('adminCard').classList.add('selected');
        }
    }
</script>

<script>
    $(document).ready(function () {
        $('.btn-success').click(function (e) {
            e.preventDefault();
            Swal.fire({
                title: "Successfully Submitted!",
                icon: "success",
                draggable: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "./?page=user/list"; // change to your list page
                }
            });
        });
    });
</script>