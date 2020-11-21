<?php

$pickup_location = $_POST['pickup_location'];
$drop_location = $_POST['drop_location'];
$cab_type = $_POST['cab_type'];
$luggage = $_POST['luggage'];

$distance_travelled = 0;
$fixed_fare = 0;
$fare = 0;

$locations = array(
    "Charbagh" => 0, "Indira Nagar" => 10,
    "BBD" => 30, "Barabanki" => 60, "Faizabad" => 100, "Basti" => 150, "Gorakhpur" => 210
);

if (array_key_exists($pickup_location, $locations) && array_key_exists($drop_location, $locations)) {
    $source = $locations[$pickup_location];
    $destination = $locations[$drop_location];
    if ($source != $destination) {
        $distance_travelled = abs($destination - $source);
    }
}

if ($cab_type == "CedMicro") {
    $fixed_fare += 50;
    $fare = $fixed_fare + calculate_fare($distance_travelled, 13.50, 12.00, 10.20, 8.50) + calculate_luggage_charge($luggage, $cab_type);
}

if ($cab_type == "CedMini") {
    $fixed_fare += 150;
    $fare = $fixed_fare + calculate_fare($distance_travelled, 14.50, 13.00, 11.20, 9.50) + calculate_luggage_charge($luggage, $cab_type);
}

if ($cab_type == "CedRoyal") {
    $fixed_fare += 200;
    $fare = $fixed_fare + calculate_fare($distance_travelled, 15.50, 14.00, 12.20, 10.50) + calculate_luggage_charge($luggage, $cab_type);
}

if ($cab_type == "CedSUV") {
    $fixed_fare += 250;
    $fare = $fixed_fare + calculate_fare($distance_travelled, 16.50, 15.00, 13.20, 11.50) + calculate_luggage_charge($luggage, $cab_type);
}

function Calculate_fare($distance, $km1, $km2, $km3, $km4)
{
    $amount = 0;
    if ($distance > 0 && $distance <= 10) {
        $amount += ($distance * $km1);
    } else if ($distance > 10 && $distance <= 60) {
        $distance -= 10;
        $amount = $amount + ($km1 * 10) + ($distance * $km2);
    } else if ($distance > 60 && $distance <= 160) {
        $distance -= 60;
        $amount = $amount + ($km1 * 10) + ($km2 * 50) + ($distance * $km3);
    } else if ($distance > 160) {
        $distance -= 160;
        $amount = $amount + ($km1 * 10) + ($km2 * 50) + ($km3 * 100) + ($distance * $km4);
    }
    return $amount;
}

function calculate_luggage_charge($luggage_capacity, $cab)
{
    $luggage_amount = 0;
    if ($luggage_capacity > 0 && $luggage_capacity <= 10) {
        $luggage_amount += 50;
    } else if ($luggage_capacity > 10 && $luggage_capacity <= 20) {
        $luggage_amount += 100;
    } else if ($luggage_capacity > 20) {
        $luggage_amount += 200;
    }

    if ($cab == "CedeMicro") {
        $luggage_amount = 0;
    }

    if ($cab == "CedSUV") {
        $luggage_amount = 2 * $luggage_amount;
    }
    return $luggage_amount;
}

echo $fare;
