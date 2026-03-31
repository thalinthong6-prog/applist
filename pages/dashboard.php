<?php
    // if(isset($_SESSION['user_id'])){
    //     echo $_SESSION['user_id'];
    // }

    //echo 'LEVEL: '. (isAdmin() ? 'ADMIN':'USER');
?>

<h1 style="font-weight: bold; color: dark; text-align: center;">Employee List</h1>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold m-0">Users List</h3>

        <div class="btn-group-1">

            <a href="./?page=user/create" role="button" class="btn btn-success">
                <i class="bi bi-person-fill-add"></i> Create New
            </a>
        </div>


    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th></th>
                <th>Photo</th>
                <th>Name</th>
                <th>Position</th>
                <th>Address</th>
                <th>Options</th>
            </tr>

            <?php
            $user = getUsers();
            $count = 1;
            while ($row = $user->fetch_object()) {
                echo '<tr>
                        <td>' . $count . '</td>
                        <td>
                            <img src="' . ($row->photo ?? './assets/images/Profile_PNG.png') . '" 
                            class="rounded img-thumbnail" style="max-width:100px"/>
                        </td>
                        <td>' . $row->name . '</td>
                        <td>' . $row->position . '</td>
                        <td>' . $row->address . '</td>
                        <td>
                            <a href="./?page=user/update&id=' . $row->id . '" 
                            role="button" class="btn btn-primary">Edit
                            </a>
                            <a href="./?page=user/delete&id=' . $row->id . '" 
                            role="button" class="btn btn-danger">Delete
                            </a>
                        </td>
                    </tr>';
                $count++;
            }
            ?>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.btn-danger').click(function (e) {
            e.preventDefault();
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = $(this).attr('href');
                }
            });
        });
    });
</script>