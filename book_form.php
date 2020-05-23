<?php

    require('booking_form_validator.php');
    include('config/db_connect.php');

    //check request id parameter
    if (isset($_GET['id'])) :
        $id= mysqli_real_escape_string($conn, $_GET['id']);

        //make sql
        $sql= "SELECT * FROM hotels WHERE id=$id";

        //make query
        $result= mysqli_query($conn, $sql);

        //fetch result
        $hotel= mysqli_fetch_assoc($result);

        mysqli_free_result($result);
        //mysqli_close($conn);
    endif;

    $errors = [];

    if(isset($_POST['submit'])){
        // validate entries
        $validation = new BookingFormValidator($_POST);
        $errors = $validation->validateForm();
        $idget= $_POST['booking-id'];
    
        // if errors is empty --> save data to db
        if (count($errors) >0) {
            print_r($errors);
        } else {
            $email= mysqli_real_escape_string($conn, $_POST['email']);
            $fullName= mysqli_real_escape_string($conn, $_POST['fullname']);
            $phone_number= mysqli_real_escape_string($conn, $_POST['phonenumber']);
            $checkinDate= mysqli_real_escape_string($conn, $_POST['check-in-date']);
            $checkoutDate= mysqli_real_escape_string($conn, $_POST['check-out-date']);
            $additionalRequests= mysqli_real_escape_string($conn, $_POST['add-requests']);
            $bookingId= $_POST['booking-id'];

            $sqlSave= "INSERT INTO booking_details(fullname, email, phone_number, checkin_date, checkout_date, additional_requests, booking_id) 
            VALUES('$fullName', '$email', '$phone_number', '$checkinDate', '$checkoutDate', '$additionalRequests', '$bookingId')";

            if (mysqli_query($conn, $sqlSave)) {
                //success
                header('Location: booking_details.php?id=' .$idget );
            } else {
                echo 'query  error:' . mysqli_error($conn);
            }
            mysqli_close($conn);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <?php include('templates/header.php') ?>

        <div class="container">
            <?php if ($hotel) : ?>
                <div class="card table-card">
                    <div class="card-body">
                        <img class= "table-pics" width= "200" height= "200" src= "data:image/jpg;charset=utf8;base64,<?php echo base64_encode($hotel['picture']); ?>"/>
                        <h4 class="name-hotel text-center"><?php echo $hotel['hotelName']; ?></h4>
                        <p class="address text-center text-secondary"><?php echo $hotel['address']; ?></p>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="card form-card">
                        <form action="book_form.php?id=<?php echo $_GET['id'] ?>" method="POST" class="white">
                            <div class="form-group">
                                <label>Full Name</label>
                                <span class="error">*</span>
                                <input type="text" name="fullname" value="<?php //echo htmlspecialchars($fullname) ?>">
                                <div class="text-danger"><?php echo $errors['fullname']  ?? '' ?></div>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <span class="error">*</span>
                                <input type="text" name="email" value="<?php //echo htmlspecialchars($email) ?>">
                                <div class="text-danger"><?php echo $errors['email'] ?? '' ?></div>
                            </div>
                            <div class="form-group">
                                <label>Phone Number</label>
                                <span class="error">*</span>
                                <input type="text" name="phonenumber" value="<?php //echo htmlspecialchars($phoneNumber) ?>">
                                <div class="text-danger"><?php echo $errors['phonenumber'] ?? '' ?></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Check-in Date</label>
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' name= "check-in-date" class="form-control" />
                                    <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Check-out Date</label>
                                <div class='input-group date' id='datetimepicker2'>
                                    <input type='text' name="check-out-date" class="form-control" />
                                    <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Additional Requests</label>
                                <textarea name="add-requests" cols="30" rows="5"></textarea>
                            </div>
                            <input type="hidden" id="booking-id" name="booking-id" value="<?php echo uniqid() ?>">
                            <div class="center">
                                <button type="submit" name="submit" class="btn btn-danger">Book Reservation</button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <footer class="section">
            <div class="text-center text-secondary">Copyright 2020 Gidi Hotels</div>
        </footer>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script> -->
        <script>
            $(function () {
                $('#datetimepicker1').datetimepicker();
            });
            $(function () {
                $('#datetimepicker2').datetimepicker();
            });
        </script>
    </body>
</html>