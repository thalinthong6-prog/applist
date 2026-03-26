<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold m-0">Users List</h3>

        <div class="print-btn">
            <button onclick="window.print()">Print Report</button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th></th>
                <th>Photo</th>
                <th>Name</th>
                <th>Address</th>
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
                        <td>' . $row->address . '</td>
                           
                        </td>
                    </tr>';
                $count++;
            }
            ?>
        </table>