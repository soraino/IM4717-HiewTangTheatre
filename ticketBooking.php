<?php

$db = new mysqli('localhost', 'f34ee', 'f34ee', 'f34ee');

if (mysqli_connect_errno()) {
    echo 'Error: Could not connect to database.';
    exit;
}

session_start();
$userId = $_COOKIE['userId'];
$userData = $_SESSION["user" . $userId];
$email = $userData['Email'];

$seatId_array = [];

$_SESSION['movieId'] = $_POST['movieId'];
$_SESSION['timeslotId'] = $_POST['showtimeId'];
$_SESSION['dateId'] = $_POST['date'];
$_SESSION['cinema'] = $_POST['location'];

// $_POST['subtotal'];
$qty = $_POST['qty'];
$seats = $_POST['seats'];

// $_POST['name'];
// $_POST['email'];
// $_POST['phone'];

// $_POST['cardName'];
$cardNo = $_POST['cardNo'];
// $_POST['expiry'];
// $_POST['cvv'];

// $_POST['movieId'];
// $_POST['genre'];
$location = $_POST['location'];
$date = $_POST['date'];
$showtimeId = $_POST['showtimeId'];

//SENDING MAIL
$sql_cardExist = "select COUNT(CardNumber) as sum from Card where CardNumber = '" . $cardNo . "'";
$run_cardExist = $db->query($sql_cardExist);
$result_cardExist = $run_cardExist->fetch_assoc();

if ($result_cardExist['sum'] > 0) {
    $sql_isUser = "select UserId from CardHolder where CardNumber = '" . $cardNo . "'";
    $run_isUser = $db->query($sql_isUser);
    $result_isUser = $run_isUser->fetch_assoc();

    if ($result_isUser['UserId'] == $userId) {

        $explodedSeats = explode(", ", $seats);

        for ($i = 0; $i < $qty; $i++) {
            ${"furtherExplode" . $i} = str_split($explodedSeats[$i], 1);
            $sql_seatId = "Select s.Id from Seating as s join Timeslot as t where s.Row = '" . ${"furtherExplode" . $i}[0] . "' and s.Column = '" . ${"furtherExplode" . $i}[1] . ${"furtherExplode" . $i}[2] . "' and t.Id = ' " . $showtimeId . "' and s.TheatreId = t.TheatreId";
            $run_seatId = $db->query($sql_seatId);
            $result_seatId = $run_seatId->fetch_assoc();
            array_push($seatId_array, $result_seatId['Id']);
        }

        $sql_booking = "insert into Booking (PremiereDate, TimeslotId, UserId) VALUES ('$date', '$showtimeId', '$userId')";
        $run_booking = $db->query($sql_booking);

        if ($run_booking) {
            $sql_currentId = "select Id FROM Booking where PremiereDate = '" . $date . "' and TimeslotId = '" . $showtimeId . "' and UserId = '" . $userId . "' ORDER BY Id DESC";
            $run_currentId = $db->query($sql_currentId);
            if ($run_currentId->num_rows > 0) {
                $result_currentId = $run_currentId->fetch_assoc();

                $currentId = $result_currentId['Id'];

                foreach ($seatId_array as $item) {
                    $sql_ticket = "insert into Ticket (SeatId, BookingId) VALUES ('$item', '$currentId')";
                    $run_ticket = $db->query($sql_ticket);
                }

                if ($run_ticket) {
                    echo "New record created successfully";

                    $sql_movieDetails = "select TS.*, MD.Name, T.Number from Timeslot TS join MovieDetail MD on TS.MovieDetailId = MD.Id join Theatre T on T.Id = TS.TheatreId where TS.Id = '" . $showtimeId . "'";
                    $run_movieDetails = $db->query($sql_movieDetails);
                    $result_movieDetails = $run_movieDetails->fetch_assoc();

                    $to      = 'f34ee@localhost';
                    $subject = "HiewTangTheatre - Booking Details";
                    $message = "You’ve booked ticket(s) for " . $result_movieDetails['Name'] . "\r\n" . "\r\n" .
                        "Reference ID: " . $currentId . "\r\n" .
                        "Cinema: " . $location . ", Theatre " . $result_movieDetails['Number'] . "\r\n" .
                        "Seat: " . $seats . "\r\n" .
                        "Date: " . $date . "\r\n" .
                        "Time: " . $result_movieDetails['StartTime'] . "\r\n" . "\r\n" .
                        "Thank you for your purchase!";
                    $headers = 'From: message@hiewtangtheatres.com';
                    mail($to, $subject, $message, $headers, '-ff34ee@localhost');
                    unset($_SESSION['movieId']);
                    unset($_SESSION['timeslotId']);
                    unset($_SESSION['dateId']);
                    unset($_SESSION['cinema']);
                    header('Location: myBooking.php?bId=' . urlencode($currentId));
                } else {
                    echo "Error: 1 " . $sql_currentId . "<br>" . $db->error;
                }
            } else {
                echo "Error: 2 " . $sql_currentId . "<br>" . $db->error;
            }
        } else {
            echo "Error: 3 " . $sql_booking . "<br>" . $db->error;
        }
    } else {
        echo "Card number provided doesnt match the user";
        header('Location: seating.php?carderror=1');
        exit;
    }
} else {
    $explodedSeats = explode(", ", $seats);

    for ($i = 0; $i < $qty; $i++) {
        ${"furtherExplode" . $i} = str_split($explodedSeats[$i], 1);
        $sql_seatId = "Select s.Id from Seating as s join Timeslot as t where s.Row = '" . ${"furtherExplode" . $i}[0] . "' and s.Column = '" . ${"furtherExplode" . $i}[1] . ${"furtherExplode" . $i}[2] . "' and t.Id = ' " . $showtimeId . "' and s.TheatreId = t.TheatreId";
        $run_seatId = $db->query($sql_seatId);
        $result_seatId = $run_seatId->fetch_assoc();
        array_push($seatId_array, $result_seatId['Id']);
    }

    $sql_booking = "insert into Booking (PremiereDate, TimeslotId, UserId) VALUES ('$date', '$showtimeId', '$userId')";
    $run_booking = $db->query($sql_booking);

    if ($run_booking) {
        $sql_currentId = "select Id FROM Booking where PremiereDate = '" . $date . "' and TimeslotId = '" . $showtimeId . "' and UserId = '" . $userId . "' ORDER BY Id DESC";
        $run_currentId = $db->query($sql_currentId);
        if ($run_currentId->num_rows > 0) {
            $result_currentId = $run_currentId->fetch_assoc();

            $currentId = $result_currentId['Id'];

            foreach ($seatId_array as $item) {
                $sql_ticket = "insert into Ticket (SeatId, BookingId) VALUES ('$item', '$currentId')";
                $run_ticket = $db->query($sql_ticket);
            }

            if ($run_ticket) {
                echo "New record created successfully";
                mail($to, $subject, $message, $headers, '-ff34ee@localhost');
                unset($_SESSION['movieId']);
                unset($_SESSION['timeslotId']);
                unset($_SESSION['dateId']);
                unset($_SESSION['cinema']);
                header('Location: myBooking.php?bId=' . urlencode($currentId));
            } else {
                echo "Error: 1 " . $sql_currentId . "<br>" . $db->error;
            }
        } else {
            echo "Error: 2 " . $sql_currentId . "<br>" . $db->error;
        }
    } else {
        echo "Error: 3 " . $sql_booking . "<br>" . $db->error;
    }
}


$db->close();
