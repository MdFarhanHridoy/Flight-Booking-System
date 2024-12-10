<?php include_once 'helpers/helper.php'; ?>
<?php subview('header.php'); ?>
<style>
body {
  background: transparent; 
}
@font-face {
  font-family: 'product sans';
  src: url('assets/css/Product Sans Bold.ttf');
}
h2.brand {
    /* font-style: italic; */
    font-size: 27px !important;
}
.vl {
  border-left: 6px solid #424242;
  height: 400px;
}
p.head {
    text-transform: uppercase;
    font-family: arial;
    font-size: 17px;
    margin-bottom: 10px ;
    color: grey;  
}
p.txt {
    text-transform: uppercase;
    font-family: arial;
    font-size: 25px;
    font-weight: bolder;
}
.out {
    border-top-left-radius: 25px;
    border-bottom-left-radius: 25px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);  
    background-color: white;
    padding-left: 25px;
    padding-right: 0px;
    padding-top: 20px;
}
h2 {
    font-weight: lighter !important;
    font-size: 35px !important;
    margin-bottom: 20px;  
    font-family :'product sans' !important;
    font-weight: bolder;
}
.text-light2 {
    color: #d9d9d9;
}
h3 {
    /* font-weight: lighter !important; */
    font-size: 21px !important;
    margin-bottom: 20px;  
    font-family: Tahoma, sans-serif;
    font-weight: lighter;
}
h1 {
    font-weight: lighter !important;
    font-size: 45px !important;
    margin-bottom: 20px;  
    font-family :'product sans' !important;
    font-weight: bolder;
  }
</style>
<main>
  <?php if(isset($_SESSION['userId'])) {   
    require 'helpers/init_conn_db.php';   
    
    if(isset($_POST['cancel_but'])) {
        $ticket_id = $_POST['ticket_id'];
        $stmt = mysqli_stmt_init($conn);
        $sql = 'SELECT * FROM Ticket WHERE ticket_id=?';
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)) {
            header('Location: ticket.php?error=sqlerror');
            exit();            
        } else {
            mysqli_stmt_bind_param($stmt,'i',$ticket_id);            
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {   
              $sql_pas = 'DELETE FROM Passenger_profile WHERE passenger_id=? 
                ';
              $stmt_pas = mysqli_stmt_init($conn);
              if(!mysqli_stmt_prepare($stmt_pas,$sql_pas)) {
                  header('Location: ticket.php?error=sqlerror');
                  exit();            
              } else {
                  mysqli_stmt_bind_param($stmt_pas,'i',$row['passenger_id']);            
                  mysqli_stmt_execute($stmt_pas);
               
              }              
            }
        }        
    }
    
    ?>     
    <div class="container mb-5"> 
    <h1 class="text-center mt-4 mb-4">E-TICKETS</h1>

      <?php 
        $stmt = mysqli_stmt_init($conn);
        $sql = 'SELECT T.*, P.*, F.*
                FROM Ticket AS T
                JOIN Passenger_profile AS P ON T.passenger_id = P.passenger_id
                JOIN Flight AS F ON T.flight_id = F.flight_id
                WHERE T.user_id = ?;';
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header('Location: ticket.php?error=sqlerror');
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, 'i', $_SESSION['userId']);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            while ($row = mysqli_fetch_assoc($result)) {
                $date_time_dep = $row['departure'];
                $date_dep = substr($date_time_dep, 0, 10);
                $time_dep = substr($date_time_dep, 10, 6);
                $date_time_arr = $row['arrivale'];
                $date_arr = substr($date_time_arr, 0, 10);
                $time_arr = substr($date_time_arr, 10, 6);

                if ($row['class'] === 'E') {
                    $class_txt = 'ECONOMY';
                } else if ($row['class'] === 'B') {
                    $class_txt = 'BUSINESS';
                }
            
                        echo '
                        <div class="row mb-5">                                                         
                        <div class="col-8 out">
                            <div class="row ">                                                    
                                <div class="col">
                                    <h2 class="text-secondary mb-0 brand">
                                        Online Flight Booking</h2> 
                                </div>
                                <div class="col">
                                    <h2 class="mb-0">'.$class_txt.' CLASS</h2>
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">  
                                <div class="col-4">
                                    <p class="head">Airline</p>
                                    <p class="txt">'.$row['airline'].'</p>
                                </div>            
                                <div class="col-4">
                                    <p class="head">from</p>
                                    <p class="txt">'.$row['source'].'</p>
                                </div>
                                <div class="col-4">
                                    <p class="head">to</p>
                                    <p class="txt">'.$row['Destination'].'</p>                
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-8">
                                    <p class="head">Passenger</p>
                                    <p class=" h5 text-uppercase">
                                    '.$row['f_name'].' '.$row['m_name'].' '.$row['l_name'].'
                                    </p>                              
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <p class="head">departure</p>
                                    <p class="txt mb-1">'.$date_dep.'</p>
                                    <p class="h1 font-weight-bold mb-3">'.$time_dep.'</p>  
                                </div>            
                                <div class="col-3">
                                    <p class="head">arrival</p>
                                    <p class="txt mb-1">'.$date_arr.'</p>
                                    <p class="h1 font-weight-bold mb-3">'.$time_arr.'</p>  
                                </div>
                                <div class="col-3">
                                    <p class="head">gate</p>
                                    <p class="txt">A22</p>
                                </div>            
                                <div class="col-3">
                                    <p class="head">seat</p>
                                    <p class="txt">'.$row['seat_no'].'</p>
                                </div>                
                            </div>                    
                        </div>
                        <div class="col-3 pl-0" style="background-color:#376b8d !important;
                            padding:20px; border-top-right-radius: 25px; border-bottom-right-radius: 25px;">
                            <div class="row">  
                                <div class="col">                                    
                                <h2 class="text-light text-center brand">
                                    DREAM AIR</h2> 
                                </div>                                      
                            </div>                             
                            <div class="row justify-content-center">
                                <div class="col-12">                                    
                                    <img src="assets/images/plane-logo.png" class="mx-auto d-block"
                                    height="200px" width="200px" alt="">
                                </div>                                
                            </div>                         
                        </div>   
                        
                        <div class="col-1">
                            <div class="dropdown">
                                <a class="text-reset text-decoration-none" href="#" 
                                    id="dropdownMenuButton" data-toggle="dropdown" 
                                    aria-haspopup="true" aria-expanded="false">
                                    
                                    <i class="fa fa-ellipsis-v"></i> </td>
                                </a>  
                                <div class="dropdown-menu">
                                    <form class="px-4 py-3"  action="ticket.php" 
                                        method="post">
                                        <input type="hidden" name="ticket_id" 
                                            value='.$row['ticket_id'].'>
                                        <button class="btn btn-danger btn-sm"
                                            name="cancel_but">
                                            <i class="fa fa-trash"></i> &nbsp; Cancel Ticket</button>
                                    </form>                                  
                                </div>
                            </div>              
                        </div>                          
                        </div>                                               
                      ' ;                                  
          }
      }   
      
       ?> 

    </div>
  </main>
  <?php } ?>
  <?php subview('footer.php'); ?> 