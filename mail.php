<!DOCTYPE html>
<html>

<body>

    <h1>Hello Mail</h1>

    <p>My first mail test.</p>

    <?php
    $sql_movieDetails = "select TS.*, MD.Name, T.Number from Timeslot TS join MovieDetail MD on TS.MovieDetailId = MD.Id join Theatre T on T.Id = TS.TheatreId where TS.Id = '" . $showtimeId . "'";
    $run_movieDetails = $db->query($sql_movieDetails);
    $result_movieDetails = $run_movieDetails->fetch_assoc();

    $to      = 'f34ee@localhost';
    $subject = "HiewTangTheatre - Booking Details";
    $message = "You’ve booked ticket(s) for " . $result_movieDetails['Name'] . "\r\n" . "\r\n" .
        "Reference ID: " . $currentId . "\r\n" .
        "Cinema: " . $location . ", Theatre " . $result_movieDetails['Number'] . "\r\n" .
        "Seat: " . $seats . "\r\n" .
        "Date: " . date_format($date, "d/m/Y") . "\r\n" .
        "Time: " . $result_movieDetails['StartTime'] . "\r\n" . "\r\n" .
        "Thank you for your purchase!";
    $headers = 'From: message@hiewtangtheatres.com';

    mail($to, $subject, $message, $headers, '-ff34ee@localhost');
    echo ("mail sent to : " . $to);
    ?>

</body>

</html>