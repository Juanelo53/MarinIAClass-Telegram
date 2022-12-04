<?php

// Llamamos ala libreria
require 'MarinIAClass.php';

// Obtiene el Token del bot
$MarinIA = new MarinIA('5891107797:AAEGPCLSDdS4KtONRWWx0uOn3z4ljJasMr4');

// Obtiene las variables
$update = $MarinIA->getUpdates();
$chat_id = $update->message->chat->id;
$message_id = $update->message->message_id;
$message = $update->message->text;

// Manda un mensaje al usuario
if ($message == 'hola') {
    $MarinIA->enviar('sendMessage', [
        'chat_id' => $chat_id,
        'text' => "Hola, soy un bot creado con la libreria de MarinIA!",
    ]);
}

// Separa el comando del mensaje del usuario
list($comando) = explode(' ', $message);

// Generar Keys

if ($comando == '/key') {
    $nombre = substr($message, 5);

    $key = GenerarKeys($nombre);

    $MarinIA->enviar('sendMessage', [
        'chat_id' => $chat_id,
        'text' => "Tu Key es: $key",
    ]);
}


?>
