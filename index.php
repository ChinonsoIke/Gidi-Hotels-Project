<?php
    include('config/db_connect.php');

    //sql to create table
    /*$sql= "CREATE TABLE hotels (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    hotelName VARCHAR(30) NOT NULL,
    price VARCHAR(30) NOT NULL,
    picture longblob NOT NULL
    )";

    if (mysqli_query($conn, $sql)) {
        echo 'table created';
    } else {
        echo 'error creating table';
    }*/

    //get hotels from database
    $sqlGetHotels= "SELECT id, hotelName, price, picture, address FROM hotels";

    $result= mysqli_query($conn, $sqlGetHotels);

    $hotels= mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

    <?php include('templates/header.php') ?>

        <main>

            <!--slider-->
            <div id="hotels-slide" class="carousel slide" data-ride= "carousel">
                <ul class="carousel-indicators">
                    <li data-target="#hotels-slide" data-slide-to="0" class="active"></li>
                    <li data-target="#hotels-slide" data-slide-to="1"></li>
                    <li data-target="#hotels-slide" data-slide-to="2"></li>
                    <li data-target="#hotels-slide" data-slide-to="3"></li>
                </ul>
                <div class="carousel-caption">
                    <h2>Find and book hotels in Lagos.</h2>
                    <p>Search through over 5,000 hotels</p>
                </div>
                <div class="carousel-inner">
                    <div class= "carousel-item active">
                        <img src="./assets/hotel1.jpg" alt="Banner 1" width= "1100" height= "500">
                    </div>
                    <div class= "carousel-item">
                        <img src="./assets/hotel2.jpg" alt="Banner 2" width= "1100" height= "500">
                    </div>
                    <div class= "carousel-item">
                        <img src="./assets/hotel3.jpg" alt="Banner 3" width= "1100" height= "500">
                    </div>
                    <div class= "carousel-item">
                        <img src="./assets/hotel4.jpg" alt="Banner 4" width= "1100" height= "500">
                    </div>
                </div>
                <!-- Left and right controls -->
                <a class="carousel-control-prev" href="#hotels-slide" data-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </a>
                <a class="carousel-control-next" href="#hotels-slide" data-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </a>
            </div>
            <!--/slider-->
            <div class="container table">
                <?php foreach ($hotels as $hotel) : ?>
                    <div class="card table-card">
                        <div class="card-body">
                            <img class= "table-pics" width= "200" height= "200" src= "data:image/jpg;charset=utf8;base64,<?php echo base64_encode($hotel['picture']); ?>"/>
                            <h4 class="name-hotel text-center"><?php echo $hotel['hotelName']; ?></h4>
                            <h6 class="address text-center text-secondary"><?php echo $hotel['address']; ?></h6>
                            <h5 class="price"><?php echo $hotel['price']; ?></h5>
                            <a href="book_form.php?id=<?php echo $hotel['id'] ?>" class= "btn btn-danger btn-book">Book Now</a>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </main>


    <?php include('templates/footer.php') ?>

</html>