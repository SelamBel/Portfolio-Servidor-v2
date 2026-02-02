<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto</title>
    <link rel="stylesheet" href="static/css/topnav-footer.css">
    <link rel="stylesheet" href="static/css/style.css">
</head>

<body>
    <?php require_once 'templates/nav.php'; ?>

    <main>
        <div id="divInfoContacto">
            <img id="imgContacto" src="static/img/img/contacto.png" alt="Contacto">
            <div id="infoContacto">
                <h1>Selam Bel Kharroub Jerez</h1>
                <p>Ciclo superior DAW</p>
                <p>IES Macia Abela (Crevillent)</p>
                <p><strong>Teléfono:</strong> 678 90 12 34</p>
                <p><strong>Email:</strong> selbeljer@alu.edu.gva.es</p>
            </div>
        </div>
        <hr>
        <div id="divFormularioContacto">
            <p>Formulario para contactar (No se enviará realmente, solo es para practicar).</p>
            <form>
                <label for="Nombre">Nombre *</label>
                <input type="text" id="Nombre" name="Nombre" required placeholder="Tu nombre">
                <label for="correo">Correo electrónico *</label>
                <input type="email" id="correo" name="correo" required placeholder="ejemplo@correo.com">
                <label for="Asunto">Asunto *</label>
                <input type="text" id="Asunto" name="Asunto" required placeholder="Motivo del mensaje">
                <label for="Mensaje">Mensaje *</label>
                <textarea id="Mensaje" name="Mensaje" required placeholder="Escribe tu mensaje aquí..."></textarea>
                <button type="submit">Enviar</button>
            </form>

    </main>

    <?php require_once 'templates/footer.php'; ?>
</body>

</html>