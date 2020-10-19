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
echo $movieId;

$sql_theatre = "select distinct Location from Theatre";
$result_theatre = $db->query($sql_theatre);
$theatre = $result_theatre->fetch_assoc();


$alphabet = range('A', 'Z');

?>

<script>
    var ticketCount = 0;
    var subtotal = 0;

    function seatSelector(id) {
        var selected = window.getComputedStyle(document.getElementById(id));
        // alert(selected.backgroundColor);
        if (selected.backgroundColor === "rgb(255, 255, 255)") {
            document.getElementById(id).style.backgroundColor = "yellow";
            ticketCount += 1;
            subtotal = 12.5 * ticketCount;
        } else if (selected.backgroundColor === "rgb(255, 255, 0)") {
            document.getElementById(id).style.backgroundColor = "white";
            ticketCount -= 1;
            subtotal = 12.5 * ticketCount;
        }
        document.getElementById('qty').value = ticketCount;
        document.getElementById('subtotal').value = subtotal;
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
    <div class="container">
        <div id="top">
            <div class="row">
                <div class="col">
                    <label>Cinema: </label>
                    <select name="cinema" id="cinema">
                        <?php
                        while ($theatre = $result_theatre->fetch_assoc()) {
                        ?>
                            <option value="<?php echo $theatre['Location']; ?>"><?php echo $theatre['Location']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col">
                    <label>Date: </label>
                    <input type="date" id="date" name="date">
                </div>
                <div class="col">
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
        <div id="tickets">
            <div class="row tickets-header">
                <p>Tickets</p>
                <p>Cost</p>
                <p>Qty</p>
                <p>Subtotal</p>
            </div>
            <div class="row tickets-item">
                <p>Standard Ticket</p>
                <p>$12.50</p>
                <p><input id="qty" type="text" value="" disabled></p>
                <p><input id="subtotal" type="text" value="" disabled></p>
            </div>
        </div>
        <div id="payment">
            <input hidden type="text" value="movie id">
            <div id="payment-left">
                <label>Email: </label>
                <input type="text" id="email" value="">
                <br>
                <label>Name on Card: </label>
                <input type="text" id="card" value="">
                <br>
                <label>Card Number: </label>
                <input type="text" id="cardNo" value="">
            </div>
            <div>
                <label>Phone Number: </label>
                <input type="text" id="phone" value="">
                <br>
                <label>Card Expiry Date: </label>
                <input type="text" id="expiry" value="">
                <br>
                <label>CVV Code: </label>
                <input type="text" id="cvv" value="">
            </div>
            <input type="submit" value="Book Now">
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