<?php
include 'includes/header.php';
?>


  <!-- Sección Principal con Video -->
  <section class="hero text-center py-5">
    <div class="container">
      <video autoplay muted loop playsinline class="w-100 mb-4" style="border-radius: 8px;">
        <source src="Video/VideoHome.mp4" type="video/mp4">
      </video>
      <h1 class="display-4">Tu proyecto, nuestra potencia</h1>
      <p class="lead">Regístrate ahora y recibe un 10% de descuento en tu primera compra. Además, obtén sugerencias personalizadas de productos con descuentos exclusivos directamente en tu correo. ¡Únete a PowerTools y aprovecha una compra segura, rápida y confiable!.</p>
      <a href="#" class="btn btn-primary btn-lg mt-3" data-toggle="modal" data-target="#loginModal">¡Unete ahora!</a>
    </div>
  </section>

  <!-- Sección Quiénes Somos -->
  <section id="about" class="py-5 bg-light">
    <div class="container">
      <h2 class="text-center">Quiénes Somos</h2>
      <p class="text-center">PowerTools es una empresa dedicada a ofrecer herramientas de alta calidad tanto para entusiastas como para profesionales. Nuestra misión es brindar productos confiables que faciliten el trabajo y mejoren la eficiencia en cada proyecto. Fundada en noviembre de 2024, nos hemos posicionado rápidamente como un referente en la venta de herramientas de excelente calidad a través de nuestra plataforma en línea.</p>
    </div>
  </section>

<!-- Sección Nuestros Productos -->
<section id="catalog" class="py-5">
  <div class="container">
    <h2 class="text-center">Nuestros Productos</h2>
    <div class="row">

      <!-- Repite el bloque de producto para cada uno -->
      <div class="col-md-3 col-sm-6 text-center mb-4">
        <a href="product-detail.html">
        <div class="card">
          <img src="imagenes\taladro.jpg" class="card-img-top" alt="Herramienta 1">
          <div class="card-body">
            <h5 class="card-title">Taladro</h5>
            <p class="card-text">$150000</p>
            <a href="product-detail.html" class="btn btn-outline-primary">Agrega al carrrito</a>
          </div>
        </div>
      </a>
      </div>
      <!-- Agrega más productos según sea necesario -->
    </div>
  </div>
</section>


<!-- Modal de Inicio de Sesión -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Iniciar sesión</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="email">Correo electrónico</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Ingrese su correo">
          </div>
          <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Ingrese su contraseña">
          </div>
          <button type="submit" class="btn btn-primary btn-block">Iniciar sesión</button>
        </form>
      </div>
      <div class="modal-footer">
        <p class="mr-auto">¿No tienes una cuenta? <a href="#" data-toggle="modal" data-target="#registerModal" data-dismiss="modal">Regístrate</a></p>
      </div>
    </div>
  </div>
</div>

<!-- Modal de Registro -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="registerModalLabel">Regístrate</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="includes/datos.php" method="post">
        <div class="form-group">
            <label for="registerName">Nombres</label>
            <input type="text" class="form-control" name="registerName" id="registerName" placeholder="Ingrese su nombre">
          </div>
          <div class="form-group">
            <label for="registerSurname">Apellido</label>
            <input type="text" class="form-control" name="registerSurname" id="registerSurname" placeholder="Ingrese su nombre">
          </div>
          <div class="form-group">
            <label for="registerEmail">Correo electrónico</label>
            <input type="email" class="form-control" name="registerEmail" id="registerEmail" placeholder="Ingrese su correo">
          </div>
          <div class="form-group">
            <label for="registerPassword">Contraseña</label>
            <input type="password" class="form-control" name="registerPassword" id="registerPassword" placeholder="Cree una contraseña">
          </div>
          <div class="form-group">
            <label for="registerConfirmPassword">Confirmar Contraseña</label>
            <input type="password" class="form-control" name="registerConfirmPassword" id="registerConfirmPassword" placeholder="Confirme su contraseña">
          </div>
          <button type="submit" class="btn btn-primary btn-block">Registrarse</button>
        </form>
      </div>
    </div>
  </div>
</div>

  <!-- Scripts de Bootstrap y script personalizado -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="js/script.js"></script>

  <!-- Pie de página -->
<footer class="bg-dark text-white py-4">
  <div class="container text-center">
    <div class="row">
      <!-- Información de contacto -->
      <div class="col-md-4 mb-3">
        <h5>Contacto</h5>
        <p>Email: contacto@powertools.com</p>
        <p>Teléfono: +123 456 7890</p>
      </div>
      <!-- Enlaces rápidos -->
      <div class="col-md-4 mb-3">
        <h5>Enlaces rápidos</h5>
        <ul class="list-unstyled">
          <li><a href="#about" class="text-white">Quiénes Somos</a></li>
          <li><a href="#catalog" class="text-white">Nuestros Productos</a></li>
          <li><a href="#support" class="text-white">Soporte</a></li>
          <li><a href="#billing" class="text-white">Facturación</a></li>
        </ul>
      </div>
      <!-- Redes sociales -->
      <div class="col-md-4 mb-3">
        <h5>Síguenos</h5>
        <a href="#" class="text-white mr-2"><i class="fab fa-facebook-f"></i> Facebook</a><br>
        <a href="#" class="text-white mr-2"><i class="fab fa-twitter"></i> Twitter</a><br>
        <a href="#" class="text-white"><i class="fab fa-instagram"></i> Instagram</a>
      </div>
    </div>
    <hr class="bg-white">
    <p class="mb-0">&copy; 2024 PowerTools. Todos los derechos reservados.</p>
  </div>


<?php

include 'includes/footer.php';
?>
