<?php
/*
In diesem PHP-Codeausschnitt wird ein neuer Benutzer für ein bestimmtes Event registriert.
rtrim(): Diese Funktion entfernt Leerzeichen oder andere Zeichen vom Ende einer Zeichenkette. Im Code wird es verwendet, um das letzte Komma im SQL-Query-Text zu entfernen.
bindParam(): Diese Methode bindet einen Parameter an einen angegebenen Variablennamen in einem SQL-Query. Im Code wird es verwendet, um die Benutzereingaben für den Namen und den Kommentar an den SQL-Query zu binden.
execute(): Diese Methode führt einen vorbereiteten SQL-Query aus.
rowCount(): Diese Methode gibt die Anzahl der betroffenen Zeilen für das letzte DELETE-, INSERT- oder UPDATE-Statement zurück. Im Code wird es verwendet, um zu überprüfen, ob die Teilnehmer erfolgreich hinzugefügt wurden.
Insgesamt fügt der Codeausschnitt einen neuen Teilnehmer für ein Event hinzu, indem er die übermittelten Daten bereinigt, einen SQL-Query vorbereitet, Parameter bindet und den Query ausführt. Anschließend gibt der Code entweder eine Erfolgsmeldung zurück oder zeigt eine Fehlermeldung an, falls etwas schiefgelaufen ist.
 */
require_once("../settings/setting.php"); //Vertabanı sorgusu için
session_start();
if (!isset($_SESSION['security'])){
  die('err');
}
if (isset($_REQUEST["id"])) {
  $meetid = intval($_REQUEST["id"]);
  $meetid = strip_tags($meetid);
  $meetid = htmlspecialchars($meetid, ENT_QUOTES, 'UTF-8');
} else {
  die("Err001");
}
if (isset($_REQUEST["name"])) {
  $name = filter_var($_REQUEST["name"], FILTER_SANITIZE_STRING);
} else {
  die("Err002");
}
if (isset($_REQUEST["comment"])) {
  $comment = filter_var($_REQUEST["comment"], FILTER_SANITIZE_STRING);
} else {
  $comment = " ";
}
if (isset($_REQUEST["t"])) {
  $t = $_REQUEST["t"];
} else {
  die("Err004");
}

$tt = array();

foreach ($t as $keyt) {
  if ($keyt[0] == "true") {
    $tt[] = $keyt[1];
  }
}
//güvenlik önlemi
if (count($tt) <= 0) {
  die("Err005");
}

$querytext = "insert into meetuser (meetid, username, description, meettime, active ) values ";

if ($meetid > 0 && $name != "") {
  foreach ($tt as $keytt) {
    $querytext .= "(" . $meetid . ", :name, :comment, " . intval($keytt) . ", 1),";
  }
}

$querytext = rtrim($querytext, ",");

$addmeetuser = $db->prepare($querytext);
$addmeetuser->bindParam(':name', $name);
$addmeetuser->bindParam(':comment', $comment);
$addmeetuser->execute();

if ($addmeetuser->rowCount() > 0) {
  echo "Registered for the event.";
} else {
  die("Err005. An Unknown Error Occurred. Please try again!");
}
?>
