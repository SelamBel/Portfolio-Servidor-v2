<?php
session_start();
if (isset($_POST["cancel"]) || isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}


if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    if ($username == "admin" && $password == "1234") {
        $_SESSION["username"] = $username;
        $_SESSION["rol"] = "ADMIN";
        header("Location: index.php");
        exit();
    } else {
        $error = "Credenciales incorrectas";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto</title>
    <link rel="stylesheet" href="static/css/topnav-footer.css">
    <link rel="stylesheet" href="static/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <?php require_once 'templates/nav.php'; ?>

    <main>
        <div id="loginForm">
            <h1>Acceso al sistema</h1>
            <form method="post">
                <input type="text" id="username" name="username" required placeholder="Username" value>
                <input type="password" id="password" name="password" required placeholder="Password">
                <?php if (isset($error)): ?>
                    <p style="color:red"><?php echo $error ?></p>
                <?php endif; ?>
                <div id="loginButtons">
                    <button type="submit" name="login" id="login">Entrar</button>
                    <button type="submit" name="cancel" id="cancel">Cancelar</button>
                </div>
            </form>
        </div>
    </main>

    <?php require_once 'templates/footer.php'; ?>
</body>

</html>