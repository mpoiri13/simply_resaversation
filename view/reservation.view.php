<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
<link href='http://fullcalendar.io/js/fullcalendar-2.3.1/fullcalendar.min.css' rel='stylesheet' />

<script src='http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js'></script>
<script src='http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='http://fullcalendar.io/js/fullcalendar-2.3.1/fullcalendar.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.3.1/lang/fr.js'></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<style>
	body {
		margin: 40px 10px;
		padding: 0;
		font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
		font-size: 14px;
	}
	#calendar {
		float:left;
		max-width: 500px;
		margin: 0 auto;
	}
	#orderdetail{
		
		
		
	}
</style>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>

$(document).ready(function() {
    $('#calendar').fullCalendar({
        lang: 'fr',
        editable: true,
        selectable: false,
		dayClick: function(date, jsEvent, view) {
			//alert('Clicked on: ' + date.format());
			// alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
			// alert('Current view: ' + view.name);
			
			if($(this).css('background-color')=="rgb(80, 120, 255)"){
				$(".fc-day").each(function(index){
					if($(this).css('background-color') == "rgb(0, 128, 0)"){
						$(this).css("background-color", "rgb(80, 120, 255)");
					}
				});//enlever le marque precedent
				$(this).css('background-color','green');//marquer le jour choisi
				$('#HoraireListDiv').children('table').children('tbody').children().remove();
				var i = 0;
				for(var key in window.calendrier[$(this).attr("data-date")]){
					var str = '<tr><td><input type="radio" name="horaire" class="horaireboutton" id="horaireboutton';
					str = str + i;
					str = str + '" onclick="ShowTableTotalChooser(this)" /><label for="horaireboutton';
					str = str + i;
					str = str + '">'
					str = str + key;
					str = str + '</label></td></tr>';
					$('#HoraireListDiv').children('table').children('tbody').append(str);
					i = i + 1;
				}
				
				//隐藏桌数 
				$("#CtnBtn").fadeOut();
				$("#TableTotalDiv").fadeOut();
				$("#HoraireListDiv").fadeIn();
				
			}

		},
		events: function( start, end, timezone, callback ) {
			$.ajax({
				url: 'classe_calendrier.php',
				type: 'POST',
				dataType: 'json',
				data: {
					function: "Available_Days_Json",
					idresto: 1,
					start: start.format("YYYY-MM-DD"),
					end: end.format("YYYY-MM-DD"),
				},
				success: function(response) {
					window.calendrier = response;
					window.AvailableDays = new Array();
					for(var key in window.calendrier){
						window.AvailableDays.push(key);
					}
					for(var i in window.AvailableDays){
						$(".fc-day").each(function(index){
						if($(this).attr("data-date") == window.AvailableDays[i])
							$(this).css("background-color", "rgb(80, 120, 255)");
						});
					}
				}
			});
		},
		viewRender: function(currentView){
			var minDate = moment(),
			maxDate = moment().add(2,'weeks');
			// Past
			if (minDate >= currentView.start && minDate <= currentView.end) {
				$(".fc-prev-button").prop('disabled', true); 
				$(".fc-prev-button").addClass('fc-state-disabled'); 
			}
			else {
				$(".fc-prev-button").removeClass('fc-state-disabled'); 
				$(".fc-prev-button").prop('disabled', false); 
			}
		},
        eventLimit: false,
        timeFormat: 'H:mm'
	});

	$( "#DialogResa" ).dialog({ 
		autoOpen: false,
		height: 600,
		width: 600,
		modal: true
	});
	$( "#CtnBtn" ).click(function() {
		var sDate,sTime,sDateTime,iNbtable;
		$(".fc-day").each(function(){
			if($(this).css('background-color') == "rgb(0, 128, 0)"){
				sDate = $(this).attr("data-date");
			}
		});
		$(".horaireboutton").each(function(){
			if(this.checked){
				sTime = $(this).next().html();
			}
		});
		$(".tabletotalboutton").each(function(){
			if(this.checked){
				iNbtable = $(this).next().html();
			}
		});
		$('#OrderDetailDateTime').val(sDate + ' ' + sTime);
		$("#OrderDetailDateTime").attr("disabled","disabled");
		$('#OrderDetailNbTable').val(iNbtable);
		$("#OrderDetailNbTable").attr("disabled","disabled");
		
		
		$( "#DialogResa" ).dialog( "open" );
	});
	$( ".horaireboutton" ).click(function() {
		
	});
	$ ("input#nbtablesrange").change (function (){
		$ ("input#nbtables").val($ ("input#nbtablesrange").val());
	});
	//recharge de case selon le glisseur
	
	
	$("#VldBtn").click(function(){
		$.ajax({
            type: "POST",
            url: "classe_calendrier2.php?o=2",
            data: {
				 DATE_RESA : $("#OrderDetailDateTime").val(), 
				 NB_TABLES : $("#OrderDetailNbTable").val(), 
				 NOM : $("#OrderDetailNom").val(), 
				 PRENOM : $("#OrderDetailPrenom").val(), 
				 EMAIL_CLIENT : $("#OrderDetailEmail").val()
			},
            dataType: "json",
            success: function(data){
			}
         });
	});
});
function ShowContinueButton(e){
	$("#CtnBtn").fadeIn();
}
function ShowTableTotalChooser(e){
	$("#CtnBtn").fadeOut();
	var date;
	$(".fc-day").each(function(index){
		if($(this).css('background-color') == "rgb(0, 128, 0)"){
			date = $(this).attr("data-date");
		}
	});//trouver le date choisi maintenant
	$('#TableTotalDiv').children('table').children('tbody').children().remove();
	for(var i = 1; i <= window.calendrier[date][$(e).next().html()] ;i++){
		var str = '<tr><td><input type="radio" name="tabletotal" class="tabletotalboutton" id="tabletotalboutton';
		str = str + i;
		str = str + '"  onclick="ShowContinueButton(this)"/><label for="tabletotalboutton';
		str = str + i;
		str = str + '">'
		str = str + i
		str = str + '</label></td></tr>';
		$('#TableTotalDiv').children('table').children('tbody').append(str);
	}
	$("#TableTotalDiv").fadeIn();
}
	

</script>

</head>
<body>
<!--  la dialogue de inscription  -->
<div id="DialogResa"  class="dialog" title="Finir votre réservation">
	<div id="OrderDetailDisplay" >Veuillez compléter votre réservation </div>
	<table id="HoraireList" ><tbody>
	<tr>
		<td><label for="OrderDetailDateTime">Date</label></td>
		<td><input name="DATE_RESA" type="text" id="OrderDetailDateTime" /></td></tr>
	<tr>
		<td><label for="OrderDetailNbTable">Nombre de Tables</label></td>
		<td><input name="NB_TABLES" type="text" id="OrderDetailNbTable" /></td></tr>
	<tr>
		<td><label for="OrderDetailNom">Nom</label></td>
		<td><input name="NOM" type="text" id="OrderDetailNom" /></td></tr>
	<tr>
		<td><label for="OrderDetailPrenom">Prénom</label>
		<td><input name="PRENOM" type="text" id="OrderDetailPrenom" /></td></tr>
	<tr>
		<td><label for="OrderDetailEmail">Adresse mail</label>
		<td><input name="EMAIL_CLIENT" type="text" id="OrderDetailEmail" /></td></tr>
	</tbody></table>
	<button id="VldBtn"class="btn"  action="" >Valider la réservation</button>
</div>
	
<div id='calendar'></div>

<div id="OrderDetailInput" >
	<div id="HoraireListDiv" style="display:none">
		<table id="HoraireList" >
			<thead>
				<tr>
					<td>Choisir votre horaire</td>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
	<div id="TableTotalDiv" style="display:none">
	<table id="TableTotal" >
		<thead>
			<tr>
				<td>Nombre de tables</td>
			</tr>
		</thead>
		<tbody></tbody>
		
	</table>
	</div>
	<button id="CtnBtn" class="btn" style="display:none">Continuer la réservation</button>
</div>
</body>
</html>


