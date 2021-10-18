<?php 
session_start();
header('Content-Type: text/html; charset=utf-8');
ini_set("magic_quotes_gpc", "0");
ini_set("display_errors", "1");
require($ruta."includes/config.php");
require($ruta."includes/classes/class.db.php");
require($ruta."includes/classes/class.parser.php");
require($ruta."seguridad/anti_sql.php");
$DB = new db_driver($mysql_host, $mysql_user, $mysql_password, $mysql_database);
$DB->development_mode = TRUE;
$Parser = new TemplateParser();

$count = substr_count($_SERVER['REQUEST_URI'], '/');
$count=$count-2;
while ($count>0){
	$count--;
	$preurl.="../";
}
?>