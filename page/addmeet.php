<!--
Wir haben jedem Element eine ID gegeben, die uns hilft, es der Datenbank hinzuzufügen
<div class="col-md-5 mx-auto">: Dieser div-Container verwendet die Bootstrap-Klasse col-md-5, um die Breite des Containers auf 5 von 12 Spalten im mittleren Ansichtsbereich (md) zu setzen. Die Klasse mx-auto zentriert den Container horizontal.
<div class="card">: Hier wird ein neuer div-Container erstellt, der die Bootstrap-Klasse card verwendet. Diese Klasse erstellt ein flexibles und erweiterbares Container-Element mit einer Schatten- und Rahmenstruktur.
<div class="card-body">: Dieser div-Container verwendet die Bootstrap-Klasse card-body, um den Inhalt der Karte zu formatieren.
idititle: Die ID des Input-Felds, das verwendet wird, um den Titel des Events einzugeben.
ididesc: Die ID des Input-Felds, das verwendet wird, um die Beschreibung des Events einzugeben.
idiloca: Die ID des Input-Felds, das verwendet wird, um den Ort des Events einzugeben.
idimstart: Die ID des Input-Felds, das verwendet wird, um das Startdatum und die Startzeit des Events einzugeben. Es hat einen onChange-Event-Listener, der die Funktion updateenddate() aufruft, wenn sich der Wert ändert.
idimend: Die ID des Input-Felds, das verwendet wird, um das Enddatum und die Endzeit des Events einzugeben.
date('Y-m-d\TH:i',time()): Diese PHP-Codezeile gibt das aktuelle Datum und die Uhrzeit im erforderlichen Format für das datetime-local Input-Feld aus.
addmeettitle(): Diese Funktion wird aufgerufen, wenn der Benutzer auf den "Sign up" Button klickt. Die Funktion ist dafür verantwortlich, die eingegebenen Daten in die Datenbank aufzunehmen.
-->
<div class="col-md-5 mx-auto">
  <div class="card">
    <div class="card-body">
      <h4>New Event</h4>
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Event Title" id="idititle">
      </div>
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Event Description" id="ididesc">
      </div>
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Ort" id="idiloca">
      </div>
      <div class="form-group" style="text-align: left;">
        <label for="">Start Date</label>
        <input type="datetime-local" class="form-control"  id="idimstart" onChange="updateenddate()" min="<?=date('Y-m-d\TH:i',time());?>">
      </div>
      <div class="form-group" style="text-align: left;">
        <label for="">End Date</label>
        <input type="datetime-local" class="form-control" id="idimend" min="<?=date('Y-m-d\TH:i',time());?>">
      </div>
      <!--addmeettitle wird verwendet, um die Daten des Formulars in die Datenbank zu übernehmen.-->
      <button onClick="addmeettitle()" class="btn btn-primary btn-block">Sign up</button>
    </div>
  </div>
</div>
