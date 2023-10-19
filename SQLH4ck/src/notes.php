<?php
    if(!isset($_SESSION['session'])){
        header("Location: /");
    }
    else{
        $host = 'mysql';
        $username = $password = 'admin';
        $database = 'sqlh4ck';

        $db = new mysqli($host, $username, $password, $database);

        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }

        $stmt = $db->query("SELECT * FROM notes WHERE user_id=" . $_SESSION['session']);
        $result = $stmt->fetch_all(MYSQLI_ASSOC);
        
        $db->close();
    }
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
    <head>
        <meta charset="UTF-8">
        <title>SQLH4ck</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link href="/style.css" rel="stylesheet" crossorigin="anonymous">
        <link rel="icon" href="/arch.png">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <!-- non so cosa tu stia cercando ma qua non c'è nulla-->
    </head>
    
</html>