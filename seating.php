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
        var x = document.getElementById(id).checked;
        var y = document.getElementById('timeslot').value;

        if (x == true) {
            ticketCount += 1;
            subtotal = 12.5 * ticketCount;
            seats.push(id);
        } else if (x == false) {
            ticketCount -= 1;
            subtotal = 12.5 * ticketCount;
            var index = seats.indexOf(id);
            seats.splice(index, 1);
        }

        if (seats != "" && y != '-- Select --') {
            document.getElementById("submit").disabled = false;
        } else {
            document.getElementById("submit").disabled = true;
        }

        document.getElementById('qty').value = ticketCount;
        document.getElementById('subtotal').value = subtotal;
        document.getElementById('seats').value = seats.join(", ");
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

    function doReload3(id) {
        document.frm3.action = 'seating.php';
        document.frm3.method = 'post';
        document.frm3.submit();
    }
</script>

<?php
$db = new mysqli('localhost', 'f34ee', 'f34ee', 'f34ee');

if (mysqli_connect_errno()) {
    echo 'Error: Could not connect to database.';
    exit;
}

session_start();

$movieId = $_POST['movie'];
$timeslotId = $_POST['timeslot'];
$dateId = $_POST['date'];
$cinema = $_POST['cinema'];
$time = $_POST['time'];

echo "movie ID: " . $movieId;
echo "TimeslotID: " . $timeslotId;
echo "Date: " . $dateId;
echo "Cinema: " . $cinema;
echo "Time: " . $time;

//GETTING USER DATA FROM DB FOR DISPLAY
$sql_uData = "select U.*, CH.CardNumber, C.Name as CardName, C.CVV, C.ExpiryDate  from User U join CardHolder CH on U.Id = CH.UserId join Card C on CH.CardNumber = C.CardNumber where Id = '" . $_COOKIE['userId'] . "'";
$run_uData = $db->query($sql_uData);
$result_uData = $run_uData->fetch_assoc();

$sql_currentTheatre = "select T.Location, TS.StartTime, TS.Id from Theatre T join Timeslot TS on T.Id = TS.TheatreId where TS.Id = '" . $timeslotId . "'";
$run_currentTheatre = $db->query($sql_currentTheatre);
$result_currentTheatre = mysqli_fetch_assoc($run_currentTheatre);

$sql_currentTimeslot = "select TS.StartTime, TS.Id from Theatre T join Timeslot TS on T.Id = TS.TheatreId join MovieDetail MD on MD.Id = TS.MovieDetailId where T.Location = '" . $result_currentTheatre['Location'] . "' and MovieDetailId = '" . $movieId . "'";
$run_currentTimeslot = $db->query($sql_currentTimeslot);

$sql_theatre = "select DISTINCT Location from Theatre T join Timeslot TS on T.Id = TS.TheatreId where TS.MovieDetailId = '" . $movieId . "'";
$run_theatre = $db->query($sql_theatre);

//Generate timeslot options based on selected movie and cinema
$sql_timeslot = "select TS.StartTime, TS.Id from MovieDetail MD join Timeslot TS on MD.Id = TS.MovieDetailId join Theatre T on TS.TheatreId = T.Id where MovieDetailId = '" . $movieId . "' and T.Location = '" . $cinema . "'";
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
                <form name="frm3" id="frm3">
                    <div class="center">
                        <input type="hidden" value="<?php echo $movieId ?>" name="movie" />
                        <input type="hidden" value="<?php echo $result_currentTheatre['Location'] ?>" name="cinema" />
                        <input type="hidden" value="<?php echo $result_currentTheatre['Id'] ?>" name="timeslot" />
                        <label>Date: </label>
                        <input type="date" id="date" name="date" value="<?php echo $dateId ?>" onchange="doReload3(this.value)">
                    </div>
                </form>
                <div class="center select_box">
                    <form name="frm2" id="frm2">
                        <label>Time: </label>
                        <input type="hidden" value="<?php echo $movieId ?>" name="movie" />
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

                        <select name="timeslot" id="timeslot" onchange="doReload2(this.value)">
                            <?php
                            if (!isset($_POST['cinema'])) {
                            ?>
                                <option selected hidden><?php echo substr($result_currentTheatre['StartTime'], 0, 5) ?></option>
                                <?php
                                while ($result_currentTimeslot = $run_currentTimeslot->fetch_assoc()) {
                                ?>
                                    <option name="" value="<?php echo $result_currentTimeslot['Id'] ?>"><?php echo substr($result_currentTimeslot['StartTime'], 0, 5); ?></option>
                                <?php
                                }
                                ?>
                            <?php
                            } else if (isset($_POST['timeslot'])) {
                            ?>
                                <option selected hidden><?php echo substr($result_currentTheatre['StartTime'], 0, 5) ?></option>
                                <?php
                                while ($result_timeslot = mysqli_fetch_assoc($run_timeslot)) {
                                ?>
                                    <option name="" value="<?php echo $result_timeslot['Id'] ?>"><?php echo substr($result_timeslot['StartTime'], 0, 5); ?></option>
                                <?php
                                }
                            } else {
                                ?>
                                <option selected>-- Select --</option>
                                <?php
                                while ($result_timeslot = mysqli_fetch_assoc($run_timeslot)) {
                                ?>
                                    <option name="" value="<?php echo $result_timeslot['Id'] ?>"><?php echo substr($result_timeslot['StartTime'], 0, 5); ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </form>
                </div>
            </div>

        </div>
        <form name="summaryForm" action="ticketBooking.php" method="post">
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
                                        <input type="checkbox" id="<?php echo $alphabet[$row] . sprintf("%02d", $col); ?>" name="seats" onchange="seatSelector('<?php echo $alphabet[$row] . sprintf("%02d", $col); ?>')">
                                        <label class="col iseat" for="<?php echo $alphabet[$row] . sprintf("%02d", $col); ?>"><?php echo $alphabet[$row] . sprintf("%02d", $col); ?></label><br>
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
                                        <input type="checkbox" id="<?php echo $alphabet[$row] . sprintf("%02d", $col); ?>" name="seats" onchange="seatSelector('<?php echo $alphabet[$row] . sprintf("%02d", $col); ?>')">
                                        <label class="col iseat" for="<?php echo $alphabet[$row] . sprintf("%02d", $col); ?>"><?php echo $alphabet[$row] . sprintf("%02d", $col); ?></label><br>
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
                        <div class="box" style="background-color: #fff;">
                            <p>Available</p>
                        </div>
                        <div class="box" style="background-color: #FFFF00;">
                            <p>Selected</p>
                        </div>
                        <div class="box" style="background-color: #808080;">
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
                                <p><label>Name: </label></p>
                                <p><label>Email: </label></p>
                                <p><label>Phone Number: </label></p>
                            </div>
                            <div class="col">
                                <p><input type="text" id="name" name="name" value="<?php echo $result_uData['Name'] ?>" placeholder="John Doe" required></p>
                                <p><input type="text" id="email" name="email" value="<?php echo $result_uData['Email'] ?>" placeholder="email@domain.com" required></p>
                                <p><input type="text" id="phone" name="phone" value="<?php echo $result_uData['PhoneNumber'] ?>" minlength="8" maxlength="8" placeholder="87651906" pattern="\d{8}" required></p>
                            </div>
                        </div>
                        <hr>
                        <h4>Payment Details</h4>
                        <div class="row">
                            <div class="col size-3">
                                <p><label>Name on Credit Card: </label></p>
                                <p><label>Card Number: </label></p>
                                <p><label>Card Expiry Date: </label></p>
                                <p><label>CVV Code: </label></p>
                            </div>
                            <div class="col">
                                <p><input type="text" id="cardName" name="cardName" value="<?php echo $result_uData['CardName'] ?>" placeholder="John Doe" required></p>
                                <p><input type="text" id="cardNo" name="cardNo" value="<?php echo $result_uData['CardNumber'] ?>" minlength="16" maxlength="16" placeholder="1234123412341234" pattern="\d{16}" title="Please enter proper credit card number" required></p>
                                <p><input type="text" id="expiry" name="expiry" value="<?php echo $result_uData['ExpiryDate'] ?>" minlength="5" maxlength="5" placeholder="MM/YY" pattern="^(0[1-9]|1[0-2])\/?([0-9]{4}|[0-9]{2})$" title="Please enter proper singaporean phone number" required></p>
                                <p><input type="text" id="cvv" name="cvv" value="<?php echo $result_uData['CVV'] ?>" minlength="3" maxlength="3" placeholder="123" pattern="\d{3}" title="Please enter proper ccv/cvc" required></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col">
                                <p><input type="checkbox" required> *I have read and accepted to the Terms and Conditions and Privacy Policy</p>
                                <p><input id="submit" type="submit" value="Book Now" disabled></p>
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
                                <p><input hidden type="text" name="movieId" value="<?php echo $movieId ?>"><?php echo $result_movie['Name'] ?></p>
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
                                    <p><input hidden type="text" name="showtimeId" value="<?php echo $timeslotId ?>"><?php echo substr($result_currentTheatre['StartTime'], 0, 5) ?></p>
                                <?php
                                } else {
                                ?>
                                    <p><input hidden type="text" name="showtimeId" value="<?php echo $timeslotId ?>"><?php echo substr($result_currentTheatre['StartTime'], 0, 5) ?></p>
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
                                <p><input id="qty" type="text" name="qty" value="0" readonly required></p>
                                <p><input id="seats" type="text" name="seats" value="" readonly required></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col">
                                <p>Subtotal ($)</p>
                            </div>
                            <div class="col">
                                <p><input id="subtotal" name="subtotal" type="text" value="0" readonly required></p>
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