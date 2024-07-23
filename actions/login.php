<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../assets/imagis/red.gif">
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
                    echo '<div class="alert alert-success">' . $_SESSION['message'] . '</div>';
                    unset($_SESSION['message']);  // Șterge mesajul după afișare
                    session_write_close();
                }
                if (isset($_SESSION['error'])) {
                    echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
                    unset($_SESSION['error']);  // Șterge mesajul după afișare
                    session_write_close();
                }
                ?>
                <form action="../includes/login_process.php" method="post" onsubmit="return validateForm()">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" id="username" name="username" class="form-control form-control-lg" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" id="password" name="password" class="form-control form-control-lg"
                               required>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="login-btn" value="Logare" class="btn btn-lg btn-block btn-primary">
                    </div>
                </form>
                <p>Daca nu ai un cont? <a href="../actions/register.php">Înregisrează-te</a>
                    <br>
                <h4 style="text-align: center;">
                    <a style="color: red;" href="../functions/decon_av.php">INFO DECONECTARI AVARIATE</a>
                </h4>

                </p>
            </div>
        </div>
    </div>
</main>
<script>
    function validateForm() {
        var username = document.getElementById('username').value;
        var password = document.getElementById('password').value;
        if (username === '' || password === '') {
            alert('Toate câmpurile sunt obligatorii.');
            return false;
        }
        return true;
    }
</script>
</body>
</html>


