<?php 

require("includes/conexion.php");

if($page == "home") {
	       require("public/home.php");
}else if($page == "registro") {
	       require("public/formulario.php");
}

if(empty($_GET['page'])) {
	$page = "home";
} else {
	$page = $_GET['page'];
}

$Parser->loadfile("template/index.html");

$Parser->assignvars(array(), array());

$Parser->assignblock(array('[ContenidoPrincipal]'), array($content));
echo($Parser->output());


?>