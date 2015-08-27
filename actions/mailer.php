<?php
$result = [
    'error' => true,
];
$emailSubject = 'Mail de Viruta Web';
$mailto = 'virutavc@gmail.com';
$name = filter_input(INPUT_POST, 'contactName');
$email = filter_input(INPUT_POST, 'contactEmail');
$message = filter_input(INPUT_POST, 'contactMessage');
if ($name && $message) {

    $body = '<h1>Nombre: ' . $name . '</h1><p>Email: ' . $email . '</p><h2>Mensaje: </h2><p>' . $message . '</p>';

    $headers = "From: " . $email . "\r\n"; // This takes the email and displays it as who this email is from.
    $headers .= "Content-type: text/html\r\n"; // This tells the server to turn the coding into the text.
    $success = mail($mailto, $emailSubject, $body, $headers);
    if ($success) {
        $result['error'] = false;
        $result['status'] = 'email send';
    } else {
        $result['status'] = 'couldnt send email';
    }
} else {
    $result['status'] = 'no input data';
}
echo json_encode($result);