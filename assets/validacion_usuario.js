function validateForm() {

    var campo_nombre = document.getElementById("nombre");
    var campo_apellidos = document.getElementById("apellidos");
    var campo_nif = document.getElementById("dni");
    var campo_e = document.getElementById("email");
    var campo_tlf = document.getElementById("telefono");
    var password = document.getElementById("contra1");
    var passconfirm = document.getElementById("contra2");

    var expreg_dni = /[0-9]{8}[A-Z]/;
    var expreg_tlf = /^([0-9])+$/;
    var expreg_email = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    var hasNumber = /\d/;
    var hasUpperCases = /[A-Z]/;
    var hasLowerCases = /[a-z]/;
    var exprTildes = /^[A-Za-záéíóúÁÉÍÓÚ\s]+$/;

    var numeroDNI = dni.value.substr(0, 8);
    var letra = dni.value.substr(-1);

    var valid = true;

    if ($('nombre').val().trim() == "") {
        campo_nombre.setCustomValidity("Introduzca su nombre.");
        $('#nombre').css("background-color", "#ffeeee");
        valid = false;
    } else if (!exprTildes.test($('#nombre').val().trim())) {
        campo_nombre.setCustomValidity("Introduzca un nombre válido.");
        $('#nombre').css("background-color", "#ffeeee");
        valid = false;
    } else {
        campo_nombre.setCustomValidity("");
        $('#nombre').css("background-color", "white");
    }

    if ($('#apellidos').val().trim() == '') {
        campo_apellidos.setCustomValidity('Introduzca sus apellidos.');
        $('#apellidos').css("background-color", "#ffeeee");
        valid = false;
    } else if (!exprTildes.test($('#apellidos').val().trim())) {
        campo_apellidos.setCustomValidity('Introduzca unos apellidos válidos.');
        $('#apellidos').css("background-color", "#ffeeee");
        valid = false;
    } else {
        campo_apellidos.setCustomValidity("");
        $('#apellidos').css("background-color", "white");
    }

    if ($('#telefono').val().trim() == '') {
        campo_tlf.setCustomValidity('Introduzca su número de teléfono.');
        $('#telefono').css("background-color", "#ffeeee");
        valid = false;
    } else if (!expreg_tlf.test($('#telefono').val().trim())) {
        campo_tlf.setCustomValidity('Un número de teléfono solo puede contener números.');
        $('#telefono').css("background-color", "#ffeeee");
        valid = false;
    } else if ($('#telefono').val().trim().length < 9) {
        campo_tlf.setCustomValidity('Introduzca un número de teléfono correcto');
        $('#telefono').css("background-color", "#ffeeee");
        valid = false;
    } else {
        campo_tlf.setCustomValidity("");
        $('#telefono').css("background-color", "white");
    }

    if ($('#dni').val() == '') {
        campo_nif.setCustomValidity('Introduzca su DNI');
        $('#dni').css("background-color", "#ffeeee");
        valid = false;
    } else if (!($('#dni').val().trim().length == 9) || (!expreg_dni.test($('#dni').val().trim()))) {
        campo_nif.setCustomValidity('Introduzca un DNI válido');
        $('#dni').css("background-color", "#ffeeee");
        valid = false;
    } else if (letra != letraDNI(numeroDNI)) {
        campo_nif.setCustomValidity('El DNI debe contener la letra adecuada');
        $('#dni').css("background-color", "#ffeeee");
        valid = false;
    } else {
        campo_nif.setCustomValidity("");
        $('#dni').css("background-color", "white");
    }

    if ($('#email').val().trim() == '') {
        campo_e.setCustomValidity('Introduzca su email.');
        $('#email').css("background-color", "#ffeeee");
        valid = false;
    } else if (!expreg_email.test($('#email').val().trim())) {
        campo_e.setCustomValidity('Introduzca un email correcto.');
        $('#email').css("background-color", "#ffeeee");
        valid = false;
    } else {
        campo_e.setCustomValidity("");
        $('#email').css("background-color", "white");
    }

    if ($('#contra1').val == '') {
        password.setCustomValidity('Introduzca una contraseña.');
        $('#contra1').css("background-color", "#ffeeee");
        valid = false;
    } else if ($('#contra1').val().trim().length < 8) {
        password.setCustomValidity('La contraseña tiene que tener 8 caracteres o más.');
        $('#contra1').css("background-color", "#ffeeee");
        valid = false;
    } else if (!hasNumber.test($('#contra1').val().trim())) {
        password.setCustomValidity('La contraseña tiene que tener mínimo un número.');
        $('#contra1').css("background-color", "#ffeeee");
        valid = false;
    } else if (!hasUpperCases.test($('#contra1').val().trim())) {
        password.setCustomValidity('La contraseña tiene que tener mínimo una letra mayúscula.');
        $('#contra1').css("background-color", "#ffeeee");
        valid = false;
    } else if (!hasLowerCases.test($('#contra1').val().trim())) {
        password.setCustomValidity('La contraseña tiene que tener mínimo una letra minúscula.');
        $('#contra1').css("background-color", "#ffeeee");
        valid = false;
    } else {
        password.setCustomValidity("");
        $('#contra1').css("background-color", "white");
    }

    if ($('#contra2').val == '') {
        password.setCustomValidity('Vuelva a introducir la contraseña.');
        $('#contra2').css("background-color", "#ffeeee");
        valid = false;
    } else if ($('#contra2').val != $('#contra1').val) {
        passconfirm.setCustomValidity('Las contraseñas no coinciden.');
        $('#contra2').css("background-color", "#ffeeee");
        valid = false;
    } else {
        passconfirm.setCustomValidity("");
        $('#contra2').css("background-color", "white");
    }

    return valid;
}

/*
function validarDNI() {
    var valid = true;
    var campo_nif = document.getElementById('dni');

    var valor_nif = campo_nif.value;

    valid = valid && valor_nif.length == 9;

    var expreg_mayus = /[A-Z]/;
    var expreg_num = /^[0-9]/;

    valid = valid && expreg_mayus.test(valor_nif) &&
        expreg_num.test(valor_nif);
    var error;

    if (!valid) {
        error = "El NIF debe tener 8 números seguidos de 1 letra mayúscula";
    } else {
        error = "";
    }

    campo_nif.setCustomValidity(error);
    return error;
}


function validarEmail() {
    var valid = true;

    var campo_e = document.getElementById('email');
    var valor_e = campo_e.value;

    var expreg_email = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/;

    valid = valid && expreg_email.test(valor_e);

    var error;

    if (!valid) {
        error = "El email debe tener un formato correcto";
    } else {
        error = "";
    }
    campo_e.setCustomValidity(error);
    return error;
}

function validarTelefono() {
    var valid = true;
    var campo_tlf = document.getElementById('telefono');
    var valor_tlf = campo_tlf.value;

    var expreg_tlf = /^[9|6|7][0-9]{8}$/;

    valid = valid && expreg_tlf.test(valor_tlf);

    var error;

    if (!valid) {
        error = "El teléfono debe tener 9 dígitos y empezar por 9, 6 o 7";
    } else {
        error = "";
    }
    campo_tlf.setCustomValidity(error);
    return error;
}

function validarContra() {
    var password = document.getElementById("contra1");
    var pwd = password.value;
    var valid = true;

    valid = valid && (pwd.length >= 8);

    var hasNumber = /\d/;
    var hasUpperCases = /[A-Z]/;
    var hasLowerCases = /[a-z]/;
    valid = valid && (hasNumber.test(pwd)) && (hasUpperCases.test(pwd)) && (hasLowerCases.test(pwd));

    if (!valid) {
        var error = "Contraseña incorrecta. La longitud tiene que ser >=8, tener mayúsculas y minúsculas, letras y dígitos.";
    } else {
        var error = "";
    }
    password.setCustomValidity(error);
    return error;
}

function validarContrasIguales() {
    var password = document.getElementById("contra1");
    var pwd = password.value;

    var passconfirm = document.getElementById("contra2");
    var confirmation = passconfirm.value;

    if (pwd != confirmation) {
        var error = "Las contraseñas tienen que ser iguales";
    } else {
        var error = "";
    }

    passconfirm.setCustomValidity(error);

    return error;
}
*/
//Funcion para calcular la letra del DNI
function letraDNI(numeroDNI) {
    if (numeroDNI.length == 8) {
        var numero = parseInt(numeroDNI) % 23;
        var letra = "";
        switch (numero) {
            case 0:
                letra = "T";
                break;
            case 1:
                letra = "R";
                break;
            case 2:
                letra = "W";
                break;
            case 3:
                letra = "A";
                break;
            case 4:
                letra = "G";
                break;
            case 5:
                letra = "M";
                break;
            case 6:
                letra = "Y";
                break;
            case 7:
                letra = "F";
                break;
            case 8:
                letra = "P";
                break;
            case 9:
                letra = "D";
                break;
            case 10:
                letra = "X";
                break;
            case 11:
                letra = "B";
                break;
            case 12:
                letra = "N";
                break;
            case 13:
                letra = "J";
                break;
            case 14:
                letra = "Z";
                break;
            case 15:
                letra = "S";
                break;
            case 16:
                letra = "Q";
                break;
            case 17:
                letra = "V";
                break;
            case 18:
                letra = "H";
                break;
            case 19:
                letra = "L";
                break;
            case 20:
                letra = "C";
                break;
            case 21:
                letra = "K";
                break;
            case 22:
                letra = "E";
                break;
        }
        return letra;
    } else {
        return "";
    }



}

/* Funcion para calcular la fortaleza de la contraseña*/

function seguridad_clave(clave) {

    var seguridad = 0;
    if (clave.length != 0) {
        if (/[0-9]/.test(clave) && /[a-zA-Z]/.test(clave)) {
            seguridad += 30;
        }
        if (/[a-z]/.test(clave) && /[A_Z]/.test(clave)) {
            seguridad += 30;
        }
        if (clave.length >= 4 && clave.length <= 5) {
            seguridad += 10;
        } else {
            if (clave.length >= 6 && clave.length <= 8) {
                seguridad += 30;
            } else {
                if (clave.length > 8) {
                    seguridad += 40;
                }
            }
        }
    }
    return seguridad
}

/*Funcion para darle color al imput según su fortaleza*/
function colorContra() {
    $("#contra1").on("keyup", function () {

        var clave = $("#contra1").val();
        if (seguridad_clave(clave) < 10) {
            $("#contra1").css("background-color", "red");
        } else if (seguridad_clave(clave) >= 10 && seguridad_clave(clave) < 30) {
            $("#contra1").css("background-color", "#ffaf7f");
        } else if (seguridad_clave(clave) >= 30 && seguridad_clave(clave) < 40) {
            $("#contra1").css("background-color", "#ffc976");
        } else if (seguridad_clave(clave) >= 40 && seguridad_clave(clave) < 60) {
            $("#contra1").css("background-color", "#fffd88");
        } else if (seguridad_clave(clave) >= 60 && seguridad_clave(clave) <= 70) {
            $("#contra1").css("background-color", "#eff580");
        } else if (seguridad_clave(clave) > 70 && seguridad_clave(clave) <= 90)
            $("#contra1").css("background-color", "#cde762");
        else if (seguridad_clave(clave) > 90) {
            $("#contra1").css("background-color", "#8bff65");
        }

    })
}