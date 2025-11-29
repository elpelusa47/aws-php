<?php
// Incluimos los datos y funciones necesarias para pintar el formulario
require_once '../src/datos.php';
require_once '../src/validaciones.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Empleados - Fase IAW 1</title>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@300;400;600&family=Orbitron:wght@500;700&display=swap" rel="stylesheet">
    
    <style>
        /* --- CONFIGURACIÓN DEL MUNDO (FONDO Y BODY) --- */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Exo 2', sans-serif;
            background-color: #050505; /* Negro*/
            color: #fff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
            
            /* Efecto de Rejilla Cyberpunk en el suelo */
            background-image: 
                linear-gradient(rgba(0, 255, 255, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 255, 255, 0.1) 1px, transparent 1px);
            background-size: 50px 50px;
            background-position: center bottom;
        }

        /* Viñeta para oscurecer los bordes de la pantalla */
        body::after {
            content: "";
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: radial-gradient(circle, transparent 40%, #050505 90%);
            pointer-events: none;
            z-index: 0;
        }

        /* --- LA TARJETA DEL FORMULARIO (CONTENEDOR) --- */
        .card-wrapper {
            position: relative;
            width: 100%;
            max-width: 450px;
            padding: 4px; /* Espacio para el borde brillante */
            border-radius: 20px;
            z-index: 1;
            margin: 20px;
            overflow: hidden;
        }

        /* EL BORDE GIRATORIO DE LUZ (La magia) */
        .card-wrapper::before {
            content: "";
            position: absolute;
            top: -50%; left: -50%;
            width: 200%; height: 200%;
            background: conic-gradient(
                transparent, 
                #00d4ff, 
                transparent 30%
            );
            animation: rotate 4s linear infinite;
        }

        /* Segundo borde para doble color (Cyan + Magenta) */
        .card-wrapper::after {
            content: "";
            position: absolute;
            top: -50%; left: -50%;
            width: 200%; height: 200%;
            background: conic-gradient(
                transparent, 
                #ff0055, 
                transparent 30%
            );
            animation: rotate 4s linear infinite;
            animation-delay: -2s; /* Desfase para que giren opuestos */
        }

        @keyframes rotate {
            100% { transform: rotate(360deg); }
        }

        /* El formulario real que tapa el centro */
        form {
            position: relative;
            background: rgba(16, 16, 24, 0.95); /* Muy oscuro */
            padding: 40px 30px;
            border-radius: 16px;
            z-index: 2; /* Encima de los bordes giratorios */
            backdrop-filter: blur(20px);
            box-shadow: inset 0 0 20px rgba(0,0,0,0.8);
        }

        h2 {
            text-align: center;
            font-family: 'Orbitron', sans-serif; /* Fuente Tech */
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-bottom: 30px;
            background: linear-gradient(90deg, #00d4ff, #fff, #ff0055);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 10px rgba(0, 212, 255, 0.5);
        }

        /* --- INPUTS ESTILO SCI-FI --- */
        .campo {
            position: relative;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 0.8rem;
            color: #8892b0;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        input, select {
            width: 100%;
            padding: 12px 0;
            font-size: 1rem;
            color: #fff;
            background: transparent;
            border: none;
            border-bottom: 2px solid #333;
            font-family: 'Exo 2', sans-serif;
            transition: 0.4s;
            box-sizing: border-box;
        }

        /* Estilo para las opciones del select (son rebeldes en CSS) */
        select option {
            background-color: #1a1a2e;
            color: #fff;
        }

        input:focus, select:focus {
            outline: none;
            border-bottom-color: #00d4ff;
            text-shadow: 0 0 8px rgba(0, 212, 255, 0.6);
        }

        /* Línea decorativa animada bajo el input */
        .bar {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: #ff0055;
            transition: 0.4s ease;
        }

        input:focus ~ .bar, select:focus ~ .bar {
            width: 100%;
        }

        /* --- BOTÓN DE ALTA ENERGÍA --- */
        button {
            width: 100%;
            padding: 15px;
            margin-top: 20px;
            background: transparent;
            color: #00d4ff;
            border: 2px solid #00d4ff;
            font-family: 'Orbitron', sans-serif;
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: 0.3s;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 212, 255, 0.2);
        }

        /* Efecto de relleno al pasar el mouse */
        button::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: #00d4ff;
            transition: 0.3s;
            z-index: -1;
        }

        button:hover {
            color: #000;
            box-shadow: 0 0 20px #00d4ff, 0 0 40px #00d4ff; /* Doble resplandor */
        }

        button:hover::before {
            left: 0;
        }

        /* --- REDUCCIÓN DE MOVIMIENTO PARA MÓVILES --- */
        @media (max-width: 480px) {
            .card-wrapper { margin: 10px; padding: 2px; }
            form { padding: 25px 15px; }
            h2 { font-size: 1.5rem; }
        }

    </style>
</head>
<body>

    <div class="card-wrapper">
        <form action="procesar.php" method="POST">
            <h2>Alta Sistema</h2> <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" placeholder="Ingrese nombre" required>
                <span class="bar"></span>
            </div>

            <div class="campo">
                <label for="apellidos">Apellidos</label>
                <input type="text" id="apellidos" name="apellidos" placeholder="Ingrese apellidos" required>
                <span class="bar"></span>
            </div>

            <div class="campo">
                <label for="dni">Identificación (DNI)</label>
                <input type="text" id="dni" name="dni" placeholder="12345678Z" required>
                <span class="bar"></span>
            </div>

            <div class="campo">
                <label for="email">Enlace de Correo</label>
                <input type="email" id="email" name="email" placeholder="usuario@red.com" required>
                <span class="bar"></span>
            </div>

            <div class="campo">
                <label for="telefono">Comunicaciones</label>
                <input type="tel" id="telefono" name="telefono" placeholder="600 000 000">
                <span class="bar"></span>
            </div>

            <div class="campo">
                <label for="fecha">Fecha de Ingreso</label>
                <input type="date" id="fecha" name="fecha" required>
                <span class="bar"></span>
            </div>

            <div class="campo">
                <label for="provincia">Sector (Provincia)</label>
                <select id="provincia" name="provincia" required>
                    <?php echo pintarOpciones($provincias); ?>
                </select>
                <span class="bar"></span>
            </div>

            <div class="campo">
                <label for="sede">Base Operativa (Sede)</label>
                <select id="sede" name="sede" required>
                    <?php echo pintarOpciones($sedes); ?>
                </select>
                <span class="bar"></span>
            </div>

            <div class="campo">
                <label for="departamento">Unidad (Departamento)</label>
                <select id="departamento" name="departamento" required>
                    <?php echo pintarOpciones($departamentos); ?>
                </select>
                <span class="bar"></span>
            </div>

            <button type="submit">Inicializar Registro</button>
        </form>
    </div>

</body>
</html>