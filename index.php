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

    $products = [
        ['name' => 'Cola', 'price' => 2],
        ['name' => 'Fanta', 'price' => 2],
        ['name' => 'Sprite', 'price' => 2],
        ['name' => 'Ice-tea', 'price' => 3],
    ];
}

if (isset($_POST["products"])) { // check if a product has been entered if yes =>
    if (isset($_GET["food"]) && $_GET["food"] == "0") { // check if the GET is 0 (= food), if not go to else statement
        for ($i = 0; $i < count($_POST["products"]); $i++) { // loop through all the products
            if ((int)$_POST["products"][$i] >= 1) { // skip the products which has no value, thus hasnt been ordered.
                $_SESSION["order-drinks"][$i] = $products[$i]["name"]; // write the values to the session.
                $_SESSION["price-drinks"][$i] = $products[$i]["price"];
                $_SESSION["amount-drinks"][$i] = $_POST["products"][$i];
            }
        }
    } else {
        for ($i = 0; $i < count($_POST["products"]); $i++) {
            if ((int)$_POST["products"][$i] >= 1) {
                $_SESSION["order-food"][$i] = $products[$i]["name"];
                $_SESSION["price-food"][$i] = $products[$i]["price"];
                $_SESSION["amount-food"][$i] = $_POST["products"][$i];
            }

        }
    }
}

// Check if there is any food ordered, if yes, get the sum of the food prices, if not, totalfood is 0;
if (isset($_SESSION["price-food"])) { //check if there is any food ordered and stored in the session
    for ($i = 0; $i < count($products); $i++) { // if yes, loop through all of them.
        if (isset($_SESSION["price-food"][$i])) { // but only write to a temporary array if the amount is equal bigger than 1
            $totalfood[] = $_SESSION["price-food"][$i] * (int)$_SESSION["amount-food"][$i]; //write for each product the amount multiplied by the price and store it in a temp array.
        }
    }
} else { // if it's not set, totalfood = 0
    $totalfood[] = 0;
}

if (isset($_SESSION["price-drinks"])) {
    for ($i = 0; $i < 5; $i++) {
        if (isset($_SESSION["price-drinks"][$i])) {
            $totaldrinks[] = $_SESSION["price-drinks"][$i] * (int)$_SESSION["amount-drinks"][$i];
        }
    }
} else {
    $totaldrinks[] = 0;
}

//Store the values in a session so I don't lose it when switching to the drinks tab, this tab only has 4 products so the last item in the food array won't show otherwise.
$_SESSION["totalfood"] = $totalfood;
$_SESSION["totaldrinks"] = $totaldrinks;


//check if the express delivery has been checked, if not, return a 0. if yes, write this to the session
if (isset($_POST["express_delivery"])) {
    $delivery = (int)$_POST["express_delivery"];
    $_SESSION["delivery"] = $delivery;
} else {
    $delivery = 0;
}

//sum of the total products checked.
$totalValue = array_sum($_SESSION["totalfood"]) + array_sum($_SESSION["totaldrinks"]) + $delivery;

if (isset($_SESSION["order-food"]) || isset($_SESSION["order-drinks"])) {
    $cookievalue = $totalValue + (float)$_COOKIE["shop"];
    setcookie("shop", "$cookievalue", time() + (86400 * 30), "/"); // 86400 = 1 day
} else {
    setcookie("shop", "$totalValue", time() + (86400 * 30), "/"); // 86400 = 1 day
}

require 'resources/form-view.php';