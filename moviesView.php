<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>HiewTang Theatre</title>
    <link rel="icon" type="image/png" href="assets/logo/favicon.ico" />
    <link rel="stylesheet" href="./css/main.css" />
    <link rel="stylesheet" href="./css/moviesView.css" />
</head>

<script>
    //Sorting is activated
    function doReload(Sort) {
        <?php
        if (isset($_GET['Search'])) {
        ?>
            document.location = 'moviesView.php?Sort=' + Sort + '&Search=<?php echo $_GET['Search']; ?>'
        <?php
        } else if (isset($_GET['View'])) {
        ?>
            document.location = 'moviesView.php?Sort=' + Sort + '&View=<?php echo $_GET['View']; ?> '
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

session_start();

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
    } else {
        $filter = "";
    }
}

?>

<body>
    <?php
    include "./navbar.php";
    ?>
    <!-- End of navigation bar -->
    <main class="container">
        <div id="sorter">
            <label>Sort By: </label> &nbsp;
            <div class="select_box">
                <select id="Sort" name="Sort" onChange="doReload(this.value)">
                    <?php
                    if (isset($_GET['Sort']) && $_GET['Sort'] != "") {
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
            </div>
            <div id="sorter_btn">
                <a href="moviesView.php?Sort=<?php echo $_GET['Sort']; ?>&View=grid&Search=<?php echo $_GET['Search']; ?>">
                    <button class="gridView-btn">
                        <img src="assets/grid.svg" alt="grid" />
                    </button>
                </a>
                <a href="moviesView.php?Sort=<?php echo $_GET['Sort']; ?>&View=list&Search=<?php echo $_GET['Search']; ?>">
                    <button class="listView-btn">
                        <img src="assets/list.svg" alt="list" />
                    </button>
                </a>
            </div>
        </div>
        <!-- Movies display -->
        <div id="movieView">
            <?php
            $searchItem = $_GET['Search'];
            $searchItem = preg_replace("#[^0-9a-z]#i", "", $searchItem);
            $sql = "select A.*, B.PhotoUrl from MovieDetail A inner join Photo B on A.Id = B.MovieDetailId where Name LIKE '%$searchItem%'" . $filter;
            $result = $db->query($sql);
            $numRows = $result->num_rows;
            if ($numRows == 0) {
                echo "'No search results'";
            }

            if (isset($_GET['View'])) {
                if ($_GET['View'] == "grid") { ?>
                    <div class="row is-wrap">
                        <?php
                        while ($movieList = $result->fetch_assoc()) { ?>
                            <a href="movieDetails.php?movie=<?php echo $movieList['Id']; ?>">
                                <div class="col size-2">
                                    <img src="assets/movie/poster/<?php echo $movieList['PhotoUrl']; ?>.jpg" alt="" width="230" height="330" />
                                    <p><?php echo $movieList['Name']; ?></p>
                                </div>
                            </a>
                        <?php
                        } ?>
                    </div>
                    <?php
                } else if ($_GET['View'] == "list") {
                    for ($counter = 0; $counter < $numRows; $counter++) { ?>
                        <?php
                        while ($movieList = $result->fetch_assoc()) { ?>
                            <div class="row is-wrap">
                                <div class="col size-2">
                                    <a href="movieDetails.php?movie=<?php echo $movieList['Id']; ?>">
                                        <img src="assets/movie/poster/<?php echo $movieList['PhotoUrl']; ?>.jpg" alt="" width="230" height="330" />
                                    </a>
                                </div>
                                <div class="listView-detail col size-8">
                                    <h3><?php echo $movieList['Name']; ?></h3>
                                    <p><?php echo $movieList['Duration']; ?> Mins</p>
                                    <p><?php echo $movieList['Genre']; ?></p>
                                    <p>Release Date: <?php echo date("F j, Y", strtotime($movieList['ReleaseDate']))  ?></p>
                                    <div>
                                        <hr />
                                        <a href="./movieDetails.php?movie=<?php echo $movieList['Id']; ?>#trailer"><span class="float-left"><img src="assets/play.svg" alt="ticket" width="20px" height="20px" />&nbsp; Watch Trailer</span></a>
                                        <?php
                                        if (time() > strtotime($movieList['ReleaseDate'])) {
                                        ?>
                                            <a href="./booking.php?movie=<?php echo $movieList['Id']; ?>"><span class="float-right"><img src="assets/ticket-alt.svg" alt="ticket" width="28px" />&nbsp; <p class="book-ticket">Book Ticket</p></span></a>
                                        <?php
                                        }
                                        ?>
                                        <hr />
                                    </div>
                                </div>
                            </div>
                        <?php
                        } ?>
                        <!-- End of while lopp -->
                    <?php
                    } ?>
                <?php
                }
            } else { ?>
                <div class="row is-wrap">
                    <?php
                    while ($movieList = $result->fetch_assoc()) { ?>
                        <a href="movieDetails.php?movie=<?php echo $movieList['Id']; ?>">
                            <div class="col size-2"><img src="assets/movie/poster/<?php echo $movieList['PhotoUrl']; ?>.jpg" alt="" width="230" height="330" />
                                <p><?php echo $movieList['Name']; ?></p>
                            </div>
                        </a>
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