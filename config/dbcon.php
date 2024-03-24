<?php

require __DIR__ . '/../vendor/autoload.php';

use Kreait\Firebase\Factory;

$firebase = (new Factory)
    ->withDatabaseUri('https://parkingsysystem-e29b4-default-rtdb.firebaseio.com/');

$database = $firebase->createDatabase(); // Use createDatabase() method to create the database instance

// Fetch slot statuses
$slotsRef = $database->getReference('/'); // Assuming the slots are stored at the root level
$slotsSnapshot = $slotsRef->getSnapshot();
$slotsData = $slotsSnapshot->getValue();

// Fetch user statuses
$usersRef = $database->getReference('/'); // Assuming the users are stored at the root level
$usersSnapshot = $usersRef->getSnapshot();
$usersData = $usersSnapshot->getValue();

// Now you can access the data
print_r($slotsData);
print_r($usersData);
