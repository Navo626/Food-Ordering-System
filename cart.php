<?php

use MyApp\DBConnector;

if (isset($_GET['cart'])) {

    $id = $_GET['cart'];
    require 'core/classes/DBConnector.php';
    // take data from menu page
    $dbuser = new DBConnector();
    $con = $dbuser->getConnection();
    $query = "SELECT * FROM menu_item WHERE menu_item_id = '$id' ";
    $pstmt = $con->prepare($query);
    $pstmt->execute();
    $rs = $pstmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rs as $rows) {
        //store that values to variables
        $name = $rows['menu_item_name'];
        $price = $rows['menu_item_price'];
        $image = $rows['menu_item_picture'];
    }

    //store that values again to database

    $query2 = "INSERT INTO cart(id,picture,food_name,price) VALUES ('$id','$image','$name','$price')";
    $pstmt = $con->prepare($query2);
    $a = $pstmt->execute();
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    require 'core/classes/DBConnector.php';
    $dbuser = new DBConnector();
    $con = $dbuser->getConnection();
    $query = "DELETE FROM cart WHERE id = '$id' ";
    $pstmt = $con->prepare($query);
    $pstmt->execute();
    header('Location:cart.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <!-- <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/Banner-Heading-Image-images.css">
    <link rel="stylesheet" href="assets/css/Navbar-Right-Links-Dark-icons.css">
</head>

<body style="background: url(assets/img/bg3.jpg); background-size: cover; background-repeat: no-repeat; background-position: center bottom">
    <div id="navbar">
        <nav class="navbar navbar-expand-md bg-dark py-3 navbar-dark">
            <div class="container"><a class="navbar-brand d-flex align-items-center" href="#"><img class="navbar-logo" src="assets/img/logo.png" style="width: 5rem;padding: 0.5rem;"></a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-5"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navcol-5">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="index.php">Home<i class="fas fa-home" style="padding: 0.3rem;color: var(--bs-warning);"></i></a></li>
                        <li class="nav-item"><a class="nav-link" href="foods.php">Foods<i class="fas fa-fish" style="padding: 0.3rem;color: var(--bs-warning);"></i></a></li>
                        <li class="nav-item"><a class="nav-link" href="restaurent.php">Restaurant<i class="fas fa-warehouse" style="padding: 0.3rem;color: var(--bs-warning);"></i></a></li>
                        <li class="nav-item"><a class="nav-link active" href="cart.php">Cart<i class="fas fa-cart-arrow-down" style="padding: 0.3rem;color: var(--bs-warning);"></i></a></li>
                    </ul><a class="btn btn-primary ms-md-2" role="button" href="profile.php" style="background: var(--bs-warning);">Login</a>
                </div>
            </div>
        </nav>
    </div>
    <div class="container mt-2">
        <div class="bg-dark border rounded border-0 border-dark overflow-hidden">
            <div class="row mt-3">
                <h3 class="fw-bold mb-2 text-center text-light" style="color: var(--bs-tertiary-bg);">Your Cart</h3>
            </div>
        </div>
    </div>

    <?php
    @include 'core/classes/config.php';
    $select = mysqli_query($conn, "SELECT * FROM cart");
    ?>
    <?php while ($row = mysqli_fetch_assoc($select)) { ?>
        <div class="container mt-3">
            <div class="bg-dark border rounded border-0 border-dark overflow-hidden">
                <div class="row mt-3">
                    <div class="col-12 col-md-6 col-lg-4" style="min-height: 200px;">
                        <img class="mx-auto d-block" width="250" height="180" src="<?php echo $row['picture']; ?>">
                    </div>
                    <div class="col-md-6 col-lg-4 mt-2  text-center ">
                        <h4 class="text-center text-light" id="item-name"><?php echo $row['food_name'] ?></h4>
                        <h5 class="text-light tedxt-center" id="item-price">Rs. <?php echo $row['price'] ?></h5>
                    </div>
                    <div class="col-md-6 col-lg-4 d-flex flex-row align-items-center justify-content-center mb-2" style="display: block;">
                    <form action="payment.php?pay=<?php echo $row['id']; ?>" method="POST">
                    <input type="number" name="quan" placeholder="Quantity" required>
                    <br><br>
                    <button class="btn btn-warning" style="color:white;"  name="payment"> Check Out </button>   &ensp;  
                    <a href="cart.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger"> Remove </a>
                    </form>    
                </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <!--Item 2-->


    &ensp;
    &ensp;

    <!--footer-->
    <div id="footer">
        <footer class="text-center bg-dark">
            <div class="container text-white py-4 py-lg-5">
                <ul class="list-inline">
                    <li class="list-inline-item me-4"><img src="assets/img/logo.png" style="width: 5rem;padding: 0.5rem;"><a class="link-light" href="#">Wellassa Eats</a></li>
                    <li class="list-inline-item me-4"><a class="link-light" href="#">wellassaeats@gmail.com</a></li>
                    <li class="list-inline-item"><a class="link-light" href="#">+949122444569</a></li>
                </ul>
                <ul class="list-inline">
                    <li class="list-inline-item me-4"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-facebook text-light">
                            <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z">
                            </path>
                        </svg></li>
                    <li class="list-inline-item me-4"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-twitter text-light">
                            <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z">
                            </path>
                        </svg></li>
                    <li class="list-inline-item"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-instagram text-light">
                            <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z">
                            </path>
                        </svg></li>
                </ul>
            </div>
        </footer>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>