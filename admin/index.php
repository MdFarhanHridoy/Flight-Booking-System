<?php include_once 'header.php'; 
require '../helpers/init_conn_db.php';?>

<link rel="stylesheet" href="../assets/css/admin.css">
<link href="https://fonts.googleapis.com/css2?family=Assistant:wght@200;300&family=Poiret+One&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Cinzel&display=swap" rel="stylesheet">
<style>
  body {
    /* background-color: #B0E2FF; */
    background-color: #efefef;
  }
  td {
    /* font-family: 'Assistant', sans-serif !important; */
    font-size: 18px !important;
  }
  p {
  font-size: 35px;
  font-weight: 100;
  font-family: 'product sans';  
  }  

  .main-section{
	width:100%;
	margin:0 auto;
	text-align: center;
	padding: 0px 5px;
}
.dashbord{
	width:23%;
	display: inline-block;
	background-color:#34495E;
	color:#fff;
	margin-top: 50px; 
}
.icon-section i{
	font-size: 30px;
	padding:10px;
	border:1px solid #fff;
	border-radius:50%;
	margin-top:-25px;
	margin-bottom: 10px;
	background-color:#34495E;
}
.icon-section p{
	margin:0px;
	font-size: 20px;
	padding-bottom: 10px;
}
.detail-section{
	background-color: #2F4254;
	padding: 5px 0px;
}
.dashbord .detail-section:hover{
	background-color: #5a5a5a;
	cursor: pointer;
}
.detail-section a{
	color:#fff;
	text-decoration: none;
}
.dashbord-2 .icon-section,.dashbord-2 .icon-section i{
	background-color: #9CB4CC;
}
.dashbord-2 .detail-section{
	background-color: #149077;
}

.dashbord-1 .icon-section,.dashbord-1 .icon-section i{
	background-color: #2980B9;
}
.dashbord-1 .detail-section{
	background-color:#2573A6;
}
.dashbord-3 .icon-section,.dashbord-3 .icon-section i{
	background-color:#316B83;
}
.dashbord-3 .detail-section{
	background-color:#CF4436;
}
  
</style>
    <main>
        <?php if(isset($_SESSION['adminId'])) { ?>
          <div class="container">

            <div class="main-section">
              <div class="dashbord dashbord-1">
                <div class="icon-section">
                  <i class="fa fa-users" aria-hidden="true"></i><br>
                 Total Passengers
                  <p><?php include 'psngrcnt.php';?></p>
                </div>
               
              </div>
 
              <div class="dashbord dashbord-3">
                <div class="icon-section">
                  <i class="fa fa-plane" aria-hidden="true"></i><br>
                 Flights
                  <p><?php include 'flightscnt.php';?></p>
                </div>
               
              </div>     
              
              <div class="dashbord">
                <div class="icon-section">
                  <i class="fa fa-plane fa-rotate-180" aria-hidden="true"></i><br>
                 Available Airlines
                  <p><?php include 'airlcnt.php';?></p>
                </div>
               
              </div>  
              
            </div>

			
          <div class="card mt-4" id="flight">
      <div class="card-body">       
        <p class="text-secondary">Today's Flights</p>
        <table class="table-sm table table-hover table-bordered">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Arrival</th>
              <th scope="col">Departure</th>
              <th scope="col">Destination</th>
              <th scope="col">Source</th>
              <th scope="col">Airlines</th>
            </tr>
          </thead>
          <tbody>              
              <?php
                $curr_date = (string)date('y-m-d');
                $curr_date = '20'.$curr_date;
                $sql = "SELECT * FROM Flight WHERE DATE(departure)=?";
                $stmt = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt,$sql);
                mysqli_stmt_bind_param($stmt,'s',$curr_date);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                while ($row = mysqli_fetch_assoc($result)) {
                  if($row['status']== '') {
                    echo '     
                <td>'.$row['flight_id'].'</td>
                <td>'.$row['arrivale'].'</td>
                <td>'.$row['departure'].'</td>
                <td>'.$row['Destination'].'</td>
                <td>'.$row['source'].'</td>
                <td>'.$row['airline'].'</td> 
               
              </tr> ' ; }} ?>
          </tbody>
        </table>        
      
      </div>
    </div>


<?php } ?>
    </main>
    <?php include_once 'footer.php'; ?>
