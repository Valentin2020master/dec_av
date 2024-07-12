<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logare</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="../assets/css/logare.css">
</head>
<body>
<main>
<div class="container">

    <div class="row">
        <div class="col-md-4 offset-md-4 form-wrapper auth login">
            <h3 class="text-center form-title">Logare</h3>
            <?php
            if (isset($_SESSION['message'])) {
                echo '<p class="success-message">' . $_SESSION['message'] . '</p>';
                unset($_SESSION['message']);  // Șterge mesajul după afișare
            }
            ?>
            <form action="../includes/login_process.php" method="post">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" id="username" name="username" class="form-control form-control-lg" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" id="password" name="password" class="form-control form-control-lg">
                </div>
                <div class="form-group">
                    <input type="submit" name="login-btn" value="Logare" class="btn btn-lg btn-block">

                </div>
            </form>
            <p>Daca nu ai un cont? <a href="../actions/register.php">Înregisreazăte</a></p>
        </div>
    </div>
</div>
</main>

</body>
</html>



