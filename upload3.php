<?php
session_start();
$connect = mysqli_connect("localhost","josuecasa","josue2804","superaplicacion");

$target_dir = "uploads/".$_SESSION["user"]."/";
$fichero_file = "uploads/".$_SESSION["user"];
$target_file = $target_dir . basename($_FILES["image"]["name"]);
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
$uploadOk = 1;


//Verificar si existe el fichero del usuario
if (file_exists($fichero_file)) {
    
}else{
    mkdir($fichero_file,0700);
}

//Verificar si existe el fichero del usuario
if (file_exists($target_file)) {
   $uploadOk = 0;
   echo json_encode(array('error'=>'Sorry, the gif yet exist'));
   exit;
}

// Verifica el formato de la imagen
if($imageFileType != "gif" && $imageFileType != "GIF") {
    echo json_encode(array('error'=>'Sorry, only GIF files are allowed.')); 
    $uploadOk = 0;
    exit;
}

// Verifica si $uploadOk es 0 por algún error
if ($uploadOk == 0) {
   echo json_encode(array('error'=>'Sorry,file is not upload.')); 
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
         //Guardar en DB los archivos que fueron guardados en el servidor url, usuario
         $sql = "INSERT INTO `tabla_gif`(`gif_url`, `gif_estatus`,`usuario_id` ) VALUES ('".$target_file."','S/N','".$_SESSION["id"]."')";
         echo json_encode(array('error'=>'','src'=>$target_file));
         $insertq = mysqli_query($connect, $sql);
    } else {
         echo json_encode(array('error'=>'Sorry,GIF file is not upload.')); 
    }
}

?>