<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
ini_set("magic_quotes_gpc", "0");
ini_set("display_errors", "1");
error_reporting(E_ALL ^ E_NOTICE);
define('__DIR__', pathinfo(__FILE__, PATHINFO_DIRNAME));
define('__BASEDIR__', substr(pathinfo(__FILE__, PATHINFO_DIRNAME), 0 , -6));
require("../includes/classes/class.parser.php");
$Parser = new TemplateParser();
if(file_exists(__DIR__."/setup.lock")){
	header("Location: ../index.php");
}

if(isset($_POST['install'])){
	
	if(!@mysqli_connect("".$_POST['dbhost']."", "".$_POST['dbuser']."", "".$_POST['dbpass']."", "".$_POST['dbname']."")){
		$error = "<tr><td class=\"red\">Error! Could not connect to the database!</td></tr>";
	}
	if(empty($error)){
	
		require(__BASEDIR__."/includes/classes/class.db.php");
		$DB = new db_driver($_POST['dbhost'], $_POST['dbuser'], $_POST['dbpass'], $_POST['dbname']);
		$DB->table_prefix = "syrup";
		$DB->development_mode = TRUE;
		
			//write the config file
		$file = fopen(__BASEDIR__."/includes/config.php", "w");
		$string = '<?php 
$mysql_host = "'.$_POST['dbhost'].'"; //Mysql host...
$mysql_user = "'.$_POST['dbuser'].'"; //Mysql user...
$mysql_password = "'.$_POST['dbpass'].'"; //Mysql password
$mysql_database = "'.$_POST['dbname'].'"; //Mysql database...
$mysql_tableprefix = "syrup"; //Table prefix...

?>';
		fwrite($file, $string);
		fclose($file);
		
			//write the config email
		$file = fopen(__BASEDIR__."/includes/configemail.php", "w");
		$string = '<?php 
$EmailHost="'.$_POST['emailhost'].'";
$EmailUsername="'.$_POST['emailuser'].'";
$EmailPassword="'.$_POST['emailpass'].'";
$EmailOwner="'.$_POST['emailowner'].'";
?>';

		fwrite($file, $string);
		fclose($file);
		
		
		
		
		
				if($_POST['radio']=='full'){
		//create the database tables
	/*		$SQLDefecto='
		DROP TABLE IF EXISTS web_sistema;
		';
	
		$DB->query($SQLDefecto, 0);
		
		$SQLDefecto='
		CREATE TABLE  web_sistema (
		  `NombreSistema` varchar(45) DEFAULT NULL,
		  `Version` varchar(45) DEFAULT NULL,
		  `Proveedor` varchar(100) DEFAULT NULL,
		  `Template` varchar(45) DEFAULT NULL
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;
		
		';*/
				}
		
		
		
		
		$DB->query($SQLDefecto, 0);
		$file = fopen(__DIR__."/setup.lock", "w");
		fclose($file);
		$succes = 1;
	}
}
if($succes == 1){
	$content = "Felicitaciones! La instalacion del Servidor ha sido Todo un Exito ! Click <a href=\"../index.php\">here</a> ir a la Pagina Principal. A continuacion, inicie sesion con su cuenta y vaya a Configuracion en el menu para configurar MasterMS.";
} else {
	require("../includes/config.php");
	if(empty($mysql_host)){
	$mysql_host="localhost";
	}
	if(empty($mysql_user)){
	$mysql_user="root";
	}
	require("../includes/configemail.php");
	if(empty($EmailHost)){
	$EmailHost="mail.dominio.com";
	}
	if(empty($EmailUsername)){
	$EmailUsername="user@dominio.com";
	}
	if(empty($EmailPassword)){
	$EmailPassword="231991kevin";
	}
	if(empty($EmailOwner)){
	$EmailOwner="tuemail@mail.com";
	}
	$Parser->loadfile("../setup/installform.html");
	$Parser->assignvars(array('{currentpage}','{installerror}','{host}','{user}','{pass}','{bd}','{EmailHost}','{EmailUsername}','{EmailPassword}','{EmailOwner}'),array($_SERVER['PHP_SELF'],$error,$mysql_host,$mysql_user,$mysql_password,$mysql_database,$EmailHost,$EmailUsername,$EmailPassword,$EmailOwner));
	$content = $Parser->output();
}

$Parser->loadfile("../setup/maininstall.html");
$Parser->assignblock(array('[content]'), array($content));
echo($Parser->output());
?>