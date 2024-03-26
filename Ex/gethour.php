<?php
require_once("../settings/setting.php"); //Vertabanı sorgusu için
//filter_var ile güvenlik önlemi aldik.
if (isset($_REQUEST["id"])) {
  $date = filter_var($_REQUEST["id"], FILTER_SANITIZE_STRING);
  $date = strtotime($date);
} else {
  die("Err001");
}

//meetDate adinda bir array olusturduk.
$meetdate = array();

//Verilen tarihe göre php'nin anlayacagi türde bir int deger olusturur.
$starttime=mktime(9,0,0,date("n",$date),date("j",$date),date("Y",$date));
$endtime=mktime(21,0,0,date("n",$date),date("j",$date),date("Y",$date));


for($i = $starttime; $i<=$endtime ; $i+=30*60){  //30 dakika aralıklarlarandevu saati oluştur dizi olarak
  $meetdate[$i] = 0; //Bütün randevuların  değerini 0 olarak atadik (Bütün randevular boş)
  //date(gün,ay,yil) halinde arrayimize atiyoruz.
}
//bindParam ile güvenlik önlemi aldik
$getmeetmbquery = $db->prepare("SELECT * FROM meeting WHERE meetdate <= :end_time AND meetdate >= :start_time AND active = 1");
$getmeetmbquery->bindParam(':end_time', $endtime, PDO::PARAM_INT);
$getmeetmbquery->bindParam(':start_time', $starttime, PDO::PARAM_INT);
$getmeetmbquery->execute();

//Dönen deger varsa onu degiskene atiyoruz.
if($getmeetmbquery->rowCount()>0){
  $getmeetdb = $getmeetmbquery -> fetchAll(PDO::FETCH_ASSOC);
  foreach($getmeetdb as $keymeetdb){
    $meetDate[$keymeetdb["meetdate"]]  = 1;  //Eğer randevu var ise değerini 1 olarak ata
  }

}

//Bu tarih için veritabanından randevuları alıp ve dolu olanları belirledik.
//Simdi bos olanlari yazdiriyoruz.
foreach ($meetdate as $keydateid => $keydate) {
  if ($keydate == 0) { // randevu boş olanları listele
    $safe_keydateid = htmlspecialchars($keydateid, ENT_QUOTES, 'UTF-8');
    $safe_time = htmlspecialchars(date("H:i", $keydateid), ENT_QUOTES, 'UTF-8');
    echo "<div onClick=\"selecthour(" . $safe_keydateid . ")\" class=\"divhour\">" . $safe_time . "</div>";
  }
}
?>