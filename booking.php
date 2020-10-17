<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./css/main.css" />
    <link rel="stylesheet" href="./css/booking.css" />
    <title>HiewTang Theatre</title>
</head>

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
    <nav class="navbar">
        <div class="navbar-menu container">
            <div class="navbar-end">
                <a href="./" class="navbar-item"> Home </a>
                <a href="./moviesView.php" class="navbar-item"> Movies </a>
                <a class="navbar-item"> Check Bookings </a>
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
    <?php
            @$DB = new mysqli('localhost', 'f34ee', 'f34ee', 'f34ee');
            $LocationVal = '';
            $PHOTO_QUERY = "SELECT PhotoUrl FROM f34ee.Photo WHERE MovieDetailId = ".$_GET['movie'].";";
            if(isset($_GET['location'])){
                $LocationVal = 'AND t.Location ="'.$_GET['location'].'"';
            }
            $TIMESLOT_QUERY = "SELECT ts.* , t.Location FROM f34ee.Timeslot AS ts INNER JOIN f34ee.Theatre AS t WHERE ts.MovieDetailId = ".$_GET['movie']." AND ts.TheatreId = t.Id ".$LocationVal." ORDER BY ts.TheatreId ASC,ts.StartTime ASC;";
            $THEATRE_QUERY = "SELECT distinct Location FROM f34ee.Theatre ORDER BY Id;";
            if(mysqli_connect_errno()){
                exit('Unable to connect to DB');
            }
            $bannerURL;
            $timeslots = array();
            $theatre = array();
            
            $queryResult = $DB->query($PHOTO_QUERY);
            if($queryResult->num_rows > 0){
                $bannerURL = $queryResult->fetch_assoc()['PhotoUrl'];
            }
            
            $queryResult = $DB->query($THEATRE_QUERY);
            if($queryResult->num_rows > 0){
                while($row = $queryResult->fetch_assoc()){
                    array_push($theatre, $row);
                }
            }
            
            $queryResult = $DB->query($TIMESLOT_QUERY);
            if($queryResult->num_rows > 0){
                while($row = $queryResult->fetch_assoc()){
                    array_push($timeslots, $row);
                }
            }
            $queryResult -> free();
            $DB->close();
            ?>
    <form action="/seating.php" method="post">
        <input type="hidden" value="<?php echo $_GET['movie'];?>" name="movie" />
        <div>
            <img src="assets/movie/banner/<?php echo $bannerURL; ?>.jpg" style="display: block" />
            <div style="height: 100px; width: 100%; background-color: #000">
                <div class="container">
                    <div class="row center-text date-selector">
                        <div class="col">
                            <input type="radio" name="date" id="day1" />
                            <label for="day1">
                                <h1 id="day1_header" class="no-margin">
                                </h1>
                                <p id="day1_para" class="no-margin">
                                </p>
                            </label>
                        </div>
                        <div class="col">
                            <input type="radio" name="date" id="day2" />
                            <label for="day2">
                                <h1 id="day2_header" class="no-margin">
                                </h1>
                                <p id="day2_para" class="no-margin">
                                </p>
                            </label>
                        </div>
                        <div class="col">
                            <input type="radio" name="date" id="day3" />
                            <label for="day3">
                                <h1 id="day3_header" class="no-margin">
                                </h1>
                                <p id="day3_para" class="no-margin">
                                </p>
                            </label>
                        </div>
                        <div class="col">
                            <input type="radio" name="date" id="day4" />
                            <label for="day4">
                                <h1 id="day4_header" class="no-margin">
                                </h1>
                                <p id="day4_para" class="no-margin">
                                </p>
                            </label>
                        </div>
                        <div class="col">
                            <input type="radio" name="date" id="day5" />
                            <label for="day5">
                                <h1 id="day5_header" class="no-margin">
                                </h1>
                                <p id="day5_para" class="no-margin">
                                </p>
                            </label>
                        </div>
                        <div class="col">
                            <input type="radio" name="date" id="day6" />
                            <label for="day6">
                                <h1 id="day6_header" class="no-margin">
                                </h1>
                                <p id="day6_para" class="no-margin">
                                </p>
                            </label>
                        </div>
                        <div class="col">
                            <input type="radio" name="date" id="day7" />
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
            <table class="table is-bordered center-text">
                <thead>
                    <tr>
                        <td>Loction</td>
                        <td colspan="5">Timeslots</td>
                    </tr>
                </thead>
                <?php
                    if(!isset($_GET['location'])){
                        for($i = 0; $i< count($theatre); $i++){
                            
                            ?>
                <tr>
                    <td>
                        <p><?php echo $theatre[$i]['Location']; ?></p>
                    </td>
                    <?php
                            for($j = 0 ; $j< count($timeslots); $j++){
                                if($theatre[$i]['Location'] == $timeslots[$j]['Location']){
                                    ?>
                    <td onclick="selectTimeSlot(this,'<?php echo "ts".$i."l".$j; ?>')">
                        <input class="timeslot" type="radio" name="timeslot" id="<?php echo "ts".$i."l".$j; ?>"
                            value="<?php echo $timeslots[$j]['Id']; ?>" onchange="updateBg(this)" />
                        <label for="<?php echo "ts".$i."l".$j; ?>">
                            <p><?php echo substr($timeslots[$j]['StartTime'],0,5); ?></p>
                        </label>
                    </td>
                    <?php
                                }
                            }
                            ?>
                </tr>
                <?php
                        }
                    }else{
                        ?>
                <tr>
                    <td>
                        <p><?php echo $_GET['location']; ?></p>
                    </td>
                    <?php
                        for($i = 0 ; $i< count($timeslots); $i++){
                            if($_GET['location'] == $timeslots[$i]['Location']){
                                ?>
                    <td onclick="selectTimeSlot(this,'<?php echo "ts".$i."l"; ?>')">
                        <input class="timeslot" type="radio" name="timeslot" id="<?php echo "ts".$i."l"; ?>"
                            value="<?php echo $timeslots[$j]['Id']; ?>" onchange="updateBg(this)" />
                        <label for="<?php echo "ts".$i."l"; ?>">
                            <p><?php echo substr($timeslots[$i]['StartTime'],0,5); ?></p>
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
                if(isset($_GET['location'])){
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

        </div>
    </form>
    <footer class="footer">
        <div class="footer-content">
            <div class="container">
                <p>Copyright lol</p>
            </div>
        </div>
    </footer>
</body>
<script>
function initDateSelector() {
    const today = new Date();
    const url = new URL(window.location);
    const search_params = url.searchParams;
    for (let i = 0; i <= 6; i++) {
        const dateIter = new Date();
        dateIter.setDate(today.getDate() + i);
        const dateVal = dateIter.getFullYear() + '-' + (dateIter.getMonth() + 1) + '-' + dateIter.getDate();
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
    document.getElementById(id).checked = true;
    const selectedSlots = document.getElementsByClassName([
        "selectedTimeSlot"
    ]);
    for (i = 0; i < selectedSlots.length; i++) {
        selectedSlots[i].classList.remove("selectedTimeSlot");
    }
    element.classList.add("selectedTimeSlot");
}

initDateSelector();
</script>

</html>