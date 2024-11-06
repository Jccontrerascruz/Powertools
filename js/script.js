document.addEventListener("DOMContentLoaded", () => {
    // Seleccionar los elementos necesarios
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
  });
  