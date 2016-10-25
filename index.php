<?php
session_start();
if(!isset($_SESSION["user"])){
  header("location:login.php");
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>SUPER GIF</title>
    <link rel="stylesheet" href="bootstrap/css/main.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" media="screen" title="no title" charset="utf-8">
    
    <script src="js/jquery-1.12.3.min.js" charset="utf-8"></script>
    <script src="bootstrap/js/bootstrap.min.js" charset="utf-8"></script>
    <script src="js/backstretch.min.js"></script>
    <!-- Add fancyBox main JS and CSS files -->
	<script type="text/javascript" src="js/jquery.fancybox.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="bootstrap/css/jquery.fancybox.css?v=2.1.5" media="screen" />
    <!-- Add Button helper (this is optional) -->
	<link rel="stylesheet" type="text/css" href="helpers/jquery.fancybox-buttons.css?v=1.0.5" />
	<script type="text/javascript" src="helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>

  </head>
  <body id="muro">
    <div id="backmuro" class="container">
        <div id="menu" class="row">
            <div class=" col-xs-6 col-md-6 ">
                <img src="bootstrap/img/logo3.png" class="img-responsive" width="80px" height="60px">
            </div>
            <div class="col-xs-6 col-md-6 text-right">
                <h3><a href="logout.php" class="label label-info">Logout</a></h3>
            </div>
        </div>
        <div id="bodyapp" class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-2">
                        <img src="bootstrap/img/iconuser.png" class="img-responsive" alt="foto perfil" width="80px;">
                    </div>
                    <div class="col-sx-10 col-md-10">
                        <div class="row full">
                            <div class="col-md-12 bblanco">
                                <a id="abrirpanel" class="btn  btn-block">
                                    SUBE TU GIF
                                </a>
                            </div>
                        </div>
                        <div id="subpanel" class="row full">
                            <div class="col-md-6 h30 bgris">
                                     <?php echo '<p>@'.$_SESSION["user"].'</p>';?>
                            </div>
                            <div class="col-md-6 h30 bgris text-right">
                                <h4><a id="cerrar" href="" class="label label-default">Cancelar</a></h4>
                            </div>
                            <div id="espaceupload" class="col-md-12 centrar-texto">
                                <a class="btn btn-block">
                                    <img  src="bootstrap/img/camara.png" class="img-responsive" alt="" width="150px;">
                                </a>
                            </div>
                            <div id="panelgif" class="col-md-12">
                                <a class="btn btn-block">
                                    <img id="imggif" src="" class="img-responsive" alt="">
                                </a>
                            </div>
                            <div class="col-md-12 bgris text-right pad-30">
                                 <a id="guardar" class="btn btn-lg btn-info" type="submit">SUBIR GIF</a>
                            </div>
                        </div>
                        <form id="form-example" action="" method="post" enctype="multipart/form-data" name="form-example">
                            <div class="row">
                                <div class="col-md-6"><input type="file" name="image" id="image" accept="image/*" class="required" required="true"/></div>       
                            </div>
                        </form>
                    </div>
                </div>
                
                <div id="idscroll" class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-10">
                        <div class="row">
                             <?php        
                                $connect = mysqli_connect("localhost","josuecasa","josue2804","superaplicacion");
                                    $sql = "SELECT * FROM tabla_gif WHERE usuario_id='".$_SESSION["id"]."' ORDER BY gif_id DESC";
                                      //echo $sql;
                                $result = mysqli_query($connect, $sql);
                                $num_row = mysqli_num_rows($result);
                                      if ($num_row > 0) {
                                          while($fila = mysqli_fetch_array($result)){
                                              echo  "<div class='col-md-12 h30 bgris'>
                                                        <p>@".$_SESSION["user"]."</p>
                                                     </div> 
                                                     <div class='col-md-12 bblanco'>
                                                        <a class='fancybox' href='".$fila[1]."' data-fancybox-group='gallery' title='Lorem ipsum dolor sit amet'><img id='' src='".$fila[1]."' class='img-responsive gifpanel'></a></div>
                                                      <div class='col-md-12 bblanco pad-abajo'><p>Date: </p><p>Estatus: ".$fila[2]." </p></div>";
                                          }

                                      } else {
                                          echo "No tiene gifs";
                                    }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col_md_4">
                
            </div>
        </div>
    </div>
  </body>
</html>
<script>
var formData = new FormData();

$(document).ready(function(){
    //efecto lightout
    $('.fancybox').fancybox();
    
    
   function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            
            $("#espaceupload").fadeOut("slow",function(){
                     $("#panelgif").fadeIn("slow", function(){
                         $('#imggif').attr('src', e.target.result);
                     });
                   })
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#image:file").change(function(){
    readURL(this);
});
    
//panel
$("#abrirpanel").click(function(){
    $("#subpanel").fadeIn();
});
    
    $("#espaceupload").click(function(){
        $("#image:file").click();
    });
    
    $('#guardar').click(function(){          
        var file = $("#image")[0].files[0];
        if(file!=undefined){
            formData.append('image', file);
        $.ajax({
               url : 'upload3.php',
               type : 'POST',
               data : formData,
               processData: false,   
               contentType: false,   
               dataType: 'json',
               success : function(data) {
                  $(location).attr('href','index.php');
               }
        }); 
        }else{
            alert("Necesitas escoger un gif");
        }
        this.value = '';
    })
});
</script>