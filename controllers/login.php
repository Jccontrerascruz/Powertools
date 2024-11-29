<?php
require __DIR__ . "/vendor/autoload.php"; // Carga el SDK de Google
include "../includes/conexionBD.php"; // Conexión a la base de datos

session_start(); // Inicia la sesión

// Verifica si es un inicio de sesión tradicional (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtiene los datos del formulario
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Verifica si los campos no están vacíos
    if (empty($email) || empty($password)) {
        die("Error: El correo y la contraseña son obligatorios.<br>");
    }

    // Busca al usuario en la base de datos
    $sql = "SELECT ID_Usuario, Nombre, Contraseña FROM usuarios WHERE Correo_Electronico = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['Contraseña'])) {
        // Usuario autenticado correctamente
        $_SESSION['user_id'] = $user['ID_Usuario'];
        $_SESSION['user_name'] = $user['Nombre'];
        header("Location: ../views/profile.html");
        exit;
    } else {
        // Usuario no encontrado o contraseña incorrecta
        die("Error: Credenciales inválidas.<br>");
    }
}

// Configuración de Google: Verifica si se trata de una autenticación con Google (GET)
$client = new Google\Client();
$client->setAuthConfig(__DIR__ . '/google-client.json'); // Cargar configuración de Google
$client->setRedirectUri("http://localhost/powertools/views/profile.html"); // URL de redirección después de autenticarse
$client->addScope("email");
$client->addScope("profile");

if (!isset($_GET['code'])) {
    // Si no hay código, genera y redirige al flujo de autenticación de Google
    $auth_url = $client->createAuthUrl();
    header("Location: $auth_url");
    exit;
}

if (isset($_GET['code'])) {
    try {
        // Obtener el token de acceso con el código recibido
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        if (isset($token['error'])) {
            die("Error al obtener el token: " . $token['error_description']);
        }

        $client->setAccessToken($token);

        // Obtener la información del usuario desde Google
        $google_oauth = new Google\Service\Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
        $google_email = $google_account_info->email;
        $google_name = $google_account_info->name;

        // Validar los datos de Google
        if (empty($google_name) || empty($google_email)) {
            die("Error: No se pudo obtener información válida del usuario de Google.");
        }

        // Verifica si el usuario ya existe en la base de datos
        $sql = "SELECT ID_Usuario, Nombre FROM usuarios WHERE Correo_Electronico = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $google_email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            // Usuario existente
            echo "Usuario existente encontrado: " . $user['Nombre'] . "<br>";
            $_SESSION['user_id'] = $user['ID_Usuario'];
            $_SESSION['user_name'] = $user['Nombre'];
            // header("Location: ../views/profile.html");
            exit;
        } else {
            // Usuario nuevo
            echo "Usuario no encontrado. Intentando crear uno nuevo...<br>";
        
            $default_password = password_hash('google-auth', PASSWORD_BCRYPT); // Contraseña hashed
            $insert_sql = "INSERT INTO usuarios (Nombre, Apellidos, Correo_Electronico, Contraseña, Dirección, Ciudad, Codigo_Postal, Teléfono, Rol) 
                           VALUES (?, '', ?, ?, '', '', '', '', 'Cliente')";
            $insert_stmt = $conn->prepare($insert_sql);
        
            if (!$insert_stmt) {
                die("Error al preparar la consulta: " . $conn->error); // Error en la consulta
            }
        
            $insert_stmt->bind_param("sss", $google_name, $google_email, $default_password);
        
            if ($insert_stmt->execute()) {
                echo "Usuario creado con éxito. ID del usuario: " . $conn->insert_id . "<br>";
                $_SESSION['user_id'] = $conn->insert_id;
                $_SESSION['user_name'] = $google_name;
                // header("Location: ../views/profile.html");
                exit;
            } else {
                die("Error al insertar nuevo usuario: " . $conn->error); // Detalle del error
            }
        }
        
    } catch (Exception $e) {
        die("Excepción capturada: " . $e->getMessage());
    }
}

echo "Error de inicio de sesión.<br>";
exit;
?>
