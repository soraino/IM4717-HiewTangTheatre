<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>HiewTang Theatre</title>
    <link rel="stylesheet" href="./css/main.css" />
    <link rel="stylesheet" href="./css/moviesView.css" />
</head>

<body>
    <nav class="navbar">
        <div class="navbar-menu container">
            <div class="navbar-end">
                <a href="index.html" class="navbar-item"> Home </a>
                <a class="navbar-item"> Movies </a>
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
    <main class="container">
        <div id="sorter">
            <label>Sort By: </label> &nbsp;
            <select>
                <option>Now Showing</option>
                <option>Trending</option>
                <option>Coming Soon</option>
            </select>
            <div id="sorter_btn">
                <a href="moviesView.php?view=grid">
                    <button class="gridView-btn">
                        <img src="assets/grid.svg" alt="grid" />
                    </button>
                </a>
                <a href="moviesView.php?view=list">
                    <button class="listView-btn">
                        <img src="assets/list.svg" alt="list" />
                    </button>
                </a>
            </div>
        </div>
        <!-- Movies display -->
        <div id="movieView">
            <!-- <div class="row">
                    <div class="column">Column 1</div>
                    <div class="column">Column 2</div>
                </div>
                <div class="row">
                    <div class="column">Column 3</div>
                    <div class="column">Column 4</div>
                </div> -->
            <?php

            if (isset($_GET['view'])) {
                if ($_GET['view'] == "grid") { ?>
                    <div class="row is-wrap">
                        <?php
                        for ($counter = 0; $counter < 10; $counter++) { ?>
                            <div class="col size-2"><img src="http://placekitten.com/200/250" />
                                <p>Movie Title</p>
                            </div>
                        <?php
                        } ?>
                    </div>
                    <?php
                } else if ($_GET['view'] == "list") {
                    for ($counter = 0; $counter < 10; $counter++) { ?>
                        <div class="row is-wrap">
                            <div class="col size-2">
                                <img src="http://placekitten.com/150/200" />
                            </div>
                            <div class="listView-detail col size-10">
                                <h3>Movie Title</h3>
                                <p>2 Hrs 30 Mins</p>
                                <p>Action | Horror</p>
                                <p>Release Date: July 18, 2020</p>
                                <hr />
                                <span class="float-left">Watch Trailer</span>
                                <span class="float-right"><img src="assets/ticket.svg" alt="ticker" width="30px" height="30px" />&nbsp; Book Ticket</span>
                                <hr />
                            </div>
                        </div>
                    <?php
                    } ?>
                <?php
                }
            } else { ?>
                <div class="row is-wrap">
                    <?php
                    for ($counter = 0; $counter < 10; $counter++) { ?>
                        <div class="col size-2"><img src="http://placekitten.com/200/250" />
                            <p>Movie Title</p>
                        </div>
                <?php
                    }
                }

                ?>
                </div>
    </main>
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