<?php
include "./dbconnect.php";
if(!isset($_POST['email']) || !isset($_POST['password'])){
    die('Unexpected error has occured');
}
$email = strtolower(trim(utf8_decode(urldecode($_POST['email']))));
$password = md5(utf8_decode(urldecode($_POST['password'])));

$LOGIN_USER_QUERY = "SELECT Id, Name, PhoneNumber FROM f34ee.User WHERE Email = '$email' and Password = '$password';";

$loginResult = $DB->query($LOGIN_USER_QUERY);

if($loginResult->num_rows){
    $row = $loginResult->fetch_assoc();
    $userData = array(
        Id => $row['Id'],
        PhoneNumber => $row['PhoneNumber'],
        Name => $row['Name'],
    );
    session_start();
    setcookie($name = 'userId', $value = $row['Id'], $expire = time()+ (3600*24*7), $path = "", $domain = "", $secure = false, $httponly = false);
    $_SESSION[$row['Id']] = $userData;
    $DB->close();
    $loginResult -> free();
?>
    <script>
        window.location.replace('./')
    </script>
<?php
}else{
    $DB->close();
    $loginResult -> free();
?>
    <script>
        window.location.replace('./login.html')
    </script>
<?php
}

?>