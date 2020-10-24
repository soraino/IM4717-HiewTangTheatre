<?php
session_start();

$db = new mysqli('localhost', 'f34ee', 'f34ee', 'f34ee');

if (mysqli_connect_errno()) {
    echo 'Error: Could not connect to database.';
    exit;
}

if (isset($_GET['update'])) {
?>
    <script>
        alert("Profile updated successfully");
    </script>
<?php
}

$userId = $_COOKIE["userId"];

$sql_profile = "select U.*, C.Name as CardName, C.CardNumber, C.CVV, C.ExpiryDate from User U join CardHolder CH on U.Id = CH.UserId join Card C on CH.CardNumber = C.CardNumber where Id = '" . $userId . "'";
$run_profile = $db->query($sql_profile);
$result_profile = $run_profile->fetch_assoc();

if (isset($_COOKIE["userId"])) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HiewTang Theatre</title>
        <link rel="stylesheet" href="./css/main.css" />
        <link rel="stylesheet" href="./css/profile.css" />
    </head>

    <style>
        #confirmPassword,
        #labelCfmPwd {
            display: none;
        }
    </style>

    <body>
        <?php include "./navbar.php"; ?>
        <main class="container">
            <form action="updateProfile.php" method="POST">
                <h3>My Profile Details</h3>
                <div class="row profile-details">
                    <div class="col size-3">
                        <p><label for="name">Name: </label></p>
                        <p><label for="email">Email: </label></p>
                        <p><label for="phone">Phone Number: </label></p>
                        <p><label for="password">Password: </label></p>
                        <p><label for="confirmPassword" id="labelCfmPwd">Confirmed Password: </label></p>
                    </div>
                    <div class="col size-3">
                        <input type="hidden" name="userId" value="<?php echo $userId ?>">
                        <p><input type="text" id="name" name="name" value="<?php echo $result_profile['Name'] ?>" placeholder="John Doe" required></p>
                        <p><input type="text" id="email" name="email" value="<?php echo $result_profile['Email'] ?>" placeholder="email@domain.com" required></p>
                        <p><input type="text" id="phone" name="phone" value="<?php echo $result_profile['PhoneNumber'] ?>" minlength="8" maxlength="8" placeholder="87651906" pattern="\d{8}" title="Please enter proper Singapore phone number" required></p>
                        <p><input type="password" id="password" name="password" value="<?php echo $result_profile['Password'] ?>" placeholder="Password" disabled required><small id="small" onclick="changePwd()" style="font-style: italic; float:right; text-decoration: underline;">Change password</small></p>
                        <div id="message">
                            <h4>Password must contain the following:</h4>
                            <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
                            <p id="capital" class="invalid">
                                A <b>capital (uppercase)</b> letter
                            </p>
                            <p id="number" class="invalid">A <b>number</b></p>
                            <p id="length" class="invalid">
                                Minimum <b>8 characters</b>
                            </p>
                        </div>
                        <p><input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" disabled required /></p>
                        <div id="message2">
                            <p id="conf" class="invalid">
                                Confirm Password must be the same as <b>Password</b>
                            </p>
                        </div>
                    </div>
                </div>
                <h3>My Payment Details</h3>
                <div class="row payment-details">
                    <div class="col size-3">
                        <p><label for="creditCardName">Name on Credit Card: </label></p>
                        <p><label for="creditCardNumber">Credit Card Number: </label></p>
                        <p><label for="cvv">CVV/CVC: </label></p>
                        <p><label for="cardExpiry">Card Expiry: </label></p>
                    </div>
                    <div class="col size-3">
                        <p><input type="text" id="creditCardName" name="creditCardName" value="<?php echo $result_profile['CardName'] ?>" placeholder="John Doe" required></p>
                        <p><input type="text" id="creditCardNumber" name="creditCardNumber" value="<?php echo $result_profile['CardNumber'] ?>" minlength="16" maxlength="16" pattern="\d{16}" title="Please enter proper credit card number" placeholder="1234123412341234" required></p>
                        <p><input type="text" id="cvv" name="cvv" value="<?php echo $result_profile['CVV'] ?>" minlength="3" maxlength="3" pattern="\d{3}" title="Please enter proper cvv/cvc" placeholder="123" required></p>
                        <p><input type="text" id="cardExpiry" name="cardExpiry" value="<?php echo $result_profile['ExpiryDate'] ?>" minlength="5" maxlength="5" placeholder="MM/YY" pattern="^(0[1-9]|1[0-2])\/?([0-9]{4}|[0-9]{2})$" title="Please enter proper card expiry" required></p>
                    </div>
                </div>
                <div class="row float-right">
                    <div class="col size-3">
                        <input type="submit" value="Save">
                    </div>
                </div>
            </form>
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

    <script>
        function changePwd() {
            document.getElementById("password").disabled = false;
            document.getElementById("password").value = "";
            document.getElementById("confirmPassword").disabled = false;
            document.getElementById("confirmPassword").style.display = "block";
            document.getElementById("labelCfmPwd").style.display = "block";
            document.getElementById("small").style.display = "none";
        }

        let passwordConf = false;
        let expiryConf = false;
        var passwordInput = document.getElementById("password");
        var confPasswordInput = document.getElementById("confirmPassword");
        var cardExpiryInput = document.getElementById("cardExpiry");
        var letter = document.getElementById("letter");
        var capital = document.getElementById("capital");
        var number = document.getElementById("number");
        var length = document.getElementById("length");
        var conf = document.getElementById("conf");

        // When the user clicks on the password field, show the message box
        passwordInput.onfocus = function() {
            document.getElementById("message").style.display = "block";
        };
        confPasswordInput.onfocus = function() {
            document.getElementById("message2").style.display = "block";
        };

        // When the user clicks outside of the password field, hide the message box
        passwordInput.onblur = function() {
            document.getElementById("message").style.display = "none";
        };
        confPasswordInput.onblur = function() {
            document.getElementById("message2").style.display = "none";
        };
        confPasswordInput.onkeyup = function() {
            if (passwordInput.value == confPasswordInput.value) {
                passwordConf = true;
                conf.classList.remove("invalid");
                conf.classList.add("valid");
            } else {
                passwordConf = false;
                conf.classList.remove("valid");
                conf.classList.add("invalid");
            }
        };
        // When the user starts to type something inside the password field
        passwordInput.onkeyup = function() {
            // Validate lowercase letters
            var lowerCaseLetters = /[a-z]/g;
            if (passwordInput.value.match(lowerCaseLetters)) {
                letter.classList.remove("invalid");
                letter.classList.add("valid");
            } else {
                letter.classList.remove("valid");
                letter.classList.add("invalid");
            }

            // Validate capital letters
            var upperCaseLetters = /[A-Z]/g;
            if (passwordInput.value.match(upperCaseLetters)) {
                capital.classList.remove("invalid");
                capital.classList.add("valid");
            } else {
                capital.classList.remove("valid");
                capital.classList.add("invalid");
            }

            // Validate numbers
            var numbers = /[0-9]/g;
            if (passwordInput.value.match(numbers)) {
                number.classList.remove("invalid");
                number.classList.add("valid");
            } else {
                number.classList.remove("valid");
                number.classList.add("invalid");
            }

            // Validate length
            if (passwordInput.value.length >= 8) {
                length.classList.remove("invalid");
                length.classList.add("valid");
            } else {
                length.classList.remove("valid");
                length.classList.add("invalid");
            }
        };

        cardExpiryInput.onkeyup = function() {
            const dates = cardExpiryInput.value.split("/");
            const currDate = new Date();

            if (
                parseInt(dates[1]) > currDate.getFullYear() - 2000 ||
                (currDate.getFullYear() - 2000 == parseInt(dates[1]) &&
                    parseInt(dates[0]) >= currDate.getMonth() + 1)
            ) {
                expiryConf = true;
            } else {
                expiryConf = false;
            }
        };

        document.querySelector("form").addEventListener("submit", (e) => {
            if (!passwordConf) {
                alert("Password and Confirm Password don't match");
                e.preventDefault();
            }
            if (!expiryConf) {
                alert("Expiry date has been reached");
                e.preventDefault();
            }
        });
    </script>


<?php

    $db->close();
} else {
    header("Location: index.php");
}
?>