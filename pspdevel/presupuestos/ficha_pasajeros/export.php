<?php
require_once __DIR__ . '/../../../config/database.php';
$svlPrivateConfiguration = svl_configuration();
$svlPassengerExportToken = isset($svlPrivateConfiguration['passenger_export_token']) ? (string) $svlPrivateConfiguration['passenger_export_token'] : '';
	// ****************************************************************************
	// This script allows retrieving all data for recently inserted passenger data.
	// No data is deleted now: the calling program will check returned data
	// and issue the "delete.php" script later passing the item identifiers.
	// Written by Massimiliano Alessandri (m.alessandri@volaincrociera.com)
	// ****************************************************************************
	// Password based protection (later, it will be replaced by IP protection)
	if ($svlPassengerExportToken === '' || !isset($_REQUEST['password']) || !is_string($_REQUEST['password']) || !hash_equals($svlPassengerExportToken, $_REQUEST['password']))
		exit();
	ob_start();
	echo <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<data>

XML;
	require '../../include/sql.php';
	execute_sql('SET NAMES UTF8');
	//$result = mysql_unbuffered_query('SELECT id_presupuesto,num_pass,nombre,apellido,nacionalidad,fecha_nacimiento,lugar_nacimiento,typo_doc,numero_doc,fecha_emission_doc,lugar_emission_doc,fecha_expiration_doc,telefono,mobile,fax,email FROM ficha_pasajeros ORDER BY id_presupuesto,num_pass', $link);
	$result = execute_sql('SELECT id_presupuesto,num_pass,nombre,apellido,nacionalidad,fecha_nacimiento,lugar_nacimiento,typo_doc,numero_doc,fecha_emission_doc,lugar_emission_doc,fecha_expiration_doc,telefono,mobile,fax,email FROM ficha_pasajeros ORDER BY id_presupuesto,num_pass', $link);
	$fiche_pasajeros = array();
	while($row = mysqli_fetch_row($result))
		$fiche_pasajeros[$row[0]][$row[1]] = array_slice($row, 2);
	//$result = mysql_unbuffered_query('SELECT d.id,d.armateur,d.bateau,d.cabine,d.num_cabine,d.ciudad_depart,d.ciudad_arrivee,d.date_depart,d.date_arrivee,d.date_trait,d.acompte,d.date_solde,d.solde,d.ref_dossier,d.prix_ttc,d.assurance_accepte,d.mode_pay,d.commentaire,d.commentaire_agent,d.notes,d.suivi,a.nombre,a.direccion,a.code_postal,a.ciudad FROM devis d INNER JOIN bileto_direccion a ON d.id=a.id_presupuesto ORDER BY d.id', $link);
	$result = execute_sql('SELECT d.id,d.armateur,d.bateau,d.cabine,d.num_cabine,d.ciudad_depart,d.ciudad_arrivee,d.date_depart,d.date_arrivee,d.date_trait,d.acompte,d.date_solde,d.solde,d.ref_dossier,d.prix_ttc,d.assurance_accepte,d.mode_pay,d.commentaire,d.commentaire_agent,d.notes,d.suivi,a.nombre,a.direccion,a.code_postal,a.ciudad FROM devis d INNER JOIN bileto_direccion a ON d.id=a.id_presupuesto ORDER BY d.id', $link);	
	while($row = mysqli_fetch_row($result)) {
		$id_presupuesto = $row[0];
		$l = count($row);
		for($i = 1; $i < $l; $i++)
			$row[$i] = trim($row[$i]);
		echo <<<XML
	<devis>
		<id>$id_presupuesto</id>
		<armateur>$row[1]</armateur>
		<bateau>$row[2]</bateau>
		<cat_cabine>$row[3]</cat_cabine>
		<num_cabine>$row[4]</num_cabine>
		<ciudad_depart>$row[5]</ciudad_depart>
		<ciudad_retour>$row[6]</ciudad_retour>
		<date_depart>$row[7]</date_depart>
		<date_retour>$row[8]</date_retour>
		<date_vente>$row[9]</date_vente>
		<acompte>$row[10]</acompte>
		<date_solde>$row[11]</date_solde>
		<solde>$row[12]</solde>
		<ref_dossier>$row[13]</ref_dossier>
		<prix_total>$row[14]</prix_total>
		<assurance_accepte>$row[15]</assurance_accepte>
		<mode_payement>$row[16]</mode_payement>
		<commentaire_client><![CDATA[$row[17]]]></commentaire_client>
		<commentaire_agent><![CDATA[$row[18]]]></commentaire_agent>
		<commentaire_notes><![CDATA[$row[19]]]></commentaire_notes>
		<suivi>$row[20]</suivi>
		<billet_envoye>
			<nombre>$row[21]</nombre>
			<direccion>$row[22]</direccion>
			<code_postal>$row[23]</code_postal>
			<ciudad>$row[24]</ciudad>
		</billet_envoye>

XML;
		if(is_array($fiche_pasajeros[$id_presupuesto]))
			foreach($fiche_pasajeros[$id_presupuesto] as $num_pass => $pasajero) {
				echo <<<XML
		<fiche_pasajero>
			<number>$num_pass</number>
			<nombre>$pasajero[0]</nombre>
			<apellido>$pasajero[1]</apellido>
			<nacionalidad>$pasajero[2]</nacionalidad>
			<fecha_nacimiento>$pasajero[3]</fecha_nacimiento>
			<lugar_nacimiento>$pasajero[4]</lugar_nacimiento>
			<typo_doc>$pasajero[5]</typo_doc>
			<numero_doc>$pasajero[6]</numero_doc>
			<fecha_emission_doc>$pasajero[7]</fecha_emission_doc>
			<lugar_emission_doc>$pasajero[8]</lugar_emission_doc>
			<fecha_expiration_doc>$pasajero[9]</fecha_expiration_doc>
			<telefono>$pasajero[10]</telefono>
			<mobile>$pasajero[11]</mobile>
			<fax>$pasajero[12]</fax>
			<email>$pasajero[13]</email>
		</fiche_pasajero>

XML;
			}
		echo <<<XML
	</devis>

XML;
	}
	echo <<<XML
</data>
XML;
	ob_end_flush();
?>