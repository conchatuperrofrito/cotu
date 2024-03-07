<?php
$claveSecreta = 'estaEsUnaClaveSecreta';
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));

// Datos a encriptar
$datos = "¡Hola, mundo!";

// Encriptar
$datosEncriptados = openssl_encrypt($datos, 'aes-256-cbc', $claveSecreta, 0, $iv);
echo "Datos encriptados: " . $datosEncriptados . "\n";

// Desencriptar
$datosDesencriptados = openssl_decrypt($datosEncriptados, 'aes-256-cbc', $claveSecreta, 0, $iv);
echo "Datos desencriptados: " . $datosDesencriptados . "\n";
?>