<?php
require __DIR__ . "/vendor/autoload.php"; // SDK de Google
include "../includes/conexionBD.php"; // Conexión a la base de datos

// Ruta del archivo de log
define('LOG_FILE', 'C:\\xampp\\htdocs\\Powertools-1\\log.txt');
define('REDIRECT_URI', 'http://localhost/powertools-1/views/profile.php'); // URI de redirección para usuarios
define('REDIRECT_URI_ADMIN', 'http://localhost/powertools-1/views/admin.html'); // URI de redirección para administradores
define('REDIRECT_URI_GOOGLE', 'http://localhost/powertools-1/controllers/login.php'); // URI de redirección para Google

function write_log($message) {
    $date = date('Y-m-d H:i:s');
    $client_ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'UNKNOWN';
    $log_message = "[$date] [IP: $client_ip] [Navegador: $user_agent] $message" . PHP_EOL;
    file_put_contents(LOG_FILE, $log_message, FILE_APPEND);
}

session_start();
write_log("Sesión iniciada.");

// Verificar conexión a la base de datos
if ($conn->connect_error) {
    write_log("Error al conectar a la base de datos: " . $conn->connect_error);
    die("Error al conectar a la base de datos.");
}
write_log("Conexión a la base de datos exitosa.");

// Función para redirigir según el rol del usuario
function redirect_user_based_on_role($role) {
    if ($role === 'Administrador') {
        header("Location: " . REDIRECT_URI_ADMIN);
    } else {
        header("Location: " . REDIRECT_URI);
    }
    exit;
}

// Verificar si la solicitud es un formulario POST (inicio de sesión manual)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || empty($password)) {
        write_log("Error: Datos de inicio de sesión inválidos.");
        die("Error: Datos inválidos.");
    }

    $sql = "SELECT ID_Usuario, Nombre, Contraseña, Rol FROM usuarios WHERE Correo_Electronico = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        write_log("Error al preparar la consulta SQL: " . $conn->error);
        die("Error al preparar la consulta SQL.");
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['Contraseña'])) {
        $_SESSION['user_id'] = $user['ID_Usuario'];
        $_SESSION['user_name'] = $user['Nombre'];
        $_SESSION['user_role'] = $user['Rol'];
        write_log("Inicio de sesión exitoso para el usuario: " . $user['Nombre'] . " (Rol: " . $user['Rol'] . ")");
        redirect_user_based_on_role($user['Rol']);
    } else {
        write_log("Error: Correo o contraseña incorrectos.");
        die("Error: Correo o contraseña incorrectos.");
    }
}

// Si no es POST, manejar autenticación con Google
$client = new Google\Client();
$client->setAuthConfig(__DIR__ . '/google-client.json');
$client->setRedirectUri(REDIRECT_URI_GOOGLE);
$client->addScope("email");
$client->addScope("profile");

// Si no hay código, redirigir a Google para autenticación
if (!isset($_GET['code'])) {
    $auth_url = $client->createAuthUrl();
    write_log("Redirigiendo a autenticación con Google. URL: $auth_url");
    header("Location: $auth_url");
    exit;
}

// Manejar retorno de Google con el código
if (isset($_GET['code'])) {
    write_log("Parámetro 'code' recibido: " . $_GET['code']);

    try {
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        if (isset($token['error'])) {
            write_log("Error al obtener el token de Google: " . $token['error_description']);
            die("Error al obtener el token: " . $token['error_description']);
        }

        $client->setAccessToken($token);
        $google_oauth = new Google\Service\Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
        $google_email = filter_var($google_account_info->email ?? '', FILTER_SANITIZE_EMAIL);
        $google_name = htmlspecialchars($google_account_info->name ?? '');

        if (empty($google_email) || empty($google_name)) {
            write_log("Error: Información de usuario de Google no válida.");
            die("Error: No se pudo obtener información válida del usuario de Google.");
        }

        write_log("Información de Google - Email: $google_email, Nombre: $google_name");

        // Verificar si el usuario ya existe en la base de datos
        $sql = "SELECT ID_Usuario, Nombre, Rol FROM usuarios WHERE Correo_Electronico = ?";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            write_log("Error al preparar la consulta SQL para Google: " . $conn->error);
            die("Error al preparar la consulta SQL.");
        }

        $stmt->bind_param("s", $google_email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            $_SESSION['user_id'] = $user['ID_Usuario'];
            $_SESSION['user_name'] = $user['Nombre'];
            $_SESSION['user_role'] = $user['Rol'];
            write_log("Usuario existente autenticado: " . $user['Nombre'] . " (Rol: " . $user['Rol'] . ")");
            redirect_user_based_on_role($user['Rol']);
        } else {
            write_log("Usuario no registrado. Insertando en la base de datos.");
            $default_password = password_hash('google-auth', PASSWORD_BCRYPT);
            $default_value = 'IngresoAPI';
            $rol = 'Cliente';

            $insert_sql = "INSERT INTO usuarios (Nombre, Apellidos, Correo_Electronico, Contraseña, Dirección, Ciudad, Codigo_Postal, Teléfono, Rol) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_sql);

            if (!$insert_stmt) {
                write_log("Error al preparar la consulta de inserción: " . $conn->error);
                die("Error al preparar la consulta de inserción.");
            }

            $insert_stmt->bind_param("sssssssss", $google_name, $default_value, $google_email, $default_password, $default_value, $default_value, $default_value, $default_value, $rol);

            if ($insert_stmt->execute()) {
                $last_insert_id = $conn->insert_id;
                write_log("Inserción exitosa. ID del nuevo usuario: $last_insert_id.");
                $_SESSION['user_id'] = $last_insert_id;
                $_SESSION['user_name'] = $google_name;
                $_SESSION['user_role'] = $rol;
                redirect_user_based_on_role($rol);
            } else {
                write_log("Error al insertar nuevo usuario: " . $conn->error);
                die("Error al insertar nuevo usuario.");
            }
        }
    } catch (Exception $e) {
        write_log("Excepción capturada: " . $e->getMessage());
        die("Excepción capturada: " . $e->getMessage());
    }
}

write_log("Error: Solicitud no válida.");
die("Error: Solicitud no válida.");
