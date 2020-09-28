
<!--import .php from other file-->
<?php

// start session to modify and delete session variables
session_start();

require_once ('./php/CreateDatabase.php');
require_once ('./php/component.php');

// create instance of CreateDatabase class
$database = new CreateDatabase("ProduceDatabase","ProductTable");

// senting product id
if(isset($_POST['add'])){

    //print_r($_POST['product_id']);
    if(isset($_SESSION['cart'])){
        $item_array_id = array_column($_SESSION['cart'], "product_id");
        // print_r($item_array_id);
        //print_r($_SESSION['cart']);

        // check is product in the cart or not
        if(in_array($_POST['product_id'], $item_array_id)){
            // if product is in cart, echo some message
            echo "<script>alert('Product is already added in the cart.')</script>";
            echo "<script>window.location='index.php'</script>";
        }else{
            // if not, adding the product id into cart
            $count = count($_SESSION['cart']);
            $item_array = array('product_id'=>$_POST['product_id']);

            // create new session variable
            $_SESSION['cart'][$count] = $item_array;
            // print_r($_SESSION['cart']);

        }

    }else{
        // adding the product id into cart
        $item_array = array('product_id'=>$_POST['product_id']);

        // create new session variable
        $_SESSION['cart'][0] = $item_array;
        // print_r($_SESSION['cart']);
    }
}

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shopping Cart</title>

    <!--  Font Awesome  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
    <!--  Boostrap CDN  -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <!--  .css style   -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php require_once ("./php/header.php");?>

<div class="container">
    <div class="row text-center py-5">
        <?php
            $result = $database->getData();
            while($row = mysqli_fetch_assoc($result)){
                component($row['product_name'],$row['product_price'], $row['product_image'], $row['id']);
            }
        ?>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>