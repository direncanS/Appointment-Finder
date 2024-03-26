<div class="card">
  <div class="card-body">
    <?php
    require_once("../settings/setting.php");
    //Wir haben es aus Sicherheitsgründen gestartet, wenn nicht, beenden Sie den Code.
    session_start();
    if (!isset($_SESSION['security'])){
      die('err');
    }
    //Überprüfen Sie die aktiven in der Datenbank.
    $getmeetquery = $db->prepare("select * from meeting where active = 1 order by startdate asc");

    $getmeetquery->execute();

    if ($getmeetquery->rowCount() > 0) {
      $getmeet = $getmeetquery->fetchALL(PDO::FETCH_ASSOC);
      ?>
      <h4>All Events</h4>
      <table class="table" style="text-align: center;">
        <thead>
        <tr style="border-bottom: thin solid black;">
          <th>Event Name</th>
          <th>Start date</th>
          <th>End Date</th>
          <th>Detail</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($getmeet as $keymeet) {
          ?>
          <tr style="border-bottom: thin dotted gray;">
            <td><?= strip_tags(htmlspecialchars($keymeet["title"])); ?></td>
            <td><?= date("d.m.Y H:i", $keymeet["startdate"]); ?></td>
            <td><?= date("d.m.Y H:i", $keymeet["enddate"]); ?></td>
            <td>
              <!--id ile getmeetdateil sayfasina yönleniyoruz.-->
              <button class="btn btn-info" onClick="getmeetdetail(<?= $keymeet['id']; ?>)">Detail</button>
            </td>
          </tr>
          <?php
        }
        ?>
        </tbody>
      </table>
      <?php
    } else {
      echo "Appointment Not Added.";
    }
    ?>
  </div>
</div>
