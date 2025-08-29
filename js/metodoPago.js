// Si ya se confirmó antes, mostrar el QR siempre
// logica de compra de entradas (cantidad y total)
const PRECIO_POR_ENTRADA = 8000; // precio de cada entrada
// elementos del DOM (Document Object Model), documentos que están en memoria 
const select = document.getElementById("opciones");
const totalEl = document.getElementById("total");

// función pura: solo calcula
function totalEntradas(cant, precio = PRECIO_POR_ENTRADA) {
  return cant * precio;
}

// cuando cambia la cantidad, recalculamos
function actualizarTotal() {
  const cant = Number(select.value); // value llega como string → lo convertimos
  const total = totalEntradas(cant);
  totalEl.textContent = "Total: " + total.toLocaleString("es-AR", {
    style: "currency",
    currency: "ARS"
});
}

// Llenar el select (tu código)
const cantidad = [1,2,3,4,5,6,7,8,9,10];
cantidad.forEach(entradas => {
  const option = document.createElement("option");
  option.value = entradas;
  option.textContent = "Entradas: " + entradas;
  select.appendChild(option);
});

//Mostrar el total inicial y escuchar cambios
actualizarTotal();              // muestra el total de la opción inicial
select.addEventListener("change", actualizarTotal);

// api mercado pago
/*
// Pago detras de logica de mercado pago-----
  // Configure sua chave pública do Mercado Pago
  const publicKey = "YOUR_PUBLIC_KEY";
  // Configure o ID de preferência que você deve receber do seu backend
  const preferenceId = "YOUR_PREFERENCE_ID";

  // Inicializa o SDK do Mercado Pago
  const mp = new MercadoPago(publicKey);

  // Cria o botão de pagamento
  const bricksBuilder = mp.bricks();
  const renderWalletBrick = async (bricksBuilder) => {
    await bricksBuilder.create("wallet", "walletBrick_container", {
      initialization: {
        preferenceId: "<PREFERENCE_ID>",
      }
});
  };

  renderWalletBrick(bricksBuilder);
*/
// mayores de 18 años
const nombre = document.getElementById("nombre");
const apellido = document.getElementById("apellido");
const fechaNacimiento = document.getElementById("fechaNacimiento");
const email = document.getElementById("email");
const confirmar = document.getElementById("confirmar");


confirmar.addEventListener("click", (e) => { // lo que hay adentro del parentecis nos perimite tener acceso al objeto evento
    const valorFecha = fechaNacimiento.value;
    const valorNombre = nombre.value;
    const valorApellido = apellido.value;
    const valorEmail = email.value;
    const cantSeleccionada = Number(select.value);
    if (disponiblesActuales <= 0) {
    e.preventDefault();
    alert("Entradas agotadas, no se puede comprar más");
    return;
}

    if (cantSeleccionada > disponiblesActuales) {
    e.preventDefault();
    alert(`Solo quedan ${disponiblesActuales} entradas disponibles`);
    return;
}


    if (!valorFecha || !valorNombre || !valorApellido || !valorEmail) {
        e.preventDefault();
        alert("Complete los datos faltantes");
        return;
    }
    // deberia evitar que se pueda comprar si no hay entradas

    // Convertimos la fecha ingresada
    const nacimiento = new Date(valorFecha);

    // Fecha de referencia: 18 de septiembre del año actual
    const hoy = new Date();
    const anioActual = hoy.getFullYear();
    const fechaReferencia = new Date(anioActual, 9, 4) // 4 de octubre

    // Calcular edad en esa fecha
    let edad = fechaReferencia.getFullYear() - nacimiento.getFullYear();
    const m = fechaReferencia.getMonth() - nacimiento.getMonth();
    if (m < 0 || (m === 0 && fechaReferencia.getDate() < nacimiento.getDate())) {
        edad--;
    }
    if (edad < 18) {
        e.preventDefault(); // evita que continúe
        alert("No pueden pasar chicos menores de 18 años.");
    }
});

// disponibilidad de entradas en la barra 
let disponiblesActuales = 0;
// consultar disponibilidad
async function cargarDisponibilidad() {
    try {
        const resp = await fetch("./php/disponibles.php"); // lo enviamos a .php de disponibles
        const data = await resp.json();

        disponiblesActuales = data.disponibles; // ← guardamos

        const meter = document.getElementById("disponibilidad");
        meter.max = data.maximo;
        meter.value = data.disponibles;

        document.getElementById("textoDisponibles").textContent = 
            `${data.disponibles} disponibles`;

        if (data.disponibles <= 0) {
          agotado = true;
          document.getElementById("confirmar").disabled = true;
        } else {
          agotado = false;
          document.getElementById("confirmar").disabled = false;
        }
    } catch (e) {
        console.error("Error cargando disponibilidad", e);
    }
}

// 2. Guardar compra (nuevo)
confirmar.addEventListener("click", async (e) => {
  e.preventDefault();

  const datosCompra = {
    nombre: nombre.value,
    apellido: apellido.value,
    email: email.value,
    cantidad: Number(select.value)
  };

  try {
    const resp = await fetch("./php/guardarCompra.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(datosCompra)
    });

    const data = await resp.json();
    if (data.ok) {
      alert("✅ Compra registrada, revisá tu email");
      cargarDisponibilidad(); // refresca la barrita
    } else {
      alert("❌ Error: " + data.error);
    }
  } catch (err) {
    console.error("Error guardando compra", err);
  }
});

// Llamada inicial
cargarDisponibilidad();

// Opcional: refrescar cada 10 segundos
setInterval(cargarDisponibilidad, 10000);