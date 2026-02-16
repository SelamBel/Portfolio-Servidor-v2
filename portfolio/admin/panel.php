<?php
session_start();
$rol = $_SESSION["rol"] ?? null;
if ($_SESSION["rol"] != "ADMIN") {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin</title>
    <link rel="stylesheet" href="../static/css/topnav-footer.css">
    <link rel="stylesheet" href="../static/css/style.css">
</head>


<body>
    <?php require_once '../templates/nav-admin.php'; ?>

    <main>
        
    </main>

    <?php require_once '../templates/footer-admin.php'; ?>
</body>

</html>