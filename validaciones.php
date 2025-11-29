<?php
// src/validaciones.php

/**
 * Limpia los datos de entrada para evitar inyecciones XSS o espacios extra
 */
function limpiarDato($dato) {
    $dato = trim($dato);
    $dato = stripslashes($dato);
    $dato = htmlspecialchars($dato);
    return $dato;
}

/**
 * Valida el formato y la letra del DNI español
 */
function validarDni($dni) {
    // Formato 8 números y 1 letra
    if (!preg_match('/^[0-9]{8}[A-Z]$/', strtoupper($dni))) {
        return false;
    }
    
    $letra = substr($dni, -1);
    $numeros = substr($dni, 0, -1);
    $letrasValidas = "TRWAGMYFPDXBNJZSQVHLCKE";
    
    // Calculamos la letra correcta
    $indice = $numeros % 23;
    $letraCorrecta = $letrasValidas[$indice];
    
    return strtoupper($letra) === $letraCorrecta;
}

/**
 * Valida formato de email
 */
function validarEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Función auxiliar para pintar las opciones de un Select
 * (Cumple con el requisito "pintarSelectProvincias")
 */
function pintarOpciones($arrayDatos) {
    $html = '<option value="" disabled selected>-- Selecciona una opción --</option>';
    foreach ($arrayDatos as $clave => $valor) {
        $html .= "<option value='$clave'>$valor</option>";
    }
    return $html;
}
?>