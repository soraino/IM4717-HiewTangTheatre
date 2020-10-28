<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>HiewTang Theatre</title>
    <link rel="icon" type="image/png" href="assets/logo/favicon.ico" />
    <link rel="stylesheet" href="./css/main.css" />
    <link rel="stylesheet" href="./css/index.css" />
</head>

<body>
    <?php
    include "./navbar.php";
    session_start();
    @$DB = new mysqli('localhost', 'f34ee', 'f34ee', 'f34ee');
    $MOVIE_QUERY = "select M.*, P.PhotoUrl from f34ee.MovieDetail as M inner join f34ee.Photo as P where P.MovieDetailId = M.Id order by M.Rating desc;";
    $THEATRE_QUERY = "select distinct Location from f34ee.Theatre;";

    $sql_userDetails = "select * from User where Id = '" . $_COOKIE['userId'] . "'";
    $run_userDetails = $DB->query($sql_userDetails);
    $result_userDetails =  mysqli_fetch_assoc($run_userDetails);

    if (mysqli_connect_errno()) {
        exit('Unable to connect to db');
    }
    session_start();

    $movies = array();
    $theatres = array();
    $queryResult = $DB->query($MOVIE_QUERY);
    if ($queryResult->num_rows > 0) {
        while ($row = $queryResult->fetch_assoc()) {
            array_push($movies, $row);
        }
    }
    $queryResult = $DB->query($THEATRE_QUERY);
    if ($queryResult->num_rows > 0) {
        while ($row = $queryResult->fetch_assoc()) {
            array_push($theatres, $row);
        }
    }
    $queryResult->free();
    $DB->close();
    $dateSortMovie = $movies;
    usort($dateSortMovie, function ($a, $b) {
        return strtotime($b['ReleaseDate']) - strtotime($a['ReleaseDate']);
    })
    ?>
    <div class="carousel-wrapper">
        <div class="carousel">
            <?php
            for ($i = 0; $i < 4; $i++) {
            ?>
                <a href="<?php echo './movieDetails.php?movie=' . urlencode($movies[$i]['Id']) ?>">
                    <?php
                    if ($i == 0) {
                    ?>
                        <img class="carousel__photo initial" src="<?php echo './assets/movie/banner/' . $movies[$i]['PhotoUrl'] . '.jpg'; ?>" />
                    <?php
                    } else {
                    ?>
                        <img class="carousel__photo" src="<?php echo './assets/movie/banner/' . $movies[$i]['PhotoUrl'] . '.jpg'; ?>" />
                    <?php
                    }
                    ?>
                </a>
            <?php
            }
            ?>
            <div class="carousel__button--next"></div>
            <div class="carousel__button--prev"></div>
        </div>
    </div>
    <main class="container">
        <div class="box">
            <h2>Quick Purchase</h2>
            <form method="GET" action="./booking.php">
                <div class="row">
                    <div class="col center">
                        <label>Movie</label>
                        <div class="select">
                            <select name="movie" id="movieSelect" onchange="movieSelectorChange(this)" required>
                                <option value="" selected disabled>Select a movie</option>
                                <?php
                                for ($i = 0; $i < count($dateSortMovie); $i++) {
                                    if (time() >= strtotime($dateSortMovie[$i]['ReleaseDate'])) {
                                        echo '<option value="' . $dateSortMovie[$i]['Id'] . '">' . $dateSortMovie[$i]['Name'] . '</option>';
                                    }
                                }
                                ?>
                                <select>
                        </div>
                    </div>
                    <div class="col center">
                        <label>Location</label>
                        <div class="select">
                            <select name="location" id="locationSelect" onchange="locationSelectorChange(this)" required>
                                <option value="" selected disabled>Select a Location</option>
                                <?php
                                for ($i = 0; $i < count($theatres); $i++) {
                                    echo '<option value="' . $theatres[$i]['Location'] . '">' . $theatres[$i]['Location'] . '</option>';
                                }
                                ?>
                                <select>
                        </div>
                    </div>
                    <div class="col center">
                        <label>Date</label>
                        <input type="date" name="date" id="dateInput" class="input is-rounded" required>
                    </div>
                </div><br>
                <div class="clearfix">
                    <button class="button float-right" type="submit">Book Now</button>
                </div>
            </form>
        </div>
        <div>
            <h2>Now Showing</h2>
            <div id="slider1" class="slider">
                <div class="wrapper">
                    <div id="slides1" class="slides shifting">
                        <?php
                        for ($i = 0; $i < count($dateSortMovie); $i++) {
                            if (time() >= strtotime($dateSortMovie[$i]['ReleaseDate'])) {
                        ?>
                                <a href="<?php echo './movieDetails.php?movie=' . urlencode($dateSortMovie[$i]['Id']) ?>">
                                    <div class="slide">
                                        <img src="<?php echo './assets/movie/poster/' . $dateSortMovie[$i]['PhotoUrl'] . '.jpg'; ?>" />
                                    </div>
                                </a>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <a id="prev1" class="control prev" style="top: 32%"></a>
                <a id="next1" class="control next" style="top: 32%"></a>
            </div>
        </div>
        <div>
            <h2>Trending</h2>
            <div id="slider2" class="slider">
                <div class="wrapper">
                    <div id="slides2" class="slides shifting">
                        <?php
                        $counter = 0;
                        for ($i = 0; $i < count($movies); $i++) {
                            if (time() >= strtotime($movies[$i]['ReleaseDate'])) {
                        ?>
                                <a href="<?php echo './movieDetails.php?movie=' . urlencode($movies[$i]['Id']) ?>">
                                    <div class="slide">
                                        <img src="<?php echo './assets/movie/poster/' . $movies[$i]['PhotoUrl'] . '.jpg'; ?>" />
                                    </div>
                                </a>
                        <?php
                                $counter++;
                            }
                            if ($counter == 5) {
                                break;
                            }
                        }
                        ?>
                    </div>
                </div>
                <a id="prev2" class="control prev" style="top: 60%"></a>
                <a id="next2" class="control next" style="top: 60%"></a>
            </div>
        </div>
        <div>
            <h2>Upcoming</h2>
            <div id="slider3" class="slider">
                <div class="wrapper">
                    <div id="slides3" class="slides shifting">
                        <?php
                        for ($i = count($dateSortMovie) - 1; $i >= 0; $i--) {
                            if (time() < strtotime($dateSortMovie[$i]['ReleaseDate'])) {
                        ?>
                                <a href="<?php echo './movieDetails.php?movie=' . urlencode($dateSortMovie[$i]['Id']) ?>">
                                    <div class="slide">
                                        <img src="<?php echo './assets/movie/poster/' . $dateSortMovie[$i]['PhotoUrl'] . '.jpg'; ?>" />
                                    </div>
                                </a>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <a id="prev3" class="control prev" style="top: 85%"></a>
                <a id="next3" class="control next" style="top: 85%"></a>
            </div>
        </div>
    </main>
    <footer class="footer">
        <div class="footer-content">
            <div class="container">
                <p>Copyright lol</p>
            </div>
        </div>
    </footer>
</body>
<script src="./js/slider.js"></script>
<script src="./js/bannerSlider.js"></script>
<script>
    const movieSelector = document.getElementById('movieSelect');
    const locationSelector = document.getElementById('locationSelect');

    function initialisedPage() {
        const dateInput = document.getElementById('dateInput');
        const dateVar = new Date();
        let day = dateVar.getDate()<10? `0${dateVar.getDate()}`: dateVar.getDate();
        dateInput.min = dateVar.getFullYear() + '-' + (dateVar.getMonth() + 1) + '-' + day;
        dateVar.setDate(dateVar.getDate() + 6);
        day = dateVar.getDate()<10? `0${dateVar.getDate()}`: dateVar.getDate();
        dateInput.max = dateVar.getFullYear() + '-' + (dateVar.getMonth() + 1) + '-' + day; 
        initSlider(1);
        initSlider(2);
        initSlider(3);
        initCarousel();
    }
    initialisedPage();
</script>

</html>