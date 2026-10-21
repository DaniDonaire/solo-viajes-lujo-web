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
	// Transformer les \' en '' pour la base de donn�e
	$temp = str_replace("\'", "''", $chaine);
	// Transformer les \" en " pour la base de donn�e
	$temp = str_replace('\"', '"', $temp);

	return $temp;

}

function getParametre($name) {
	if(!isset($_REQUEST[$name]))
		return FALSE;
	if(get_magic_quotes_gpc())
		return stripslashes($_REQUEST[$name]);
	return $_REQUEST[$name];
}
	 
// Fonction qui permet de changer les caracteres de saut de ligne '\r\n' en balise html '<br \>'
function string_bd_html ($chaine)
{
	return str_replace("\r\n", "<br \>", $chaine);
}
// Fonction qui renvoie le plus petit tarif pour une croisiere

function sql_viajes($id)
{
	$sql =
		"SELECT * FROM newsletter n left join destinos_svl p on n.id_destino = p.id_destino and p.activo='1'
		where n.id_destino = '$id' and n.visible='S' group by titulo order by n.id_news desc";
	return $sql;
}
		
function sql_detalle_viaje($form_id)
{
	//$sql = "SELECT * FROM newsletter WHERE id_news = '$form_id'";
	$sql = "SELECT *  FROM newsletter n , destinos_svl d , paises_svl p WHERE n.id_destino = d.id_destino and d.id_pais=p.id_pais and id_news='$form_id'
	and p.activo='1' and d.activo='1'";
	return $sql;
	//echo $sql;
}
function sql_all_news_lanza($id)
{
	$sql = "SELECT * FROM lanzamientos l LEFT JOIN newsletter n ON l.id_lanzamiento=n.id_lanzamiento left join destinos_svl d on n.id_destino = d.id_destino  WHERE l.id_lanzamiento = '$id' and n.visible='S' ORDER BY n.orden asc";
	
	return $sql;
}
function sql_lanza_id($form_id)
{
	$sql = "SELECT * FROM lanzamientos WHERE id_lanzamiento = $form_id";
	return $sql;
}

function sql_especialidad($form_id)
{
	$sql = "SELECT *,(SELECT group_concat(destino) FROM destinos_svl where id_pais=$form_id and activo='1') as destinos FROM paises_svl where id_pais=$form_id and activo='1'";
	return $sql;
}
function sql_especialidades()
{
	$sql = "SELECT * FROM paises_svl where activo='1'";
	return $sql;
}
function sql_destinos($form_id)
{
	$sql = "SELECT * FROM destinos_svl d, paises_svl p WHERE d.id_pais = $form_id and d.id_pais=p.id_pais and d.activo='1' and p.activo='1'";
	return $sql;
}

function sql_destino($form_id)
{
	$sql = "SELECT * FROM destinos_svl d, paises_svl p WHERE id_destino = $form_id and d.id_pais=p.id_pais and d.activo='1' and p.activo='1'";
	return $sql;
}

function sql_insert_presupuesto($id,$destino,$comenzando_fecha,$adulto,$ninos,$vuelo,$ciudad,$nombre,$apellido_1,$apellido_2,$phone,$email,$hora_recordatorio,$comentarios,$date_last_added,$ip)
{
	$sql = "insert into presupuesto (id_crucero,destino,comenzando_fecha,adulto,ninos,vuelo,ciudad,nombre,apellido_1,apellido_2,phone,email,hora_recordatorio,comentarios,sitio,date_last_added,ip) values ('$id','$destino','$comenzando_fecha','$adulto','$ninos','$vuelo','$ciudad','$nombre','$apellido_1','$apellido_2','$phone','$email','$hora_recordatorio','$comentarios','SoloViajesDeLujo','$date_last_added','$ip')";
	return $sql;
}
	
function sql_insert_peticion($id ,$fecha ,$emailhash ,$ip_address)
{
	$sql = "insert into peticiones (id,fecha, emailhash, sitio,ip_address) values ('$id' ,'$fecha' ,'$emailhash' ,'SoloViajesDeLujo' ,'$ip_address')";
	return $sql;
	//echo $sql;
}

function sql_insert_mail($email)
{
	$sql = "insert into nuevos_mails (email,lista) values ('$email' ,'5' )";
	return $sql;
	//echo $sql;
}

function sql_baja_mail($email)
{
	$sql = "delete from nuevos_mails where email='$email'";
	return $sql;
	//echo $sql;
}

function sql_rutas()
{
	$sql = "SELECT * FROM newsletter n left join destinos_svl p on n.id_destino = p.id_destino and p.activo='1' where esbanner <> 0 and n.visible='S' group by titulo order by n.id_news desc limit 9";
	return $sql;
}

function sql_pais($form_id)
{
	$sql = "SELECT * FROM paises_svl where id_pais=$form_id and activo='1'";
	return $sql;
}

function sql_ofertas_exclusivas()
{
	$sql = "SELECT * FROM newsletter n left join destinos_svl p on n.id_destino = p.id_destino and p.activo='1' where esbanner_eventos <> 0 and n.visible='S' order by n.id_news desc limit 6";
	return $sql;
}

function sql_existe_mail($email)
{
	$sql = "SELECT 1 from nuevos_mails where email='$email'";
	return $sql;
	//echo $sql;
}
?>