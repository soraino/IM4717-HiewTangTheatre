<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/main.css" />
    <link rel="stylesheet" href="./css/seating.css" />
    <title>Seats selection</title>
</head>

<?php
$db = new mysqli('localhost', 'f34ee', 'f34ee', 'f34ee');

if (mysqli_connect_errno()) {
    echo 'Error: Could not connect to database.';
    exit;
}

$movieId = $_POST['movie'];
echo "movie ID: " . $movieId;

$sql_theatre = "select distinct Location from Theatre";
$result_theatre = $db->query($sql_theatre);
$theatre = $result_theatre->fetch_assoc();

$sql_movie = "select * from MovieDetail A join Photo B on A.Id = B.MovieDetailId where MovieDetailId = '" . $movieId . "'";
$run_movie = $db->query($sql_movie);
$result_movie = mysqli_fetch_assoc($run_movie);


$alphabet = range('A', 'Z');

?>

<script>
    var ticketCount = 0;
    var subtotal = 0;
    var seats = [];

    function seatSelector(id) {
        var selected = window.getComputedStyle(document.getElementById(id));
        // alert(selected.backgroundColor);
        if (selected.backgroundColor === "rgb(255, 255, 255)") {
            document.getElementById(id).style.backgroundColor = "yellow";
            ticketCount += 1;
            subtotal = 12.5 * ticketCount;
            seats.push(id);
        } else if (selected.backgroundColor === "rgb(255, 255, 0)") {
            document.getElementById(id).style.backgroundColor = "white";
            ticketCount -= 1;
            subtotal = 12.5 * ticketCount;
            var index = seats.indexOf(id);
            seats.splice(index, 1);
        }
        document.getElementById('qty').value = ticketCount;
        document.getElementById('subtotal').value = '$ ' + subtotal;
        document.getElementById('seats').innerHTML = seats.join(", ");
    }
</script>

<body>
    <nav class="navbar">
        <div class="navbar-menu container">
            <div class="navbar-end">
                <a href="index.php" class="navbar-item"> Home </a>
                <a href="moviesView.php" class="navbar-item"> Movies </a>
                <a class="navbar-item"> Bookings </a>
                <div class="navbar-item">
                    <input class="input is-rounded" type="text" placeholder="Search" />
                    <svg class="search-icon" viewBox="0 0 12 13">
                        <g stroke-width="2" stroke="#999999" fill="none">
                            <path d="M11.29 11.71l-4-4" />
                            <circle cx="5" cy="5" r="4" />
                        </g>
                    </svg>
                </div>
            </div>
        </div>
    </nav>
    <!-- End of navigation bar -->
    <div id="banner">
        <img src="./assets/movie/banner/<?php echo $result_movie['PhotoUrl'] ?>.jpg" alt="<?php echo $result_banner['PhotoUrl'] ?>" width="100%" height="350px">
    </div>
    <div class="container">
        <div id="top">
            <div class="row">
                <div class="center select_box">
                    <label>Cinema: </label>
                    <select name="cinema" id="cinema">
                        <option disabled selected>-- Select --</option>
                        <?php
                        while ($theatre = $result_theatre->fetch_assoc()) {
                        ?>
                            <option value="<?php echo $theatre['Location']; ?>"><?php echo $theatre['Location']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="center">
                    <label>Date: </label>
                    <input type="date" id="date" name="date">
                </div>
                <div class="center select_box">
                    <label>Time: </label>
                    <select name="time" id="time">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                </div>
            </div>
        </div>
        <div id="selection">
            <!-- outer container -->
            <div class="outer-container">
                <!-- screen -->
                <div class="row screen">Screen</div>

                <!-- seats -->
                <div class="row seats">
                    <!-- seats left -->
                    <div class="col seats-left">
                        <?php
                        for ($row = 0; $row < 5; $row++) {
                        ?>
                            <div class="row">
                                <?php
                                for ($col = 1; $col <= 6; $col++) { ?>
                                    <input hidden type="text" value="<?php echo $alphabet[$row] . $col; ?>">
                                    <div class="col iseat" id="<?php echo $alphabet[$row] . $col; ?>" onclick="seatSelector('<?php echo $alphabet[$row] . $col; ?>')"><?php echo $alphabet[$row] . $col; ?></div>
                                <?php
                                } ?>
                            </div>
                        <?php
                        } ?>
                    </div>
                    <!-- seats right -->
                    <div class="col seats-right">
                        <?php
                        for ($row = 0; $row < 5; $row++) {
                        ?>
                            <div class="row">
                                <?php
                                for ($col = 7; $col <= 12; $col++) { ?>
                                    <input hidden type="text" value="<?php echo $alphabet[$row] . $col; ?>">
                                    <div class="col iseat" id="<?php echo $alphabet[$row] . $col; ?>" onclick="seatSelector('<?php echo $alphabet[$row] . $col; ?>')"><?php echo $alphabet[$row] . $col; ?></div>
                                <?php
                                } ?>
                            </div>
                        <?php
                        } ?>
                    </div>
                </div>

                <!-- legends -->
                <div class="legends">
                    <div class="title">
                        <h4>Legends</h4>
                    </div>
                    <div class="box" style="background-color: white;">
                        <p>Available</p>
                    </div>
                    <div class="box" style="background-color: yellow;">
                        <p>Selected</p>
                    </div>
                    <div class="box" style="background-color: grey;">
                        <p>Unavailable</p>
                    </div>

                </div>
            </div>
        </div>
        <br>
        <div id="summary">
            <div class="row">
                <div class="col size-7 outer-container">
                    <h4>Contact Details</h4>
                    <div class="row">
                        <div class="col size-3">
                            <p><label>Email: </label></p>
                            <p><label>Phone Number: </label></p>
                        </div>
                        <div class="col">
                            <p><input type="text" id="email" name="email" value=""></p>
                            <p><input type="text" id="phone" name="phone" value=""></p>
                        </div>
                    </div>
                    <hr>
                    <h4>Payment Details</h4>
                    <div class="row">
                        <div class="col size-3">
                            <p><label>Name on Card: </label></p>
                            <p><label>Card Number: </label></p>
                            <p><label>Card Expiry Date: </label></p>
                            <p><label>CVV Code: </label></p>
                        </div>
                        <div class="col">
                            <p><input type="text" id="card" name="card" value=""></p>
                            <p><input type="text" id="cardNo" name="cardNo" value=""></p>
                            <p><input type="text" id="expiry" name="expiry" value=""></p>
                            <p><input type="text" id="cvv" name="cvv" value=""></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <p><input type="checkbox"> *I have read and accepted to the Terms and Conditions and Privacy Policy</p>
                            <p><input type="submit" value="Book Now"></p>
                        </div>
                    </div>
                </div>
                <div class="col size-4 outer-container">
                    <h4>Booking Summary</h4>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <p><?php echo $result_movie['Name'] ?></p>
                            <p><?php echo $result_movie['Genre'] ?></p>
                            <p>?Location?</p>
                            <p>?Date?</p>
                            <p>?Time?</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <p>Standard Ticket</p>
                            <p>Quantity</p>
                            <p>Seat(s)</p>
                        </div>
                        <div class="col">
                            <p>$12.50</p>
                            <p><input id="qty" type="text" value="" disabled></p>
                            <p id="seats"></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <p>Subtotal</p>
                        </div>
                        <div class="col">
                            <p><input id="subtotal" type="text" value="" disabled></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End of container -->
    <footer class="footer">
        <div class="footer-content">
            <div class="container">
                <p>Copyright lol</p>
            </div>
        </div>
    </footer>
</body>

</html>