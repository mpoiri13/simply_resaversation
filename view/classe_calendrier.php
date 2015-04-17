<?php

switch ($_POST['function']){
case "Horaire_Events_Json":
	Horaire_Events_Json($_POST['idresto'], $_POST['start'], $_POST['end']);
	break;
case "Available_Days_Json":
	Available_Days_Json($_POST['idresto'], $_POST['start'], $_POST['end']);
	break;
default:
}
//Available_Days_Json(1,"2015-06-01","2015-07-12");
function GenerateCalendrer($iIdresto, $sStartDate, $sEndDate){
    $dsn = "mysql:host=localhost;dbname=database";
    $db = new PDO($dsn, 'root', '');
    $calendrier = Array ();
	for($date = strtotime($sStartDate); $date <= strtotime($sEndDate); $date = strtotime("+1days",$date)){
		$jour = date("w",$date);
		if($rsh = $db -> query("SELECT * FROM `calendrier_hebdo`  WHERE `id_resto` = $iIdresto and `jour` = $jour"))
		while($row = $rsh -> fetch()){
			$calendrier[date("Y-m-d",$date)][$row['HORAIRE']] = $row['NB_TABLES'];
		}
	}
	$rse = $db -> query("SELECT * FROM `calendrier_exception`  WHERE `id_resto` = 1");
	while($row = $rse -> fetch()){
		if(strtotime($sStartDate) <= strtotime($row['DATE_EXCEPTION']) && strtotime($row['DATE_EXCEPTION']) <= strtotime($sEndDate)){
			if($row['NB_TABLES']!=0)
				$calendrier[$row['DATE_EXCEPTION']][$row['HORAIRE']] = $row['NB_TABLES'];
			else
				unset($calendrier[$row['DATE_EXCEPTION']][$row['HORAIRE']]);
		}
	}
	foreach ($calendrier as $date => $calendrier_jour){
		if(empty($calendrier[$date]))
			unset($calendrier[$date]);
    }
	$db = null;
	return $calendrier;
}


function Horaire_Events_Json($iIdresto, $sStartDate, $sEndDate){
    $calendrier = GenerateCalendrer($iIdresto, $sStartDate, $sEndDate);
	$calendrier_export = Array();
    foreach ($calendrier as $date => $calendrier_jour){
    	foreach ($calendrier_jour as $horaire => $nbtable){
    		array_push($calendrier_export, array("title"=>"$nbtable tables dispo","start"=>$date."T".$horaire));
    	}
    }
	echo json_encode($calendrier);
    //echo json_encode($calendrier_export);
}
function Available_Days_Json($iIdresto, $sStartDate, $sEndDate){
    $calendrier = GenerateCalendrer($iIdresto, $sStartDate, $sEndDate);
	$days_available = Array();
    foreach ($calendrier as $date => $calendrier_jour){
    	array_push($days_available, $date);
    }
	echo json_encode($calendrier);
    //echo json_encode($days_available);
}



function creercalendrierhebdo($iIdresto, $iJour, $sHoraire){
    $dsn = "mysql:host=localhost;dbname=database";
    $db = new PDO($dsn, 'root', '');
    
    $db = null;
}
?>