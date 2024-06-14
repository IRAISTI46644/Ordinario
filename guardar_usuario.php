<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];
    $avatar = $_FILES['avatar'];

    // Validar y sanitizar los datos
    $nombre = filter_var($nombre, FILTER_SANITIZE_STRING);
    $correo = filter_var($correo, FILTER_SANITIZE_EMAIL);
    $contraseña = filter_var($contraseña, FILTER_SANITIZE_STRING);

    // Guardar el archivo de imagen en la carpeta avatars y obtener el nombre del archivo
    $avatarNombre = basename($avatar['name']);
    move_uploaded_file($avatar['tmp_name'], 'avatars/' . $avatarNombre);

    // Crear un objeto de usuario
    $usuario = [
        'nombre' => $nombre,
        'correo' => $correo,
        'contraseña' => $contraseña,
        'avatar' => $avatarNombre
    ];

    // Leer los usuarios actuales del archivo
    $usuarios = json_decode(file_get_contents('usuarios.json'), true);

    // Agregar el nuevo usuario
    $usuarios[] = $usuario;

    // Guardar los usuarios actualizados en el archivo
    file_put_contents('usuarios.json', json_encode($usuarios));

    // Enviar una respuesta
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success']);
} else {
    // Enviar una respuesta de error
    header('HTTP/1.1 400 Bad Request');
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
