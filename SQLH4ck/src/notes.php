<?php
    session_start();

    if(!isset($_SESSION['session'])){
        header("Location: /");
        die();
    }

    $host = 'mysql';
    $username = $password = 'admin';
    $database = 'sqlh4ck';

    $db = new mysqli($host, $username, $password, $database);

    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    $stmt = $db->prepare("SELECT * FROM users WHERE id=?");
    $stmt->bind_param("i", $_SESSION['session']); // se c'è una SQL Injection mi sparo (non so usare PHP)
    $stmt->execute();
    $user = $stmt->get_result()->fetch_row()[1];
    $stmt->close();
    
    $stmt = $db->prepare("SELECT * FROM notes WHERE user_id=?");
    $stmt->bind_param("i", $_SESSION['session']);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $db->close();
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
    <head>
        <meta charset="UTF-8">
        <title>SQLH4ck</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link href="/static/style.css" rel="stylesheet" crossorigin="anonymous">
        <link rel="icon" href="/arch.png">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <!-- non so cosa tu stia cercando ma qua non c'è nulla-->
    </head>
    <div id="title" class="text-center" style="padding: 2.5%">
        <h1>Notes of user <?php echo $user; ?></h1>
    </div>
    <div class="col">
        <?php
            $num_rows = count($result);
            for($i=0; $i<$num_rows; $i++){
                echo "<div class='row card mb-3 w-50 mx-auto' style='max-width: 70%;'><div class='row g-0'><div class='col-md-8'><div class='card-body'><h5 class='card-title'>" . $result[$i]["title"] . "</h5><p class='card-text'>". $result[$i]["content"] ."</p><p class='card-text'><small class='text-body-secondary'>Made by user: " . $user . "</small></p></div></div></div></div>";
            }
            if($user !== "admin"){

            }
        ?>
    </div>
</html>