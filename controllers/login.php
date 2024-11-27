<?php
require __DIR__ . "/vendor/autoload.php"; // Carga el SDK de Google
if (file_exists(__DIR__ . "/vendor/autoload.php")) {
    echo "SDK de Google cargado correctamente.<br>";
} else {
    die("Error al cargar el SDK de Google.<br>");
}

include "../includes/conexionBD.php"; // Conexión a la base de datos
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error . "<br>");
} else {
    echo "Conexión a la base de datos exitosa.<br>";
}

session_start(); // Inicia la sesión
if (session_id()) {
    echo "Sesión iniciada correctamente.<br>";
} else {
    echo "Error al iniciar la sesión.<br>";
}

// Configuración del cliente de Google
$client = new Google\Client();
$client->setAuthConfig(__DIR__ . '/google-client.json'); // Cargar configuración de Google
if (file_exists(__DIR__ . '/google-client.json')) {
    echo "Archivo de configuración JSON cargado correctamente.<br>";
} else {
    die("Error: Archivo JSON de configuración no encontrado.<br>");
}

$client->setRedirectUri("http://localhost/powertools/views/profile.html"); // Redirige al mismo archivo después de la autenticación
$client->addScope("email");
$client->addScope("profile");

echo "Configuración del cliente de Google realizada correctamente.<br>";
echo "Client ID: " . $client->getClientId() . "<br>";
echo "Redirect URI: " . $client->getRedirectUri() . "<br>";

// Verificar si no se recibió el código de autorización
if (!isset($_GET['code'])) {
    echo "No se recibió código de autorización. Redirigiendo al flujo de autenticación...<br>";
    $auth_url = $client->createAuthUrl();
    echo "URL de autenticación generada: $auth_url<br>";
    header("Location: $auth_url");
    exit;
}

// Si se recibe el código de autorización, procesar la autenticación
if (isset($_GET['code'])) {
    echo "Código de autorización recibido: " . $_GET['code'] . "<br>";

    try {
        // Obtener el token de acceso con el código recibido
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        echo "Token de acceso recibido: " . json_encode($token) . "<br>";

        if (isset($token['error'])) {
            die("Error al obtener el token: " . $token['error_description'] . "<br>");
        }

        $client->setAccessToken($token);
        echo "Token configurado correctamente en el cliente de Google.<br>";

        // Obtener la información del usuario desde Google
        $google_oauth = new Google\Service\Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();

        echo "Información del usuario obtenida:<br>";
        echo "Correo: " . $google_account_info->email . "<br>";
        echo "Nombre: " . $google_account_info->name . "<br>";

        $google_email = $google_account_info->email;
        $google_name = $google_account_info->name;

        // Buscar al usuario en la base de datos
        echo "Buscando usuario en la base de datos...<br>";
        $sql = "SELECT ID_Usuario, Nombre FROM usuarios WHERE Correo_Electronico = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $google_email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            // Usuario existente
            echo "Usuario encontrado: " . $user['Nombre'] . "<br>";
            $_SESSION['user_id'] = $user['ID_Usuario'];
            $_SESSION['user_name'] = $user['Nombre'];
            header("Location: ../views/profile.html");
            exit;
        } else {
            // Usuario nuevo
            echo "Usuario no encontrado. Creando nuevo usuario...<br>";
            $insert_sql = "INSERT INTO usuarios (Nombre, Correo_Electronico, Rol) VALUES (?, ?, 'Cliente')";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param("ss", $google_name, $google_email);
            if ($insert_stmt->execute()) {
                echo "Usuario creado con éxito.<br>";
                $_SESSION['user_id'] = $conn->insert_id;
                $_SESSION['user_name'] = $google_name;
                header("Location: ../views/profile.html");
                exit;
            } else {
                die("Error al insertar nuevo usuario: " . $conn->error . "<br>");
            }
        }
    } catch (Exception $e) {
        die("Excepción capturada: " . $e->getMessage() . "<br>");
    }
} else {
    echo "No se recibió el código de autorización.<br>";
}

echo "Error de inicio de sesión.<br>";
exit;
?>
