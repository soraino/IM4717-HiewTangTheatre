<?php
$db = new mysqli('localhost', 'f34ee', 'f34ee', 'f34ee');

if (mysqli_connect_errno()) {
    echo 'Error: Could not connect to database.';
    exit;
}

$userId = $_POST['userId'];
$email_hidden = $_POST['email_hidden'];
$phone_hidden = $_POST['phone_hidden'];
$cardNum_hidden = $_POST['cardNum_hidden'];

$name = $_POST['name'];
$email = strtolower(trim(utf8_decode(urldecode($_POST['email']))));
$phone = $_POST['phone'];

$password = md5(utf8_decode(urldecode($_POST['password'])));

$creditCardName = $_POST['creditCardName'];
$creditCardNumber = $_POST['creditCardNumber'];
$CVV = $_POST['cvv'];
$cardExpiry = $_POST['cardExpiry'];

$DbValidation = true;

$QUERY_EMAIL = "SELECT Email FROM f34ee.User WHERE Email = '" . trim($_POST['email']) . "';";
$QUERY_PHONENUMBER = "SELECT PhoneNumber FROM f34ee.User WHERE PhoneNumber = '" . trim($_POST['phone']) . "';";
$QUERY_CARDNUMBER = "SELECT CardNumber FROM f34ee.Card WHERE CardNumber = '" . trim($_POST['creditCardNumber']) . "';";

$emailResults = $db->query($QUERY_EMAIL);
$phoneNumberResults = $db->query($QUERY_PHONENUMBER);
$cardNumberResults = $db->query($QUERY_CARDNUMBER);

if ($emailResults->num_row > 0 && $email != $email_hidden) {
    $DbValidation = false;
?>
    <script>
        alert('Email already exist.');
    </script>
<?php
}
if ($phoneNumberResults->num_row > 0 && $phone != $phone_hidden) {
    $DbValidation = false;
?>
    <script>
        alert('Phone number has been use.');
    </script>
<?php
}
if ($cardNumberResults->num_row > 0 &&  $creditCardNumber != $cardNum_hidden) {
    $DbValidation = false;
?>
    <script>
        alert('Card Number is already in use.');
    </script>
<?php
}

$emailResults->free();
$phoneNumberResults->free();
$cardNumberResults->free();

if (!$DbValidation) {
    $db->close();
?>
    <script>
        window.history.back();
    </script>
<?php
} else {
    $sql = "Update User SET Name='$name', Email='$email', PhoneNumber='$phone' where Id='$userId'";
    $run = $db->query($sql);

    if ($run) {
        $sql3 = "Update Card SET CardNumber='$creditCardNumber', Name='$creditCardName', CVV='$CVV', ExpiryDate='$cardExpiry' where CardNumber='$cardNum_hidden'";
        $run3 = $db->query($sql3);

        if ($run3) {
            if (isset($_POST['password'])) {
                $sql_pwd = "Update User SET Password='$password' where Id='$userId'";
                $run_pwd =  $db->query($sql_pwd);

                if ($run_pwd) {
                    echo "<script>
                        alert('Profile updated successfully');
                        window.location.href='profile.php';
                        </script>";
                } else {
                    // echo "Error 4: issue with updating password: " . $db->error;
                    echo "<script>
                        alert('Error updating new password');
                        window.location.href='profile.php';
                        </script>";
                }
            } else {
                echo "<script>
                    alert('Profile updated successfully');
                    window.location.href='profile.php';
                    </script>";
            }
        } else {
            // echo "Error 3: issue with updating Card: " . $db->error;
            echo "<script>
                alert('Error updating Credit Card Details');
                window.location.href='profile.php';
                </script>";
        }
    } else {
        echo "<script>
            alert('Error updating');
            window.location.href='profile.php';
            </script>";
    }
}

$db->close();
