<?php
include('db.php');
include('functions.php');
$usuario=$_POST['usuario'];
$contrasenia=$_POST['contrasenia'];
session_start();

$_SESSION['usuario']=$usuario;


$conexion=mysqli_connect("localhost","root","12345","loggin");

$consulta="SELECT*FROM usuarios where usuario='$usuario' and contrasenia='$contrasenia'";
$resultado=mysqli_query($conexion,$consulta);

$filas=mysqli_num_rows($resultado);

if($filas){
  
    header("location:practicantes.php");

}else{
    ?>
    <?php
    include("index.html");

  ?>
  <h1 class="bad">ERROR DE AUTENTIFICACION</h1>
  <?php
}
mysqli_free_result($resultado);
mysqli_close($conexion);
