<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PowerTools - Carrito de Compras</title>
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

  <!-- Barra de Navegación -->
  <header class="container-fluid">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="http://localhost/Powertools/">
        <img src="../Imagenes/logo.png" alt="Logo" width="30" height="30" class="d-inline-block align-top">
        PowerTools
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="index.html#about">Quiénes Somos</a></li>
          <li class="nav-item"><a class="nav-link" href="index.html#catalog">Nuestros productos</a></li>
          <li class="nav-item"><a class="nav-link" href="Facturacion.html">Mis compras</a></li>
          <li class="nav-item"><a class="nav-link" href="#support">Soporte</a></li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- Sección de Carrito de Compras -->
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
    <!-- Modal de Finalizar Compra -->
<div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Encabezado del Modal -->
        <div class="modal-header">
          <h5 class="modal-title" id="checkoutModalLabel">Finalizar Compra</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
  
        <!-- Cuerpo del Modal -->
        <div class="modal-body">
          <form id="checkoutForm">
            <!-- Información Personal -->
            <div class="form-group">
              <label for="fullName">Nombre Completo</label>
              <input type="text" class="form-control" id="fullName" placeholder="Ingrese su nombre completo" required>
            </div>
  
            <div class="form-group">
              <label for="email">Correo Electrónico</label>
              <input type="email" class="form-control" id="email" placeholder="Ingrese su correo" required>
            </div>
  
            <div class="form-group">
              <label for="phone">Teléfono</label>
              <input type="tel" class="form-control" id="phone" placeholder="Ingrese su número de teléfono" required>
            </div>
  
            <!-- Dirección de Envío -->
            <div class="form-group">
              <label for="address">Dirección de Envío</label>
              <input type="text" class="form-control" id="address" placeholder="Ingrese su dirección" required>
            </div>
  
            <div class="form-group">
              <label for="city">Ciudad</label>
              <input type="text" class="form-control" id="city" placeholder="Ingrese su ciudad" required>
            </div>
  
            <div class="form-group">
              <label for="postalCode">Código Postal</label>
              <input type="text" class="form-control" id="postalCode" placeholder="Ingrese su código postal" required>
            </div>
  
            <!-- Método de Pago -->
            <h6 class="mt-3">Método de Pago</h6>
            <div class="form-group">
              <select class="form-control" id="paymentMethod" required>
                <option value="" disabled selected>Seleccione un método de pago</option>
                <option value="creditCard">Tarjeta de Crédito/Débito</option>
                <option value="paypal">PayPal</option>
                <option value="cashOnDelivery">Pago Contra Entrega</option>
              </select>
            </div>
  
            <!-- Información de la Tarjeta (solo si elige tarjeta) -->
            <div id="cardInfo" style="display: none;">
              <div class="form-group">
                <label for="cardNumber">Número de Tarjeta</label>
                <input type="text" class="form-control" id="cardNumber" placeholder="Ingrese el número de su tarjeta">
              </div>
  
              <div class="form-group">
                <label for="expiryDate">Fecha de Expiración</label>
                <input type="text" class="form-control" id="expiryDate" placeholder="MM/AA">
              </div>
  
              <div class="form-group">
                <label for="cvv">CVV</label>
                <input type="text" class="form-control" id="cvv" placeholder="Código de seguridad">
              </div>
            </div>
  
            <!-- Botón de Confirmación -->
            <button type="submit" class="btn btn-primary btn-block">Confirmar Compra</button>
          </form>
        </div>
  
        <!-- Pie del Modal -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Pie de Página -->
  <footer class="text-center py-4">
    <p>© 2024 PowerTools - Todos los derechos reservados</p>
    <div class="social-icons">
      <a href="#"><img src="Imagenes/icon-facebook.png" alt="Facebook" width="30" height="30"></a>
      <a href="#"><img src="Imagenes/icon-twitter.png" alt="Twitter" width="30" height="30"></a>
      <a href="#"><img src="Imagenes/icon-instagram.png" alt="Instagram" width="30" height="30"></a>
    </div>
  </footer>

<?php

include '../includes/footer.php';
?>
