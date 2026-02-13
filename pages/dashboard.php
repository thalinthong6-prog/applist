<?php
    if(isset($_SESSION['user_id'])){
        echo $_SESSION['user_id'];
    }

    echo 'LEVEL: '. (isAdmin() ? 'ADMIN':'USER');
?>

<h1 style="font-weight: bold; color: dark; text-align: center;">Dashboard</h1>