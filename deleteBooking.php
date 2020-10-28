<?php
include "./dbconnect.php";
if(!isset($_POST['bId'])){
    $DB->close();
    die('Unexpected error has occured <a href="./">Return to home</a>');
}
$bId = $_POST['bId'];
$DELETE_TICKET_QUERY = "DELETE FROM f34ee.Ticket WHERE BookingId = '".$bId."';";
$DELETE_BOOKING_QUERY = "DELETE FROM f34ee.Booking WHERE Id = '".$bId."';";

$DB->query($DELETE_TICKET_QUERY);

if($DB->affected_rows > 0){
    $DB->query($DELETE_BOOKING_QUERY);
    if($DB->affected_rows > 0){ 
        header('location: myBooking.php');
    }
}else{
    echo $DELETE_TICKET_QUERY."<br>";
    echo $DELETE_BOOKING_QUERY;
    $DB->close();
    die('Unexpected error has occured <a href="./">Return to home</a>');
}

?>