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

$creditCardName = $_POST['creditCardName'];
$creditCardNumber = $_POST['creditCardNumber'];
$CVV = $_POST['cvv'];
$cardExpiry = $_POST['cardExpiry'];




$sql = "Update User SET Name='$name', Email='$email', PhoneNumber='$phone' where Id='$userId'";
$run = $db->query($sql);

if ($run) {
    $sql2 = "select CardNumber from CardHolder where UserId='$userId'";
    $run2 = $db->query($sql2);
    $result2 = $run2->fetch_assoc();
    $oldCardNumber = $result2['CardNumber'];

    if ($result2) {
        $sql3 = "Update Card SET CardNumber='$creditCardNumber', Name='$creditCardName', CVV='$CVV', ExpiryDate='$cardExpiry' where CardNumber='$oldCardNumber'";
        $run3 = $db->query($sql3);

        if ($run3) {
            if (isset($_POST['password'])) {
                $password = $_POST['password'];
                $sql_pwd = "Update User SET Password='$password' where Id='$userId'";
                $run_pwd =  $db->query($sql_pwd);

                if ($run_pwd) {
                    header('Location: profile.php?update=1');
                } else {
                    echo "Error 4: issue with updating password: " . $db->error;
                }
            } else {
                header('Location: profile.php?update=1');
            }
        } else {
            echo "Error 3: issue with updating Card: " . $db->error;
        }
    } else {
        echo "Error 2: issue with getting old card number: " . $db->error;
    }
} else {
    echo "Error 1: issue with updating User table: " . $db->error;
}

$db->close();
