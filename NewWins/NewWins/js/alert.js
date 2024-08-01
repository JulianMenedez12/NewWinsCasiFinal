// alert.js

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

// Función para mostrar alerta de éxito al eliminar noticia
function mostrarAlertaExitoEliminarNoticia(message) {
    Toast.fire({
        icon: 'success',
        title: message
    });
}

// Función para mostrar alerta de error al eliminar noticia
function mostrarAlertaErrorEliminarNoticia(message) {
    Toast.fire({
        icon: 'error',
        title: message
    });
}

// Función para mostrar alerta de éxito
function mostrarAlertaExito(mensaje) {
    Swal.fire({
        icon: 'success',
        title: 'Éxito',
        text: mensaje
    });
}

// Función para mostrar alerta de error
function mostrarAlertaError(mensaje) {
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: mensaje
    });
}

// Función para previsualizar imagen seleccionada
function previewImage(input) {
    var preview = document.getElementById('preview');
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Función para cancelar selección de archivo
function cancelUpload() {
    var input = document.getElementById('foto_perfil');
    input.value = null; // Clear the file input
    var preview = document.getElementById('preview');
    preview.src = 'http://bootdey.com/img/Content/avatar/avatar1.png'; // Reset preview image
}
