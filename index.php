<?php
//this line makes PHP behave in a more strict way
declare(strict_types=1);

//we are going to use session variables so we need to enable sessions
session_start();

function whatIsHappening()
{
    echo '<h2>$_GET</h2>';
    var_dump($_GET);
    echo '<h2>$_POST</h2>';
    var_dump($_POST);
    echo '<h2>$_COOKIE</h2>';
    var_dump($_COOKIE);
    echo '<h2>$_SESSION</h2>';
    var_dump($_SESSION);
}

//your products with their price.

$products = [
    ['name' => 'Club Ham', 'price' => 3.20],
    ['name' => 'Club Cheese', 'price' => 3],
    ['name' => 'Club Cheese & Ham', 'price' => 4],
    ['name' => 'Club Chicken', 'price' => 4],
    ['name' => 'Club Salmon', 'price' => 5]
];

if (isset($_GET["food"]) && $_GET["food"] == "0") {
   // unset ($_SESSION["order"]);
  //  unset ($_SESSION["price"]);
    $products = [
        ['name' => 'Cola', 'price' => 2],
        ['name' => 'Fanta', 'price' => 2],
        ['name' => 'Sprite', 'price' => 2],
        ['name' => 'Ice-tea', 'price' => 3],
    ];
}
/*
if (isset($_GET["food"]) && $_GET["food"] == "1") {
    unset ($_SESSION["order"]);
    unset ($_SESSION["price"]);
}*/


if (isset($_POST["products"])) { // check if a product has been entered if yes
    if (isset($_GET["food"]) && $_GET["food"] == "0") { // check if the get is 0 (= drinks), if not go to else statement
        for ($i = 0; $i < count(array_filter($_POST["products"])); $i++) { // for
            $_SESSION["order-drinks"][$i] = $products[$i]["name"];
            $_SESSION["price-drinks"][$i] = $products[$i]["price"];
            $_SESSION["amount-drinks"][$i] = $_POST["products"][$i];
        }
    } else {
        for ($i = 0; $i < count($_POST["products"]); $i++) {
            $_SESSION["order-food"][$i] = $products[$i]["name"];
            $_SESSION["price-food"][$i] = $products[$i]["price"];
            $_SESSION["amount-food"][$i] = $_POST["products"][$i];
            var_dump($_POST["products"][$i]);
            var_dump($products[$i]["name"]);

        }
    }


}
$totaldrinks = [];
$totalfood = [];


//get the total amount food multiplied with the price.
if (isset($_SESSION["amount-food"])) {
    for ($i = 0; $i < count(array_filter($_SESSION["amount-food"])); $i++) {
        $totalfood[] = $_SESSION["amount-food"][$i] * $_SESSION["price-food"][$i];

    }
}



//get the total amount drinks multiplied with the price.
if (isset($_SESSION["amount-drinks"])) {
    for ($i = 0; $i < count(array_filter($_SESSION["amount-drinks"])); $i++) {
        $totaldrinks[] = $_SESSION["amount-drinks"][$i] * $_SESSION["price-drinks"][$i];
    }
}

//check if the express delivery has been checked, if not, return a 0.
if (isset($_POST["express_delivery"])) {
    $delivery = (int)$_POST["express_delivery"];
    $_SESSION["delivery"] = $delivery;
} else {
    $delivery = 0;
}


//check if the express delivery has been checked, if not, return a 0.
if (isset($_SESSION["delivery"])) {
    $delivery = $_SESSION["delivery"];
} else {
    $delivery = 0;
}



//sum of the total products checked.
$totalValue = array_sum($totaldrinks) + array_sum($totalfood) + $delivery;
$cookievalue = $totalValue + (float)$_COOKIE["shop"];
if (isset($_SESSION["order-food"]) || isset($_SESSION["order-drinks"])) {
    setcookie("shop", "$cookievalue", time() + (86400 * 30), "/"); // 86400 = 1 day
}



require 'resources/form-view.php';