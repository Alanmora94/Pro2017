function ValidarFoto(){


	if ($("#foto").val() == "") {
		return;
	}

	var foto =  $("#foto")[0];
	var pagina= "admin.php";
	var conec = new FormData();
	conec.append("foto", foto.files[0]);
	conec.append("accion", "validarFoto");

	$.ajax({

		type: 'POST',
		url: pagina,
		dataType: 'json',
		cache: false,
		processData: false,
		contentType: false,
		data: conec

	})
	.done(function (resultado){
		if (!resultado.valor) {
			alert(resultado.Mensaje)
		}else{
			$("#divFoto").html(resultado.Html);
		}

	})
	.fail(function (a, b, c){

		alert(a.responseText + "  " + b + "  " + c);
	});

}




function BorrarFoto(){

	var foto = $("#bandera").val();

	if (foto =="") {

		alert("No hay nada para borrar...");
		return;
	}

	var pagina = "admin.php";

	$.ajax({
		type:'POST',
		url: pagina,
		dataType: 'json',
		data:{accion : "BorrarFoto",
			  foto: foto}
	})
	.done(function (resultado){
		if (!resultado.valor) {
			alert(resultado.Mensaje)
		}
	})
	.fail(function (a, b, c){

		alert(a.responseText + "  " + b + "  " + c);
	});

		$("#divFoto").html("");
		$("#bandera").val("");
		$("foto").val("");

}

function GrabarRegistro(){


	var empleado = {};

	empleado.nombre = $("#nombre").val();
	empleado.apellido = $("#apellido").val();
	empleado.fecha = $("#fecha").val();
	empleado.dni = $("#dni").val();
	empleado.legajo = $("#legajo").val();
	empleado.foto = $("#bandera").val();
	empleado.sueldo = $("#sueldo").val();
	empleado.expe = "[";

	
	if (document.getElementById('hombre').checked) {

		empleado.sexo = 'M';

	}
	if (document.getElementById('mujer').checked) {

		empleado.sexo = 'F';

	}

	if (document.getElementById('LPHP').checked) {

		empleado.expe = empleado.expe + 'PHP';

	}
	if (document.getElementById('LAndroid').checked) {

		if (empleado.expe != "[") {

			empleado.expe = empleado.expe + '-';
		}
		empleado.expe = empleado.expe + 'Android';

	}
	if (document.getElementById('Lmysql').checked) {

		if (empleado.expe != "[") {

			empleado.expe = empleado.expe + '-';
		}
		empleado.expe = empleado.expe + 'MySql';

	}

	empleado.expe = empleado.expe + "]";

	var pagina = "admin.php";

		$.ajax({
		type: 'POST',
		url: pagina,
		dataType: 'json',
		data:{accion : "grabar",
			  empleado: empleado}
	})
	.done(function (resultado){
		if (!resultado) {
			alert("Error al grabar el registro...");
		}else{
			alert("registro grabado...");
			LimpiarForm();
			CargarGrilla();
		}
	})
	.fail(function (a, b, c){
		alert(a.responseText + "  " + b + "  " + c);
	});


}


function CargarGrilla(){


var pagina = "admin.php";

	$.ajax({
		type:'POST',
		url: pagina,
		dataType: 'html',
		data:{accion : "CargarGrilla"}
	})
	.done(function (resultado){
		
			$("#divGrilla").html(resultado);
			
	})
	.fail(function (a, b, c){
		alert(a.responseText + "  " + b + "  " + c);
	});


}


function LimpiarForm(){

	$("#nombre").val("");
	 $("#apellido").val("");
	 $("#fecha").val("");
	 $("#dni").val("");
	 $("#legajo").val("");
	$("#bandera").val("");
	 $("#sueldo").val("");
	 $("#divFoto").html("");
	 $("#hombre").prop('checked',false);
	 $("#mujer").prop('checked',false);
	 $("#LPHP").prop('checked',false);
	 $("#LAndroid").prop('checked',false);
	 $("#Lmysql").prop('checked',false);
	 


}

function Accion(aux){

	$("#accionATomar").val(aux);


var pagina = "admin.php";

	$.ajax({
		type:'POST',
		url: pagina,
		dataType: 'html',
		data:{accion : "CargarGrilla",
			  accion2 : true}
	})
	.done(function (resultado){
		console.log(resultado);
			$("#divGrilla").html(resultado);
			//alert(resultado);
	})
	.fail(function (a, b, c){
		alert(a.responseText + "  " + b + "  " + c);
	});

}







function Ejecutar(aux){

var contador = $("#contador").val()
var vector = new Array();

for (var i = 0; i < contador; i++) {
	
	if ($("#check" + (i + 1)).is(":checked")) {

		//alert($("#check" + i).attr("name"));
		vector[i] = $("#check" + (i+1)).attr("name"); 

	}

	

}

if (vector.length < 1) {

	alert("Debe seleccionar un registro...");
	return;
}


if (aux == "eliminar") {

	BorrarRegistro(vector);

}else{

	ModificarRegistro(vector);
}

}




function BorrarRegistro(aux){


var pagina = "admin.php";

		$.ajax({
		type: 'POST',
		url: pagina,
		dataType: 'json',
		data:{accion : "borrar",
			  empleados: aux}
	})
	.done(function (resultado){
		if (!resultado) {
			alert("Error al borrar registro/s...");
		}else{
			alert("registro/s borrado/s...");
			CargarGrilla();
		}
	})
	.fail(function (a, b, c){
		alert(a.responseText + "  " + b + "  " + c);
	});

}



function ModificarRegistro(aux){



if (aux.length > 1) {

	alert("Solo de puede modificar un registro a la vez, seleccione solo uno y vuelva a hacer click en Modificar...");
	return;
};



var pagina = "admin.php";

		$.ajax({
		type: 'POST',
		url: pagina,
		dataType: 'json',
		data:{accion : "modificar",
			  empleado: aux[0]}
	})
	.done(function (resultado){

	console.log(resultado);
	/* $("#nombre").val(resultado.nombre);
	 $("#apellido").val(resultado.apellido);
	 $("#fecha").val("");
	 $("#dni").val("");
	 $("#legajo").val("");
	 $("#bandera").val("");
	 $("#sueldo").val("");
	 $("#divFoto").html("");
	 $("#hombre").prop('checked',false);
	 $("#mujer").prop('checked',false);
	 $("#LPHP").prop('checked',false);
	 $("#LAndroid").prop('checked',false);
	 $("#Lmysql").prop('checked',false);
	CargarGrilla();*/

	})
	.fail(function (a, b, c){
		alert(a.responseText + "  " + b + "  " + c);
	});

}

//*****************************************************************

function Logeo(){

var user = $("#user").val();
var password = $("#password").val();

var pagina = "admin.php";

		$.ajax({
		type: 'POST',
		url: pagina,
		dataType: 'json',
		data:{usuario : user,
			  password: password}
	})
	.done(function (resultado){
		if (!resultado) {
			alert("Error al borrar registro/s...");
		}else{
			alert("registro/s borrado/s...");
			CargarGrilla();
		}
	})
	.fail(function (a, b, c){
		alert(a.responseText + "  " + b + "  " + c);
	});

}
