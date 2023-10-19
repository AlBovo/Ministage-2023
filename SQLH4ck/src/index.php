<?php
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $host = 'mysql';
        $username = $password = 'admin';
        $database = 'sqlh4ck';

        $db = new mysqli($host, $username, $password, $database);

        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }

        if(!isset($_POST['username']) || !isset($_POST['password'])) {
            error_log("Username or password not set");
            $error = "Username or password not set";
        }
        else{
            $username = $_POST['username'];
            $password = $_POST['password'];
            $stmt = $db->query("SELECT * FROM users WHERE username='$username' AND password='$password'");
            $result = $stmt->fetch_all(MYSQLI_ASSOC);
    
            if(!isset($result) || empty($result)){
                $error = "Wrong username or password";
            }
            else{
                error_log("User logged in with id: " . $result[0]['id']);
                $_SESSION['session'] = $result[0]['id'];
                $db->close();
                $redirect = true;
                exit();
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
    <head>
        <meta charset="UTF-8">
        <title>SQLH4ck</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link href="/style.css" rel="stylesheet" crossorigin="anonymous">
        <link rel="icon" href="/static/.png">
        <?php if(isset($redirect)) echo "<meta http-equiv='refresh' content='0; url=notes.php' />"; ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <!-- non so cosa tu stia cercando ma qua non c'è nulla-->
    </head>
    <body>
        <div class="container-fluid d-flex justify-content-center" style="padding: 1.5%;">
            <h1>SQLH4ck</h1>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card my-5">
                        <form class="card-body p-lg-5" action="/" method="POST">
                            <div class="text-center">
                                <img src="/static/ciccio.png" class="img-fluid profile-image-pic img-thumbnail rounded-circle my-3" width="200px" alt="profile">
                            </div>
                    
                            <div class="mb-3">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" id="username" placeholder="username" required>
                            </div>
                            <div class="mb-3">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" id="password" placeholder="password" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-secondary px-5 mb-5 w-100">Login</button>
                            </div>
                            <div id="emailHelp" class="form-text text-center mb-5">
                                Not Registered? 
                                <a onclick="alert('Non voglio nuovi utenti')" class=" fw-bold">Create an Account</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php if(isset($error)) echo "<script>alert('" . $error . "');</script>"; ?>
    </body>
</html>
