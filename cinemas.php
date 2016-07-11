<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <link href="./css/bootstrap.css" rel="stylesheet">
        <title></title>
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li><a href="index.php">Home</a></li>
                        <li class="active"><a href="cinemas.php">See all cinemas</a></li>
                        <li><a href="movies.php">See all movies</a></li>
                        <li><a href="buy_ticket.php">Buy ticket</a></li>
                        <li><a href="admin.php">Admin</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <div class="jumbotron">
                <div class="container text-center">
                    <h1>All cinemas</h1>      
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                <?php
                require_once 'connection.php';
                $sql = "SELECT * FROM Cinemas ORDER BY Cinemas.name";
                $result = $conn->query($sql);

                if($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<h3>'. $row['name'] . '</h3>';

                        $sqlShows = "SELECT * FROM Seans JOIN Movies ON Seans.movies_id = Movies.id
                                    WHERE cinemas_id = {$row['id']} ORDER BY Movies.title";
                        $resultShows = $conn->query($sqlShows);
                        if($resultShows->num_rows > 0) {
                            echo '<ul>';
                            while($rowShow = $resultShows->fetch_assoc()) {
                                echo '<li><b>' . $rowShow['title'] .'</b> '. $rowShow['date'] .' <b>Time:</b> '. $rowShow['time'] . '</li>';
                            }
                            echo '</ul>';
                        }
                        else {
                            echo 'No shows';
                        }
                    }
                }
                else {
                    echo 'No cinemas<br>';
                }
                
                
                ?>
                </div>
            </div>
        </div>    
    </body>
</html>
