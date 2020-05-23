<?php
    include('config/db_connect.php');

    //check request id parameter
    if (isset($_GET['id'])) :
        $id= $_GET['id'];

        //make sql
        $sql= "SELECT * FROM booking_details WHERE booking_id='$id'";

        //make query
        $result= mysqli_query($conn, $sql);

        //fetch result
        $guest= mysqli_fetch_assoc($result);

        mysqli_free_result($result);
        mysqli_close($conn);
        
    endif;

?>

<!DOCTYPE html>
<html lang="en">
<?php include('templates/header.php') ?>

    <div class="container">
        <?php if ($guest) : ?>
            <div class="container text-center">
                <h2 class="text-success">Your reservation is being processed!</h2>
                <p><h6 class="text-secondary">Thank you for booking with us.</h6></p>
            </div>
            <h5 class="text-center detail-text text-secondary">Booking Details</h5>
            <div class="row justify-content-center det-border">
                <div class="detail-row text-secondary text-center">
                    <p>GUEST</p>
                    <p><h6><?php echo $guest['fullname'] ?></h6></p>
                </div>
                <div class="detail-row text-secondary text-center">
                    <p>PHONE NUMBER</p>
                    <p><h6><?php echo $guest['phone_number'] ?></h6></p>
                </div>
                <div class="detail-row text-secondary text-center">
                    <p>EMAIL</p>
                    <p><h6><?php echo $guest['email'] ?></h6></p>
                </div>
                <div class="detail-row text-secondary text-center">
                    <p>BOOKING ID</p>
                    <p><h6><?php echo $guest['booking_id'] ?></h6></p>
                </div>
            </div>
        <?php endif ?>
    </div>

<?php include('templates/footer.php') ?>
</html>