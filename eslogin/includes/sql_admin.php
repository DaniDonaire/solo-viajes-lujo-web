<?php
// Fonction qui permet de modifier les "on" en 1 et les "off" en 0 pour les checkbox
function checkbox_bd($checkbox){
	if($checkbox == "on")
		return 1;
	else
	   return 0;
}
// Fonction qui permet de nettoyer une chaine de caractere avent de la mettre dans la bd
function string_bd ($chaine)
{
	// Transformer les \' en '' pour la base de donnיe
	$temp = str_replace("\'", "''", $chaine);
	// Transformer les \" en " pour la base de donnיe
	$temp = str_replace('\"', '"', $temp);
	
	return $temp;

}

function normaliza($cadena){
//echo $cadena;
    $originales = 'ביםףתאטלעשס';
    $modificadas = 'aeiouaeioun';
    $cadena = utf8_decode($cadena);
    $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
    //$cadena = strtolower($cadena);
//echo $cadena;
    return utf8_encode($cadena);
}

// fi baners motor
function sql_destinos($form_id)
{
	$sql = "SELECT * FROM destinos_svl WHERE id_pais = $form_id ";
	return $sql;
}

function sql_insert_destino($form_nombre,$form_pagina, $imagen, $activo )
{
	//$nombre_pagina_pais = str_replace(' ','-',$form_nombre);
	//$imagen = str_replace(' ','-',$imagen);
	$sql = 
		"INSERT INTO paises_svl
		( nombre_pais, imagen_pais, nombre_pagina_pais, activo) 
		VALUES 
		('$form_nombre', '$imagen', '$form_pagina', '$activo')
		";
	return $sql;
	
}

function sql_destino_id($form_id)
{
	$sql = "SELECT * FROM paises_svl WHERE id_pais = $form_id ";
	return $sql;
}

function sql_paises_svl()
{
	$sql = "SELECT * FROM paises_svl ";
	return $sql;
}

function sql_update_pais_svl($form_id_pais, $form_nombre, $form_pagina, $form_imagen, $activo )
{
	//$nombre_pagina_pais = str_replace(' ','-',$form_nombre);
	//$imagen = str_replace(' ','-',$form_imagen);
	$sql = 
		"UPDATE paises_svl 
		SET nombre_pais = '$form_nombre',  
		imagen_pais = '$form_imagen' ,
		nombre_pagina_pais = '$form_pagina',
		activo= '$activo'
		WHERE id_pais = $form_id_pais
		";
	return $sql;
}

function sql_delete_pais_svl($form_id)
{
	$sql = "delete FROM paises_svl WHERE id_pais = $form_id ";
	return $sql;
}

function sql_insert_especialidad($form_nombre,$form_pagina, $form_id_pais,$imagen, $activo )
{
	//$nombre_pagina_destino = str_replace(' ','-',$form_nombre);
	//$imagen = str_replace(' ','-',$imagen);
	$sql = 
		"INSERT INTO destinos_svl
		( id_pais, destino, nombre_pagina_destino, imagen_destino , activo)  
		VALUES 
		('$form_id_pais', '$form_nombre', '$form_pagina','$imagen', '$activo')
		";
	return $sql;
	
}

function sql_especialidad_id($form_id)
{
	$sql = "SELECT * FROM destinos_svl WHERE id_destino = $form_id ";
	return $sql;
}

function sql_update_especialidad_svl($form_id_destino,$form_id_pais, $form_nombre, $form_pagina, $form_imagen, $activo)
{
	//$nombre_pagina_destino = str_replace(' ','-',$form_nombre);
	//$imagen = str_replace(' ','-',$form_imagen);
	$sql = 
		"UPDATE destinos_svl 
		SET id_pais = '$form_id_pais',  
		destino= '$form_nombre' ,
		imagen_destino = '$form_imagen' ,
		nombre_pagina_destino = '$form_pagina',
		activo= '$activo'
		WHERE id_destino = $form_id_destino
		";
	return $sql;
}
function sql_delete_especialidad_svl($form_id)
{
	$sql = "delete FROM destinos_svl WHERE id_destino = $form_id ";
	return $sql;
}
function sql_destinos_svl()
{
	$sql = "SELECT * FROM destinos_svl ";
	return $sql;
}

function sql_last_lanzamiento()
{
	$sql = "SELECT max(id_lanzamiento) as max_id_lanzamiento FROM lanzamientos";
	return $sql;
}

function sql_all_news_lanza($id_lanzamiento)
{
	$sql = "SELECT *,(select nombre_pais from paises_svl p where p.id_pais=n.id_pais_espe) as nombre_pais ,
		(select destino from destinos_svl d where d.id_destino = n.id_destino) as destino
	FROM newsletter n where id_lanzamiento = '$id_lanzamiento' ORDER BY orden asc";
	return $sql;
}

// Fonction pour prendre les info d'une zona
function sql_all_lanzamientos()
{
	$sql = "SELECT * FROM lanzamientos ORDER BY id_lanzamiento desc";
	return $sql;
}
// Fonction pour prendre les info d'une zona


////////
function sql_insert_lanza_old($titulo)
{
	$sql = 
		"INSERT INTO lanzamientos ( nombre) 
		VALUES ('$titulo')";
	//echo $sql;	
	return $sql;
}
////
function sql_insert_lanza($titulo,$texto_click,$logo,$texto_cabecera,$logo_pie_wrld,$logo_pie_svl,$logo_pie_eve,$logo_pie_cru)
{
	$sql = 
		"INSERT INTO lanzamientos ( nombre,texto_click,logo,texto_cabecera,logo_pie_wrld,logo_pie_svl,logo_pie_eve,logo_pie_cru) 
		VALUES ('$titulo','$texto_click','$logo','$texto_cabecera','$logo_pie_wrld','$logo_pie_svl','$logo_pie_eve','$logo_pie_cru')";
	//echo $sql;	
	return $sql;
}
// Fonction pour prendre les info d'une zona
function sql_lanza_id($form_id)
{
	$sql = "SELECT * FROM lanzamientos WHERE id_lanzamiento = $form_id ";
	return $sql;
}
// Fonction pour mettre a jour une zona de la base de donnיe
function sql_update_lanza($form_id_news, $titulo,$texto_click,$logo,$texto_cabecera,$logo_pie_wrld,$logo_pie_svl,$logo_pie_eve,$logo_pie_cru)
{
	$sql = 
		"UPDATE lanzamientos 
		SET nombre = '$titulo',
		texto_click = '$texto_click',
		logo = '$logo',
		texto_cabecera = '$texto_cabecera',
		logo_pie_wrld = '$logo_pie_wrld',
		logo_pie_svl = '$logo_pie_svl',
		logo_pie_eve = '$logo_pie_eve',
		logo_pie_cru = '$logo_pie_cru'
		WHERE id_lanzamiento = $form_id_news
		";
	//echo $sql;
	return $sql;
}
// Fonction qui supprime une ligne d'un itinיraire
function sql_delete_lanza($id)
{
	$sql ="DELETE FROM lanzamientos WHERE id_lanzamiento = $id";
	return $sql;
}

// Fonction pour prendre les info d'une zona
function sql_all_titulos_defecto()
{
	$sql = "select 0 as id_news,'Elegir News' as titulo from dual union SELECT id_news,titulo FROM newsletter WHERE id_lanzamiento = (select max(id_lanzamiento) from lanzamientos)";
	return $sql;
}
// Fonction pour prendre les info d'une zona
function sql_otros_titulos($id)
{
	$sql = "select 0 as id_news,'Elegir otra news' as titulo from dual union SELECT id_news,titulo FROM newsletter WHERE id_lanzamiento = (SELECT max( id_lanzamiento ) FROM lanzamientos WHERE id_lanzamiento = $id ) ";
	return $sql;
}
function sql_otros_titulos_defecto()
{
	$sql = "select 0 as id_news,'Elegir otra news' as titulo from dual union SELECT id_news,titulo FROM newsletter WHERE id_lanzamiento = (SELECT max( id_lanzamiento ) FROM lanzamientos ) ";
	return $sql;
}

function sql_all_paises()
{
	$sql = "select 0 as id_pais,'Elegir Especializacion' as nombre_pais from dual union SELECT id_pais,nombre_pais FROM paises_svl";
	return $sql;
}
function sql_insert_news($titulo, $id_lanzamiento, $imagen,$texto,$textoAmp,$orden,$visible,$descuento,$esbanner,$id_pais,$esbanner_eventos,$id_destino)
{
	$sql = 
		"INSERT INTO newsletter ( titulo, id_lanzamiento, imagen, texto, textoAmp ,orden, visible, descuento,esbanner,id_pais_espe,esbanner_eventos,id_destino,id_lanzamiento_imagen) 
		VALUES ('$titulo', '$id_lanzamiento', '$imagen', '$texto', '$textoAmp',$orden, '$visible', $descuento, $esbanner,$id_pais,$esbanner_eventos,$id_destino, '$id_lanzamiento')";
	//echo $sql;	
	return $sql;
}
// Fonction pour prendre les info d'une zona
function sql_news_id($form_id)
{
	$sql = "SELECT * FROM newsletter WHERE id_news = $form_id ";
	return $sql;
}
// Fonction pour mettre a jour une zona de la base de donnיe
function sql_update_news($form_id_news, $titulo, $id_lanzamiento, $imagen,$texto, $textoAmp,$orden,$visible,$descuento,$esbanner,$id_pais,$esbanner_eventos,$id_destino, $id_lanzamiento_imagen)
{
	$sql = 
		"UPDATE newsletter 
		SET titulo = '$titulo', 
		id_lanzamiento = '$id_lanzamiento', 
		imagen = '$imagen',
		texto = '$texto',
		textoAmp = '$textoAmp',
		orden = '$orden',
		visible = '$visible',
		descuento = '$descuento',
		esbanner = '$esbanner',
		id_pais_espe= '$id_pais',
		esbanner_eventos = '$esbanner_eventos',
		id_lanzamiento_imagen = '$id_lanzamiento_imagen', 
		id_destino='$id_destino'
		WHERE id_news = $form_id_news
		";
	//echo $sql;
	return $sql;
}
// Fonction qui supprime une ligne d'un itinיraire
function sql_delete_news($id)
{
	$sql ="DELETE FROM newsletter WHERE id_news = $id";
	return $sql;
}
// Fonction pour prendre les info d'une zona
function sql_all_news()
{
	$sql = "SELECT * FROM newsletter ORDER BY orden asc";
	return $sql;
}

function sql_all_titulos($id)
{
	$sql = "select 0 as id_news,'Elegir News' as titulo from dual union SELECT id_news,titulo FROM newsletter WHERE id_lanzamiento = $id";
	return $sql;
}

function sql_insert_copiarNews($id_lanza_2,$id_news){
	$sql = "insert into newsletter (id_lanzamiento,titulo,imagen,texto,orden,visible,descuento,textoAmp,esbanner,id_pais_espe,id_lanzamiento_imagen,id_destino) select $id_lanza_2,titulo,imagen,texto,orden,visible,descuento,textoAmp,esbanner,id_pais_espe,id_lanzamiento_imagen,id_destino from newsletter where id_news = $id_news";
	return $sql;
}

?>