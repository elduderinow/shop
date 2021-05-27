<?php

//create a class for valadity so I can call it in the html where I want to.
class validity {
    public $emailInval = '';
    public $streetInval = '';
    public $streetnrInval = '';
    public $cityInval = '';
    public $zipcodeInval = '';
}

$Invalid = new validity;

//if else for validating the respective input field.

if (isset($_POST["email"])) {
    $email = $_POST["email"];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { //filter if email format has been respected.
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
        if (ctype_alpha($street)){ // filter to check if the street name has only alphabetic characters.
            $_SESSION["information"]["street"] = $street;
        } else {
            $Invalid->streetInval = "*Please only use alphabetic characters";
        }

    }
}

if (isset($_POST["streetnumber"])) {
    $streetnr = $_POST["streetnumber"];
    if ($streetnr == "") {
        $Invalid->streetnrInval = "*Please fill in the street number.";
    } else {
        if (is_numeric($streetnr) === true) { //check if street nr has only numbers
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
        if (is_numeric($streetnr) === true) { //check if zipcode has only numbers
            $_SESSION["information"]["zipcode"] = $zipcode;
        } else {
            $Invalid->zipcodeInval = "*Please use only numbers.";
        }
    }
}