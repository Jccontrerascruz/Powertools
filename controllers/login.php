<?php
include "../includes/conexionBD.php"; // Conexión a la base de datos

session_start(); // Inicia la sesión

// Recibir datos del formulario
$email = $_POST['email'];
$password = $_POST['password'];

// Verificar que los campos no estén vacíos
if (empty($email) || empty($password)) {
    die("Error: Todos los campos son obligatorios.");
}

// Buscar al usuario en la base de datos por su correo
$sql = "SELECT ID_Usuario, Contraseña, Nombre FROM usuarios WHERE Correo_Electronico = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user) {
    // Verificar la contraseña
    if (password_verify($password, $user['Contraseña'])) {
        // Credenciales correctas: guardar ID de usuario en la sesión
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['Nombre']; // Opcional: nombre del usuario para mostrar en la app
        // Redirigir al dashboard o página principal
        header("Location: ../views/profile.html");
        exit;
    } else {
        // Contraseña incorrecta
        die("Error: Contraseña incorrecta.");
    }
} else {
    // Usuario no encontrado
    die("Error: Usuario no encontrado.");
}

// Cerrar conexión
$stmt->close();
$conn->close();
?>
