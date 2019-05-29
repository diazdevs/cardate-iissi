function validateForm() {
    var noValidation = document.getElementById("#formulario").noValidation;
    var error1 = validarDNI();
    var error2 = validarEmail();
    var error3 = validarTelefono();
    var error4 = validarContra();
    var error5 = validarContrasIguales();
    
    if (!noValidation) {
        return (error1.length == 0) && (error2.length == 0) && (error3.length == 0) && (error4.length == 0) && (error5.length == 0);
    }
    return true;
}


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