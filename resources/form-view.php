<!doctype html>
<?php

    $cookie_name = "shop";
    $cookie_value = "empty";
    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day

if(!isset($_COOKIE[$cookie_name])) {
    echo "Cookie named '" . $cookie_name . "' is not set!";
} else {
    echo "Cookie '" . $cookie_name . "' is set!<br>";
    echo "Value is: " . $_COOKIE[$cookie_name];
}

?>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shop</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Extra links -->
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>
<?php
include 'resources/checkValid.php';
include 'resources/classes.php';
?>
<div class="container">
    <h1>Order food in restaurant "the Personal Ham Processors"</h1>
    <nav>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="?food=1">Order food</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?food=0">Order drinks</a>
            </li>
        </ul>
    </nav>
    <form method="post">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="email">E-mail:<?php echo "<span style='color:red;'>".($Invalid->emailInval)."</span>"; ?></label>
                <input value="<?php

                if (isset($_SESSION["information"]["email"])) {
                    echo $_SESSION["information"]["email"];
                }

                ?>" type="text" id="email" name="email" class="form-control"/>
            </div>


        </div>

        <fieldset>
            <legend>Address</legend>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="street">Street: <?php echo "<span style='color:red;'>".($Invalid->streetInval)."</span>"; ?></label>
                    <input value="<?php if (isset($_SESSION["information"]["street"])) {
                        echo $_SESSION["information"]["street"];
                    } ?>" type="text" name="street" id="street" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label for="streetnumber">Street number: <?php echo "<span style='color:red;'>".($Invalid->streetnrInval)."</span>"; ?></label>
                    <input value="<?php if (isset($_SESSION["information"]["streetnr"])) {
                        echo $_SESSION["information"]["streetnr"];
                    } ?>" type="text" id="streetnumber" name="streetnumber" class="form-control">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="city">City: <?php echo "<span style='color:red;'>".($Invalid->cityInval)."</span>"; ?></label>
                    <input value="<?php if (isset($_SESSION["information"]["city"])) {
                        echo $_SESSION["information"]["city"];
                    } ?>" type="text" id="city" name="city" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label for="zipcode">Zipcode: <?php echo "<span style='color:red;'>".($Invalid->zipcodeInval)."</span>"; ?></label>
                    <input value="<?php if (isset($_SESSION["information"]["zipcode"])) {
                        echo $_SESSION["information"]["zipcode"];
                    } ?>" type="text" id="zipcode" name="zipcode" class="form-control">
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Products</legend>
            <?php
            global $NewOrder;
            // for each loops through both food or drinks array and displays them.
            foreach ($products as $i => $product): ?>
                <label>
                    <input type="checkbox" value="1" name="products[<?php echo $i ?>]"/> <?php echo $product['name'] ?>
                    -
                    &euro; <?php echo number_format($product['price'], 2) ?></label><br/>
            <?php endforeach;




            //redefine the totalvaliue var as an array
            $totalValue = [];

            //check if a product has been checken and compare this to the original products array.
            if (isset($_POST["products"])) {
                for ($i = 0; $i < count($_POST["products"]); $i++) {
                    array_push($totalValue, $products[$i]["price"]);
                    $_SESSION["order"][$i] = $products[$i]["name"];
                    $_SESSION["price"][$i] = $products[$i]["price"];
                }
            }
            //check if the express delivery has been checken, if not, return a 0.
            if (isset($_POST["express_delivery"])) {
                $delivery = (int)$_POST["express_delivery"];
                $_SESSION["delivery"] = $delivery;
            } else {
                $delivery = 0;
            }

            //sum of the total products checked + the express delivery.
            $totalValue = array_sum($totalValue) + $delivery;

            whatIsHappening()
            ?>
        </fieldset>

        <label>
            <input type="checkbox" name="express_delivery" value="5"/>
            Express delivery (+ 5 EUR)
        </label>
        <button type="submit" class="btn btn-primary">Order!</button>
    </form>
    <?php
    if (isset($_SESSION["information"]) && isset($_SESSION["order"])) {
        if (count($_SESSION["information"]) == 5 && count($_SESSION["order"]) >= 1 ) {
            include 'resources/confirmation.php';
        }
    }
    ?>
    <footer>You already ordered <strong>&euro; <?php echo $totalValue ?></strong> in food and drinks.</footer>
</div>

<style>
    footer {
        text-align: center;
    }
</style>
</body>

<!-- Optional JavaScript -->
<script src="../resources/functions.js"></script>
<script defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
<script defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/v4-shims.min.js"></script>

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://ajax.aspnetcdn.com/ajax/bootstrap/4.3.1/bootstrap.min.js"></script>
</html>