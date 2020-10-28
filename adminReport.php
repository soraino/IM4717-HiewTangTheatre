<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Report</title>
    <link rel="icon" type="image/png" href="assets/logo/favicon.ico" />
    <link rel="stylesheet" href="./css/main.css" />

    <style>
        h3 {
            background-color: #ffc66b;
            margin: 0;
            margin-top: 20px;
            padding: 10px;
            margin-bottom: 10px;
        }

        .filter {
            width: 90%;
            margin: 0 auto;
            margin-bottom: 20px;
        }

        table,
        tr,
        th,
        td {
            border: 1px solid black;
        }

        table {
            border-collapse: collapse;
            width: 90%;
            margin: 0 auto;
        }

        th,
        td {
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #ffb34f;
        }

        tr:nth-child(even) {
            background-color: #ffe6c4;
        }

        tr:nth-child(odd) {
            background-color: #fff4e6;
        }

        input[type="submit"] {
            margin-left: 80px;
        }
    </style>
</head>

<body>
    <?php
    @$DB = new mysqli('localhost', 'f34ee', 'f34ee', 'f34ee');

    $month = $_POST['month'];
    $year = $_POST['year'];

    $sql_location = "SELECT distinct Location FROM Theatre";
    $run_location = $DB->query($sql_location);

    ?>

    <main class="container">
        <form action="./adminReport.php" method="POST">
            <h3>Admin - Report : Bookings by Day of Week</h3>
            <div class="row filter">
                <div class="col size-2">
                    <div class="select">
                        <select name="month" required>
                            <option selected disabled value="">-- Select a month --</option>
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                    </div>
                </div>
                <div class="col size-2">
                    <input class="input" type="text" name="year" minlength="4" maxlength="4" placeholder="e.g. 2020" required>
                </div>
                <div class="col size-2">
                    <input class="button" type="submit" value="Generate">
                </div>

            </div>
            <div class="row">
                <table>
                    <tr>
                        <th></th>
                        <th>Sunday</th>
                        <th>Monday</th>
                        <th>Tueday</th>
                        <th>Wednesday</th>
                        <th>Thursday</th>
                        <th>Friday</th>
                        <th>Saturday</th>
                    </tr>
                    <?php
                    while ($result_location = $run_location->fetch_assoc()["Location"]) {
                    ?>
                        <tr>
                            <th><?php echo $result_location ?></th>

                            <?php

                            $arrayDay = array();

                            $sql = "SELECT count(t.BookingId) as quantity, th.Location,DAYOFWEEK(b.PremiereDate) as DayOfWeek 
                                from f34ee.Ticket as t 
                                inner join f34ee.Booking as b on b.Id = t.BookingId 
                                inner join f34ee.Timeslot as ts on ts.Id = b.TimeslotId
                                join f34ee.Theatre as th on ts.TheatreId = th.Id
                                where YEAR(b.PremiereDate) = '$year' AND MONTH(b.PremiereDate) = '$month' and TheatreId and th.Location = '$result_location'
                                group by DAYOFWEEK(b.PremiereDate), th.Location";
                            $run = $DB->query($sql);

                            while ($result = $run->fetch_assoc()) {
                                $arrayDay[$result['DayOfWeek']] = $result['quantity'];
                            }
                            for ($i = 1; $i <= 7; $i++) {
                            ?>
                                <td><?php echo $arrayDay[$i] ? $arrayDay[$i] : "0" ?></td>
                        <?php
                            }
                            echo "</tr>";
                        }

                        ?>
                </table>
            </div>
        </form>
    </main>

</body>

</html>