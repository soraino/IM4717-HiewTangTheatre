<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>HiewTang Theatre</title>
    <link rel="stylesheet" href="./css/main.css" />
    <link rel="stylesheet" href="./css/movieDetails.css" />
</head>

<?php
$db = new mysqli('localhost', 'f34ee', 'f34ee', 'f34ee');

if (mysqli_connect_errno()) {
    echo 'Error: Could not connect to database.';
    exit;
}

$selectedMovie = $_GET['movie'];
$sql = "select * from MovieDetail A inner join Photo B on A.Id = B.MovieDetailId and A.Name = '" . $selectedMovie . "'";
$result = $db->query($sql);
$numRows = $result->num_rows;
$movieDetails = $result->fetch_assoc();

?>

<body>
    <nav class="navbar">
        <div class="navbar-menu container">
            <div class="navbar-end">
                <a href="index.php" class="navbar-item"> Home </a>
                <a href="moviesView.php" class="navbar-item"> Movies </a>
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
    <main>
        <div class="banner">
            <div class="container">
                <div class="row">
                    <div class="col size-3 bring-front">
                        <img class="movie-image" src="assets/movie/poster/<?php echo $movieDetails['PhotoUrl']; ?>.jpg" alt="" width="260" />
                    </div>
                    <div class="col size-9">
                        <h1 class="movie-title"><?php echo $movieDetails['Name']; ?></h1>
                        <br />
                        <p><?php echo $movieDetails['Language']; ?></p>
                        <p style="margin-top: 10px;"><?php echo $movieDetails['Genre']; ?></p>
                        <p style="margin-top: 10px;"><?php echo date("F j, Y", strtotime($movieDetails['ReleaseDate']))  ?></p>
                        <p><?php echo $movieDetails['Duration'] ?> Mins</p>
                    </div>
                </div>
            </div>
            <div class="black-bar">
                <div class="container">
                    <div class="row">
                        <div class="col size-3 image-width"></div>
                        <div class="col size-9">
                            <div class="row">
                                <div style="padding: 0" class="col">
                                    <h2 style="margin: 0"><?php echo $movieDetails['Rating']; ?></h3>
                                        <p style="margin: 0">User Ratings</p>
                                </div>
                                <div class="col">
                                    <a href="" class="button float-right">BOOK TICKET</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container padded">
            <section>
                <h1>Screen shot</h1>
                <div id="slider1" class="slider">
                    <div class="wrapper">
                        <div id="slides1" class="slides shifting">
                            <?php
                            for ($counter = 1; $counter <= 5; $counter++) { ?>
                                <div class="slide">
                                    <img src="assets/movie/screenshot/<?php echo $movieDetails['PhotoUrl'] . $counter; ?>.jpg" alt="<?php echo $movieDetails['Name']; ?>" width="260" />
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <a id="prev1" class="control prev" style="top: 23%"></a>
                    <a id="next1" class="control next" style="top: 23%"></a>
                </div>
            </section>
            <div class="row">
                <div class="col">
                    <h3>SYSNOPSIS</h3>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Modi eum mollitia eligendi voluptatum? Perspiciatis minus beatae, consequatur, odit autem maiores nostrum cupiditate ipsa non perferendis quidem quae officiis deleniti mollitia. Consectetur, voluptas assumenda! Atque voluptatem vel hic nobis consequatur sapiente, ullam explicabo perferendis in quo ipsum ipsa repellat possimus ab repellendus alias placeat nemo, mollitia laborum cupiditate blanditiis laboriosam! Voluptas ab animi, a alias ipsum beatae quas, dolore quasi, voluptatem consectetur voluptatum? Reiciendis ut reprehenderit modi dolorem odio labore a corrupti recusandae! Illo qui dolor pariatur! Expedita ad pariatur velit harum placeat, qui autem vel veritatis facere aut dolorem quod?</p>
                </div>
                <div class="col">
                    <h3>DIRECTOR</h3>
                    <ul>
                        <li>Lorem ipsum dolor sit amet.</li>
                        <li>Lorem ipsum dolor sit amet.</li>
                        <li>Lorem ipsum dolor sit amet.</li>
                    </ul>
                    <h3>CAST</h3>
                    <ul>
                        <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis, provident.</li>
                        <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam, fugiat?</li>
                    </ul>
                </div>
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
    initSlider(1);
</script>

</html>