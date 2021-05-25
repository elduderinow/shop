
<div class="confirmation">
    <h1>Confirmation</h1>
    <h3>Your order</h3>
    <ul>
        <?php

        if (isset($_SESSION["order-food"])) {
            for ($i = 0; $i < count($_SESSION["order-food"]); $i++) {
                echo "<li>".$_SESSION["amount-food"][$i]."x ".$_SESSION["order-food"][$i].": € ".$_SESSION["price-food"][$i]."</li>";
            }
        }

        if (isset($_SESSION["order-drinks"])) {
            for ($i = 0; $i < count($_SESSION["order-drinks"]); $i++) {
               // $totaldrinks = array_push($_SESSION["amount-drinks"][$i]*$_SESSION["price-drinks"][$i]);
                echo "<li>".$_SESSION["amount-drinks"][$i]."x ".$_SESSION["order-drinks"][$i].": € ".$_SESSION["price-drinks"][$i]."</li>";
            }
        }

        if (isset($_SESSION["delivery"])) {
            echo "<li>Delivery: € ".$_SESSION["delivery"]."</li>";
        }



        ?>
    </ul>

    <h5>Total: <?php
       echo "€ ";
       if (isset($_SESSION["delivery"])) {
           echo $totalValue;
       } else {
           echo $totalValue;
       }

        ?> </h5>

    <h3>Delivery time: <?php
        if (isset($_SESSION["delivery"])) {
            echo "express delivery 45min";
        } else {
            echo "normal delivery 2h";
        }

        ?>

    </h3>

</div>