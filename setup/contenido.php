<?php 
$ruta="../";
require($ruta."includes/conexion.php");
$DB->query("SELECT * FROM web_sistema", 0);
$settings = $DB->get_field_data(0);
$NombreSistema=$settings['NombreSistema'];



if(isset($_POST['btnEnviar'])){
if(empty($NombreSistema)){
$DB->query("insert into  web_sistema (NombreSistema,Version,Proveedor,Template) Values ('".$_POST['txtNombreSistema']."','".$_POST['txtVersion']."','".$_POST['txtProveedor']."','".$_POST['cmbTemplate']."')", 1);
}
		$DB->query("UPDATE web_sistema set NombreSistema='".$_POST['txtNombreSistema']."'", 1);
		$DB->query("UPDATE web_sistema set template='".$_POST['cmbTemplate']."'", 1);
	}
?>
<body>
<form id="form1" name="form1" method="post" action="">
<table width="356" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" style="text-align: center; font-weight: bold;">Contenido del Sistema</td>
  </tr>
  <tr>
    <td width="150">Nombre del Sistema:</td>
    <td width="200">
      <label for="txtNombreSistema"></label>
      <input type="text" name="txtNombreSistema" id="txtNombreSistema" />
   </td>
  </tr>
  <tr>
    <td>Version:</td>
    <td><input type="text" name="txtVersion" id="txtVersion" /></td>
  </tr>
  <tr>
    <td>Proveedor:</td>
    <td><input type="text" name="txtProveedor" id="txtProveedor" /></td>
  </tr>
  <tr>
    <td>Template:</td>
    <td>
      <select name="cmbTemplate" id="cmbTemplate">
      <?php 
if ($handle = opendir('../template')) {
while (false !== ($entry = readdir($handle))) {
$pos = strpos($entry, '.');
	if ($pos === false) {
	  echo '<option value='.$entry.'>'.$entry.'</option>';
	} 

}
}

?>
        
      </select></td>
  </tr>
  <tr>
    <td><a href="../?">index</a></td>
    <td><input type="submit" name="btnEnviar" id="btnEnviar" value="Enviar"></td>
  </tr>
</table>
 </form>
</body>
</html>
