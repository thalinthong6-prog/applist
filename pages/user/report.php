<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold m-0">Report List</h3>

        <div class="print-btn">
            <button onclick="window.print()" role="button" class="btn btn-success">Print Report</button>
            <a href="./?page=user/attendance" role="button" class="btn btn-success">
                <i class="bi bi-person-fill-add"></i> Back
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Position</th>
                <th>Attendance</th>
                <th>Date</th>
            </tr>

            <?php
            $user = getUsers();
            $count = 1;
            $date = date("Y-m-d");
            while ($row = $user->fetch_object()) {
                echo '<tr>
                    <td>' . $count . '</td>
                    <td>' . $row->name . '</td>
                    <td>' . $row->position . '</td>
                    <td>
                        <select name="attendance[' . $row->id . ']" class="form-control">
                            <option value="Present">Present</option>
                            <option value="Absent">Absent</option>
                            <option value="Late">Late</option>
                        </select>
                    </td>

                    <td>
                        <input type="date" name="date" value="' . $date . '" class="form-control">
                    </td>
                </tr>';
                $count++;
            }
            ?>
        </table>