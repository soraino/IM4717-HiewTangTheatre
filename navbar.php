<?php
session_start();

$userId = $_COOKIE['userId'];
$userData = $_SESSION["user" . $userId];
$uname = $userData['Name'];

?>

<nav class="navbar">
    <div class="navbar-menu container">
        <a href="./">
            <div class="logo">
                <img src="./assets/logo/HiewTangTheatre_dark.png" />
            </div>
        </a>
        <div class="navbar-start">
            <a href="./" class="navbar-item"> Home </a>
            <a href="moviesView.php" class="navbar-item"> Movies </a>
            <?php if (isset($_COOKIE["userId"])) {
            ?>
                <a class="navbar-item" href="myBooking.php"> My Bookings </a>
            <?php
            }
            ?>
        </div>
        <div class="navbar-end">

            <div class="navbar-item">
                <form name="search-form" action="moviesView.php" method="GET">
                    <input class="input is-rounded" name="Search" type="text" placeholder="Search" value="<?php echo $_GET['Search'] ?>" />
                </form>
                <svg class="search-icon" viewBox="0 0 12 13">
                    <g stroke-width="2" stroke="#999999" fill="none">
                        <path d="M11.29 11.71l-4-4" />
                        <circle cx="5" cy="5" r="4" />
                    </g>
                </svg>
            </div>
            <?php if (isset($_COOKIE["userId"])) {
            ?>
                <a href="./logout.php" class="navbar-item"> Logout </a>
                <a href="./profile.php" class="navbar-item"><img style="margin-right: 8px;" src="./assets/user.svg" alt="user.svg" width="32px" height="32px"></a>
            <?php
            } else {
            ?>
                <a href="./login.html" class="navbar-item"> Login </a>
                <a href="./register.html" class="navbar-item"> Register </a>
            <?php
            }
            ?>

        </div>
    </div>
</nav>