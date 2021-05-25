<?php

class validity {
    public $emailInval = '';
    public $streetInval = '';
    public $streetnrInval = '';
    public $cityInval = '';
    public $zipcodeInval = '';
}

$Invalid = new validity;

if (isset($_POST["email"])) {
    $email = $_POST["email"];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $Invalid->emailInval = "*Invalid email format";
    } else {
        $_SESSION["information"]["email"] = $email;
    }
}

if (isset($_POST["street"])) {
    $street = $_POST["street"];
    if ($street == "") {
        $Invalid->streetInval = "*Please fill in the street name.";
    } else {
        $_SESSION["information"]["street"] = $street;
    }
}

if (isset($_POST["streetnumber"])) {
    $streetnr = $_POST["streetnumber"];
    if ($streetnr == "") {
        $Invalid->streetnrInval = "*Please fill in the street number.";
    } else {
        if (is_numeric($streetnr) === true) {
            $_SESSION["information"]["streetnr"] = $streetnr;
        } else {
            $Invalid->streetnrInval = "*Please use only numbers.";
        }
    }
}

if (isset($_POST["city"])) {
    $city = $_POST["city"];
    if ($city == "") {
        $Invalid->cityInval = "*Please fill in the city name.";
    } else {
        $_SESSION["information"]["city"] = $city;
    }
}

if (isset($_POST["zipcode"])) {
    $zipcode = $_POST["zipcode"];
    if ($zipcode == "") {
        $Invalid->zipcodeInval = "*Please fill in the zipcode.";
    } else {
        if (is_numeric($streetnr) === true) {
            $_SESSION["information"]["zipcode"] = $zipcode;
        } else {
            $Invalid->zipcodeInval = "*Please use only numbers.";
        }
    }
}