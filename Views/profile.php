<?php
include "../includes/conexionBD.php"; // Conexión a la base de datos

// Consultar los datos del usuario
// Asegúrate de tener un mecanismo para identificar al usuario (por ejemplo, una sesión activa)
session_start();
$user_id = $_SESSION['Nombre']; // Obtén el ID del usuario desde la sesión

$query = "SELECT Nombre, Apellidos FROM usuarios WHERE Correo_Electronico  = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nombre = $row['Nombre'];
    $apellidos = $row['Apellidos'];
} else {
    $nombre = "Invitado";
    $apellidos = "";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PowerTools - Perfil del Cliente</title>
  <link rel="stylesheet" href="css/styles.css"> <!-- Vinculación del archivo CSS externo -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

  <!-- Barra de Navegación -->
  <header class="container-fluid">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="http://localhost/Powertools-1/">
        <img src="../Imagenes/logo.png" alt="Logo" width="30" height="30" class="d-inline-block align-top">
        PowerTools
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="historial-compras.html">Mis Compras</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="productos-recomendados.html">Recomendados</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="carrito.html">Carrito</a>
          </li>
          <li class="nav-item">
            <a class="nav-link btn btn-danger text-white" href="/Powertools-1/controllers/logout.php">Cerrar Sesión</a>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- Sección de Bienvenida -->
  <section class="py-5 text-center bg-light">
    <div class="container">
      <h1>Bienvenido de nuevo, <?php echo htmlspecialchars($nombre . ' ' . $apellidos); ?></h1>
      <p class="lead">Consulta tu historial de compras o encuentra productos recomendados para ti.</p>
    </div>
  </section>

  <!-- Sección Historial de Compras -->
  <section class="py-5">
    <div class="container">
      <h2 class="text-center">Historial de Compras</h2>
      <table class="table table-hover mt-4">
        <thead class="thead-dark">
          <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Fecha de Compra</th>
            <th>Estado</th>
          </tr>
        </thead>
        <tbody>
          <!-- Ejemplo de datos, estos deberían generarse dinámicamente -->
          <tr>
            <td>Taladro Eléctrico</td>
            <td>1</td>
            <td>$150.000</td>
            <td>2024-11-20</td>
            <td>Entregado</td>
          </tr>
          <tr>
            <td>Sierra Circular</td>
            <td>2</td>
            <td>$300.000</td>
            <td>2024-11-15</td>
            <td>En tránsito</td>
          </tr>
          <!-- Fin de ejemplo -->
        </tbody>
      </table>
    </div>
  </section>

  <!-- Sección Productos Recomendados -->
  <section class="py-5 bg-light">
    <div class="container">
      <h2 class="text-center">Productos Recomendados para Ti</h2>
      <div class="row">
        <!-- Producto 1 -->
        <div class="col-md-3 col-sm-6 text-center mb-4">
          <div class="card">
            <img src="imagenes/atornillador.jpg" class="card-img-top" alt="Atornillador">
            <div class="card-body">
              <h5 class="card-title">Atornillador</h5>
              <p class="card-text">$80.000</p>
              <a href="product-detail.html" class="btn btn-primary">Agregar al Carrito</a>
            </div>
          </div>
        </div>
        <!-- Producto 2 -->
        <div class="col-md-3 col-sm-6 text-center mb-4">
          <div class="card">
            <img src="imagenes/martillo.jpg" class="card-img-top" alt="Martillo">
            <div class="card-body">
              <h5 class="card-title">Martillo</h5>
              <p class="card-text">$20.000</p>
              <a href="product-detail.html" class="btn btn-primary">Agregar al Carrito</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Pie de página -->
  <footer class="bg-dark text-white py-4">
    <div class="container text-center">
      <p class="mb-0">&copy; 2024 PowerTools. Todos los derechos reservados.</p>
    </div>
  </footer>

  <!-- Scripts de Bootstrap -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
