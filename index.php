<?php
include './assets/db/dbConnect.php';
$conn = OpenCon();
$location  = "SELECT * FROM registerkenya";
$usercount = $traincount = $booked = $loc = 0;
$UsersDets = $conn->query("SELECT * FROM registerkenya");
while ($rowUsers = $UsersDets->fetch_assoc()) {
  $usercount = $usercount  + 1;
}
$arrayX=[];
$hotelEx = '';
$bookDetails = $conn->query("SELECT * FROM bookings");
while ($rowBook = $bookDetails->fetch_assoc()) {
  $traincount = $traincount + 1;
  foreach ($arrayX as $key => $value) {
    if ($value==$rowBook['hotel']) {
      $hotelEx = 'TRUE';
    }
  }
  if ($hotelEx != 'TRUE') {
    array_push($arrayX, $rowBook['hotel']);
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Admin Dashboard - Restaurant Management System
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <!-- CSS Files -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/paper-dashboard.css?v=2.0.0" rel="stylesheet" />
</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="white" data-active-color="danger">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
    -->
      <?php include 'assets/layouts/sidebar.php'; ?>
      <div class="main-panel">
      <!-- Navbar -->
      <?php include 'assets/layouts/nav.php'; ?>
      <div class="content">
        <div class="row">
          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <i class="nc-icon nc-single-02 text-info"></i>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">Current Active Users</p>
                      <p class="card-title"><?php echo $usercount; ?>
                        <p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <i class="fa fa-cutlery text-success"></i>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">Bookings Transacted</p>
                      <p class="card-title"><?php echo $traincount; ?>
                        <p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <i class="nc-icon nc-spaceship text-success"></i>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">Current Active Restaurants</p>
                      <p class="card-title"><?php echo count($arrayX); ?>
                        <p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card ">
              <div class="card-header ">
                <h5 class="card-title">Restaurants Popularity</h5>
                <p class="card-category">Top Restaurants</p>
              </div>
              <div class="card-body ">
                <canvas id=mycanvas width="400" height="100"></canvas>
              </div>
              <div class="card-footer ">
                <hr>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php include 'assets/layouts/footer.php'; ?>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="assets/js/core/jquery.min.js"></script>
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>
  <script src="assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chart JS -->
  <script src="assets/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="assets/js/paper-dashboard.min.js?v=2.0.0" type="text/javascript"></script>
  <!-- Paper Dashboard DEMO methods, don't include it in your project! -->
  <script src="assets/demo/demo.js"></script>
  <script>
  $(document).ready(function(){
  $.ajax({
    url: "http://254gamers1.softether.net/ela/admin/data.php",
    method: "GET",
    success: function(data) {
      console.log(data);
      var rest = [];
      var count = [];

      datax = JSON.parse(data);

      for (var i = 0; i < datax.length; i++) {
        rest.push(datax[i].hotel);
        count.push(datax[i].count);
      }

      var chartdata = {
        labels: rest,
        datasets : [
          {
            label: 'Bookings',
            backgroundColor: 'rgba(150, 20, 200, 0.75)',
            borderColor: 'rgba(200, 200, 200, 0.75)',
            hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
            hoverBorderColor: 'rgba(200, 200, 200, 1)',
            data: count
          }
        ]
      };

      var ctx = $("#mycanvas");

      var barGraph = new Chart(ctx, {
        type: 'bar',
        data: chartdata
      });
    },
    error: function(data) {
      console.log(data);
    }
  });
});
  </script>
</body>

</html>
