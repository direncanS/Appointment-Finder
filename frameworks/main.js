/*
$meetid: Eine globale Variable, die die ID des Meetings speichert.
escapeHTML(unsafe): Eine Funktion, die unsichere Zeichen in einer Zeichenkette in ihre HTML-Entity-Äquivalente umwandelt.
security(): Eine Funktion, die einen AJAX-Post-Request an "page/security.php" sendet und dabei die ID "1" übergibt.
queryhour(): Eine Funktion, die einen AJAX-Post-Request an "page/gethour.php" sendet und dabei den Wert des Elements mit der ID "ididate" übergibt. Die Antwort wird verwendet, um den Inhalt des Elements mit der ID "iddivhour" zu aktualisieren.
selecthour($id): Eine Funktion, die einen AJAX-Post-Request an "page/getaddemeet.php" sendet und dabei die übergebene ID übergibt. Die Antwort wird verwendet, um den Inhalt des Elements mit der ID "iddivhour" zu aktualisieren.
getpagemeet(): Eine Funktion, die einen AJAX-Post-Request an "page/mainmeet.php" sendet und die Antwort verwendet, um den Inhalt des Elements mit der ID "iddivbody" zu aktualisieren.
getallmeet(): Eine Funktion, die Menüelemente aktualisiert und einen AJAX-Post-Request an "page/mainallmeet.php" sendet. Die Antwort wird verwendet, um den Inhalt des Elements mit der ID "iddivbody" zu aktualisieren.
addmeet(): Eine Funktion, die Menüelemente aktualisiert und einen AJAX-Post-Request an "page/addmeet.php" sendet. Die Antwort wird verwendet, um den Inhalt des Elements mit der ID "iddivbody" zu aktualisieren.
addmeettitle(): Eine Funktion, die die eingegebenen Daten überprüft und einen AJAX-Post-Request an "page/getaddmeet.php" sendet, um ein neues Meeting zu erstellen. Zeigt Fehlermeldungen an, falls erforderlich.
addmeetuser($id): Eine Funktion, die ein Formular zum Hinzufügen von Benutzern zu einem Meeting anzeigt. Sie sendet einen AJAX-Post-Request an "page/getmeetadduser.php" und übergibt die Meeting-ID.
closemeet(): Eine Funktion, die das Benutzer-Hinzufügen-Formular schließt und die globale Variable $meetid auf 0 zurücksetzt.
savemeetuser($id): Eine Funktion, die die eingegebenen Daten überprüft und einen AJAX-Post-Request an "page/savemeetuser.php" sendet, um einen Benutzer zu einem Meeting hinzuzufügen. Zeigt Fehlermeldungen an, falls erforderlich.
getmeetdetail($id): Diese Funktion sendet eine AJAX-Anfrage an die "page/getmeetdetail.php" Seite mit der übergebenen $id als Parameter. Wenn die Anfrage erfolgreich ist, wird das "iddivbody" Element auf der Seite mit dem empfangenen Inhalt aktualisiert. Diese Funktion wird verwendet, um die Details eines bestimmten Meetings anzuzeigen.
updateenddate(): Diese Funktion aktualisiert das minimale Datum und die Uhrzeit, die im "idimend" Element ausgewählt werden können. Es stellt sicher, dass das Enddatum nicht vor dem Startdatum liegt, indem es das "min" Attribut des "idimend" Elements auf den Wert des "idimstart" Elements setzt.
err($message, $status = 0): Diese Funktion zeigt eine Benachrichtigung auf der Seite an, basierend auf dem übergebenen $message und $status. $status bestimmt die Farbe der Benachrichtigung (0 für Grün und 1 für Rot). Die Funktion erstellt ein neues "divnotice" Element, fügt es dem Body der Seite hinzu und zeigt es für 3 Sekunden an, bevor es entfernt wird.
bodyeffect(): Diese Funktion wird verwendet, um eine Drehanimation auf dem "iddivbody" Element der Seite auszuführen. Die Animation dreht das Element um 180 Grad um die Y-Achse und dreht es dann nach einer Verzögerung von 300 ms zurück auf 0 Grad. Diese Funktion wird aufgerufen, um eine visuelle Rückmeldung zu geben, wenn der Inhalt der Seite aktualisiert wird.
deletemeet($id, $meetid): Diese Funktion sendet eine AJAX-Anfrage an die "page/deletemeet.php" Seite, um ein Meeting mit der übergebenen $id zu löschen. Wenn die Anfrage erfolgreich ist, wird eine Erfolgsmeldung angezeigt und die Detailansicht des Meetings mit der $meetid wird aktualisiert. Im Fehlerfall wird eine Fehlermeldung angezeigt.
 */
var $meetid = 0;

function escapeHTML(unsafe) {
  return unsafe.replace(/[&<"']/g, function(m) {
    switch (m) {
      case '&':
        return '&amp;';
      case '<':
        return '&lt;';
      case '>':
        return '&gt;';
      case '"':
        return '&quot;';
      default:
        return '&#039;';
    }
  });
}

function  security(){
  $.post('page/security.php',{'id':1},function($result){

  });
}
//Wenn die Funktion queryhour() aufgerufen wird, hat die Seite ein Feld namens "ididate", der Wert dieses Felds wird abgerufen.
// Dieser Wert enthält normalerweise ein Datum oder eine Uhrzeit.
// Als nächstes wird eine Anfrage gesendet, um Informationen von einer anderen Seite namens "gethour.php" zu erhalten.
// Diese Anfrage sendet auch den Wert im Feld "ididate".
// Somit kann die Seite "gethour.php" mit diesem Wert aktiv werden.
// Wenn Informationen von der Seite „gethour.php“ abgerufen werden, gibt es auf der Seite ein weiteres Feld mit dem Namen „iddivhour“ und der Text in diesem Feld wird durch die erhaltenen Informationen ersetzt.
// Dies dient dazu, neue Informationen auf der Seite anzuzeigen.
function queryhour() {
  $.post("page/gethour.php", { "id": escapeHTML(document.getElementById("ididate").value) }, function ($result) {
    document.getElementById("iddivhour").innerHTML = $result.trim();
  });
}
// Eine Anfrage wird gesendet, um Informationen von einer anderen Seite mit dem Namen "getaddemeet.php" zu erhalten.
// Diese Anfrage sendet auch den Wert der ausgewählten Stunde.
// Somit kann die Seite "getaddemeet.php" mit diesem Wert aktiv werden.
//Um Informationen von der Seite "getaddemeet.php" zu erhalten, gibt es ein weiteres Feld auf der Seite namens "iddivhour".
// Der Text in diesem Feld wird durch die empfangenen Informationen ersetzt. Dies dient dazu, neue Informationen auf der Seite anzuzeigen.
function selecthour($id) {
  $.post("page/getaddemeet.php", { "id": $id }, function ($result) {
    document.getElementById("iddivhour").innerHTML = $result.trim();
  });
}

function getpagemeet() {
  bodyeffect();
  $.post("page/mainmeet.php", function ($result) {
    document.getElementById("iddivbody").innerHTML = $result.trim();
  });
}
//Diese Funktion ändert zuerst den Stil der Menüpunkte in der oberen linken Ecke der Seite
//Sendet dann eine AJAX-Anfrage ($.post()), um Daten aus der Datei mainallmeet.php abzurufen.
// Wenn die Anfrage erfolgreich ist, werden die empfangenen Daten als Inhalt des div auf der Hauptseite namens iddivbody gesetzt.
function getallmeet() {
  bodyeffect();
  // findet einen Bereich auf der Seite namens "iddivmenu".
  // Innerhalb dieses Bereichs befinden sich zwei hintereinander angeordnete Schaltflächen.
  // Das erste untergeordnete Element fügt einen Stil namens "divmenuitemactive" hinzu, das zweite untergeordnete Element fügt einen weiteren Stil namens "divmenuitem" hinzu.
  // Dies ändert das Aussehen der Schaltflächen.
  // Da wir die Seite nicht ändern, ändern wir die Klasse mit Savascript und geben diese Features.
  document.getElementById("iddivmenu").children[0].className = "divmenuitemactive";
  document.getElementById("iddivmenu").children[1].className = "divmenuitem";

  // Wenn die Anfrage erfolgreich ist, werden die empfangenen Daten als Inhalt des div auf der Hauptseite namens iddivbody gesetzt.
  //Ein Muster, das wir mit jquery erstellt haben, dient zum Senden und Empfangen von Daten mit $.post().
  //$result ist unser Rückgabewert. Betten Sie diesen Wert auch in den Idivbody ein.
  //document.getElementById("iddivbody").innerHTML += $result.trim(); Sagen Sie tpla mit sich selbst, sodass jedes Mal, wenn wir darauf klicken, ein neues hinzugefügt wird, ohne das alte zu beschädigen
  $.post("page/mainallmeet.php", function ($result) {
    document.getElementById("iddivbody").innerHTML = $result.trim();
  });
}

function addmeet() {
  bodyeffect();
  //eins. und 2. Navbar-Spalten durch Klassen ersetzen
  document.getElementById("iddivmenu").children[1].className = "divmenuitemactive";
  document.getElementById("iddivmenu").children[0].className = "divmenuitem";
  $.post("page/addmeet.php", function ($result) {
    document.getElementById("iddivbody").innerHTML = $result.trim();
  });
}

function addmeettitle() {
  let $title = document.getElementById("idititle");
  let $desc = document.getElementById("ididesc");
  let $loca = document.getElementById("idiloca");
  let $mstart = document.getElementById("idimstart");
  let $mend = document.getElementById("idimend");

  if ($title.value.length > 0) {
    if ($desc.value.length > 0) {
      if ($mstart.value.length > 0) {
        if ($mend.value.length > 0) {
          bodyeffect();
          $.post("page/getaddmeet.php", {
            "title": escapeHTML($title.value),
            "desc": escapeHTML($desc.value),
            "loca": escapeHTML($loca.value),
            "mstart": escapeHTML($mstart.value),
            "mend": escapeHTML($mend.value)
          }, function ($result) {
            if ($result.trim().substr(0, 2) != "Err") {
              err($result.trim());
              getallmeet();
            } else {
              err($result.trim(), 1);
            }
          });
        } else {
          err("Add End Date and Time!", 1);
          $mend.focus();
        }
      } else {
        err("Add the Start Date and Time!", 1);
        $mstart.focus();
      }
    }   } else {
    err("Add Event Title!", 1);
    $title.focus();
  }
}
//Join event beitreten und zur ID unter main hinzufügen..
function addmeetuser($id) {
  $meetid = $id;
  document.getElementById("iddivaddmeet").style.transform = "scale(1)";
  $.post("page/getmeetadduser.php", { "id": $id }, function ($result) {
    document.getElementById("iddivaddmeet").innerHTML = $result.trim();
  });
}

function closemeet() {
  $meetid = 0;
  document.getElementById("iddivaddmeet").style.transform = "scale(0)";
}

function savemeetuser($id) {
  let $tt = new Array();//Wir haben es für den Fall definiert, dass in der Checkbox kein Datum ausgewählt ist.
  if ($meetid == $id) {
    let $art = -1;
    let $secildimi = false;

    if (document.getElementById("idiname").value.length >= 3) {
      //Wir verwenden es, um zu überprüfen, ob es ausgewählt ist oder nicht.
      do {
        $art++;

        if (document.getElementById("idtime[" + $art + "]") != null) {
          $tt[$art] = [document.getElementById("idtime[" + $art + "]").checked, document.getElementById("idtime[" + $art + "]").value];
          if (document.getElementById("idtime[" + $art + "]").checked == true) {
            $secildimi = true;
          }
        }
      } while (document.getElementById("idtime[" + $art + "]") != null);
      //Wenn irgendein Datum ausgewählt ist
      if ($secildimi) {
        bodyeffect();
        $.post("page/savemeetuser.php", {
          "id": $id,
          "name": escapeHTML(document.getElementById("idiname").value),
          "comment": escapeHTML(document.getElementById("idicomment").value),
          "t": $tt
        }, function ($result) {
          if ($result.trim().substr(0, 2) != "Err") {
            err($result.trim());
            getallmeet();
            closemeet();
          } else {
            err($result.trim(), 1);
          }
        });
      } else {
        err("Please Select Date!!", 1);
      }

    } else {
      err("Your name must be Min 3 characters!", 1);
    }
  }
}

function getmeetdetail($id) {
  bodyeffect();
  $.post("page/getmeetdetail.php", { "id": $id }, function ($result) {
    document.getElementById("iddivbody").innerHTML = $result.trim();
  });
}

function updateenddate() {
  let $startdate = document.getElementById("idimstart");
  let $enddate = document.getElementById("idimend");
  //Der Mindestwert von Enddatum ist der Wert von Startdatum, sodass wir nicht früher auswählen können.
  $enddate.min = $startdate.value;
}

function err($message, $status = 0) {
  let $errcolor = "#00FF00";
  let $errdiv = document.createElement("div");
  $errdiv.className = "divnotice";
  document.body.appendChild($errdiv);

  switch ($status) {
    case 0:
      $errcolor = "#00FF00";
      break;
    case 1:
      $errcolor = "#FF0000";
      break;
    default:
      $errcolor = "#00FF00";
  }
  if ($message.trim() != "") {
    $errdiv.innerHTML = $message;
    $errdiv.style.borderColor = $errcolor;
    $errdiv.style.transform = "scale(1)";
    $errdiv.style.top = "20px";
    setTimeout(function () {
      $errdiv.style.zIndex = "-1";
      $errdiv.style.transform = "scale(0)";
      $errdiv.style.opacity = "0";
      setTimeout(function () {
        $errdiv.remove();
      }, 100);
    }, 3000);
  }
}
//Dieser Code definiert eine Funktion namens bodyeffect().
// Der Zweck dieser Funktion besteht darin, einen Teil der Seite schnell zu drehen und so einen Animationseffekt zu erzeugen.
// Wenn die Funktion bodyeffect() aufgerufen wird, findet sie ein Element auf der Seite namens "iddivbody" und dreht es um 180 Grad.
// Dies ist eine Drehung mit RotateY(180deg).
// Diese Aktion bewirkt, dass das Element um die Y-Achse gedreht wird.
// Als nächstes wird die Funktion setTimeout verwendet.
// Diese Funktion wird verwendet, um nach einer bestimmten Zeit eine Operation auszuführen.
// In diesem Fall wird nach 300 Millisekunden (0,3 Sekunden) eine neue Funktion ausgeführt.
// Diese neue Funktion findet das Element mit dem Namen "iddivbody" erneut und bringt das Element diesmal an seine ursprüngliche Position (0 Grad) zurück.
// Dies geschieht mit rotationY(0deg).
function bodyeffect() {
  document.getElementById("iddivbody").style.transform = "rotateY(180deg)";
  setTimeout(function () {
    document.getElementById("iddivbody").style.transform = "rotateY(0deg)";
  }, 300);
}

function deletemeet($id, $meetid) {
  $.post("page/deletemeet.php", { "id": $id }, function ($result) {
    if ($result.trim().substr(0, 2) != "Err") {
      err($result.trim());
      getmeetdetail($meetid);
    } else {
      err($result.trim(), 1);
    }
  });
}


