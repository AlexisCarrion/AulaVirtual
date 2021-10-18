<?php
$DB->query("SELECT * FROM web_sistema", 0);
$settings = $DB->get_field_data(0);
require("includes/login.php");

$NombreSistema=$settings['NombreSistema'];
$Version=$settings['Version'];
$Proveedor=$settings['Proveedor'];
$Template=$settings['Template'];
$verprecio=$settings['verprecio'];
$faceAppid=$settings['faceAppid'];
$faceSecret=$settings['faceSecret'];
$faceToken=$settings['faceToken'];
$faceIdfanpage=$settings['faceIdfanpage'];
$lugar=$settings['lugar'];
$telefono=$settings['telefono'];
$email=$settings['email'];
$EmailHost=$settings['EmailHost'];
$EmailUsername=$settings['EmailUsername'];
$EmailPassword=$settings['EmailPassword'];
$hometxt=$settings['hometxt'];

$VerPrecio=$settings['verprecio'];


if($_GET['page']=="off_camigo"){
$_SESSION["cAmigo"]=false;	
	$_GET['page']="";
}else if($_GET['page']=="on_camigo"){
$_SESSION["cAmigo"]=true;	
$_GET['page']="";	
}
if(!empty($_SESSION["idCuenta"]) && !empty($_SESSION["facebooklogin"]) && $_SESSION["cAmigo"]){
require_once 'public/facebookAmigos.php';
	
}


if(!empty($_SESSION["facebooklogin"])){
	$Social='<div id="currency"> <span>Social<b></b></span>
          <ul>
            <li> <a href="'.$preurl.'addproducto" title="Mis Amigos"><center><img src="'.$preurl.'imagenes/pedidopendiente.png" width="32" height="32"></center></a>  </li>
            <li> <a href="'.$preurl.'on_camigo" title="Mostrar los Que Cumplen este mes"><center><img src="'.$preurl.'imagenes/amigo.png" width="32" height="32"></center></a>  </li>
         <li> <a href="'.$preurl.'addproducto" title="Validar Comentarios"><center><img src="'.$preurl.'imagenes/comentario.png" width="32" height="32"></center></a>  </li>
          </ul>
        </div>';
}

//PANEL ADMINISTRADOR
if($_SESSION["nivel"]==100){
	$PanelAdmin='<div id="currency"> <span>Administracion<b></b></span>
          <ul>
            <li> <a href="'.$preurl.'addproducto" title="Nuevo Producto"><center><img src="'.$preurl.'imagenes/newproducto.png" width="32" height="32"></center></a>  </li>
            <li> <a onClick="javascript:window.open(\''.$preurl.'MANTENIMIENTO/CATEGORIAS/index.php\', \'WinName\', 
\'width=900,height=800,left=150,top=50 Barra de menú = no\');" Window target="_blank" title="Categorias y SubCategorias"><center><img src="'.$preurl.'imagenes/categorias.png" width="32" height="32"></center></a>  </li>
          <li> <a onClick="javascript:window.open(\''.$preurl.'MANTENIMIENTO/MARCAS/index.php\', \'WinName\', 
\'width=900,height=800,left=150,top=50 Barra de menú = no\');" Window target="_blank" title="Marcas" ><center><img src="'.$preurl.'imagenes/marca.png" width="32" height="32"></center></a>  </li>
          <li> <a href="'.$preurl.'configuracion" title="Configurar Web"><center><img src="'.$preurl.'imagenes/configuracion.png" width="32" height="32"></center></a>  </li>
          </ul>
        </div>';
}
if($_SESSION["nivel"]>=50){//MODERADOR
	$PanelModerador='<div id="currency"> <span>Funcionalidades<b></b></span>
          <ul>
            <li> <a href="'.$preurl.'addproducto" title="Pedidos Pendientes"><center><img src="'.$preurl.'imagenes/pedidopendiente.png" width="32" height="32"></center></a>  </li>
            <li> <a href="'.$preurl.'addproducto" title="Pedidos Realizados"><center><img src="'.$preurl.'imagenes/pedidoterminados.png" width="32" height="32"></center></a>  </li>
         <li> <a href="'.$preurl.'addproducto" title="Validar Comentarios"><center><img src="'.$preurl.'imagenes/comentario.png" width="32" height="32"></center></a>  </li>
          </ul>
        </div>';
}
	





if($VerPrecio){
	if(!empty($_SESSION["idCuenta"])){
$DB->query("SELECT count(idCuenta) as Cantidad,sum(preciototal) as totalprecio,sum(bonosrequiere) as requierebonos,sum(preciounitario*cantidad) as subtotal,sum(descuento) as Descuentototal FROM carrito c, productos pro where c.idProducto=pro.idProducto and idCuenta=".$_SESSION["idCuenta"], 1);
$ListCarritototal = $DB->get_field_data(1);		
	$minicarrito='<!--Mini Shopping Cart Start-->
        <section id="cart">
          <div class="heading">
            <h4><img width="32" height="32" alt="" src="'.$preurl.'template/ventas3/image/cart-bg.png"></h4>
            <a><span id="cart-total">'.$ListCarritototal['Cantidad'].' Items(s) - S/. '.$ListCarritototal['totalprecio'].'</span></a> </div>
          <div class="content">
            <div class="mini-cart-info">
              <table>';
		$DB->query("SELECT * FROM carrito c, productos pro where c.idProducto=pro.idProducto and idCuenta=".$_SESSION["idCuenta"], 0);
while($ListCarrito = $DB->get_field_data(0)){
	 $minicarrito.='    <tr>
                  <td class="image"><a href="'.$preurl.str_replace(" ", "-",$ListCarrito['Nombre']).'"><img src="'.$preurl.'ProductoImg/'.$ListCarrito['idProducto'].'/'.$ListCarrito['imagenpredeterminada'].'" width="50" height="40" alt="'.$ListCarrito['Nombre'].'" title="'.$ListCarrito['Nombre'].'" /></a></td>
                  <td class="name"><a href="'.$preurl.str_replace(" ", "-",$ListCarrito['Nombre']).'">'.$ListCarrito['Nombre'].'</a></td>
                  <td class="quantity">x&nbsp;'.$ListCarrito['cantidad'].'</td>
                  <td class="total">S/. '.$ListCarrito['preciototal'].'</td>
                  <td class="remove"><img src="'.$preurl.'template/ventas3/image/remove-small.png" alt="Remove" title="Remove" onclick="eliminarCarrito(\''.$ListCarrito['idCarrito'].'\',\''.$preurl.'\')"/></td>
                </tr>';
}	  
        
		
		
		
		   
            
            $minicarrito.='
              </table>
            </div>
            <div class="mini-cart-total">
              <table>
                <tr>
                  <td class="right"><b>Sub-Total:</b></td>
                  <td class="right">S/. '.$ListCarritototal['subtotal'].'</td>
                </tr>
                <tr>
                  <td class="right"><b>Descuento:</b></td>
                  <td class="right">S/. '.$ListCarritototal['Descuentototal'].'</td>
                </tr>
                <tr>
                  <td class="right"><b>Puntos Bonos:</b></td>
                  <td class="right">- '.$ListCarritototal['requierebonos'].'</td>
                </tr>
                
                <tr>
                  <td class="right"><b>Total:</b></td>
                  <td class="right">S/.'.$ListCarritototal['totalprecio'].'</td>
                </tr>
              </table>
            </div>
            <div class="checkout"><a class="button" href="'.$preurl.'carrito">Ver Carrito Compras</a> &nbsp; <a class="button" href="'.$preurl.'pedido">Hacer Pedido</a></div>
          </div>
        </section>
        <!--Mini Shopping Cart End-->';
				if($DB->get_num_records(0)==0){
					$minicarrito="";
				}
        }
}




$DB->query("SELECT * FROM categorias where Estado=1 order by Orden asc", 0);
while($ListCategorias = $DB->get_field_data(0)){
	
	$ListaCategorias.='<div class="column"> <a href="'.$preurl.''.$ListCategorias['Nombre'].'">'.$ListCategorias['Nombre'].'</a>
                <div>
                  <ul>';
	$DB->query("SELECT * FROM subcategorias where idCategoria=".$ListCategorias['idCategoria']." and Estado=1 order by Orden asc", 1);
		while($ListSubCategorias = $DB->get_field_data(1)){
			$ListaCategorias.='
                    <li><a href="'.$preurl.''.$ListCategorias['Nombre'].'/'.str_replace(" ", "-",$ListSubCategorias['Nombre']).'">'.$ListSubCategorias['Nombre'].'</a></li>
                   
                  ';
		}
$ListaCategorias.='</ul>
                </div>
              </div>
              
            ';

}

$DB->query("SELECT * FROM categorias where Estado=1 order by Orden asc", 0);
$activemenu=" active";
while($ListCategorias = $DB->get_field_data(0)){
	
	
	$ListaCategoriasMenu.='
                 <li class="custom_id'.$ListCategorias['idCategoria'].'"><a class="cutom-parent'.$activemenu.'" href="'.$preurl.''.$ListCategorias['Nombre'].'"><b>'.$ListCategorias['Nombre'].'</b></br><img src="'.$preurl.'funciones/ReducirImagen.php?w=100&h=100&c=80&urlimg=../'.$ListCategorias['imagen'].'" width="120" height="30" /> </a> <span class="down"></span>
                  <ul>';
	$DB->query("SELECT * FROM subcategorias where idCategoria=".$ListCategorias['idCategoria']." and Estado=1 order by Orden asc", 1);
		while($ListSubCategorias = $DB->get_field_data(1)){
			$ListaCategoriasMenu.='
                    <li class=""><a class="" href="'.$preurl.''.$ListCategorias['Nombre'].'/'.str_replace(" ", "-",$ListSubCategorias['Nombre']).'">'.$ListSubCategorias['Nombre'].'</a></li>
                   
                  ';
		}
		
		$ListaCategoriasMenu.='';
		
$ListaCategoriasMenu.='</ul>
                </li>
             ';
			 
$activemenu="";
}


if($VerPrecio){
	$refinarprecio=' <!--Refine Search Start-->
        <div class="box">
          <div class="box-heading">AFINAR LA BÚSQUEDA</div>
          <div class="box-content">
            <ul class="box-filter">
              <li><span id="filter-group">Precio</span>
                <ul>
                  <li>
                    <input type="checkbox" value="3" id="filter3" />
                    <label for="filter3">$0 - $100 (1)</label>
                  </li>
                  <li>
                    <input type="checkbox" value="4" id="filter4" />
                    <label for="filter4">$100 - $500 (5)</label>
                  </li>
                  <li>
                    <input type="checkbox" value="5" id="filter5" />
                    <label for="filter5">$500 - $1000 (1)</label>
                  </li>
                  <li>
                    <input type="checkbox" value="6" id="filter6" />
                    <label for="filter6">$1000 - $1500 (0)</label>
                  </li>
                </ul>
              </li>
            </ul>
            <a id="button-filter" class="button">Refine Search</a> </div>
        </div>
        <!--Refine Search End-->';
}




$DB->query("SELECT *,(select promedioRedondeado from estrellas where producto_id=pro.idProducto) as valorestrella ,YEAR(pro.fechaFin) as AnhoFinal,MONTH(pro.fechaFin) as MesFinal ,DAY(pro.fechaFin) as DiaFinal,pro.fechaFin,pro.fechaInicio   FROM productos pro where Estado=1 Order by fechaCreacion desc limit 5", 0);
$Recientes='<div class="box-content">
            <div class="box-product">
              <div class="flexslider">
                <ul class="slides">
                  ';
while($List = $DB->get_field_data(0)){


				$Nuevo=true;
				require("public/FormatoListaProducto.php");	
			$Recientes.=$ListaProducto;
			$ListaProducto="";
				
}

$Recientes.='</ul>
              </div>
            </div>
          </div>';













$Template=$settings['Template'];
if(empty($NombreSistema)){
	header("Location: setup/contenido.php");
}

?>