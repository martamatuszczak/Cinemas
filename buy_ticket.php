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
                    <h1>Buy ticket</h1>      
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <h2>Buy tickets</h2>
                    <form method="POST">
                        <div class="form-group">
                            <label>Shows
                                <select name="seans" class="form-control">    
                                    <?php
                                    require_once 'connection.php';
                                    $sql = "SELECT Cinemas.name, Movies.title, Seans.id, Seans.date, Seans.time FROM Seans
                                    JOIN Movies ON Seans.movies_id = Movies.id
                                    JOIN Cinemas ON Seans.cinemas_id = Cinemas.id";
                                    $result = $conn->query($sql);

                                    if($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value = '{$row['id']}'> {$row['name']}: {$row['title']}  Date: {$row['date']}  Time: {$row['time']}</option>";
                                        }
                                    }
                                    else {
                                        echo 'No shows<br>';
                                    }


                                    ?>
                                </select>
                            </label>    
                        </div>
                        <div class="form-group">    
                            <label>Number of tickets
                            <input name="quantity" type="number" min="0" class="form-control"/>
                            </label>
                        </div>
                        <div class="form-group"> 
                            <label>Price
                                <select name="price" class="form-control">
                                    <option value="12">12 PLN - group discount</option>
                                    <option value="15">15 PLN - child discount</option>
                                    <option value="18">18 PLN - normal</option>
                                </select>
                            </label>    
                        </div>
                        <div class="form-group"> 
                            <label>Payment type
                                <select name="type" class="form-control">
                                    <option value="none">Pay later</option>
                                    <option value="transfer">Transfer</option>
                                    <option value="cash">Cash</option>
                                    <option value="card">Card</option>
                                </select>
                            </label>
                        </div>
                        <button type="submit" name="submit" value="seansTicket" class="btn btn-primary">Kup</button>
                    </form>
                </div>
            <div class="col-md-6">
                <?php
                    if($_SERVER['REQUEST_METHOD'] === 'POST')  {

                        if($_POST['quantity'] > 0 && in_array($_POST['price'], ['12', '15','18']) && in_array($_POST['type'], ['transfer', 'cash','card','none'])) {
                            $count = $_POST['quantity'];
                            $price = $_POST['price'];
                            $type = $_POST['type'];
                            $seans = $_POST['seans'];


                            $sql = "INSERT INTO Tickets (quantity, price, seans_id) VALUES ('$count', '$price', '$seans')";

                            if($conn->query($sql)) {
                                echo("Added ticket<br>");
                                $last_id = $conn->insert_id;

                                if(in_array($type, ['transfer', 'cash','card'])) {

                                    $sqlPayment = "INSERT INTO Payments (id, type, date) VALUES ('$last_id', '$type', NOW())";
                                    if($conn->query($sqlPayment)) {
                                        echo("Added payment<br>");
                                    }     
                                    else {
                                        echo("Error adding payment<br>");
                                    }
                                }    
                                else {
                                    echo("Error adding payment<br>");
                                }


                            }
                            else {
                                echo("Error. Ticket not added<br>");
                            }
                        }
                        $sqlTicketInfo = "SELECT Cinemas.name, Movies.title, Seans.id, Tickets.price, Tickets.quantity FROM Seans
                                    JOIN Movies ON Seans.movies_id =Movies.id
                                    JOIN Cinemas ON Seans.cinemas_id = Cinemas.id
                                    JOIN Tickets ON Seans.id = Tickets.seans_id
                                    WHERE Tickets.id = '$last_id'";

                        $resultTicket = $conn->query($sqlTicketInfo); 
                        if($resultTicket->num_rows > 0) {                        
                                while($row = $resultTicket->fetch_assoc()) { 
                                    $cost = $row['quantity'] * $row['price'];
                                    echo("Bought {$row['quantity']} ticket(s) for: {$row['title']} showed in: {$row['name']}<br>");    
                                    echo("Total cost: $cost PLN"); 
                                }
                        }    
                    }
                ?>
                </div>
            </div>
        </div>    
    </body>
</html>

