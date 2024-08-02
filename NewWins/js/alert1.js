const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
});

// Función para mostrar alerta de éxito
function mostrarAlertaExito(message) {
    Toast.fire({
        icon: 'success',
        title: message
    });
}

// Función para mostrar alerta de error
function mostrarAlertaError(message) {
    Toast.fire({
        icon: 'error',
        title: message
    });
}
