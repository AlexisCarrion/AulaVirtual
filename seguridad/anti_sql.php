<?php


array_walk($_POST, 'limpiarCadena');
array_walk($_GET, 'limpiarCadena');
function limpiarCadena($valor)
{
	$check = $valor;
	
	$valor = str_ireplace(" SELECT ","",$valor);
	$valor = str_ireplace(" COPY ","",$valor);
	$valor = str_ireplace(" DELETE ","",$valor);
	$valor = str_ireplace(" DROP ","",$valor);
	$valor = str_ireplace(" DUMP ","",$valor);
	$valor = str_ireplace(" OR ","",$valor);
	$valor = str_ireplace(" LIKE ","",$valor);
	$valor = str_ireplace(" group_concat ","",$valor);

	

	
	
	if( $check != $valor )
        {
			if(!empty($_SESSION['cantidadsql'])){
		$_SESSION['cantidadsql']++;
	}else{
	$_SESSION['cantidadsql']=1;
	}
	
            $logf = fopen("../seguridad/sqllog.txt", "a+");
            fprintf($logf, print_r($_SESSION,true)."Date: %s - IP: %s - Código: %s, - Correto: %s\r\n", date("d-m-Y h:i:s A"), $_SERVER['REMOTE_ADDR'], $check, $valor );
            fclose($logf);
        }
	
	
	return $valor;
}



$ip = $_SERVER['REMOTE_ADDR'];
$script = $_SERVER['PATH_TRANSLATED'];
$fp = fopen ($ruta."seguridad/sql_Injections.txt", "a+");
$sql_inject_1 = array(";","'","table_name",'"','truncate','order by','group_concat','insert',"drop","union","select"); #Whoth need replace
$sql_inject_2 = array("", "","","&quot;","","","","","","",""); #To wont replace
$GET_KEY = array_keys($_GET); #array keys from $_GET
/*begin clear $_GET */
for($i=0;$i<count($GET_KEY);$i++){
  $real_get[$i] = $_GET[$GET_KEY[$i]];
  $_GET[$GET_KEY[$i]] = str_replace($sql_inject_1, $sql_inject_2, HtmlSpecialChars($_GET[$GET_KEY[$i]]));
   if($real_get[$i] != $_GET[$GET_KEY[$i]]){
    
     fwrite ($fp, print_r($_SESSION,true)." \r\n");
   
	if(!empty($_SESSION['cantidadsql'])){
		$_SESSION['cantidadsql']++;
	}else{
	$_SESSION['cantidadsql']=1;
	}
	
	
	echo "<script language='JavaScript'> alert('Inyección SQL detectado'); </script> 
<script language='JavaScript' type='text/javascript'> 
var pagina='?'
function redireccionar() 
{
location.href=pagina
} 
redireccionar();

</script>";
     fwrite ($fp, "IP: $ip\r\n");
     fwrite ($fp, "Method: GET\r\n");
     fwrite ($fp, "Value: $real_get[$i]\r\n");
     fwrite ($fp, "Script: $script\r\n");
     fwrite ($fp, "Time: ".date("d-m-Y H:i:s")."\r\n");
     fwrite ($fp, "==================================\r\n");
	 


    
   }
}
fclose ($fp);

/*end clear $_GET */
?>