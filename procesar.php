<?php
// Cargamos lógica y datos
require_once '../src/datos.php';
require_once '../src/validaciones.php';

$errores = [];
$datos = [];

// Verificamos que el formulario se haya enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Recogida y limpieza de datos
    $nombre = limpiarDato($_POST['nombre'] ?? '');
    $apellidos = limpiarDato($_POST['apellidos'] ?? '');
    $dni = limpiarDato($_POST['dni'] ?? '');
    $email = limpiarDato($_POST['email'] ?? '');
    $telefono = limpiarDato($_POST['telefono'] ?? '');
    $fecha = limpiarDato($_POST['fecha'] ?? '');
    $provincia = limpiarDato($_POST['provincia'] ?? '');
    $sede = limpiarDato($_POST['sede'] ?? '');
    $departamento = limpiarDato($_POST['departamento'] ?? '');

    // 2. Validaciones
    if (empty($nombre)) $errores[] = "El nombre es obligatorio.";
    if (empty($apellidos)) $errores[] = "Los apellidos son obligatorios.";
    
    if (empty($dni) || !validarDni($dni)) {
        $errores[] = "El DNI introducido no es válido (Revise número y letra).";
    }

    if (empty($email) || !validarEmail($email)) {
        $errores[] = "El correo electrónico no es válido.";
    }

    // Validamos que las opciones seleccionadas existan en nuestros arrays (seguridad)
    if (!array_key_exists($provincia, $provincias)) $errores[] = "La provincia seleccionada no es válida.";
    if (!array_key_exists($sede, $sedes)) $errores[] = "La sede seleccionada no es válida.";
    if (!array_key_exists($departamento, $departamentos)) $errores[] = "El departamento no es válido.";

    // 3. Mostrar Resultados
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Resultado del Registro</title>
        <style>
            body { font-family: sans-serif; max-width: 600px; margin: 2rem auto; padding: 1rem; }
            .exito { background-color: #d4edda; color: #155724; padding: 1rem; border: 1px solid #c3e6cb; border-radius: 5px; }
            .error { background-color: #f8d7da; color: #721c24; padding: 1rem; border: 1px solid #f5c6cb; border-radius: 5px; }
            ul { margin: 0; padding-left: 20px; }
            a { display: inline-block; margin-top: 20px; text-decoration: none; color: #007BFF; }
        </style>
    </head>
    <body>

    <?php if (empty($errores)): ?>
        <div class="exito">
            <h3>✅ Empleado registrado correctamente</h3>
            <p><strong>Resumen de datos:</strong></p>
            <ul>
                <li><strong>Nombre:</strong> <?php echo $nombre . " " . $apellidos; ?></li>
                <li><strong>DNI:</strong> <?php echo $dni; ?></li>
                <li><strong>Email:</strong> <?php echo $email; ?></li>
                <li><strong>Teléfono:</strong> <?php echo $telefono; ?></li>
                <li><strong>Fecha Alta:</strong> <?php echo $fecha; ?></li>
                <li><strong>Provincia:</strong> <?php echo $provincias[$provincia]; ?></li>
                <li><strong>Sede:</strong> <?php echo $sedes[$sede]; ?></li>
                <li><strong>Departamento:</strong> <?php echo $departamentos[$departamento]; ?></li>
            </ul>
        </div>
    <?php else: ?>
        <div class="error">
            <h3>❌ Error en el registro</h3>
            <p>Por favor, corrige los siguientes errores:</p>
            <ul>
                <?php foreach ($errores as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <a href="index.php">⬅ Volver al formulario</a>
    
    </body>
    </html>

<?php
} else {
    // Si alguien intenta entrar directamente a procesar.php sin enviar el formulario
    header("Location: index.php");
    exit();
}
?>