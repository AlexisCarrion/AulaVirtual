<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
ini_set("magic_quotes_gpc", "0");
ini_set("display_errors", "1");
error_reporting(E_ALL ^ E_NOTICE);
define('__DIR__', pathinfo(__FILE__, PATHINFO_DIRNAME));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Error en la Base datos</title>
	<meta http-equiv="Content-Language" content="English" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="David Herreman (www.free-css-templates.com)" />
	<meta name="description" content="MapleSyrup" />
	<meta name="keywords" content="Syrup,CMS,MapleStory" />	
	<meta name="Robots" content="index,follow" />
	<link rel="stylesheet" type="text/css" href="templates/default/css/style.css" media="screen" />
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="rss/" />
<style type="text/css">
body,td,th {
	color: #FFF;
}
body {
	background-color: #000;
	text-align: center;
	color: #FF0;
}
</style>
</head>
<body>
<div class="content">
	<div id="top">
				
				<h1>Error En La Base de Datos!<br /></h1>
				<h2>Experimentando Problema en la web...</h2>
	</div>
	<!-- end of the Top part -->
</div>
<div id="prec">
<div style="width: 800px; margin: auto;">
  <p><img src="imagenes/error.png" style="float: left; margin-left: 5px; margin-right: 5px;"  /> <span style="color: #FFF">Oops! La pagina web esta experimentando dificultades tecnicas, que hacer?, </span></p>
  <p>Intente hacer nuevamente lo que estaba haciendo </p>
  <p><span style="color: #FFF">si sigue el problema informe al porveedor del sistema web lo que esta acontinuacion:</span><br />
    <br />
  </p>
</div>
<div style="text-align: center;">
<?php
echo $_SESSION['mysql_error'];
?>

</div>
</div>
</body>
</html>