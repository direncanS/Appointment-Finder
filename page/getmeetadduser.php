<?php
/*
session_start();: Diese Funktion startet eine neue oder setzt eine vorhandene Sitzung fort, damit Session-Variablen verwendet werden können.
if (!isset($_SESSION['security'])){ die('err'); }: Dieser Codeblock überprüft, ob die Session-Variable security gesetzt ist. Wenn sie nicht gesetzt ist, stoppt das Skript mit der Ausgabe "err".
_REQUEST["id"]: Diese Super-Globale Variable ruft den Wert für die Event-ID aus den GET- oder POST-Daten ab.
$meetid: Diese Variable speichert die bereinigte Version der Event-ID.
try { ... } catch (PDOException $hata) { ... }: Dieser Codeblock umfasst den gesamten Datenbankzugriff und fängt eventuelle PDOExceptions ab, die während der Abfrage auftreten könnten.
$getmeetdetail: Diese Variable speichert das vorbereitete SQL-Statement, um die Details des gewünschten Events abzufragen.
$db->prepare(): Diese Funktion bereitet das SQL-Statement zur Ausführung vor. Sie verhindert SQL-Injection, indem sie Platzhalter verwendet, die später mit tatsächlichen Werten ersetzt werden.
$getmeetdetail->execute(): Diese Funktion führt das vorbereitete SQL-Statement mit den angegebenen Werten aus.
if ($getmeetdetail->rowCount() > 0) { ... }: Dieser Codeblock überprüft, ob mindestens ein Datensatz (ein gültiges Event) aus der Datenbank abgerufen wurde.
$getmeet: Diese Variable speichert die Eventdetails, die aus der Datenbank abgerufen wurden.
$meetdate[] = $i;: Hier wird ein neues Element zum Array $meetdate hinzugefügt, das die Zeitpunkte im einstündigen Abstand zwischen Start- und Enddatum des Events enthält.
$activetime: Diese Variable wird verwendet, um das aktuelle Datum im Loop zu speichern und zu überprüfen, ob ein neuer Tag begonnen hat.
foreach ($meetdate as $keymeetid => $keymeet) { ... }: Dieser Codeblock iteriert durch das $meetdate-Array und erzeugt die HTML-Struktur für die Liste der verfügbaren Zeiten.
<input type="checkbox" ...>: Dieses HTML-Element erstellt eine Checkbox für jede verfügbare Zeit, die der Benutzer auswählen kann.
onClick="savemeetuser(<?= $getmeet['id']; ?>)": Dieses Attribut fügt eine JavaScript-Funktion hinzu, die ausgeführt wird, wenn der Benutzer auf die Schaltfläche "Sign up" klickt. Die Funktion savemeetuser() sollte im JavaScript-Code definiert sein und verwendet die Event-ID als Parameter.
Insgesamt erstellt dieses Skript eine HTML-Struktur, die es Benutzern ermöglicht, sich für ein Event anzumelden, indem sie ihren Namen und ihre Kommentare eingeben und die gewünschten Zeiten
 */
require_once("../settings/setting.php");
session_start();
if (!isset($_SESSION['security'])){
  die('err');
}
if (isset($_REQUEST["id"])) {
  $meetid = filter_var($_REQUEST["id"], FILTER_SANITIZE_NUMBER_INT);
  $meetid = strip_tags($meetid);
  $meetid = htmlspecialchars($meetid, ENT_QUOTES, 'UTF-8');
} else {
  die("Err001");
}

try {
  $getmeetdetail = $db->prepare("SELECT * FROM meeting WHERE id = ? AND active = 1 AND enddate > ?");
  $getmeetdetail->execute([
      $meetid, time()
  ]);
//Saatleri siraliyoruz.
  if ($getmeetdetail->rowCount() > 0) {
    $getmeet = $getmeetdetail->fetch(PDO::FETCH_ASSOC);

    for ($i = $getmeet["startdate"]; $i <= $getmeet["enddate"]; $i += 60 * 60) {
      $meetdate[] = $i;
    }

  } else {
    die("Err002, Invalid Request!");
  }
} catch (PDOException $hata) {
  die($hata);
}
?>

<div class="col-md-6 mx-auto">
  <div>
    <div class="divclosex" onClick="closemeet()">X</div>
  </div>
  <h4>Join the Event</h4>

  <div class="form-group">
    <input type="text" class="form-control" placeholder="Name Surname" id="idiname">
  </div>
  <div class="form-group">
    <input type="text" class="form-control" placeholder="Comments" id="idicomment" maxlength="255">
  </div>
  <div class="form-group" id="iddivmeettime">
    <?php
    $art = -1;
    $activetime = "";
    foreach ($meetdate as $keymeetid => $keymeet) {
      $art++;
      if ($activetime == "") {
        $activetime = date("d.m.Y", $keymeet);
        echo "<div class='datetitle'>" . htmlspecialchars($activetime) . "</div>";
      } else {
        if ($activetime != date("d.m.Y", $keymeet)) {
          $activetime = date("d.m.Y", $keymeet);
          echo "<div class='datetitle'>" . htmlspecialchars($activetime) . "</div>";
        }
      }
      ?>
      <div style="display:inline-block ; position: relative; width: 19%;">
        <input type="checkbox" class="form-control" style="display: inline-block; width:  auto;"
               id="idtime[<?= $keymeetid; ?>]" value="<?= $keymeet; ?>"><label
            for="idtime[<?= $keymeetid; ?>]"><?= date("H:i", $keymeet); ?></label>
      </div>
    <?php } ?>
  </div>
  <button onClick="savemeetuser(<?= $getmeet['id']; ?>)" class="btn btn-primary btn-block">Sign up</button>
</div>
