$(function () {
	// Habilitar tooltips
	const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
	const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
});

function iniciar_sesion() {
	var curp = $("#sesion_curp").val();
	if (curp == "") {
		Swal.fire(
			'Error',
			'CURP no puede estar vacío',
			'error'
		);
		return;
	}
	var contrasenia = $("#sesion_contrasenia").val();
	if (contrasenia == "") {
		Swal.fire(
			'Error',
			'La contraseña no puede estar vacía',
			'error'
		);
		return;
	}
	if (curp != contrasenia) {
		Swal.fire(
			'Error',
			'El CURP y la contraseña no coinciden',
			'error'
		);
		return;
	}
	$.ajax({
		type: "post",
		url: "functions_class.php",
		data: {
			accion: "iniciar_sesion",
			curp: curp
		},
		dataType: "html",
		success: function (response) {
			console.log(response);
			if (response == "ok") {
				Swal.fire(
					'Iniciando sesion',
					'Bienvenido (a) a la biblioteca Altamirano',
					'success'
				);
				localStorage.setItem("CurpUsuario", curp);
				window.location = "dashboard.php"; //Se cambio a la terminacion .php.
			}
			else {
				Swal.fire(
					'Sesion no iniciada',
					'Usuario no encontrado',
					'warning'
				);
			}
		},
		error: function (xhr) {
			//Error captura el error que haya ocurrido en la transferencia entre main.js o en el archivo php como funtions_class
			console.log(xhr.responseText);
			Swal.fire(
				'Error',
				'Ha ocurrido un error, por favor revise la consola o el inspector de la página para saber más detalles',
				'error'
			);
		}
	});
}

function registrar_usuario() {
	var curp_registro = $("#curp_registro").val();
	var grado_grupo_registro = $("#grado_grupo_registro").val();
	var usuario_registro = $("#usuario_registro").val();

	//#region Validación de campos (si un campo viene vacío, manda un mensaje y no manda los datos a la base de datos)
	if (curp_registro == "") {
		Swal.fire(
			'Registrar usuario',
			'El CURP del usuario no puede venir vacío',
			'error'
		);
		$("#curp_registro").focus();
		return;
	}
	else {
		curp_registro = curp_registro.toUpperCase();
	}

	if (grado_grupo_registro == "") {
		Swal.fire(
			'Registrar usuario',
			'El grado y grupo del usuario no puede venir vacío',
			'error'
		);
		$("#grado_grupo_registro").focus();
		return;
	}

	if (usuario_registro == "") {
		Swal.fire(
			'Regisrar usuario',
			'El nombre del usuario no puede venir vacío',
			'success'
		);
		return;
	}
	//#endregion

	$.ajax({
		type: "POST",
		url: "functions_class.php",
		data: {
			accion: "registrar_usuario",
			curp_registro: curp_registro,
			grado_grupo_registro: grado_grupo_registro,
			usuario_registro: usuario_registro
		},
		dataType: "HTML",
		success: function (response) {
			console.log(response);
			if (response == "OK") {
				// Si response es OK significa que obtuvo una respuesta de functions_class y fue satisfactoria.
				Swal.fire(
					'Registrar usuario',
					'Usuario registrado exitosamente en el sistema',
					'success'
				);
			} else {
				// Si response no es OK significa que no ejecutó la acción correctamente.
				Swal.fire(
					'Registrar usuario',
					'Usuario no registrado, por favor verifique que todos los datos vengan escritos correctamente',
					'error'
				);
			}
		},
		error: function (xhr) {
			console.log(xhr.responseText);
			//Error captura el error que haya ocurrido en la transferencia entre main.js o en el archivo php como funtions_class
			console.log(xhr.responseText);
			Swal.fire(
				'Error',
				'Ha ocurrido un error, por favor revise la consola o el inspector de la página para saber más detalles',
				'error'
			);
		}
	});
}

function registrar_libro() {
	//#region Declaración de variables.
	var titulo_registro = $("#titulo_registro").val();
	var autor_registro = $("#autor_registro").val();
	var categoria_registro = $("#categoria_registro").val();
	var cantidad_registro = $("#cantidad_registro").val();
	var descripcion_registro = $("#descripcion_registro").val();
	//#endregion

	//#region Validación
	if (titulo_registro == "") {
		Swal.fire(
			'Registrar libro',
			'El título del libro no puede venir vacío',
			'warning'
		);
		return;
	}
	if (autor_registro == "") {
		Swal.fire(
			'Registrar libro',
			'El autor del libro no puede venir vacío',
			'warning'
		);
		return;
	}
	if (categoria_registro == "") {
		Swal.fire(
			'Registrar libro',
			'La categoría del libro no puede venir vacía',
			'warning'
		);
		return;
	}
	if (cantidad_registro == "") {
		Swal.fire(
			'Registrar libro',
			'La cantidad del libro no puede venir vacía',
			'warning'
		);
		return;
	}
	//#endregion

	$.ajax({
		type: "POST",
		url: "functions_class.php",
		data: {
			accion: "registrar_libro",
			titulo_registro: titulo_registro,
			autor_registro: autor_registro,
			categoria_registro: categoria_registro,
			cantidad_registro: cantidad_registro,
			descripcion_registro: descripcion_registro
		},
		dataType: "html",
		success: function (response) {
			console.log(response);
			if (response == "OK") {
				Swal.fire(
					'Registrar libro',
					'El libro ha quedado registrado exitosamente',
					'success'
				);
			} else {
				Swal.fire(
					'Registrar libro',
					'El libro no se ha registrado',
					'error'
				);
			}
		},
		error: function (xhr) {
			console.log(xhr.responseText);
			Swal.fire(
				'Error',
				'Ha ocurrido un error',
				'error'
			);
		}
	});
}

function registrar_categoria() {
	var categoria_nuevo = $("#categoria_nuevo").val();
	if (categoria_nuevo == "") {
		Swal.fire(
			'Categoría de libros',
			'El nombre de la categoría viene vacío',
			'warning'
		);
		return;
	}
	$.ajax({
		type: "POST",
		url: "functions_class.php",
		data: {
			accion: "registrar_categoria",
			categoria_nuevo: categoria_nuevo
		},
		dataType: "html",
		success: async function (response) {
			console.log(response);
			if (response == "OK") {
				await Swal.fire(
					'Categoría de libros',
					'Categoría guardada exitosamente',
					'success'
				);
				$('#categoriaModal').modal('hide');
				window.location.reload();
			}
		},
		error: function (xhr) {
			console.log(xhr.responseText);
			Swal.fire(
				'Error',
				'Ha ocurrido un error del sistema',
				'error'
			);
		}
	});
}

function buscar_libro() {
	var libro_buscar = $("#libro_buscar").val();
	$.ajax({
		type: "POST",
		url: "functions_class.php",
		data: {
			accion: "buscar_libro",
			libro_buscar: libro_buscar
		},
		dataType: "html",
		success: async function (response) {
			// console.log(response);
			const Toast = Swal.mixin({
				toast: true,
				position: 'bottom-end',
				showConfirmButton: false,
				timer: 1500,
				timerProgressBar: false,
				didOpen: (toast) => {
					toast.addEventListener('mouseenter', Swal.stopTimer)
					toast.addEventListener('mouseleave', Swal.resumeTimer)
				}
			})
			await Toast.fire({
				icon: 'info',
				title: 'Buscando libros con el autor o título "' + libro_buscar + '"'
			});
			$("#tbody-libros").html(response);
			if (response == "0") {
				await Swal.fire(
				  'Buscar libros',
				  'No se han encontrado coincidencias',
				  'info'
				);
			}
		},
		error: function (xhr) {
			// console.log(xhr.responseText);
			Swal.fire(
				'Error',
				'Ha ocurrido un error en el sistema',
				'error'
			);
		}
	});
}

function prestar_libro() {
	var libro_prestar = $("#libro_prestar").val();
	var curp_usuario = localStorage.getItem("CurpUsuario");
	var fecha_prestamo = $("#fecha_prestamo").val();
	var numero_libro_prestar = $("#numero_libro_prestar").val();

	$.ajax({
		type: "POST",
		url: "functions_class.php",
		data: {
			accion: "prestar_libro",
			libro_prestar: libro_prestar,
			curp_usuario: curp_usuario,
			fecha_prestamo: fecha_prestamo,
			numero_libro_prestar: numero_libro_prestar
		},
		dataType: "html",
		success: async function (response) {
			console.log(response);
			if (response == "Prestado") {
				Swal.fire(
					'Préstamo libros',
					'Este libro ya ha sido prestado, no se puede volver a prestar',
					'info'
				);
				return;
			} else if (response == "OK") {
				await Swal.fire(
					'Préstamo libros',
					'Libro prestado correctamente, devolver pronto',
					'success'
				);
				location.reload();
			} else {
				Swal.fire(
					'Préstamo libros',
					'Este libro no se ha prestado, recargue página',
					'info'
				);
				return;
			}
		},
		error: function (xhr) {
			console.log(xhr.responseText);
			Swal.fire(
				'Error',
				'Ha ocurrido un error en el sistema',
				'error'
			);
		}
	});
}

function numero_libro(id_libro = 0) {
	$.ajax({
		type: "POST",
		url: "functions_class.php",
		data: {
			accion: "numero_libro",
			id_libro: id_libro
		},
		dataType: "html",
		success: function (response) {
			$("#numero_libro_prestar").val(parseInt(response) + 1);
		}
	});
}

function buscar_lector(id_usuario = 0) {
	$.ajax({
		type: "POST",
		url: "functions_class.php",
		data: {
			accion: "buscar_lector",
			id_usuario: id_usuario
		},
		dataType: "html",
		success: function (response) {
			// console.log(response);
			$("#libro_devolver").html(response);
			// Swal.fire(response);
		},
		error: function (xhr) {
			console.log(xhr.responseText);
			Swal.fire(
				'Error',
				'Ha ocurrido un error en el sistema',
				'error'
			);
			return;
		}
	});
}

function buscar_prestamo(id_prestamo = 0) {
	$.ajax({
		type: "POST",
		url: "functions_class.php",
		data: {
			accion: "buscar_prestamo",
			id_prestamo: id_prestamo
		},
		dataType: "html",
		success: function (response) {
			console.log(response);
			$("#fecha_devolucion_prestado").val(response);
		},
		error: function (xhr) {
			console.log(xhr.responseText);
			Swal.fire(
				'Error',
				'Ha ocurrido un error en el sistema',
				'error'
			);
		}
	});
}

function devolver_libro() {
	var usuario_devolver = $("#usuario_devolver").val();
	var libro_devolver = $("#libro_devolver").val();
	var fecha_devolucion = $("#fecha_devolucion").val();

	if (libro_devolver == "") {
		Swal.fire(
			'Devolución de libro',
			'No ha seleccionado el libro prestado a devolver',
			'warning'
		);
		return;
	}
	if (fecha_devolucion == "") {
		Swal.fire(
			'Devolución de libro',
			'Elija la fecha para devolver el libro',
			'warning'
		);
		return;
	}

	$.ajax({
		type: "POST",
		url: "functions_class.php",
		data: {
			accion: "devolver_libro",
			usuario_devolver: usuario_devolver,
			libro_devolver: libro_devolver,
			fecha_devolucion: fecha_devolucion
		},
		dataType: "html",
		success: async function (response) {
			console.log(response);
			if (response == "OK") {
				await Swal.fire(
					'Devolución de libro',
					'El registro de la devolución del libro se ha realizado correctamente, revisar el inventario',
					'success'
				);
				location.reload();
			} else {
				Swal.fire(
					'Devolución de libro',
					'El libro no ha sido devuelto, recargue la página y reintente',
					'warning'
				);
			}
		},
		error: function (xhr) {
			console.log(xhr.responseText);
			Swal.fire(
				'Error',
				'Ha ocurrido un error en el sistema',
				'error'
			);
		}
	});
}

function consultar_historial() {
	var desde = $("#desde").val();
	var hasta = $("#hasta").val();

	if (desde == "") {
		Swal.fire(
			'Historial',
			'¿Desde cuándo quiere consultar el historial?',
			'question'
		);
		return;
	}

	if (hasta == "") {
		Swal.fire(
			'Historial',
			'¿Hasta cuándo quiere consultar el historial?',
			'question'
		);
		return;
	}

	$.ajax({
		type: "POST",
		url: "functions_class.php",
		data: {
			accion: "consultar_historial",
			desde: desde,
			hasta: hasta
		},
		dataType: "html",
		success: function (response) {
			$("#tbody-historial").html(response);
		},
		error: function (xhr) {
			console.log(xhr.responseText);
		}
	});
}

function ver_contrasenia() {
	var contrasenia = $("#sesion_contrasenia").attr("type");
	if (contrasenia == "password") {
		$("#sesion_contrasenia").attr("type", "text");
		$("#ver_contrasenia_icon").removeClass("bi-eye-slash");
		$("#ver_contrasenia_icon").addClass("bi-eye");

	} else {
		$("#sesion_contrasenia").attr("type", "password");
		$("#ver_contrasenia_icon").removeClass("bi-eye");
		$("#ver_contrasenia_icon").addClass("bi-eye-slash");
	}
}