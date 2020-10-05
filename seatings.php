<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/main.css" />
    <link rel="stylesheet" href="./css/seatings.css" />
    <title>Seats selection</title>
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
    <div class="container">
        <div id="top">
            <div class="row">
                <div class="col">
                    <label>Cinema: </label>
                    <select name="cinema" id="cinema">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                </div>
                <div class="col">
                    <label>Date: </label>
                    <input type="date" id="date" name="date">
                </div>
                <div class="col">
                    <label>Time: </label>
                    <select name="time" id="time">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                </div>
            </div>
        </div>
        <div id="selection">
            <!-- outer container -->
            <div class="outer-container">
                <!-- screen -->
                <div class="row screen">Screen</div>
                <!-- seats -->
                <div class="row seats">
                    <!-- seats left -->
                    <div class="col">
                        <div class="row is-wrap">
                            <?php
                            for ($counter = 0; $counter < 30; $counter++) { ?>
                                <div class="col size-2 iseat">A1</div>
                            <?php
                            } ?>
                        </div>
                    </div>
                    <!-- seats right -->
                    <div class="col seats-right">
                        <div class="row is-wrap">
                            <?php
                            for ($counter = 0; $counter < 30; $counter++) { ?>
                                <div class="col size-2 iseat">A1</div>
                            <?php
                            } ?>
                        </div>
                    </div>
                </div>
                <!-- legends -->
                <div class="row legends">
                    <div class="col title">
                        Legends
                        <div class="row boxes">
                            <div class="unavailable"></div>
                            <div class="selected"></div>
                            <div class="available"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div id="payment">

        </div>
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