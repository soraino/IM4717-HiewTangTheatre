<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>HiewTang Theatre</title>
        <link rel="stylesheet" href="./css/main.css" />
    </head>
    <body>
        <nav class="navbar">
            <div class="navbar-menu container">
                <a href="./">
                    <div class="logo">
                        <img src="./assets/logo/HiewTangTheatre_dark.png" />
                    </div>
                </a>
                <div class="navbar-start">
                    <a href="./" class="navbar-item"> Home </a>
                    <a href="moviesView.php" class="navbar-item"> Movies </a>
                    <a class="navbar-item"> Check Bookings </a>
                </div>
                <div class="navbar-end">
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
                    <a href="./login.html" class="navbar-item"> Login </a>
                    <a href="./register.html" class="navbar-item"> Register </a>
                </div>
            </div>
        </nav>
        <main class="container center-text" style="margin-top: 150px">
            <h2>YOUR BOOKING DETAILS</h2>
            <h2>
                You’ve booked ticket(s) for
                <span style="color: #ef8f00">TRAIN TO BUSAN</span>
            </h2>
            <h3>
                Reference ID: 8943091389<br />
                Cinema: Nex, Serangoon, Theatre 1 <br />
                Seat: F12, F13<br />
                Date: 28/11/2020<br />
                Time: 9.30 PM<br />
            </h3>
            <br />
            <h2>
                Thank You for your purchase. <br />
                <br />An email containing your ticket and receipt will be sent
                to ${User email}
            </h2>
            <br />
            <a href="./" class="button">Return to Home Page</a>
        </main>
        <footer class="footer">
            <div class="footer-content">
                <div class="container">
                    <p>Copyright lol</p>
                </div>
            </div>
        </footer>
    </body>
    <script>
        if (window.location.href.indexOf("?") < 0) {
            window.location.replace("./");
        }
    </script>
</html>
