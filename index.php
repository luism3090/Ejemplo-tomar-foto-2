<html>
	<head>
		<!-- <meta http-equiv="Conetnt-type content=text/html charset=utf8"/>-->
		<meta charset="UTF-8">
		<title>Cámara</title>

		<!-- <link rel="stylesheet" href="stilo.css"/> -->
		<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>-->
	 <script src="jquery1.11.3.min.js"></script>
 <style type="text/css">
        .contenedor{ width: 350px; float: left;}
        .titulo{ font-size: 12pt; font-weight: bold;}
        #camara, #foto{
            width: 320px;
            min-height: 240px;
            border: 1px solid #008000;
        }
    </style>
		<!-- <script src="js/jquery-3.1.0.min.js"></script>-->
	</head>

	<body  style="background-image:url(2.jpg)"  >
	
	<form action="subir.php" enctype="multipart/form-data" method="post" >

		<input type = "hidden" name="operaciones" id="operaciones" value="" />
		<input type ="hidden" name="uu" id="uu" value="" />


		<div id = "botonera">

		<input id="botonIniciar" type="button" value="Iniciar"></input>
		<input id="botonDetener" type="button" value="Detener"></input>
		<input id="botonCapturar" type="button" value="Capturar"></input>
		 <input id="botonGuardar" type="button" value="Guardar"></input>
		<input id="botonDescargar" type="button" value="Descargar"></input>
		</div>



		<div class= "contenedor">
			<div class="titulo"> Cámara </div>

			<!--
			cuando diga que se llame es por que va hacer con id
			div con estilo 350px width y floatleft
			dentro de ese div otro div que se llamará camara cerramos div y adelantito camara
			cerramos div y abajo creamos etiqueta video vedeo como nombre camara espacio auto play control
			debe funcionar los tres primeros menos guardar
			-->

			<video id= "camara" autoplay controls style="background-image:url(cmr.png)"> </video>
		</div>

		<div class= "contenedor" ><!-- con style , control de video-->

			<div class="titulo">Foto</div>
			<canvas id="foto" style="background-image:url(cmr.png)"></canvas>
		</div>


	<input type="hidden"  id="imagenaAsubir" name="imagen">


	<!-- <p><input type="file" name="imagen2" id="file"  /></p>-->
	<!--<p><input id="btnSubir" type="submit" value="Subir"></input></p>-->

	

 </form>

		<script>

			window.URL = window.URL || window.webkitURL;
			navigator.getUserMedia= navigator.getUserMedia || navigator.webkitGetUSerMedia || navigator.mozGetUSerMedia;

			navigator.getUserMedia= navigator.getUserMedia || navigator.webkitGetUSerMedia || navigator.mozGetUSerMedia;
			/*fuction()
			{
				alert('Su navegador no soporta la cámara');

			} ;
			*/
			

			window.datosVideo = {
				'StreamVideo':null,
				'url':null
			}

			$('#botonIniciar').on('click',function(e){
			// pedimos al navegador que nos de acceso algun dispositivo de video (la webcam)
				navigator.getUserMedia({
					'audio':false,
					'video':true

				}, function (streamVideo){
					
					datosVideo.StreamVideo = streamVideo;
					datosVideo.url = window.URL.createObjectURL(streamVideo);
					$('#camara').attr('src', datosVideo.url);

				}, function() {
					alert('No fue posible obtener el acceso a la cámara');
				
				});

			});

			$('#botonDetener').on('click', function(e) {
				//debugger;
				if (datosVideo.StreamVideo) {
					datosVideo.StreamVideo.stop();
					window.URL.revokeObjectURL(datosVideo.url);
				}
				

				//$("#camara").trigger("click");
			});

			$('#botonCapturar').on('click', function(e){
				
				var oCamara, oFoto, oContexto, w, h;
				
				oCamara=jQuery('#camara');
				oFoto= jQuery('#foto');
				w = oCamara.width();
				h = oCamara.height();
				oFoto.attr({
					'width':w,
					'height':h
				});

				oContexto = oFoto[0].getContext('2d');
				oContexto.drawImage(oCamara[0], 0, 0, w, h);
				});

/*
			$('#botonGuardar').on('click',function(e){
				debugger;
				var canvas=document.getElementById("foto");
				var dataURL = canvas.toDataURL();
				document.getElementById("imagen").value = dataURL;
				document.getElementById("opciones").value= "guardar";
				document.form.submit();

			});
*/
//para que funcione el boton guardar js con php la accion de guardar 
$('#botonGuardar').on('click',function(e){
				//alert ('hola');
				

				var canvas=document.getElementById("foto");
				var dataURL = canvas.toDataURL();
				document.getElementById("imagenaAsubir").value = dataURL;// uu campo oculto que se ocurra guardamos la url o codificacion de foto//hidden input 
				document.getElementById("operaciones").value= "Guardar"; // operaciones campo oculto que se delimita si va hacer cambio busqueda alta eliminar
				//document.form.submit(); 
				//en la carpeta fotos y se vaya recargando 

				//$("form").prepend("<a href="+dataURL+" download  id='descargarImagen' style='display:none'>image</a>");

			/*
				var letra = "C:\\";
				var ruta = "fakepath\\";
				var nombre_imagen = dataURL;

				var datos = letra+ruta+nombre_imagen;

				*/


				if($("#foto")[0].toDataURL().length>1594)
				{

					$.ajax({
					    type: "POST",
					    url: "subir2.php",
					    data: {img: dataURL},
					    contentType: "application/x-www-form-urlencoded;charset=UTF-8",
					    success: function(result)
					    {
					    	
					        alert(result);
					    }

					});

				}
				else
				{
					alert("Primero debe tomar una captura");
				}

});

$('#botonDescargar').on('click',function(e){
				//alert ('hola');
				

				if($("#foto")[0].toDataURL().length>1594)
				{
					var canvas=document.getElementById("foto");
					var dataURL = canvas.toDataURL("image/png");

					$("form").prepend("<a href="+dataURL+" download='mi_imagen'  id='descargarImagen' style='display:none'>image</a>"+"<img src="+dataURL+" style='display:none'>");

					$("#descargarImagen").first().click();
				}
				else
				{
					alert("Primero debe tomar una captura");
				}
				

				//$("#imagen2").val(dataURL);



			
});




$("body").on("click","#descargarImagen",function(e) 
{ 

		this.click();
});





$("body").on("click","#botonDescargar",function(e) 
{ 

					var canvas=document.getElementById("foto");
					var dataURL = canvas.toDataURL("image/png");

});





</script>



		</body>
</html>