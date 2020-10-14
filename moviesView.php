<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>HiewTang Theatre</title>
    <link rel="stylesheet" href="./css/main.css" />
    <link rel="stylesheet" href="./css/moviesView.css" />
</head>

<script>
    function doReload(Sort) {
        <?php
        if (isset($_GET['View'])) {
        ?>
            document.location = 'moviesView.php?Sort=' + Sort + '&View=<?php echo $_GET['View']; ?>';
        <?php
        } else {
        ?>
            document.location = 'moviesView.php?Sort=' + Sort;
        <?php
        }
        ?>
    }
</script>

<?php
$db = new mysqli('localhost', 'f34ee', 'f34ee', 'f34ee');

if (mysqli_connect_errno()) {
    echo 'Error: Could not connect to database.';
    exit;
}

$filter = "";
if (isset($_GET['Sort'])) {
    if (($_GET['Sort'] == "Now Showing")) {
        $currentDate = date("Y-m-d H:i:s", time());
        $filter = "and ReleaseDate <= '$currentDate'";
    } else if (($_GET['Sort'] == "Trending")) {
        $filter = "and Rating >= 4";
    } else if (($_GET['Sort'] == "Coming Soon")) {
        $currentDate = date("Y-m-d H:i:s", time());
        $filter = "and ReleaseDate > '$currentDate'";
    }
}

?>

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
            <select id="Sort" name="Sort" onChange="doReload(this.value)">
                <?php
                if (isset($_GET['Sort'])  && $_GET['Sort'] != "") {
                ?>
                    <option selected="selected" hidden><?php echo $_GET['Sort'] ?></option>
                    <option value="Default">Default</option>
                    <option value="Now Showing">Now Showing</option>
                    <option value="Trending">Trending</option>
                    <option value="Coming Soon">Coming Soon</option>
                <?php
                } else {
                ?>
                    <option value="Default">Default</option>
                    <option value="Now Showing">Now Showing</option>
                    <option value="Trending">Trending</option>
                    <option value="Coming Soon">Coming Soon</option>
                <?php
                }
                ?>
            </select>
            <div id="sorter_btn">
                <a href="moviesView.php?Sort=<?php echo $_GET['Sort']; ?>&View=grid">
                    <button class="gridView-btn">
                        <img src="assets/grid.svg" alt="grid" />
                    </button>
                </a>
                <a href="moviesView.php?Sort=<?php echo $_GET['Sort']; ?>&View=list">
                    <button class="listView-btn">
                        <img src="assets/list.svg" alt="list" />
                    </button>
                </a>
            </div>
        </div>
        <!-- Movies display -->
        <div id="movieView">
            <?php


            $sql = "select * from MovieDetail A inner join Photo B on A.Id = B.MovieDetailId " . $filter;
            $result = $db->query($sql);
            $numRows = $result->num_rows;

            if (isset($_GET['View'])) {
                if ($_GET['View'] == "grid") { ?>
                    <div class="row is-wrap">
                        <?php
                        while ($movieList = $result->fetch_assoc()) { ?>
                            <div class="col size-2"><img src="assets/movie/poster/<?php echo $movieList['PhotoUrl']; ?>.jpg" alt="" width="230" height="330" />
                                <p><?php echo $movieList['Name']; ?></p>
                            </div>
                        <?php
                        } ?>
                    </div>
                    <?php
                } else if ($_GET['View'] == "list") {
                    for ($counter = 0; $counter < 10; $counter++) { ?>
                        <div class="row is-wrap">
                            <?php
                            while ($movieList = $result->fetch_assoc()) { ?>
                                <div class="col size-2"><img src="assets/movie/poster/<?php echo $movieList['PhotoUrl']; ?>.jpg" alt="" width="230" height="330" />
                                </div>
                                <div class="listView-detail col size-10">
                                    <h3><?php echo $movieList['Name']; ?></h3>
                                    <p><?php echo $movieList['Duration']; ?></p>
                                    <p><?php echo $movieList['Genre']; ?></p>
                                    <p>Release Date: <?php echo date("F j, Y", strtotime($movieList['ReleaseDate']))  ?></p>

                                    <hr />
                                    <span class="float-left">Watch Trailer</span>
                                    <span class="float-right"><img src="assets/ticket.svg" alt="ticker" width="30px" height="30px" />&nbsp; Book Ticket</span>
                                    <hr />
                                </div>
                            <?php
                            } ?>
                        </div>
                    <?php
                    } ?>
                <?php
                }
            } else { ?>
                <div class="row is-wrap">
                    <?php
                    while ($movieList = $result->fetch_assoc()) { ?>
                        <div class="col size-2"><img src="assets/movie/poster/<?php echo $movieList['PhotoUrl']; ?>.jpg" alt="" width="230" height="330" />
                            <p><?php echo $movieList['Name']; ?></p>
                        </div>
                <?php
                    }
                }
                ?>
                </div>
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