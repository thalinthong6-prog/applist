<?php
$conn = mysqli_connect("localhost","root","","tbl_users");

if(!$conn){
    echo "Database connection failed";
}
?>

<?php
include "db.php";

if(isset($_POST['attendance'])) {

    $date = $_POST['date'];

    foreach($_POST['attendance'] as $user_id => $status) {

        mysqli_query($conn, "
            INSERT INTO tbl_attendance (user_id, attendance_date, status)
            VALUES ('$user_id', '$date', '$status')
            ON DUPLICATE KEY UPDATE status='$status'
        ");
    }

    echo "Attendance Saved!";
}
?>