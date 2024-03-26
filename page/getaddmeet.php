<?php
/*
require_once("../settings/setting.php");: Diese Zeile lädt die Datei setting.php aus dem settings-Verzeichnis, in dem vermutlich die Datenbankverbindung und andere Einstellungen definiert sind.
session_start();: Diese Funktion startet eine neue oder setzt eine vorhandene Sitzung fort, damit Session-Variablen verwendet werden können.
if (!isset($_SESSION['security'])){ die('err'); }: Dieser Codeblock überprüft, ob die Session-Variable security gesetzt ist. Wenn sie nicht gesetzt ist, stoppt das Skript mit der Ausgabe "err".
$_REQUEST["title"], $_REQUEST["desc"], $_REQUEST["loca"], $_REQUEST["mstart"], und $_REQUEST["mend"]: Diese Super-Globale Variablen rufen die Werte für Titel, Beschreibung, Ort, Startdatum und Enddatum aus den GET- oder POST-Daten ab.
$title, $desc, $loca, $mstart, $mend: Diese Variablen speichern die bereinigten Versionen der entsprechenden Anforderungsdaten (GET oder POST).
strtotime(): Diese Funktion konvertiert eine Datums- und Zeitzeichenkette in einen Unix-Timestamp.
if ($mstart <= time()): Diese Bedingung überprüft, ob das Startdatum in der Vergangenheit liegt.
if ($mstart <= $mend): Diese Bedingung überprüft, ob das Enddatum gleich oder nach dem Startdatum liegt.
$addmeetquery: Diese Variable speichert das vorbereitete SQL-Statement zum Einfügen eines neuen Datensatzes in die meeting-Tabelle.
$db->prepare(): Diese Funktion bereitet das SQL-Statement zur Ausführung vor. Sie verhindert SQL-Injection, indem sie Platzhalter verwendet, die später mit tatsächlichen Werten ersetzt werden.
$addmeetquery->execute(): Diese Funktion führt das vorbereitete SQL-Statement mit den angegebenen Werten aus.
if ($addmeetquery->rowCount() > 0): Diese Bedingung überprüft, ob mindestens eine Zeile in die meeting-Tabelle eingefügt wurde.
echo "Event created successfully": Diese Zeile gibt die Erfolgsmeldung aus, wenn der Datensatz erfolgreich eingefügt wurde.
die() und echo: Diese Funktionen stoppen das Skript und geben entsprechende Fehler- oder Erfolgsmeldungen aus.
Insgesamt nimmt dieses Skript die Event-Informationen entgegen, validiert und bereinigt sie und fügt sie in die meeting-Tabelle ein. Es gibt Erfolgsmeldungen aus, wenn das Event erfolgreich erstellt wurde, und Fehlermeldungen
 */
require_once("../settings/setting.php");
session_start();
if (!isset($_SESSION['security'])){
    die('err');
}

if (isset($_REQUEST["title"])) {
    $title = filter_var($_REQUEST["title"], FILTER_SANITIZE_STRING);
    $title = strip_tags($title);
    $title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
} else {
    die("Error: Event header is missing.");
}

if (isset($_REQUEST["desc"])) {
    $desc = filter_var($_REQUEST["desc"], FILTER_SANITIZE_STRING);
} else {
    die("Error: Event description is missing.");
}

$loca = isset($_REQUEST["loca"]) ? filter_var($_REQUEST["loca"], FILTER_SANITIZE_STRING) : "";

if (isset($_REQUEST["mstart"])) {
    $mstart = filter_var($_REQUEST["mstart"], FILTER_SANITIZE_STRING);
} else {
    die("Error: Event start date is missing.");
}

if (isset($_REQUEST["mend"])) {
    $mend = filter_var($_REQUEST["mend"], FILTER_SANITIZE_STRING);
} else {
    die("Error: The event end date is missing.");
}

$mstart = strtotime($mstart);
$mend = strtotime($mend);
//wir können keinen Termin mit einem vergangenen Datum vereinbaren time() gibt die aktuelle Uhrzeit zurück
if ($mstart <= time()) {
    die("Error: The start date cannot be in the past.");
}

if ($mstart <= $mend) {
    $addmeetquery = $db->prepare("INSERT INTO meeting (title, startdate, enddate, description, adddate, active, location) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $addmeetquery->execute([
        $title, $mstart, $mend, $desc, time(), 1, $loca
    ]);

    if ($addmeetquery->rowCount() > 0) {
        echo "Event created successfully";
    } else {
        echo "Error: An unknown error has occurred!";
    }
} else {
    die("Error: End date cannot be earlier than start date!");
}
?>
