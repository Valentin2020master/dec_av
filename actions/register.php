<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Înregistrare</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="../assets/css/logare.css">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-4 offset-md-4 form-wrapper auth">
            <h3 class="text-center form-title">Înregistrare</h3>
            <form action="../functions/register_process.php" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" class="form-control form-control-lg" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control form-control-lg" required>
                </div>
                <div class="form-group">
                    <input type="submit" name="signup-btn" value="Înregistrare" class="btn btn-lg btn-block">
                </div>
            </form>
            <p>Deja ai un cont? <a href="../pages/login.php">Login</a></p>
        </div>
    </div>
</div>
</body>
</html>
