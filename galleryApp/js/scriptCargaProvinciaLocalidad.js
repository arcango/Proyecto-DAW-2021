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

            lista.options[0] = new Option("- selecciona -");
            var i = 1;
            for (var codigo in provincias) {
                lista.options[i] = new Option(provincias[codigo], codigo);
                i++;
            }
        }
    }
}

function cargaMunicipios() {
    var lista = document.getElementById("provincia");
    var provincia = lista.options[lista.selectedIndex].value;
    console.log(lista.options[lista.selectedIndex]);
    if (!isNaN(provincia)) {
        peticion = inicializa_xhr();
        if (peticion) {
            peticion.onreadystatechange = muestraMunicipios;
            peticion.open("POST", "./municipiosProvincias/cargaMunicipiosJSON.php", true);
            peticion.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            peticion.send("provincia=" + provincia);
        }
    }
}

function muestraMunicipios() {
    if (peticion.readyState == 4) {
        if (peticion.status == 200) {
            var lista = document.getElementById("municipio");
            var municipios = JSON.parse(peticion.responseText);
            var municipios = eval('(' + peticion.responseText + ')');

            lista.options.length = 0;
            var i = 0;
            for (var codigo in municipios) {
                lista.options[i] = new Option(municipios[codigo], municipios[codigo]);
                i++;
            }
        }
        resultadoProvincia();
        resultadoLocalidad();
    }
}

function resultadoProvincia() {
    var select = document.getElementById("provincia");
    var provinciaSeleccionada = select.options[select.selectedIndex].text;
    document.getElementById("resultadoProvincia").value = provinciaSeleccionada;
    console.log(provinciaSeleccionada);
}

function resultadoLocalidad() {
    var select = document.getElementById("municipio");
    var municipioSeleccionado = select.options[select.selectedIndex].text;
    document.getElementById("resultadoLocalidad").value = municipioSeleccionado;
    console.log(municipioSeleccionado);
}

window.onload = function() {
    peticion = inicializa_xhr();
    if (peticion) {
        peticion.onreadystatechange = muestraProvincias;
        peticion.open("GET", "./municipiosProvincias/cargaProvinciasJSON.php", true);
        peticion.send(null);
    }

    document.getElementById("provincia").onchange = cargaMunicipios;
    document.getElementById("municipio").onchange = resultadoLocalidad;
}