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
        /* The Modal (background) */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        #confirmPassword,
        #labelCfmPwd {
            display: none;
        }
    </style>

    <body>
        <?php include "./navbar.php"; ?>
        <div id="myModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <h4>Upload new profile picture</h4>
                <form action="upload.php" method="post" enctype="multipart/form-data">
                    Select image to upload:
                    <input type="hidden" name="userId" value="<?php echo $userId ?>">
                    <input type="file" name="fileToUpload" id="fileToUpload">
                    <input type="submit" value="Upload Image" name="submit">
                </form>
            </div>

        </div>
        <main class="container">
            <div class="row profile-img">
                <div class="col size-1">
                    <img id="profilePic" src="./assets/user.png" alt="profile picture">
                    <span id="myBtn">Edit</span>
                </div>
                <div class="col size-5">
                    <h2 style=" text-align: center; margin-top: 50px;"><?php echo $result_profile['Name'] ?></h2>
                </div>
            </div>
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
                        <p><input type="text" id="name" name="name" value="<?php echo $result_profile['Name'] ?>" required></p>
                        <p><input type="text" id="email" name="email" value="<?php echo $result_profile['Email'] ?>" required></p>
                        <p><input type="text" id="phone" name="phone" value="<?php echo $result_profile['PhoneNumber'] ?>" minlength="8" maxlength="8" pattern="\d{8}" title="Please enter proper singaporean phone number" required></p>
                        <p><input type="password" id="password" name="password" value="<?php echo $result_profile['Password'] ?>" placeholder="Password" disabled required><small id="small" onclick="changePwd()" style="font-style: italic; float:right; text-decoration: underline;">Change password</small></p>
                        <p><input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required /></p>
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
                        <p><input type="text" id="creditCardName" name="creditCardName" value="<?php echo $result_profile['CardName'] ?>" required></p>
                        <p><input type="text" id="creditCardNumber" name="creditCardNumber" value="<?php echo $result_profile['CardNumber'] ?>" minlength="16" maxlength="16" pattern="\d{16}" title="Please enter proper credit card number" required></p>
                        <p><input type="text" id="cvv" name="cvv" value="<?php echo $result_profile['CVV'] ?>" minlength="3" maxlength="3" pattern="\d{3}" title="Please enter proper cvv/cvc" required></p>
                        <p><input type="text" id="cardExpiry" name="cardExpiry" value="<?php echo $result_profile['ExpiryDate'] ?>" minlength="5" maxlength="5" placeholder="MM/YY" pattern="^(0[1-9]|1[0-2])\/?([0-9]{4}|[0-9]{2})$" title="Please enter proper singaporean phone number" required></p>
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
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal 
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        function changePwd() {
            document.getElementById("password").disabled = false;
            document.getElementById("password").value = "";
            document.getElementById("confirmPassword").style.display = "block";
            document.getElementById("labelCfmPwd").style.display = "block";
            document.getElementById("small").style.display = "none";
        }
    </script>


<?php

    $db->close();
} else {
    header("Location: index.php");
}
?>