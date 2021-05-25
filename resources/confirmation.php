
<div class="confirmation">
    <h1>Confirmation</h1>
    <h3>Your order</h3>
    <ul>
        <?php
        for ($i = 0; $i < count($_SESSION["order"]); $i++) {
            echo "<li>".$_SESSION["order"][$i].": € ".$_SESSION["price"][$i]."</li>";
        }

        if (isset($_SESSION["delivery"])) {
            echo "<li>Delivery: € ".$_SESSION["delivery"]."</li>";
        }



        ?>
    </ul>
    <h5>Total: <?php
       echo "€ ";
       if (isset($_SESSION["delivery"])) {
           echo array_sum($_SESSION["price"]) + $_SESSION["delivery"];
       } else {
           echo array_sum($_SESSION["price"]);
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