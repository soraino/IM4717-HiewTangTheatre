<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>HiewTang Theatre</title>
    <link rel="stylesheet" href="./css/main.css" />
    <link rel="icon" type="image/png" href="assets/logo/favicon.ico" />
</head>

<body>
    <?php
        session_start();
        $userId = $_COOKIE['userId'];
        $userData = $_SESSION["user".$userId];
        include "./navbar.php";
        @$DB = new mysqli('localhost', 'f34ee', 'f34ee', 'f34ee');
        $BOOKING_QUERY = "select B.PremiereDate, TIME_FORMAT(T.StartTime, '%h:%i %p') as StartTime, TH.Location, TH.Number, M.Name from f34ee.Booking as B inner join f34ee.Timeslot as T on T.id = B.TimeslotId inner join f34ee.Theatre as TH on TH.id = T.TheatreId inner join f34ee.MovieDetail as M on M.Id = T.MovieDetailId where B.Id = '".$_GET['bId']."' ;";
        $SEAT_NUMBER_QUERY = "select CONCAT(S.`Row`,'',S.`Column`) as seatNumber from f34ee.Seating as S inner join f34ee.Ticket as T on T.SeatId = S.Id where T.BookingId = '".$_GET['bId']."' ;";
        if(mysqli_connect_errno()){
            echo 'Error: Could not connect to database.';
            exit;
        }
        $bookingReults = $DB->query($BOOKING_QUERY);
        $seatNumberReults = $DB->query($SEAT_NUMBER_QUERY);
        $date;
        $startTime;
        $location;
        $theatreNumber;
        $movieName;
        $seatNumbers = array();
        if($bookingReults->num_rows > 0){
            $row = $bookingReults->fetch_assoc();
            $date=date_create($row['PremiereDate']);
            $startTime = $row['StartTime'];
            $location = $row['Location'];
            $theatreNumber = $row['Number'];
            $movieName = $row['Name'];
        }
        if($seatNumberReults->num_rows > 0){
            while($row = $seatNumberReults -> fetch_assoc()){
                array_push($seatNumbers, $row['seatNumber']);
            }
        }
    ?>
    <main class="container center-text" style="margin-top: 150px">
        <h2>YOUR BOOKING DETAILS</h2>
        <h2>
            You’ve booked ticket(s) for
            <span style="color: #ef8f00"><?php echo $movieName; ?></span>
        </h2>
        <h3>
            Reference ID: <?php echo $_GET['bId']; ?><br />
            Cinema: <?php echo $location; ?>, Theatre <?php echo $theatreNumber; ?> <br />
            Seat: <?php 
            for($i = 0 ; $i< count($seatNumbers); $i++){
                echo strtoupper($seatNumbers[$i]);
                if(count($seatNumbers) > 1 && $i < count($seatNumbers) -1 ){
                    echo ', ';
                }
            }
            ?><br />
            Date: <?php echo date_format($date,"d/m/Y"); ?><br />
            Time: <?php echo $startTime; ?><br />
        </h3>
        <br />
        <h2>
            Thank You for your purchase. <br />
            <br />An email containing your ticket and receipt will be sent
            to <?php echo $userData['Email'] ?>
        </h2>
        <br />
        <a href="./" class="button">Return to Home Page</a>
    </main>
    <footer class="footer">
        <div class="footer-content">
            <div class="container">
                <p>Copyright lol</p>
            </div>
        </div>
    </footer>
</body>

</html>