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
        echo $_COOKIE["userId"];
            @$DB = new mysqli('localhost', 'f34ee', 'f34ee', 'f34ee');
            $MOVIE_QUERY = "select M.*, P.PhotoUrl from f34ee.MovieDetail as M inner join f34ee.Photo as P where P.MovieDetailId = M.Id order by M.Rating desc;";
            $THEATRE_QUERY = "select distinct Location from f34ee.Theatre;";
            if(mysqli_connect_errno()){
                exit('Unable to connect to db');
            }
            $movies = array();
            $theatres = array();
            $queryResult = $DB->query($MOVIE_QUERY);
            if($queryResult->num_rows > 0){
                while($row = $queryResult->fetch_assoc()){
                    array_push($movies, $row);
                }
            }
            $queryResult = $DB->query($THEATRE_QUERY);
            if($queryResult->num_rows > 0){
                while($row = $queryResult->fetch_assoc()){
                    array_push($theatres, $row);
                }
            }
            $queryResult -> free();
            $DB->close();
            $dateSortMovie = $movies;
            usort($dateSortMovie, function($a, $b) {
                return strtotime($b['ReleaseDate']) - strtotime($a['ReleaseDate']);
            })
        ?>
    <nav class="navbar">
        <div class="navbar-menu container">
            <a href="./">
                <div class="logo">
                    <img src="./assets/logo/HiewTangTheatre_dark.png" />
                </div>
            </a>
            <div class="navbar-start">
                <a href="./" class="navbar-item active"> Home </a>
                <a href="moviesView.php" class="navbar-item"> Movies </a>
                <a class="navbar-item"> Check Bookings </a>
            </div>
            <div class="navbar-end">

                <div class="navbar-item">
                    <input class="input is-rounded" type="text" placeholder="Search" />
                    <svg class="search-icon" viewBox="0 0 12 13">
                        <g stroke-width="2" stroke="#999999" fill="none">
                            <path d="M11.29 11.71l-4-4" />
                            <circle cx="5" cy="5" r="4" />
                        </g>
                    </svg>
                </div>
                <a href="./login.html" class="navbar-item"> Login </a>
                <a href="" class="navbar-item"> Register </a>
            </div>
        </div>
    </nav>
    <div class="carousel-wrapper">
        <div class="carousel">
            <?php
                    for($i = 0; $i < 4; $i++){
                ?>
            <a href="<?php echo './movieDetails.php?movie='.urlencode($movies[$i]['Name'])?>">
                <?php
                        if($i==0){
                ?>
                <img class="carousel__photo initial"
                    src="<?php echo './assets/movie/banner/'.$movies[$i]['PhotoUrl'].'.jpg'; ?>" />
                <?php
                        }else{
                ?>
                <img class="carousel__photo"
                    src="<?php echo './assets/movie/banner/'.$movies[$i]['PhotoUrl'].'.jpg'; ?>" />
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
                                        for($i = 0; $i < count($dateSortMovie); $i++){
                                            if(time() >= strtotime($dateSortMovie[$i]['ReleaseDate'])){
                                                echo '<option value="'.$dateSortMovie[$i]['Id'].'">'.$dateSortMovie[$i]['Name'].'</option>';
                                            }
                                        }
                                    ?>
                                <select>
                        </div>
                    </div>
                    <div class="col center">
                        <label>Location</label>
                        <div class="select">
                            <select name="location" id="locationSelect" onchange="locationSelectorChange(this)"
                                required>
                                <option value="" selected disabled>Select a Location</option>
                                <?php
                                        for($i = 0; $i < count($theatres); $i++){
                                            echo '<option value="'.$theatres[$i]['Location'].'">'.$theatres[$i]['Location'].'</option>';
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
                                for($i = 0; $i < count($dateSortMovie); $i++){
                                    if(time() >= strtotime($dateSortMovie[$i]['ReleaseDate'])){
                            ?>
                        <a href="<?php echo './movieDetails.php?movie='.urlencode($dateSortMovie[$i]['Name'])?>">
                            <div class="slide">
                                <img
                                    src="<?php echo './assets/movie/poster/'.$dateSortMovie[$i]['PhotoUrl'].'.jpg'; ?>" />
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
                                for($i = 0; $i < count($movies); $i++){
                                    if(time() >= strtotime($movies[$i]['ReleaseDate'])){
                            ?>
                        <a href="<?php echo './movieDetails.php?movie='.urlencode($movies[$i]['Name'])?>">
                            <div class="slide">
                                <img src="<?php echo './assets/movie/poster/'.$movies[$i]['PhotoUrl'].'.jpg'; ?>" />
                            </div>
                        </a>
                        <?php
                                        $counter++;
                                    }
                                    if($counter == 5){
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
                                for($i = count($dateSortMovie) - 1; $i >= 0; $i--){
                                    if(time() < strtotime($dateSortMovie[$i]['ReleaseDate'])){
                            ?>
                        <a href="<?php echo './movieDetails.php?movie='.urlencode($dateSortMovie[$i]['Name'])?>">
                            <div class="slide">
                                <img
                                    src="<?php echo './assets/movie/poster/'.$dateSortMovie[$i]['PhotoUrl'].'.jpg'; ?>" />
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
    dateInput.min = dateVar.getFullYear() + '-' + (dateVar.getMonth() + 1) + '-' + dateVar.getDate();
    dateVar.setDate(dateVar.getDate() + 7);
    dateInput.max = dateVar.getFullYear() + '-' + (dateVar.getMonth() + 1) + '-' + dateVar.getDate();
    initSlider(1);
    initSlider(2);
    initSlider(3);
    initCarousel();
}
initialisedPage();
</script>

</html>