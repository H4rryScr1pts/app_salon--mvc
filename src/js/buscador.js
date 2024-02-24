document.addEventListener("DOMContentLoaded", function () {
  iniciarApp();
});

function iniciarApp() {
  buscarFecha();
}

// Buscar citas por el input de fechas
function buscarFecha() {
  const fechaInput = document.querySelector("#fecha"); // Obtener el elemento
  fechaInput.addEventListener("input", (e) => {
    const fechaSeleccionada = e.target.value; // Agregar la fecha a la variable

    window.location = `?fecha=${fechaSeleccionada}`;
  });
}

// Eliminar una cita
function eliminarCita(id) {
  Swal.fire({
    // Mostrar la alerta de eliminar
    title: "¿Eliminar Cita?",
    text: "Una vez eliminada, no podrá recuperarse",
    icon: "warning",
    showCancelButton: true,
    cancelButtonText: "Cancelar",
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, eliminar",
  }).then((result) => {
    if (result.isConfirmed) {
      try {
        // Enviar petición al servidor
        apiEliminarCita(id);
      } catch (error) {
        console.log(error);
      }
    }
  });
}

// Api para eliminar una cita
async function apiEliminarCita(id) {
  try {
    const data = new FormData();
    data.append("id", id);
    const url = `${location.origin}/api/eliminar`;
    const respuesta = await fetch(url, {
      method: "POST",
      body: data,
    });
    const resultado = await respuesta.json();
    if (respuesta) {
      Swal.fire({
        title: "¡Eliminado Correctamente!",
        text: "El registro fue eliminado exitosamente",
        icon: "success",
      }).then(() => {
        window.location.reload();
      });
    }
    console.log(resultado);
  } catch (error) {
    Swal.fire({
      icon: "error",
      title: "Error",
      text: "Ha ocurrido un error al eliminar la Cita",
    });
    console.log(error);
  }
}

function eliminarServicio(id) {
  Swal.fire({
    // Mostrar la alerta de eliminar
    title: "¿Eliminar Servicio?",
    text: "Una vez eliminado, no podrá recuperarse",
    icon: "warning",
    showCancelButton: true,
    cancelButtonText: "Cancelar",
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, eliminar",
  }).then((result) => {
    if (result.isConfirmed) {
      try {
        // Enviar petición al servidor
        apiEliminarServicio(id);
      } catch (error) {
        console.log(error);
      }
    }
  });
}

async function apiEliminarServicio(id) {
  try {
    const data = new FormData();
    data.append("id", id);
    const url = `${location.origin}/api/eliminar-cita`;
    const request = await fetch(url, {
      method: "POST",
      body: data,
    });

    const respuesta = await request.json();

    if (respuesta) {
      Swal.fire({
        icon: "success",
        title: "Servicio Eliminado",
        text: "Servicio eliminado correctamente",
      }).then(() => {
        window.location.reload();
      });
    }
  } catch (error) {
    Swal.fire({
      icon: "error",
      title: "Error",
      text: "Ha ocurrido un error al eliminar el Servicio",
    });
    console.log(error);
  }
}
