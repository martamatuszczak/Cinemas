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
                        <li><a href="cinemas.php">See all cinemas</a></li>
                        <li class="active"><a href="movies.php">See all movies</a></li>
                        <li><a href="buy_ticket.php">Buy ticket</a></li>
                        <li><a href="admin.php">Admin</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <div class="jumbotron">
                <div class="container text-center">
                    <h1>All movies</h1>      
                </div>
            </div>
            <div class="row">
 
                <div class="col-md-12">
                <?php
                require_once 'connection.php';
                $sql = "SELECT * FROM Movies ORDER BY Movies.title";
                $result = $conn->query($sql);

                if($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<h3>'. $row['title'] . '</h3>';

                        $sqlCinemas = "SELECT * FROM Seans JOIN Cinemas ON Seans.cinemas_id = Cinemas.id
                                    WHERE movies_id = {$row['id']} ORDER BY Cinemas.name";
                        $resultCinemas = $conn->query($sqlCinemas);
                        if($resultCinemas->num_rows > 0) {
                            echo '<ul>';
                            while($rowCinema = $resultCinemas->fetch_assoc()) {
                                echo '<li><b>' . $rowCinema['name'] .'</b> Adres: '. $rowCinema['address'] . '</li>';
                            }
                            echo '</ul>';
                        }
                        else {
                            echo 'No cinema shows this movie';
                        }
                    }
                }
                else {
                    echo 'No movies<br>';
                }
                
                
                ?>
                </div>
            </div>
        </div>
    </body>
</html>