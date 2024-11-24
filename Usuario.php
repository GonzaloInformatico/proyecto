<?php
// Verificar si la sesión ya está activa antes de intentar iniciarla
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["Nombre"])) {
    header("Location: index.php");
    exit();
}
$nombre = $_SESSION["Nombre"];
$apellido = $_SESSION["Apellido"];

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <style>
        /* Limitar el texto en la columna Descripción */
        .text-limit {
            max-width: 100px;
            /* Ajusta este valor según el ancho deseado */
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
        .hover-effect:hover {
        background-color: rgba(255, 255, 255, 0.2); /* Fondo translúcido blanco */
        color: #fff; /* Mantener el texto blanco */
        border-radius: 5px; /* Opcional: darle bordes redondeados */
    }


        table {
            /* width: 100%; /* Ancho total de la tabla */
            max-width: 1000000px;
            /* Ancho máximo de la tabla */


        }

        .status {
            font-weight: bold;
            color: #666;
        }

        .status.to-do {
            color: #1a73e8;
        }

        .status.in-progress {
            color: #d93025;
        }

        .priority {

            align-items: center;
        }

        .priority::before {
            content: '';
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 5px;
        }

        .priority.medium::before {
            background-color: #fbbc05;
        }

        .priority.high::before {
            background-color: #ea4335;
        }

        .priority.low::before {
            background-color: #34a853;
        }

        .channel {
            font-size: 1.2em;
        }

        .channel.email::after {
            content: "📧";
        }

        .channel.chat::after {
            content: "💬";
        }

        .channel.phone::after {
            content: "📞";
        }

        .channel.video::after {
            content: "💻";
        }

        .response-time {
            color: #555;
        }
    </style>
    <title>InicioUsuario</title>
</head>

<body>

<nav class="navbar bg-dark border-bottom border-body sticky-top navbar-expand-sm" data-bs-theme="dark">
    <a class="navbar-brand" href="#">
        <img src="img/Sitrans.png" alt="Logo" width="200" height="50" class="d-inline-block align-text-top">
    </a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <div class="navbar-nav me-auto text-center">
        <button type="button" class="btn text-white border-0 bg-transparent hover-effect">Mis solicitudes</button>
        <button type="button" class="btn text-white border-0 bg-transparent">Generar Solicitud</button>
        <button type="button" class="btn text-white border-0 bg-transparent hover-effect">Solicitudes cerradas</button>
        </div>
        <div class="ms-auto d-flex align-items-center me-4">
            <h5 class="mb-0 me-3 text-white"><?php echo $nombre, " ", $apellido ?></h5>
            <button type="button" class="btn btn-light" onclick="window.location.href='salir.php'">Cerrar Sesión</button>
        </div>
    </div>
</nav>



    <div class="container table-responsive container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Titulo</th>
                    <th scope="col" style="width: 20%;">Descripcion</th>
                    <th scope="col ">- Fecha -</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Ver</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Requerimeitno 1</td>
                    <td>Falta de ilminacion </td>
                    <td style="width: 40%;">23-11-2024</td>
                    <td>Aceptado</td>
                    <td>@mdo</td>

                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>Requerimeitno 1</td>
                    <td class="text-limit">Falta de ilminasdasdasdasdasdasdacioasdasdasdasdasdasdasdn </td>
                    <td>23-11-2024</td>
                    <td>Aceptado</td>
                    <td>@mdo</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>Requerimeitno 1</td>
                    <td>Falta de ilminacion </td>
                    <td>23-11-2024</td>
                    <td>Aceptado</td>
                    <td>@mdo</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="container table-responsive">
        <h2>Ticket Management Table</h2>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Summary</th>
                    <th>Status</th>
                    <th>Requester</th>
                    <th>Priority</th>
                    <th>Channel</th>
                    <th>Response</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Access to Scrumdinger</td>
                    <td class="status to-do">TO DO</td>
                    <td>Annika</td>
                    <td class="priority medium">Medium</td>
                    <td class="channel chat"></td>
                    <td class="response-time">2h</td>
                </tr>
                <tr>
                    <td>Login denied error</td>
                    <td class="status in-progress">IN PROGRESS</td>
                    <td>Taha</td>
                    <td class="priority high">High</td>
                    <td class="channel video"></td>
                    <td class="response-time">1h</td>
                </tr>
                <tr>
                    <td>Update staging environment</td>
                    <td class="status in-progress">IN PROGRESS</td>
                    <td>Fran</td>
                    <td class="priority medium">Medium</td>
                    <td class="channel chat"></td>
                    <td class="response-time">1d</td>
                </tr>
                <tr>
                    <td>Replace laptop</td>
                    <td class="status to-do">TO DO</td>
                    <td>Molly</td>
                    <td class="priority low">Low</td>
                    <td class="channel email"></td>
                    <td class="response-time">2d</td>
                </tr>
                <!-- Add more rows as needed -->
            </tbody>
        </table>


    </div>


</body>

</html>