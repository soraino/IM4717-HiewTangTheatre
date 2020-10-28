<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" href="assets/logo/favicon.ico" />
    <link rel="stylesheet" href="./css/main.css" />
    <link rel="stylesheet" href="./css/booking.css" />
    <title>HiewTang Theatre</title>
</head>

<?php

session_start();

if (isset($_COOKIE["userId"])) {
?>

    <body>
        <script>
            function redirectHome() {
                window.location.replace("./");
            }
            <?php
            if (!isset($_GET['movie'])) {
            ?>
                alert('Please come into this page throught the proper channels');
                redirectHome();
            <?php
            }
            ?>
        </script>

        <?php
        include "./navbar.php";
        @$DB = new mysqli('localhost', 'f34ee', 'f34ee', 'f34ee');
        $MOVIE_QUERY = "SELECT * FROM f34ee.MovieDetail WHERE Id = " . $_GET['movie'] . ";";
        $movieResult = $DB->query($MOVIE_QUERY);
        if ($movieResult->num_rows > 0) {
            $movieDetails = $movieResult->fetch_assoc();
            if (time() < strtotime($movieDetails['ReleaseDate'])) {
        ?>
                <script>
                    alert('Please come into this page throught the proper channels');
                    redirectHome();
                </script>
        <?php
            }
        }


        $LocationVal = '';
        $PHOTO_QUERY = "SELECT PhotoUrl FROM f34ee.Photo WHERE MovieDetailId = " . $_GET['movie'] . ";";
        if (isset($_GET['location'])) {
            $LocationVal = 'AND t.Location ="' . $_GET['location'] . '"';
        }
        $TIMESLOT_QUERY = "SELECT ts.* , t.Location FROM f34ee.Timeslot AS ts INNER JOIN f34ee.Theatre AS t WHERE ts.MovieDetailId = " . $_GET['movie'] . " AND ts.TheatreId = t.Id " . $LocationVal . " ORDER BY ts.TheatreId ASC,ts.StartTime ASC;";
        $THEATRE_QUERY = "SELECT distinct Location FROM f34ee.Theatre ORDER BY Id;";
        $AVAILABLE_QUERY = "SELECT count(t.BookingId) as numRows, t.BookingId, b.TimeslotId from f34ee.Ticket as t inner join f34ee.Booking as b on b.Id = t.BookingId where b.PremiereDate ='" . $_GET['date'] . "' group by b.TimeslotId";
        if (mysqli_connect_errno()) {
            exit('Unable to connect to DB');
        }
        $bannerURL;
        $timeslots = array();
        $theatre = array();
        $ticsBrought = array();

        $queryResult = $DB->query($PHOTO_QUERY);
        if ($queryResult->num_rows > 0) {
            $bannerURL = $queryResult->fetch_assoc()['PhotoUrl'];
        }

        $queryResult = $DB->query($THEATRE_QUERY);
        if ($queryResult->num_rows > 0) {
            while ($row = $queryResult->fetch_assoc()) {
                array_push($theatre, $row);
            }
        }

        $queryResult = $DB->query($TIMESLOT_QUERY);
        if ($queryResult->num_rows > 0) {
            while ($row = $queryResult->fetch_assoc()) {
                array_push($timeslots, $row);
            }
        }
        $queryResult = $DB->query($AVAILABLE_QUERY);
        if ($queryResult->num_rows > 0) {
            while ($row = $queryResult->fetch_assoc()) {
                $ticsBrought["Id" . $row['TimeslotId']] = $row['numRows'];
            }
        }
        $queryResult->free();
        $DB->close();
        ?>
        <form action="seating.php" method="POST">
            <input type="hidden" value="<?php echo $_GET['movie']; ?>" name="movie" />
            <div>
                <img src="assets/movie/banner/<?php echo $bannerURL; ?>.jpg" style="display: block" />
                <div style="height: 100px; width: 100%; background-color: #000">
                    <div class="container">
                        <div class="row center-text date-selector">
                            <div class="col">
                                <input type="radio" name="date" id="day1" onchange="reload(this)" />
                                <label for="day1">
                                    <h1 id="day1_header" class="no-margin">
                                    </h1>
                                    <p id="day1_para" class="no-margin">
                                    </p>
                                </label>
                            </div>
                            <div class="col">
                                <input type="radio" name="date" id="day2" onchange="reload(this)" />
                                <label for="day2">
                                    <h1 id="day2_header" class="no-margin">
                                    </h1>
                                    <p id="day2_para" class="no-margin">
                                    </p>
                                </label>
                            </div>
                            <div class="col">
                                <input type="radio" name="date" id="day3" onchange="reload(this)" />
                                <label for="day3">
                                    <h1 id="day3_header" class="no-margin">
                                    </h1>
                                    <p id="day3_para" class="no-margin">
                                    </p>
                                </label>
                            </div>
                            <div class="col">
                                <input type="radio" name="date" id="day4" onchange="reload(this)" />
                                <label for="day4">
                                    <h1 id="day4_header" class="no-margin">
                                    </h1>
                                    <p id="day4_para" class="no-margin">
                                    </p>
                                </label>
                            </div>
                            <div class="col">
                                <input type="radio" name="date" id="day5" onchange="reload(this)" />
                                <label for="day5">
                                    <h1 id="day5_header" class="no-margin">
                                    </h1>
                                    <p id="day5_para" class="no-margin">
                                    </p>
                                </label>
                            </div>
                            <div class="col">
                                <input type="radio" name="date" id="day6" onchange="reload(this)" />
                                <label for="day6">
                                    <h1 id="day6_header" class="no-margin">
                                    </h1>
                                    <p id="day6_para" class="no-margin">
                                    </p>
                                </label>
                            </div>
                            <div class="col">
                                <input type="radio" name="date" id="day7" onchange="reload(this)" />
                                <label for="day7">
                                    <h1 id="day7_header" class="no-margin">
                                    </h1>
                                    <p id="day7_para" class="no-margin">
                                    </p>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <?php
                if (isset($_GET['date'])) {
                ?>
                    <table class="table is-bordered center-text">
                        <thead>
                            <tr>
                                <td>Loction</td>
                                <td colspan="5">Timeslots</td>
                            </tr>
                        </thead>
                        <?php
                        if (!isset($_GET['location'])) {
                            for ($i = 0; $i < count($theatre); $i++) {
                        ?>
                                <tr>
                                    <td>
                                        <p><?php echo $theatre[$i]['Location']; ?></p>
                                    </td>
                                    <?php
                                    for ($j = 0; $j < count($timeslots); $j++) {
                                        if ($theatre[$i]['Location'] == $timeslots[$j]['Location']) {
                                    ?>
                                            <td onclick="selectTimeSlot(this,'<?php echo "ts" . $i . "l" . $j; ?>')" class="<?php echo $ticsBrought["Id" . $timeslots[$j]['Id']] == 60 ? 'disabled' : ''; ?>">
                                                <input class="timeslot" type="radio" name="timeslot" id="<?php echo "ts" . $i . "l" . $j; ?>" value="<?php echo $timeslots[$j]['Id']; ?>" onchange="updateBg(this)" <?php echo $ticsBrought["Id" . $timeslots[$j]['Id']] == 60 ? 'disabled' : ''; ?> />
                                                <label for="<?php echo "ts" . $i . "l" . $j; ?>">
                                                    <p><?php echo substr($timeslots[$j]['StartTime'], 0, 5); ?></p>
                                                </label>
                                            </td>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td>
                                    <p><?php echo $_GET['location']; ?></p>
                                </td>
                                <?php
                                for ($i = 0; $i < count($timeslots); $i++) {
                                    if ($_GET['location'] == $timeslots[$i]['Location']) {
                                ?>
                                        <td onclick="selectTimeSlot(this,'<?php echo "ts" . $i . "l"; ?>')" class="<?php echo $ticsBrought["Id" . $timeslots[$i]['Id']] == 60 ? 'disabled' : ''; ?>">
                                            <input class="timeslot" type="radio" name="timeslot" id="<?php echo "ts" . $i . "l"; ?>" value="<?php echo $timeslots[$i]['Id']; ?>" onchange="updateBg(this)" <?php echo $ticsBrought["Id" . $timeslots[$i]['Id']] == 60 ? 'disabled' : ''; ?> />
                                            <label for="<?php echo "ts" . $i . "l"; ?>">
                                                <p><?php echo substr($timeslots[$i]['StartTime'], 0, 5); ?></p>
                                            </label>
                                        </td>
                                <?php
                                    }
                                }
                                ?>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                    <?php
                    if (isset($_GET['location'])) {
                    ?>
                        <div class="clearfix">
                            <button type="button" class="link float-right" onclick="showAllLocation()">
                                View All Locations
                            </button>
                        </div>
                    <?php
                    }
                    ?>
                    <br>
                    <div class="clearfix">
                        <button class="button float-right" type="submit">
                            Proceed to Seat Selection
                        </button>
                    </div>
                <?php
                }
                ?>
            </div>
        </form>
        <?php include "./footer.php"; ?>
    </body>
<?php
} else {
    header("Location: login.html?notLogin=1&movie=" . $_GET['movie']);
}

?>
<script>
    function initDateSelector() {
        const today = new Date();
        const url = new URL(window.location);
        const search_params = url.searchParams;
        for (let i = 0; i <= 6; i++) {
            const dateIter = new Date();
            dateIter.setDate(today.getDate() + i);
            let day = dateIter.getDate() < 10 ? `0${dateIter.getDate()}` : dateIter.getDate();
            const dateVal = dateIter.getFullYear() + '-' + (dateIter.getMonth() + 1) + '-' + day;
            document.getElementById(
                `day${i + 1}_para`
            ).innerText = `${dateIter.toLocaleString("en-GB", {
                    day: "numeric",
                    month: "short"
                })}`;
            document.getElementById(
                `day${i + 1}_header`
            ).innerText = `${dateIter.toLocaleString("en-GB", {
                    weekday: "short"
                })}`;
            document.getElementById(
                `day${i + 1}`
            ).value = dateVal;
            if (search_params.get('date') != null && dateVal == search_params.get('date')) {
                document.getElementById(
                    `day${i + 1}`
                ).checked = true;
            }
        }
    }

    function showAllLocation() {
        const url = new URL(window.location);
        const search_params = url.searchParams;
        search_params.delete('location');
        url.search = search_params.toString();
        window.location.replace(url.toString());
    }

    function updateBg(element) {
        if (element.checked) {
            const selectedSlots = document.getElementsByClassName([
                "selectedTimeSlot"
            ]);
            for (i = 0; i < selectedSlots.length; i++) {
                selectedSlots[i].classList.remove("selectedTimeSlot");
            }
            element.parentElement.classList.add("selectedTimeSlot");
        }
    }

    function selectTimeSlot(element, id) {
        if (!document.getElementById("ts0l").disabled) {
            document.getElementById(id).checked = true;
            const selectedSlots = document.getElementsByClassName([
                "selectedTimeSlot"
            ]);
            for (i = 0; i < selectedSlots.length; i++) {
                selectedSlots[i].classList.remove("selectedTimeSlot");
            }
            element.classList.add("selectedTimeSlot");
        }

    }

    function reload(element) {
        const url = new URL(window.location);
        const search_params = url.searchParams;
        if (search_params.get('location') != null) {
            window.location.replace(
                `./booking.php?movie=${search_params.get('movie')}&location=${search_params.get('location')}&date=${element.value}`
            );
        } else {
            window.location.replace(`./booking.php?movie=${search_params.get('movie')}&date=${element.value}`);
        }
    }
    document.querySelector('form').addEventListener('submit', e => {
        // Get all radio buttons, convert to an array.
        const radios = Array.prototype.slice.call(document.querySelectorAll('input[type=radio]'));
        // Reduce to get an array of radio button sets
        const questions = Object.values(radios.reduce((result, el) =>
            Object.assign(result, {
                [el.name]: (result[el.name] || []).concat(el)
            }), {}));
        // Loop through each question, looking for any that aren't answered.
        const hasUnanswered = questions.some(question => !question.some(el => el.checked));
        const found = questions.find(question => !question.some(el => el.checked));
        if (hasUnanswered) {
            alert(`Please insert a ${found[0].name}`)
            e.preventDefault(); // just for demo purposes... normally, just put this in the hasUnanswered part
        }

    });

    initDateSelector();
</script>

</html>