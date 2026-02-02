<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio Sel</title>
    <link rel="stylesheet" href="static/css/topnav-footer.css">
    <link rel="stylesheet" href="static/css/style.css">
</head>

<body>
    <?php require_once 'templates/nav.php'; ?>

    <main>
        <div id="indexMain">
            <svg class="logo-svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="logoGrad2" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#000;stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#ed1838;stop-opacity:1" />
                    </linearGradient>
                </defs>
                <polygon points="50,10 20,50 50,90 80,50" fill="none" stroke="url(#logoGrad2)" stroke-width="5" />
                <circle cx="50" cy="50" r="5" stroke="url(#logoGrad2)" fill="none" stroke-width="3"/>
            </svg>

            <h1>Bienvenido a mi Portfolio</h1>
            <p>Explora mis proyectos y trabajos destacados.</p>
        </div>
    </main>

    <?php require_once 'templates/footer.php'; ?>
</body>

</html>