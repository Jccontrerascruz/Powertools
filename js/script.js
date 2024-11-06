document.addEventListener("DOMContentLoaded", () => {
  // Seleccionar los elementos necesarios para el cálculo del total
  const quantityInput = document.getElementById("quantity");
  const unitPrice = 150000; // Precio por unidad en pesos colombianos, cambia este valor según el producto
  const totalField = document.getElementById("total");

  // Función para calcular y actualizar el total
  function updateTotal() {
    const quantity = parseInt(quantityInput.value) || 1;
    const total = unitPrice * quantity;
    totalField.textContent = `$${total.toLocaleString("es-CO")}`; // Formato de moneda colombiana
  }

  // Actualizar el total al cambiar la cantidad
  quantityInput.addEventListener("input", updateTotal);

  // Inicializar el total al cargar la página
  updateTotal();

  // Función de validación de correo electrónico
  function validateEmail(email) {
    const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    return emailPattern.test(email);
  }

  // Validación en el campo de correo en el modal de inicio de sesión
  const loginEmail = document.getElementById("email");
  loginEmail.addEventListener("blur", function () {
    if (!validateEmail(loginEmail.value)) {
      alert("Correo inválido, por favor revise el formato.");
      loginEmail.value = ""; // Limpia el campo si el formato es incorrecto
    }
  });

  // Validación en el campo de correo en el modal de registro
  const registerEmail = document.getElementById("registerEmail");
  registerEmail.addEventListener("blur", function () {
    if (!validateEmail(registerEmail.value)) {
      alert("Correo inválido, por favor revise el formato.");
      registerEmail.value = ""; // Limpia el campo si el formato es incorrecto
    }
  });
});
