<?php
include "./dbconnect.php";
if(!isset($_POST['email']) || !isset($_POST['password']) 
|| !isset($_POST['confirmPassword'])|| !isset($_POST['name'])
|| !isset($_POST['phone'])|| !isset($_POST['creditCardName'])
|| !isset($_POST['creditCardNumber'])|| !isset($_POST['ccv'])
|| !isset($_POST['cardExpiry'])){
    $DB->close();
    die('Unexpected error has occured <a href="./">Return to home</a>');
}
if($_POST['password'] != $_POST['confirmPassword']){
    $DB->close();
    ?>
<script>
alert("Password and Confirm Password are not the same.")
window.location.replace('./login.html')
</script>
<?php
}
$DbValidation = true;
$QUERY_EMAIL = "SELECT Email FROM f34ee.User WHERE Email = '".trim($_POST['email'])."';";
$QUERY_PHONENUMBER = "SELECT PhoneNumber FROM f34ee.User WHERE Email = '".trim($_POST['phone'])."';";
$QUERY_CARDNUMBER = "SELECT CardNumber FROM f34ee.Card WHERE CardNumber = '".trim($_POST['creditCardNumber'])."';";

$emailResults = $DB->query($QUERY_EMAIL);
$phoneNumberResults = $DB->query($QUERY_PHONENUMBER);
$cardNumberResults = $DB->query($QUERY_CARDNUMBER);

// Validation
if($emailResults->num_row > 0){
    $DbValidation = false;
    ?>
<script>
alert('Email already exist.');
</script>
<?php
}
if($phoneNumberResults->num_row > 0){
    $DbValidation = false;
    ?>
<script>
alert('Phone number has been use.');
</script>
<?php
}
if($cardNumberResults->num_row > 0){
    $DbValidation = false;
    ?>
<script>
alert('Card Number is already in use.');
</script>
<?php
}

$emailResults -> free();
$phoneNumberResults -> free();
$cardNumberResults -> free();


if(!$DbValidation){
    $DB -> close();
    ?>
<script>
// window.location.replace('./register.html');
</script>
<?php
}
// end of validation

$INSERT_USER_QUERY = "INSERT INTO f34ee.User( Name, Email, PhoneNumber, Password) VALUES ('".trim($_POST['name'])."','".trim(urldecode($_POST['email']))."','".$_POST['phone']."','".md5(utf8_decode(urldecode($_POST['password'])))."');";
$INSERT_CARD_QUERY = "INSERT INTO  f34ee.Card ( CardNumber , Name , CCV , ExpiryDate ) VALUES ('".trim($_POST['creditCardNumber'])."','".trim($_POST['creditCardName'])."','".trim($_POST['ccv'])."','".trim(urldecode($_POST['cardExpiry']))."');";
$NEW_USER_ID = "SELECT Id FROM f34ee.User WHERE Email = '".trim(urldecode($_POST['email']))."';";

//INSER USER
$userInsertResult = $DB->query($INSERT_USER_QUERY);
if ($userInsertResult){
    //INSERT CREIT CARD
    $cardInsertResult = $DB->query($INSERT_CARD_QUERY);
    if($cardInsertResult){
        //RETRIEVE ID OF NEW USER
        $userIdResult = $DB->query($NEW_USER_ID);
        if($userIdResult->num_rows > 0){
            $id = $userIdResult->fetch_assoc()['Id'];
            $INSERT_CARD_HOLDER_QUERY = "INSERT INTO `CardHolder`(`UserId`, `CardNumber`) VALUES ('".$id."','".$_POST['creditCardNumber']."');";
            //INSER CARD HOLDER
            $cardHolderResult = $DB->query($INSERT_CARD_HOLDER_QUERY);
            if($cardHolderResult){
                $userData = array(
                    'Id' => $id,
                    'PhoneNumber' => $_POST['phone'],
                    'Name' => $_POST['Nnameame'],
                );
                session_start();
                setcookie($name = 'userId', $value = $id, $expire = time()+ (3600*24*7), $path = "", $domain = "", $secure = false, $httponly = false);
                $_SESSION[$id] = $userData;
                header('location: index.php');
            }else{
                echo 'Unexpected error has occured <a href="./">Return to home</a>';
            }
        }
    }else{
        echo 'Unexpected error has occured <a href="./">Return to home</a>';
    }
    
}else{
    echo 'Unexpected error has occured <a href="./">Return to home</a>';
}

?>