<!DOCTYPE html>
<?php
require_once 'connection.php';
?>
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
                        <li><a href="movies.php">See all movies</a></li>
                        <li><a href="buy_ticket.php">Buy ticket</a></li>
                        <li class="active"><a href="admin.php">Admin</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <div class="jumbotron">
                <div class="container text-center">
                    <h1>Welcome Admin!</h1>  
                    <p>What do you want to do?</p>
                    <?php
                        if($_SERVER['REQUEST_METHOD'] === 'POST') {

                        switch($_POST['submit']){

                            case 'cinema':
                                $name = isset($_POST['name']) && strlen($_POST['name']) > 0 ?$_POST['name'] :null;
                                $address = isset($_POST['address']) && strlen($_POST['address']) > 0 ?$_POST['address'] :null;

                                if($name && $address) {
                                    $sql = "INSERT INTO Cinemas (name, address) VALUES ('$name', '$address')";

                                    if($conn->query($sql)) {
                                        echo("Added new cinema");
                                    }
                                    else {
                                        echo("Error adding new cinema");
                                    }    
                                }
                                else {
                                    echo("Connection error");
                                }

                                break;

                            case 'film':
                                $title = isset($_POST['title']) && strlen($_POST['title']) > 0 ?$_POST['title'] :null;
                                $description = isset($_POST['description']) && strlen($_POST['description']) > 0 ?$_POST['description'] :null;
                                $rating = isset($_POST['rating']) && $_POST['rating'] >= 0.0 && $_POST['rating'] <= 10.0?$_POST['rating'] :null;

                                if($title && $description && $rating) {
                                    $sql = "INSERT INTO Movies (title, description, rating) VALUES ('$title', '$description', '$rating')"; 

                                    if($conn->query($sql)) {
                                        echo("Added new movie");
                                    }
                                    else {
                                        echo("Error adding new movie");
                                    }
                                }
                                else {
                                    echo("Connection error");
                                }
                                break;
                            
                            case 'show':
                                if(isset($_POST['cinema']) && isset($_POST['movie']) && isset($_POST['date']) && isset($_POST['time'])) {
        
                                    $sql = "INSERT INTO Seans (cinemas_id, movies_id, date, time) VALUES ('{$_POST['cinema']}', '{$_POST['movie']}', '{$_POST['date']}', '{$_POST['time']}')";
                                    if($conn->query($sql)) {
                                        echo("Added new show");
                                    }
                                    else {
                                        echo("Error adding new show");
                                    }
                                }
                                else {
                                    echo("Connection error");
                                }
                                break;  
                        }
                    }   
                    ?>
                </div>
            </div>
                
            <div class="row">
                <div class="col-md-4">
                    <h3>Add show</h3>
                    <form method="POST">
                        <div class="form-group">
                            <label>Cinema name<br>
                                <select name="cinema" class="form-control">
                                    <?php                    
                                    $sql = "SELECT * FROM Cinemas";
                                    $result = $conn->query($sql);                   
                                    if($result->num_rows > 0) {                        
                                        while($row = $result->fetch_assoc()) {                            
                                            echo("<option value = '{$row['id']}'> {$row['name']} </option>");                            
                                        }
                                    }
                                    ?>
                                </select>
                            </label>
                        </div>
                        <div class="form-group">
                            <label>Movie title<br>
                                <select name="movie" class="form-control">
                                    <?php
                                    $sql = "SELECT * FROM Movies";
                                    $result = $conn->query($sql);                   
                                    if($result->num_rows > 0) {  
                                        while($row = $result->fetch_assoc()) {    
                                            echo("<option value = '{$row['id']}'> {$row['title']} </option>");    
                                        }
                                    }
                                    ?>
                                </select>
                            </label>
                        </div>
                        <div class="form-group">
                            <label>Date
                                <input type="date" name="date" class="form-control">
                            </label>
                        </div>
                        <div class="form-group">
                            <label>Time
                                <input type="time" name="time" class="form-control">
                            </label>
                        </div>
                        <button type="submit" name="submit" value="show" class="btn btn-primary">Add</button>   
                    </form>
                </div>
                <div class="col-md-4">
                    <form method="post" action="#">
                        <h3>Add cinema</h3>
                        <div class="form-group">
                            <label>Name</label>
                            <input name="name" class="form-control" type="text" maxlength="255" value=""/>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input name="address" class="form-control" type="text" maxlength="255" value=""/>
                        </div>
                        <button type="submit" name="submit" value="cinema" class="btn btn-primary">Add</button>
                    </form>
                </div> 
                <div class="col-md-4">
                    <form method="post" action="#">
                        <h3>Add movie</h3>
                        <div class="form-group">
                            <label>Title</label>
                            <input name="title" class="form-control" type="text" maxlength="255" value=""/>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <input name="description" class="form-control" type="text" maxlength="255" value=""/>
                        </div>
                        <div class="form-group">
                            <label>Rating</label>
                            <input name="rating" class="form-control" type="number" min="0.0" step="0.1" max="10.0"/>
                        </div>
                        <button type="submit" name="submit" value="film" class="btn btn-primary">Add</button>
                    </form>
                </div>
            </div> 
            <hr>
            <div class="row">
            <div class="col-md-12 text-center">
                <h2>Show payments</h2>
                <form method="POST">
                    <div class="btn-group">
                    <button type="submit" name="submit" value="transfer" class="btn btn-primary">Transfer</button>
                    <button type="submit" name="submit" value="cash" class="btn btn-primary">Cash</button>
                    <button type="submit" name="submit" value="card" class="btn btn-primary">Card</button>
                    <button type="submit" name="submit" value="none" class="btn btn-primary">Not payed for</button>
                    </div>
                </form>

                <?php
                if($_SERVER['REQUEST_METHOD'] === 'POST') {

                    switch($_POST['submit']) {

                       case "transfer":
                           $sql = "SELECT Tickets.* FROM Tickets JOIN Payments ON Tickets.id=Payments.id WHERE type='transfer'";

                           $result = $conn->query($sql);
                           if($result->num_rows > 0) {
                               while($row = $result->fetch_assoc()) {
                                   echo("Number of tickets: " . $row['quantity'] . " Price: ". $row['price'] . "<br>");
                               }
                           }
                           else {
                               echo("No tickets");
                           }
                           break;

                       case "cash":
                           $sql = "SELECT Tickets.* FROM Tickets JOIN Payments ON Tickets.id=Payments.id WHERE type='cash'";

                           $result = $conn->query($sql);
                           if($result->num_rows > 0) {
                               while($row = $result->fetch_assoc()) {
                                   echo("Number of tickets: " . $row['quantity'] . " Price: ". $row['price'] . "<br>");
                               }
                           }
                           else {
                               echo("No tickets");
                           }
                           break;

                       case "card":
                           $sql = "SELECT Tickets.* FROM Tickets JOIN Payments ON Tickets.id=Payments.id WHERE type='card'";

                           $result = $conn->query($sql);
                           if($result->num_rows > 0) {
                               while($row = $result->fetch_assoc()) {
                                   echo("Number of tickets: " . $row['quantity'] . " Price: ". $row['price'] . "<br>");
                               }
                           }
                           else {
                               echo("No tickets");
                           }
                           break;

                       case "none":
                           $sql = "SELECT Tickets.* FROM Tickets LEFT JOIN Payments ON Tickets.id=Payments.id WHERE type IS NULL";

                           $result = $conn->query($sql);
                           if($result->num_rows > 0) {
                               while($row = $result->fetch_assoc()) {
                                   echo("Number of tickets: " . $row['quantity'] . " Price: ". $row['price'] . "<br>");
                               }
                           }
                           else {
                               echo("No tickets");
                           }
                           break;
                    }
                }
                ?>
            </div>
        </div>
        </div>
    </body>
</html>