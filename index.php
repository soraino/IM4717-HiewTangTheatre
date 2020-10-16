<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>HiewTang Theatre</title>
        <link rel="stylesheet" href="./css/main.css" />
        <link rel="stylesheet" href="./css/index.css" />
    </head>
    <body>
        <?php
            @$DB = new mysqli('localhost', 'f34ee', 'f34ee', 'f34ee');
            $MOVIE_QUERY = "select M.*, P.PhotoUrl from f34ee.MovieDetail as M inner join f34ee.Photo as P where P.MovieDetailId = M.Id order by M.Rating desc;";
            if(!$DB){
                exit('Unable to connect to db');
            }
            $movies = array();
            $queryResult = $DB->query($MOVIE_QUERY);
            if($queryResult->num_rows > 0){
                while($row = $queryResult->fetch_assoc()){
                    array_push($movies, $row);
                }
            }
            $queryResult->free();
            $DB->close();
            $dateSortMovie = $movies;
            usort($dateSortMovie, function($a, $b) {
                return strtotime($b['ReleaseDate']) - strtotime($a['ReleaseDate']);
            })
        ?>
        <nav class="navbar">
            <div class="navbar-menu container">
                <div class="navbar-end">
                    <a class="navbar-item"> Home </a>
                    <a href="moviesView.php" class="navbar-item"> Movies </a>
                    <a class="navbar-item"> Check Bookings </a>
                    <div class="navbar-item">
                        <input
                            class="input is-rounded"
                            type="text"
                            placeholder="Search"
                        />
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
        <div class="carousel-wrapper">
            <div class="carousel">
                <?php
                    for($i = 0; $i < 4; $i++){
                        if($i==0){
                ?>
                    <img
                        class="carousel__photo initial"
                        src="<?php echo './assets/movie/banner/'.$movies[$i]['PhotoUrl'].'.jpg'; ?>"
                    />
                <?php
                        }else{
                ?>
                    <img
                        class="carousel__photo"
                        src="<?php echo './assets/movie/banner/'.$movies[$i]['PhotoUrl'].'.jpg'; ?>"
                    />
                <?php
                        }
                    }
                ?>
                <div class="carousel__button--next"></div>
                <div class="carousel__button--prev"></div>
            </div>
        </div>
        <main class="container">
            <div class="box">
                <h2>Quick Purchase</h2>
                <form>
                    <div class="row">
                        <div class="col center">
                            <label>Movie</label>
                            <div class="select">
                                <select>
                                <option>test</option>    
                                <select>
                            </div>
                        </div>
                        <div class="col center">
                            <label>Location</label>
                            <div class="select">
                                <select>
                                <option>test</option>    
                                <select>
                            </div>
                        </div>
                        <div class="col center">
                            <label>Date</label>
                            <input type="date" name="date" id="dateInput" class="input is-rounded">
                        </div>
                        <div class="col center">
                            <label>Timeslot</label>
                            <div class="select">
                                <select>
                                <option>test</option>    
                                <select>
                            </div>
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
                                <div class="slide">
                                    <img
                                        src="<?php echo './assets/movie/poster/'.$dateSortMovie[$i]['PhotoUrl'].'.jpg'; ?>"
                                    />
                                </div>
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
                                <div class="slide">
                                    <img
                                        src="<?php echo './assets/movie/poster/'.$movies[$i]['PhotoUrl'].'.jpg'; ?>"
                                    />
                                </div>
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
                                for($i = count($movies) - 1; $i >= 0; $i--){
                                    if(time() < strtotime($dateSortMovie[$i]['ReleaseDate'])){
                            ?>
                                <div class="slide">
                                    <img
                                        src="<?php echo './assets/movie/poster/'.$dateSortMovie[$i]['PhotoUrl'].'.jpg'; ?>"
                                    />
                                </div>
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
    <script>
        
        const slidesContainers = document.querySelectorAll(".slide-container");
        const wrapper = document.querySelector(".wrapper");

        // Variables to target our base class,  get carousel items, count how many carousel items there are, set the slide to 0 (which is the number that tells us the frame we're on), and set motion to true which disables interactivity.
        const itemClassName = "carousel__photo";
        const items = document.getElementsByClassName(itemClassName);
        const totalItems = items.length;
        let slide = 0;
        let moving = true;
        // To initialise the carousel we'll want to update the DOM with our own classes
        function setInitialClasses() {
            // Target the last, initial, and next items and give them the relevant class.
            // This assumes there are three or more items.
            items[totalItems - 1].classList.add("prev");
            items[0].classList.add("active");
            items[1].classList.add("next");
        }
        // Set click events to navigation buttons
        function setEventListeners() {
            const next = document.getElementsByClassName(
                "carousel__button--next"
            )[0];
            const prev = document.getElementsByClassName(
                "carousel__button--prev"
            )[0];
            next.addEventListener("click", moveNext);
            prev.addEventListener("click", movePrev);
        }

        // Disable interaction by setting 'moving' to true for the same duration as our transition (0.5s = 500ms)
        function disableInteraction() {
            moving = true;
            setTimeout(function () {
                moving = false;
            }, 500);
        }
        function moveCarouselTo(slide) {
            // Check if carousel is moving, if not, allow interaction
            if (!moving) {
                // temporarily disable interactivity
                disableInteraction();
                // Preemptively set variables for the current next and previous slide, as well as the potential next or previous slide.
                let newPrevious = slide - 1;
                let newNext = slide + 1;
                let oldPrevious = slide - 2;
                let oldNext = slide + 2;
                // Checks if the new potential slide is out of bounds and sets slide numbers
                if (newPrevious <= 0) {
                    oldPrevious = totalItems - 1;
                } else if (newNext >= totalItems - 1) {
                    oldNext = 0;
                }
                // Check if current slide is at the beginning or end and sets slide numbers
                if (slide === 0) {
                    newPrevious = totalItems - 1;
                    oldPrevious = totalItems - 2;
                    oldNext = slide + 1;
                } else if (slide === totalItems - 1) {
                    newPrevious = slide - 1;
                    newNext = 0;
                    oldNext = 1;
                }

                // Now we've worked out where we are and where we're going, by adding and removing classes, we'll be triggering the carousel's transitions.
                // Based on the current slide, reset to default classes.
                items[oldPrevious].className = itemClassName;
                items[oldNext].className = itemClassName;
                // Add the new classes
                items[newPrevious].className = itemClassName + " prev";
                items[slide].className = itemClassName + " active";
                items[newNext].className = itemClassName + " next";
            }
        }
        // Next navigation handler
        function moveNext() {
            // Check if moving
            if (!moving) {
                // If it's the last slide, reset to 0, else +1
                if (slide === totalItems - 1) {
                    slide = 0;
                } else {
                    slide++;
                }

                // Move carousel to updated slide
                moveCarouselTo(slide);
            }
        }
        // Previous navigation handler
        function movePrev() {
            // Check if moving
            if (!moving) {
                // If it's the first slide, set as the last slide, else -1
                if (slide === 0) {
                    slide = totalItems - 1;
                } else {
                    slide--;
                }

                // Move carousel to updated slide
                moveCarouselTo(slide);
            }
        }

        // Initialise carousel
        function initCarousel() {
            setInitialClasses();
            setEventListeners();
            // Set moving to false now that the carousel is ready
            moving = false;
        }
        
        function initialisedPage(){
            const dateInput = document.getElementById('dateInput');
            const dateVar = new Date();
            dateInput.min = dateVar.getFullYear() +'-' +(dateVar.getMonth() + 1)+'-' + dateVar.getDate();
            dateVar.setDate(dateVar.getDate() + 7);
            dateInput.max = dateVar.getFullYear() +'-' +(dateVar.getMonth() + 1)+'-' + dateVar.getDate();
            initSlider(1);
            initSlider(2);
            initSlider(3);
            initCarousel();
        }
        initialisedPage();

    </script>
</html>
