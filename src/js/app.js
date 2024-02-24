// Contador de pasos para paginación
let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

// Objeto para la cita de un cliente
const cita = {
  id: "",
  nombre: "",
  fecha: "",
  hora: "",
  servicios: [],
};

// Inicio
document.addEventListener("DOMContentLoaded", function () {
  iniciarApp();
});

/**
 * Función de arranque en toda la aplicación
 */
function iniciarApp() {
  mostrarSeccion(); // Muestra y oculta una sección de la aplicación
  tabs(); // Cambia la sección cuando se preciona un tab
  botonesPaginador(); // Agrega o quita los botones del paginador
  paginaSiguiente(); // Funciones de paginación (Volver)
  paginaAnterior(); // Funciones de paginación (Volver)

  // Consulta de API en el backend de PHP
  consultarAPI();

  // Obtener el id del cliente
  idCliente();

  // Obtener el nombre del cliente
  nombreCliente();

  // Seleccionar Fecha
  seleccionrFecha();

  // Sleccionar la hora de la cita
  seleccionarHora();

  // Muestra el resumen de la cita
  mostrarResumen();
}

/**
 * Muestra una sección en especifico dentro del HTML, la sección varia dependiendo de la sección en la que se encuentre el usuario.
 */
function mostrarSeccion() {
  // Ocultar la sección anterior
  const seccionAnterior = document.querySelector(".mostrar");

  // Comrpobar si existe una sección anterior y eliminar el contenido
  if (seccionAnterior) {
    seccionAnterior.classList.remove("mostrar");
  }

  // Seleccionar la sección con el paso
  const pasoSelector = `#paso-${paso}`;
  const seccion = document.querySelector(pasoSelector);
  seccion.classList.add("mostrar");

  // Quitar la clase de actual al tab anterior
  const tabAnterior = document.querySelector(".actual");
  if (tabAnterior) {
    tabAnterior.classList.remove("actual");
  }

  // Resalta el tab actual
  const tab = document.querySelector(`[data-paso="${paso}"]`);
  tab.classList.add("actual");
}

/**
 * Cambiar de la sección que se muestra en el HTML cuando se da click en los tabs
 */
function tabs() {
  const botones = document.querySelectorAll(".tabs button");

  // Iterar sobre la lista de botones
  botones.forEach((boton) => {
    boton.addEventListener("click", (e) => {
      // Asignar el paso a la variable de paso
      paso = parseInt(e.target.dataset.paso);

      // Validar y mostrar seccion
      mostrarSeccion();

      // Validar y mostrar botones
      botonesPaginador();
    });
  });
}

/**
 * Función para mostrar y ocultar de forma dinámica los botones de paginación de acuerdo a la sección en la que se encuentre el usuario.
 */
function botonesPaginador() {
  const pagAnt = document.querySelector("#anterior");
  const pagSig = document.querySelector("#siguiente");

  if (paso === 1) {
    pagAnt.classList.add("ocultar");
    pagSig.classList.remove("ocultar");
  } else if (paso === 3) {
    pagAnt.classList.remove("ocultar");
    pagSig.classList.add("ocultar");
    mostrarResumen();
  } else {
    pagAnt.classList.remove("ocultar");
    pagSig.classList.remove("ocultar");
  }

  mostrarSeccion();
}

/**
 * Función con la lógica del botón de volver
 */
function paginaAnterior() {
  const paginaAnterior = document.querySelector("#anterior");

  paginaAnterior.addEventListener("click", () => {
    if (paso <= pasoInicial) return;
    paso--;

    botonesPaginador();
  });
}

/**
 * Función con la lógica del botón de volver
 */
function paginaSiguiente() {
  const paginaSiguiente = document.querySelector("#siguiente");

  paginaSiguiente.addEventListener("click", () => {
    if (paso >= pasoFinal) return;
    paso++;

    botonesPaginador();
  });
}

// API DE SERVICIOS
async function consultarAPI() {
  try {
    // Consultar el servicio con Fetch
    const resultado = await fetch(`${location.origin}/api/servicios`);
    const servicios = await resultado.json();

    // Mostrar los servicios
    mostrarServicios(servicios);
  } catch (error) {
    console.log(error);
  }
}

/** Agregega los servicios obtenidos en formato JSON al HTML
 * @param servicios
 */
function mostrarServicios(servicios) {
  // Iterar sobre los servicios
  servicios.forEach((servicio) => {
    // Destructuring para obtener variables y valores
    const { id, nombre, precio } = servicio;

    // Scripting del nombre del servicio
    const nombreServicio = document.createElement("P");
    nombreServicio.classList.add("nombre-servicio");
    nombreServicio.textContent = nombre;

    // Scripting del precio del servicio
    const precioServicio = document.createElement("P");
    precioServicio.classList.add("precio-servicio");
    precioServicio.textContent = `$${precio}`;

    // Scripting del contenedor del servicio
    const servicioDiv = document.createElement("DIV");
    servicioDiv.classList.add("servicio");
    servicioDiv.dataset.idServicio = id;

    // Callback para seleccionar un servicio y agregarlo al objeto "Cita"
    servicioDiv.onclick = function () {
      seleccionarServicio(servicio);
    };

    // Agregar el contenido al div
    servicioDiv.appendChild(nombreServicio);
    servicioDiv.appendChild(precioServicio);

    document.querySelector("#servicios").appendChild(servicioDiv);
  });
}

/** Agregar uno o más servicios al arreglo de servicios dentro del objeto "cita"
 * @param servicio
 */
function seleccionarServicio(servicio) {
  // Extracción de datos necesarios
  const { id } = servicio;
  const { servicios } = cita;

  // Identificar el elemento al que se le da click
  const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);

  // Comprobar si un servicio ya fue agregado
  if (servicios.some((agregado) => agregado.id === id)) {
    // Remover el servicio y quitar la clase de seleccionado
    cita.servicios = servicios.filter((agregado) => agregado.id !== id);
    divServicio.classList.remove("seleccionado");
  } else {
    // Tomar una copia del arreglo anterior y agregar el nuevo contenido. Agregar la clase de seleccionado
    cita.servicios = [...servicios, servicio];
    divServicio.classList.add("seleccionado");
  }
  console.log(cita);
}

function idCliente() {
  cita.id = document.querySelector("#id").value;
}

// Función para obtener el nombre del cliente desde el formulario
function nombreCliente() {
  const nombre = document.querySelector("#nombre").value;
  cita.nombre = nombre;
}

// Seleccionar la fecha de la cita en el objeto
function seleccionrFecha() {
  const inputFecha = document.querySelector("#fecha");
  inputFecha.addEventListener("input", (e) => {
    // Otener el numero de dia seleccionado
    const dia = new Date(e.target.value).getUTCDay();

    // Validar la fecha (Revisar si el numero de día es S o D)
    if ([6, 0].includes(dia)) {
      // Mostrar alerta de error
      e.target.value = "";
      mostrarAlerta("Fines de Semana no permitidos", "error", ".formulario");
    } else {
      // Asignar la fecha
      cita.fecha = e.target.value;
    }
  });
}

// Seleccionar la hora de la cita y asignarla al objeto
function seleccionarHora() {
  const inputHora = document.querySelector("#hora");
  inputHora.addEventListener("input", (e) => {
    const horaCita = e.target.value;
    const hora = horaCita.split(":")[0]; // Obtener el número de la hora (hrs).

    if (hora < 10 || hora > 18) {
      mostrarAlerta("Hora no valida", "error", ".formulario");
    } else {
      cita.hora = e.target.value;
    }
  });
}

// Mostrar alertas al usuario
function mostrarAlerta(mensaje, tipo, elemento, desaparecer = true) {
  // Validacion de alerta previa (Evita crear muchas alertas)
  const alertaPrevia = document.querySelector(".alerta");
  if (alertaPrevia) {
    alertaPrevia.remove();
  }

  // Scripting de la alerta
  const alerta = document.createElement("DIV");
  alerta.textContent = mensaje;
  alerta.classList.add("alerta");
  alerta.classList.add(tipo);

  // Injectar la alerta
  const referencia = document.querySelector(elemento);
  referencia.appendChild(alerta);

  if (desaparecer) {
    // Eliminar la alerta
    setTimeout(() => {
      alerta.remove();
    }, 3000);
  }
}

// Mostrar el resumen de la cita
function mostrarResumen() {
  const resumen = document.querySelector(".contenido-resumen");

  // Limpiar el div de resumen
  while (resumen.firstChild) {
    resumen.removeChild(resumen.firstChild);
  }

  // Validar campos llenos del objeti y arreglo de servicios dentro del objeto
  if (Object.values(cita).includes("") || cita.servicios.length === 0) {
    mostrarAlerta(
      "Faltan datos de servicios, fecha u hora",
      "error",
      ".contenido-resumen",
      false
    );
    return;
  }

  // Formatear el div de resumen.
  const { nombre, fecha, hora, servicios } = cita;

  const heading = document.createElement("H3");
  heading.textContent = "Resumen de Servicios";

  resumen.appendChild(heading);

  // Iterar los servicios
  servicios.forEach((servicio) => {
    const { id, precio, nombre } = servicio;

    const contenedorServicio = document.createElement("DIV");
    contenedorServicio.classList.add("contenedor-servicio");

    const textoServicio = document.createElement("P");
    textoServicio.textContent = nombre;

    const precioServicio = document.createElement("P");
    precioServicio.innerHTML = `<span>Precio:</span> $${precio}`;

    contenedorServicio.appendChild(textoServicio);
    contenedorServicio.appendChild(precioServicio);
    resumen.appendChild(contenedorServicio);
  });

  const headingCita = document.createElement("H3");
  headingCita.textContent = "Resumen de la Cita";

  const nombreCliente = document.createElement("P"); // Nombre del cliente
  nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;

  // Formatear la fecha en español
  const fechaObj = new Date(fecha);
  const mes = fechaObj.getMonth();
  const dia = fechaObj.getDate() + 2;
  const year = fechaObj.getFullYear();

  // Crear objeto formateado con la fecha
  const fechaUTC = new Date(Date.UTC(year, mes, dia));

  // Opciones de formateo para la fecha
  const opciones = {
    weekday: "long",
    year: "numeric",
    month: "long",
    day: "numeric",
  };

  // Fecha formateada
  const fechaFormateada = fechaUTC.toLocaleDateString("es-MX", opciones);

  const fechaCita = document.createElement("P"); // Fecha de la cita
  fechaCita.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`;

  const horaCita = document.createElement("P"); // Hora de la cita
  horaCita.innerHTML = `<span>Hora:</span> ${hora} Horas`;

  // Boton para reservar una cita
  const botonReservar = document.createElement("BUTTON");
  botonReservar.textContent = "Reservar Cita";
  botonReservar.classList.add("boton");
  botonReservar.onclick = reservarCita;

  resumen.appendChild(headingCita);
  resumen.appendChild(nombreCliente);
  resumen.appendChild(fechaCita);
  resumen.appendChild(horaCita);
  resumen.appendChild(botonReservar);
}

// Funcion para reservar una cita
async function reservarCita() {
  // Obtener los datos de cita
  const { id, nombre, fecha, hora, servicios } = cita;
  const idServicios = servicios.map((servicio) => servicio.id); // Obtener los id's de los servicios

  // Datos para enviar a la peticion fetch.
  const datos = new FormData();
  datos.append("id_usuario", id); // Añadir datos al form data
  datos.append("fecha", fecha);
  datos.append("hora", hora);
  datos.append("servicios", idServicios);

  // peticion hacia la api
  try {
    const url = `${location.origin}/api/citas`; // URL de la api
    const respuesta = await fetch(url, {
      method: "POST", // Metodo Request
      body: datos, // Cuerpo de la peticion (Contenido del form data)
    });
    // Formatear el resultado
    const resultado = await respuesta.json();

    // Mostrar alerta de ejecución
    if (resultado.resultado) {
      Swal.fire({
        // Nueva sweet alert
        icon: "success",
        title: "Cita Creada.",
        text: "Tu cita fue creada correctamente",
        button: "OK",
      }).then(() => {
        window.location.reload(); // Regargar la página
      });
    }
  } catch (error) {
    // Mostrar alerta en caso de error con la petición
    Swal.fire({
      // Nueva sweet alert
      icon: "error",
      title: "Error",
      text: "Ha ocurrido un error al guardar la cita",
      button: "Volver",
    });
  }
}
