<?php
$db = new mysqli('localhost', 'f34ee', 'f34ee', 'f34ee');

if (mysqli_connect_errno()) {
    echo 'Error: Could not connect to database.';
    exit;
}

$userId = $_POST['userId'];

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$password = $_POST['password'];

$sql = "Update User SET Name='$name', Email='$email', PhoneNumber='$phone' where Id='$userId'";
$run = $db->query($sql);

if ($run === TRUE) {
    echo "Record updated successfully";
    header("Location: profile.php?update=1");
} else {
    echo "Error updating record: " . $db->error;
}

$db->close();
