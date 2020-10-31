
function doAjaxGet(callback) {

  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {

      var res = JSON.parse(this.responseText);

      if (res.status == "success") {
        callback(res);
      } else {
        if (res.error)
          printError("Action failed: " + res.error);
        else
          printError("Action failed because of an unknown reason");
      }

    } else if (this.readyState == 4) {
        printError("XMLHttpRequest failed");
    }

    
  };
  xhttp.open("GET", "./api/readAll.php", true);
  xhttp.send();
}

function printJugadores(json) {
  //console.log(json); // DEBUG
  var table = document.querySelector("tbody");
  table.innerHTML = "";
  json.jugadores.forEach(function(jugador) {
    printJugador(jugador, table);
  });

}

function printJugador(jugador, table) {
  //console.log(jugador); // DEBUG
  var trow = document.createElement("tr");
  trow.innerHTML = `
  <tr>
   <td>${jugador.id}</td>
   <td>${jugador.nombre}</td>
   <td>${jugador.descripcion}</td>
   <td>${jugador.caracteristica}</td>
   <td>${jugador.edad}</td>
  </tr>
  `;
  table.appendChild(trow);
  trow.addEventListener('click',function(e){ 
    //onlick copy row to form
    document.getElementById('idInput').value = jugador.id;
    document.getElementById('nombreInput').value = jugador.nombre;
    document.getElementById('caracteristicaInput').value = jugador.caracteristica;
    document.getElementById('descripcionInput').value = jugador.descripcion;
    document.getElementById('edadInput').value = jugador.edad;
 });
}

function printError(msg) {
  var alert = document.getElementById('alert');
  alert.innerText = msg;
  alert.style.display = "block";
  if (msg === "")alert.style.display = "none";
}

function submitAction() 
{
  var action = document.querySelector('input[name="actionradio"]:checked').value;
  switch (action) {
    case "C":
      doAjaxPost("./api/insert.php", function(res) 
      {
        doAjaxGet(printJugadores);
      });
      break;
    case "R":
      doAjaxPost("./api/search.php", printJugadores);
      break;

    case "U":
      doAjaxPost("./api/update.php", function(res) 
      {
        doAjaxGet(printJugadores);
      });
      break;
    case "D":
      doAjaxPost("./api/delete.php", function(res) 
      {
        doAjaxGet(printJugadores);
      });
      break;
  
    default:
      break;
  }
}

function doAjaxPost(url, callback) {
  
  var id = document.getElementById("idInput").value;
  var nombre = document.getElementById("nombreInput").value;
  var car = document.getElementById("caracteristicaInput").value;
  var des = document.getElementById("descripcionInput").value;
  var edad = document.getElementById("edadInput").value;

  var urlEncodedDataPairs = [];

  if (id !== "") 
    urlEncodedDataPairs.push( encodeURIComponent( "id" ) + '=' + encodeURIComponent( id ) );
  if (nombre !== "") 
    urlEncodedDataPairs.push( encodeURIComponent( "nombre" ) + '=' + encodeURIComponent( nombre ) );
  if (car !== "") 
    urlEncodedDataPairs.push( encodeURIComponent( "caracteristica" ) + '=' + encodeURIComponent( car ) );
  if (des !== "") 
    urlEncodedDataPairs.push( encodeURIComponent( "descripcion" ) + '=' + encodeURIComponent( des ) );
  if (edad !== "") 
    urlEncodedDataPairs.push( encodeURIComponent( "edad" ) + '=' + encodeURIComponent( edad ) );

  var dataForm =  urlEncodedDataPairs.join( '&' ).replace( /%20/g, '+' );

  //console.log (dataForm); // DEBUG

  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      // console.log (this.responseText); // DEBUG
      var res = JSON.parse(this.responseText);

      if (res.status == "success") {
        printError("");
        callback(res);
      } else {
        if (res.message)
          printError("Action failed: " + res.message);
        else
          printError("Action failed because of an unknown reason");
      }

    } else if (this.readyState == 4) {
        printError("XMLHttpRequest failed");
    }
  };

  xhttp.open("POST", url, true);
  xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhttp.send(dataForm);
}

// on load execute
doAjaxGet(printJugadores);


// form enable or disable fields on action change
$(function() {
  var id = document.getElementById("idInput");
  var nombre = document.getElementById("nombreInput");
  var car = document.getElementById("caracteristicaInput");
  var des = document.getElementById("descripcionInput");
  var edad = document.getElementById("edadInput");
  $('input:radio[name="actionradio"]').change(function() {
      id.required = false;
      nombre.required = false;
      car.required = false;
      des.required = false;
      edad.required = false;
      id.disabled = false;
      nombre.disabled = false; 
      car.disabled = false; 
      des.disabled = false; 
      edad.disabled = false;

      switch ($(this).val()) {
        case "C":
          id.disabled = true;
          nombre.required = true;
          car.required = true;
          des.required = true;
          edad.required = true;
          break;
        case "R":
          // none required or disabled
          break;
        case "U":
          id.required = true;
          break;
        case "D":
          id.required = true;
          nombre.disabled = true;
          car.disabled = true;
          des.disabled = true;
          edad.disabled = true;
          break;
      }
  })
});