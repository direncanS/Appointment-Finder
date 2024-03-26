<?php
/*
require_once("../settings/setting.php");: Diese Zeile lädt die Datei setting.php aus dem settings-Verzeichnis, in dem vermutlich die Datenbankverbindung und andere Einstellungen definiert sind.
session_start();: Diese Funktion startet eine neue oder setzt eine vorhandene Sitzung fort, damit Session-Variablen verwendet werden können.
if (!isset($_SESSION['security'])){ die('err'); }: Dieser Codeblock überprüft, ob die Session-Variable security gesetzt ist. Wenn sie nicht gesetzt ist, stoppt das Skript mit der Ausgabe "err".
$_REQUEST["id"]: Das ist eine Super-Globale Variable, die den Wert der "id" aus den GET- oder POST-Daten abruft.
$meetid: Diese Variable speichert die bereinigte Version der "id" aus den Anforderungsdaten (GET oder POST).
filter_var(): Diese Funktion wird verwendet, um die "id" mithilfe des FILTER_SANITIZE_NUMBER_INT-Filters zu bereinigen, der alle Zeichen außer Ziffern und den Vorzeichen "+" und "-" entfernt.
strip_tags(): Diese Funktion entfernt alle HTML- und PHP-Tags aus der übergebenen Zeichenkette.
htmlspecialchars(): Diese Funktion konvertiert Sonderzeichen in HTML-Entities, um Cross-Site Scripting (XSS) zu verhindern.
$updatequery: Diese Variable speichert das vorbereitete SQL-Statement zum Aktualisieren des meetuser-Datensatzes.
$db->prepare(): Diese Funktion bereitet das SQL-Statement zur Ausführung vor. Sie verhindert SQL-Injection, indem sie Platzhalter verwendet, die später mit tatsächlichen Werten ersetzt werden.
$updatequery->execute([$meetid]);: Diese Funktion führt das vorbereitete SQL-Statement mit dem angegebenen Wert $meetid aus.
if ($updatequery->rowCount() > 0): Diese Bedingung überprüft, ob mindestens eine Zeile im meetuser-Datensatz aktualisiert wurde.
echo "The record has been deleted successfully.";: Diese Zeile gibt die Erfolgsmeldung aus, wenn der Datensatz erfolgreich aktualisiert wurde.
die("Error: An unknown error has occurred!");: Diese Zeile stoppt das Skript und gibt eine Fehlermeldung aus, wenn keine Zeile aktualisiert wurde oder ein unbekannter Fehler aufgetreten ist.
Insgesamt aktualisiert dieses Skript den meetuser-Datensatz, indem es den Wert der active-Spalte auf 0 setzt. Es überprüft auch die Berechtigung des Benutzers, indem es die Session-Variable security überprüft.
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
    die("Error: Unvalid ID.");
}


$updatequery = $db->prepare("UPDATE meetuser SET active = 0 WHERE id = ?");
$updatequery->execute([$meetid]);

if ($updatequery->rowCount() > 0) {
    echo "The record has been deleted successfully.";
} else {
    die("Error: An unknown error has occurred!");
}
?>
