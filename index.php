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
                        <li class="active"><a href="index.php">Home</a></li>
                        <li><a href="cinemas.php">See all cinemas</a></li>
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
                    <h1>Cinema network</h1>      
                    <p>
                        <h2>Hello Stranger!</h2>
                        Welcome to our site!
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php
                    require_once 'connection.php';
                
                
                    ?>
                </div>                
            </div>
        </div>
                
    </body>
</html>
