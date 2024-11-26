<?php

include "../includes/conexionBD.php";

$sql = "SELECT Correo_Electronico, Contraseña, FROM usuarios";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo "Correo electronico: " . $row["Correo_Electronico"]. "Contraseña: " . $row["Contraseña"]. "<br>";
  }
} else {
  echo "0 results";
}
$conn->close();
?>