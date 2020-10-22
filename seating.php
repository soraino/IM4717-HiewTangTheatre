<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/main.css" />
    <link rel="stylesheet" href="./css/seating.css" />
    <title>Seats selection</title>
</head>

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

    function doReload(id) {
        document.frm1.action = 'seating.php';
        document.frm1.method = 'post';
        document.frm1.submit();
    }

    function doReload2(id) {
        document.frm2.action = 'seating.php';
        document.frm2.method = 'post';
        document.frm2.submit();
    }
</script>

<?php
$db = new mysqli('localhost', 'f34ee', 'f34ee', 'f34ee');

if (mysqli_connect_errno()) {
    echo 'Error: Could not connect to database.';
    exit;
}

$movieId = $_POST['movie'];
$timeslotId = $_POST['timeslot'];
$dateId = $_POST['date'];
$cinema = $_POST['cinema'];
$time = $_POST['time'];

echo "movie ID: " . $movieId;
echo "Timeslot: " . $timeslotId;
echo "Date: " . $dateId;
echo "Cinema: " . $cinema;
echo "Timeslot: " . $time;

$sql_currentTheatre = "select T.Location, TS.StartTime from Theatre T join Timeslot TS on T.Id = TS.TheatreId where TS.Id = '" . $timeslotId . "'";
$run_currentTheatre = $db->query($sql_currentTheatre);
$result_currentTheatre = mysqli_fetch_assoc($run_currentTheatre);

$sql_currentTimeslot = "select TS.StartTime from Theatre T join Timeslot TS on T.Id = TS.TheatreId join MovieDetail MD on MD.Id = TS.MovieDetailId where T.Location = '" . $result_currentTheatre['Location'] . "' and MovieDetailId = '" . $movieId . "'";
$run_currentTimeslot = $db->query($sql_currentTimeslot);

$sql_theatre = "select DISTINCT Location from Theatre T join Timeslot TS on T.Id = TS.TheatreId where TS.MovieDetailId = '" . $movieId . "'";
$run_theatre = $db->query($sql_theatre);

//Generate timeslot options based on selected movie and cinema
$sql_timeslot = "select * from MovieDetail MD join Timeslot TS on MD.Id = TS.MovieDetailId join Theatre T on TS.TheatreId = T.Id where MovieDetailId = '" . $movieId . "' and T.Location = '" . $cinema . "'";
$run_timeslot = $db->query($sql_timeslot);

$sql_movie = "select * from MovieDetail A join Photo B on A.Id = B.MovieDetailId where MovieDetailId = '" . $movieId . "'";
$run_movie = $db->query($sql_movie);
$result_movie = mysqli_fetch_assoc($run_movie);


$alphabet = range('A', 'Z');

?>

<body>
    <?php
        include "./navbar.php";
    ?>
    <!-- End of navigation bar -->
    <div id="banner">
        <img src="./assets/movie/banner/<?php echo $result_movie['PhotoUrl'] ?>.jpg" alt="<?php echo $result_banner['PhotoUrl'] ?>" width="100%" height="350px">
    </div>
    <div class="container">
        <div id="top">
            <div class="row">
                <div class="center select_box">
                    <form name="frm1" id="frm1">
                        <label>Cinema: </label>
                        <input type="hidden" value="<?php echo $movieId ?>" name="movie" />
                        <input type="hidden" value="<?php echo $timeslotId ?>" name="timeslot" />
                        <input type="hidden" value="<?php echo $dateId ?>" name="date" />
                        <select name="cinema" id="cinema" onchange="doReload(this.value)">
                            <?php
                            if (isset($_POST['cinema'])) {
                            ?>
                                <option selected hidden><?php echo $cinema ?></option>
                            <?php
                            } else {
                            ?>
                                <option selected hidden><?php echo $result_currentTheatre['Location'] ?></option>
                            <?php
                            }
                            while ($result_theatre = $run_theatre->fetch_assoc()) {
                            ?>
                                <option name="" value="<?php echo $result_theatre['Location']; ?>"><?php echo $result_theatre['Location']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </form>
                </div>
                <div class="center">
                    <label>Date: </label>
                    <input type="date" id="date" name="date" value="<?php echo $dateId ?>">
                </div>
                <div class="center select_box">
                    <form name="frm2" id="frm2">
                        <label>Time: </label>
                        <input type="hidden" value="<?php echo $movieId ?>" name="movie" />
                        <input type="hidden" value="<?php echo $timeslotId ?>" name="timeslot" />
                        <input type="hidden" value="<?php echo $dateId ?>" name="date" />
                        <?php
                        if (isset($_POST['cinema'])) {
                        ?>
                            <input type="hidden" value="<?php echo $cinema ?>" name="cinema" />
                        <?php
                        } else {
                        ?>
                            <input type="hidden" value="<?php echo $result_currentTheatre['Location'] ?>" name="cinema" />
                        <?php
                        }
                        ?>

                        <select name="time" id="time" onchange="doReload2(this.value)">
                            <?php
                            if (!isset($_POST['cinema'])) {
                            ?>
                                <option selected hidden><?php echo $result_currentTheatre['StartTime'] ?></option>
                                <?php
                                while ($result_currentTimeslot = $run_currentTimeslot->fetch_assoc()) {
                                ?>
                                    <option name="" value="<?php echo $result_currentTimeslot['StartTime']; ?>"><?php echo $result_currentTimeslot['StartTime']; ?></option>
                                <?php
                                }
                                ?>
                            <?php
                            } else if (isset($_POST['time'])) {
                            ?>
                                <option selected hidden><?php echo $time ?></option>
                                <?php
                                while ($result_timeslot = mysqli_fetch_assoc($run_timeslot)) {
                                ?>
                                    <option name="" value="<?php echo $result_timeslot['StartTime']; ?>"><?php echo $result_timeslot['StartTime']; ?></option>
                                <?php
                                }
                            } else {
                                ?>
                                <option selected>-- Select --</option>
                                <?php
                                while ($result_timeslot = mysqli_fetch_assoc($run_timeslot)) {
                                ?>
                                    <option name="" value="<?php echo $result_timeslot['StartTime']; ?>"><?php echo $result_timeslot['StartTime']; ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </form>
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
        <form action="receipt.php" method="POST">
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
                                <p><input type="checkbox" required> *I have read and accepted to the Terms and Conditions and Privacy Policy</p>
                                <p><input type="submit" value="Book Now"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col size-4 outer-container">
                        <h4>Booking Summary</h4>
                        <hr>
                        <div class="row">
                            <div class="col">
                                <p>Movie</p>
                                <p>Genre</p>
                                <p>Cinema</p>
                                <p>Date</p>
                                <p>Showtime</p>
                            </div>
                            <div class="col">
                                <p><input hidden type="text" name="movie" value="<?php echo $result_movie['Name'] ?>"><?php echo $result_movie['Name'] ?></p>
                                <p><input hidden type="text" name="genre" value="<?php echo $result_movie['Genre'] ?>"><?php echo $result_movie['Genre'] ?></p>
                                <?php
                                if (isset($_POST['cinema'])) {
                                ?>
                                    <p><input hidden type="text" name="location" value="<?php echo $cinema ?>"><?php echo $cinema ?></p>
                                <?php
                                } else {
                                ?>
                                    <p><input hidden type="text" name="location" value="<?php echo $result_currentTheatre['Location'] ?>"><?php echo $result_currentTheatre['Location'] ?></p>
                                <?php
                                }
                                ?>
                                <p><input hidden type="text" name="date" value="<?php echo $dateId ?>"><?php echo date("F j, Y", strtotime($dateId)) ?></p>
                                <?php
                                if (isset($_POST['cinema'])) {
                                ?>
                                    <p><input hidden type="text" name="showtime" value="<?php echo substr($time, 0, 5) ?>"><?php echo substr($time, 0, 5) ?></p>
                                <?php
                                } else {
                                ?>
                                    <p><input hidden type="text" name="showtime" value="<?php echo $result_currentTheatre['StartTime'] ?>"><?php echo $result_currentTheatre['StartTime'] ?></p>
                                <?php
                                }
                                ?>
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
        </form>
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