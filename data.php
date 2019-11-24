<?php
include './assets/db/dbConnect.php';
$conn = OpenCon();
$arrayX=[];
$finArr = [];
$hotelEx ='';
$i=0;
$bookDetails = $conn->query("SELECT * FROM bookings");
while ($rowBook = $bookDetails->fetch_assoc()) {
  foreach ($arrayX as $key => $value) {
    if ($value==$rowBook['hotel']) {
      $hotelEx = 'TRUE';
    }
  }
  if ($hotelEx != 'TRUE') {
    array_push($arrayX, $rowBook['hotel']);
  }
}

foreach ($arrayX as $key => $value) {
  $bookDetailsx = $conn->query("SELECT * FROM bookings WHERE hotel='$value'");
  $count = 0;
  while ($rowBookx = $bookDetailsx->fetch_assoc()) {
    $count = $count + 1;
  }
  $finArr[$i]['hotel'] = $value;
  $finArr[$i]['count'] = $count;
  $i = $i + 1;
}

print json_encode($finArr);
 ?>
