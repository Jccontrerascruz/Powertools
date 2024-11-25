<?php

include "conexionBD.php";

$registerName = $_POST['registerName'];
$registerSurname = $_POST['registerSurname'];
$registerEmailUser = $_POST['registerEmail'];
$registerPasswordUser = $_POST['registerPassword'];
$registerConfirmpaswordUser = $_POST['registerConfirmPassword'];

// calidacion de contraceña
if ($registerPasswordUser !== $registerConfirmpaswordUser) {
    die("Error: Las contraseñas no coinciden.");}
/*
echo $registerEmailUser;
echo $registerPasswordUser;
echo $registerConfirmpaswordUser;
*/

// cifrado de contraceña

$hashedPassword = password_hash($registerPasswordUser, PASSWORD_BCRYPT);

$sql = "INSERT INTO usuarios (
    Nombre, 
    Apellidos, 
    Correo_Electronico, 
    Contraseña, 
    Rol
) 
VALUES (
    '$registerName', 
    '$registerSurname', 
    '$registerEmailUser', 
    '$hashedPassword', 
    'Cliente'
    )";

if (mysqli_query($conn, $sql)) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);

?>