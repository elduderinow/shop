
<div class="confirmation">
    <h1>Confirmation</h1>
    <h3>Your order</h3>
    <ul>
        <?php
        if (isset($_SESSION["order-food"])) { //if food has been ordere then =>
           for ($i = 0; $i <500; $i++) { // loop through al ordered food and display them
               if (isset($_SESSION["order-food"][$i])) {
                   echo "<li>".$_SESSION["amount-food"][$i]."x ".$_SESSION["order-food"][$i].": € ".$_SESSION["price-food"][$i]."</li>";
               }
            }
        }

        if (isset($_SESSION["order-drinks"])) {
            for ($i = 0; $i <500; $i++) {
                if (isset($_SESSION["order-drinks"][$i])) {
                    echo "<li>".$_SESSION["amount-drinks"][$i]."x ".$_SESSION["order-drinks"][$i].": € ".$_SESSION["price-drinks"][$i]."</li>";
                }
            }
        }

        if (isset($_SESSION["delivery"])) { //display delivery if checked
            echo "<li>Express delivery: € ".$_SESSION["delivery"]."</li>";
        }

        ?>
    </ul>

    <h5>Total: <?php //echo the total value
       echo "€ ".$totalValue;
        ?> </h5>

    <h5>Delivery time: <?php
        date_default_timezone_set('Europe/Brussels'); //Set the default timezone to europe/brussels
        $expressD = date("H:i",time() + 2700); //express delivery + 2700seconds + 45min
        $NormalD = date("H:i",time() + 7200); //normal delivery + 7200 seconds = 2h
        if (isset($_SESSION["delivery"])) {
            echo "Your order will be delivered at ".$expressD;
        } else {
            echo "Your order will be delivered at ".$NormalD;
        }

        ?>

    </h5>

</div>