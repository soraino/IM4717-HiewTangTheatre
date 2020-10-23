<?php

$db = new mysqli('localhost', 'f34ee', 'f34ee', 'f34ee');

if (mysqli_connect_errno()) {
    echo 'Error: Could not connect to database.';
    exit;
}

session_start();
$userId = $_COOKIE['userId'];
$seatId_array = [];

// $_POST['subtotal'];
$qty = $_POST['qty'];
$seats = $_POST['seats'];

// $_POST['name'];
// $_POST['email'];
// $_POST['phone'];

// $_POST['cardName'];
// $_POST['cardNo'];
// $_POST['expiry'];
// $_POST['cvv'];

// $_POST['movieId'];
// $_POST['genre'];
// $_POST['location'];
$date = $_POST['date'];
$showtimeId = $_POST['showtimeId'];

$sql_currentId = "SELECT Id FROM Booking ORDER BY Id DESC LIMIT 1";
$run_currentId = $db->query($sql_currentId);
$result_currentId = $run_currentId->num_rows;

$currentId = $result_currentId + 1;

$explodedSeats = explode(", ", $seats);

for ($i = 0; $i < $qty; $i++) {
    ${"furtherExplode" . $i} = str_split($explodedSeats[$i], 1);
    $sql_seatId = "Select s.Id from Seating as s join Timeslot as t where s.Row = '" . ${"furtherExplode" . $i}[0] . "' and s.Column = '" . ${"furtherExplode" . $i}[1] . ${"furtherExplode" . $i}[2] . "' and t.Id = ' " . $showtimeId . "' and s.TheatreId = t.TheatreId";
    $run_seatId = $db->query($sql_seatId);
    $result_seatId = $run_seatId->fetch_assoc();
    array_push($seatId_array, $result_seatId['Id']);
}

if ($result_currentId = 0) {
    $sql_booking = "insert into Booking (Id, PremiereDate, TimeslotId, UserId) VALUES ('1', '$date', '$showtimeId', '$userId')";
    $run_booking = $db->query($sql_booking);
    foreach ($seatId_array as $item) {
        $sql_ticket = "insert into Ticket (SeatId, BookingId) VALUES ('$item', '1')";
        $run_ticket = $db->query($sql_ticket);
    }
} else {
    $sql_booking = "INSERT INTO Booking (Id, PremiereDate, TimeslotId, UserId) VALUES ('$currentId', '$date', '$showtimeId', '$userId')";
    $run_booking = $db->query($sql_booking);
    foreach ($seatId_array as $item) {
        $sql_ticket = "INSERT INTO Ticket (SeatId, BookingId) VALUES ('$item', '$currentId')";
        $run_ticket = $db->query($sql_ticket);
    }
}

if ($run_booking === TRUE && $run_ticket === TRUE) {
    echo "New record created successfully";
    header('Location: receipt.php');
} else {
    echo "Error: " . $sql . "<br>" . $db->error;
}

$db->close();
