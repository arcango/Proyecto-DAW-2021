var peticion = null;


function inicializa_xhr() {
    if (window.XMLHttpRequest) {
        return new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        return new ActiveXObject("Microsoft.XMLHTTP");
    }
}

function muestraProvincias() {
    if (peticion.readyState == 4) {
        if (peticion.status == 200) {
            var lista = document.getElementById("provincia");
            var provincias = eval('(' + peticion.responseText + ')');
            var provincias = JSON.parse(peticion.responseText);

            lista.options[0] = new Option("- Provincia -");
            var i = 1;
            for (var codigo in provincias) {
                lista.options[i] = new Option(provincias[codigo], codigo);
                i++;
            }
        }
    }
}

function resultadoProvincia() {
    var select = document.getElementById("provincia");
    var provinciaSeleccionada = select.options[select.selectedIndex].text;
    document.getElementById("resultadoProvincia").value = provinciaSeleccionada;
    console.log(provinciaSeleccionada);
}

window.onload = function() {
    peticion = inicializa_xhr();
    if (peticion) {
        peticion.onreadystatechange = muestraProvincias;
        peticion.open("GET", "./municipiosProvincias/cargaProvinciasJSON.php", true);
        peticion.send(null);
    }

    document.getElementById("provincia").onchange = resultadoProvincia;
}