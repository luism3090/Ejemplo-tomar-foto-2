<?php


saveImage($_POST['img']);



function saveImage($base64img)
{
    
    $base64img = str_replace('data:image/png;base64,', '', $base64img);
    $base64img  = str_replace(' ', '+', $base64img);

    $data = base64_decode($base64img);

    $file = 'fotos/' . uniqid() . '.png';

    


    $resultado = file_put_contents($file, $data);

     if($resultado)
     {
     	echo "archivo guardado correctamente";
     }
     else
     {
     	echo "error al subir el archivo";
     }
  

}




?>