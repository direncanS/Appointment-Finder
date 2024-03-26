<?php
/*
$meetid: Diese Variable speichert die bereinigte Version der Event-ID.
$getmeetquery: Diese Variable speichert das vorbereitete SQL-Statement, um die Details des gewünschten Events abzufragen.
$db->prepare(): Diese Funktion bereitet das SQL-Statement zur Ausführung vor. Sie verhindert SQL-Injection, indem sie Platzhalter verwendet, die später mit tatsächlichen Werten ersetzt werden.
$getmeetquery->execute(): Diese Funktion führt das vorbereitete SQL-Statement mit den angegebenen Werten aus.
if ($getmeetquery->rowCount() > 0) { ... }: Dieser Codeblock überprüft, ob mindestens ein Datensatz (ein gültiges Event) aus der Datenbank abgerufen wurde.
$getmeet: Diese Variable speichert die Eventdetails, die aus der Datenbank abgerufen wurden.
$getmeetuserquery: Diese Variable speichert das vorbereitete SQL-Statement, um die Benutzerdetails für das gewünschte Event abzufragen.
$getmeetuserquery->execute(): Diese Funktion führt das vorbereitete SQL-Statement mit den angegebenen Werten aus.
if ($getmeetuserquery->rowCount() > 0) { ... }: Dieser Codeblock überprüft, ob mindestens ein Datensatz (ein gültiger Benutzer) aus der Datenbank abgerufen wurde.
$meetusers: Diese Variable speichert die Benutzerdetails, die aus der Datenbank abgerufen wurden.
if ($getmeet["enddate"] > time()) { ... }: Dieser Codeblock prüft, ob das Enddatum des Events in der Zukunft liegt und zeigt die Schaltfläche "Join the Event" nur an, wenn das Event noch nicht beendet ist.
onClick="addmeetuser(<?= $getmeet['id']; ?>)": Dieses Attribut fügt eine JavaScript-Funktion hinzu, die ausgeführt wird, wenn der Benutzer auf die Schaltfläche "Join the Event" klickt. Die Funktion addmeetuser() sollte im JavaScript-Code definiert sein und verwendet die Event-ID als Parameter.
foreach ($meetusers as $keyuser) { ... }: Dieser Codeblock iteriert durch das $meetusers-Array und erzeugt die HTML-Struktur für die Liste der Teilnehmer und deren Informationen.
onClick="deletemeet(<?= $keyuser['id']; ?>,<?= $meetid; ?>)": Dieses Attribut fügt eine JavaScript-Funktion hinzu, die ausgeführt wird, wenn der Benutzer auf die Schaltfläche "Delete" klickt. Die Funktion deletemeet() sollte im JavaScript-Code definiert sein und verwendet die Benutzer-ID und die Event-ID als Parameter.
date(): Diese Funktion formatiert ein Unix-Timestamp in ein menschenlesbares Datum und/oder eine Uhrzeit. Im gegebenen Code wird es verwendet, um die Start- und Endzeiten der Veranstaltung sowie die Event-Zeit der Teilnehmer anzuzeigen.
<table>: Das HTML-Element <table> wird verwendet, um eine Tabelle mit Event-Details und Teilnehmerinformationen zu erstellen.
<thead> und <tbody>: Diese HTML-Elemente werden verwendet, um den Tabellenkopf und den Tabellenkörper zu definieren.
<tr>: Das HTML-Element <tr> wird verwendet, um eine Tabellenzeile zu erstellen.
<td>: Das HTML-Element <td> wird verwendet, um eine Tabellenzelle innerhalb einer Zeile zu erstellen.
<th>: Das HTML-Element <th> wird verwendet, um einen Tabellenkopf innerhalb einer Zeile zu erstellen.
Die meisten Variablen und Funktionen in diesem Codeausschnitt sind Teil der PHP- und HTML-Struktur, die zum Erstellen der Benutzeroberfläche für die Anzeige der Event-Details und der Liste der Teilnehmer verwendet wird. Die Funktionen und Variablen werden hauptsächlich verwendet, um Daten aus der Datenbank abzufragen und sie in einer formatierten Tabelle anzuzeigen. Außerdem sind einige JavaScript-Funktionsaufrufe enthalten, um Aktionen wie das Hinzufügen oder Löschen von Teilnehmern auszuführen.
 */
require_once("../settings/setting.php");
session_start();
if (!isset($_SESSION['security'])){
  die('err');
}
if (isset($_REQUEST["id"])) {
  //ENT_QUOTES löscht einfache doppelte Anführungszeichen.
  $meetid = strip_tags(htmlspecialchars($_REQUEST["id"],ENT_QUOTES));
} else {
  die("Err001");
}

$getmeetquery = $db->prepare("SELECT * FROM meeting WHERE active = 1 AND id = ?");
$getmeetquery->execute([$meetid]);

if ($getmeetquery->rowCount() > 0) {
  $getmeet = $getmeetquery->fetch(PDO::FETCH_ASSOC);
} else {
  die("Err002, Invalid Request!");
}

$getmeetuserquery = $db->prepare("SELECT * FROM meetuser WHERE meetid = ? AND active = 1 ORDER BY meettime ASC");
$getmeetuserquery->execute([
    $meetid
]);

if ($getmeetuserquery->rowCount() > 0) {
  $meetusers = $getmeetuserquery->fetchAll(PDO::FETCH_ASSOC);
} else {
  $meetusers = null;
}
?>
<?php if ($getmeet["enddate"] > time()) { ?>
  <div class="col-12">
    <div class="card">
      <div class="card-body" style="text-align: right;">
        <button onClick="addmeetuser(<?= $getmeet['id']; ?>)" class="btn btn-danger">+ Join the Event</button>
      </div>
    </div>
  </div>
<?php } ?>
<div class="col-md-12 mx-auto">
  <div class="card">
    <div class="card-body">
      <h4><?= htmlspecialchars(ucwords($getmeet["title"])); ?>&nbsp;Event</h4>
      <table class="table">
        <tbody>
        <tr>
          <td>Start</td>
          <td><?= date("d.m.Y H:i", $getmeet["startdate"]); ?></td>
        </tr>
        <tr>
          <td>End</td>
          <td><?= date("d.m.Y H:i", $getmeet["enddate"]); ?></td>
        </tr>
        <tr>
          <td>Ort</td>
          <td><?= htmlspecialchars(ucwords($getmeet["location"])); ?></td>
        </tr>
        <tr>
          <td>Info</td>
          <td><?= htmlspecialchars($getmeet["description"]); ?></td>
        </tr>
        </tbody>
      </table>
    </div>
  </div>

</div>
<div class="col-md-12 mx-auto" style="margin-top: 20px;">
  <div class="card">
    <div class="card-body">
      <h4>Event Details</h4>
      <?php
      if ($meetusers != null) {
      ?>
      <table class="table">
        <thead>
        <tr>
          <th>Participant</th>
          <th>Comment</th>
          <th>Event time</th>
          <?php if ($getmeet["enddate"] > time()) { ?><th>Process</th><?php } ?>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($meetusers as $keyuser) { ?>
          <tr>
            <td><?= htmlspecialchars($keyuser["username"]); ?></td>
            <td><?= htmlspecialchars($keyuser["description"]); ?></td>
            <td><?= date("H:i", $keyuser["meettime"]); ?></td>
            <?php if ($getmeet["enddate"] > time()) { ?>
              <td>
                <button class="btn btn-danger" onClick="deletemeet(<?= $keyuser['id']; ?>,<?= $meetid; ?>)">Delete</button>
              </td>
            <?php } ?>
          </tr>
        <?php } ?>
        </tbody>
      </table>
      <?php } else { ?>
        <h5>No Participants</h5>
      <?php } ?>
    </div>
  </div>

</div>

