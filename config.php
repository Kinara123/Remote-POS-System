<?php
//this is the database connection configuration, encryption key for backup encryption and string manipulation functions
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'ezekiel pos';
// $DATABASE_NAME = 'remote pos';//never name your db like this with spaces in the name use a (_) instead of a ( )

// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    // If there is an error with the connection, stop the script and display the error.
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Encryption key (keep this secret) and don't change it after you have encrypted backups, otherwise you won't be able to decrypt them
$encryption_key = '37e69fd9c7e82405c3df6877b843e29cef010127f248b7a19c1a88e84c5e6113'; // Use a strong encryption key

//this function is used to convert a string to sentence case
function toSentenceCase($string)
{
    // Trim any leading or trailing spaces
    $string = trim($string);

    // Convert the entire string to lowercase
    $string = strtolower($string);

    // Capitalize the first letter
    $string = ucfirst($string);

    return $string;
}
//this function is used to convert a string to uppercase
function toUpperCase($string)
{
    $string = trim($string);
    return strtoupper($string);
}
//this function is used to convert a string to title case
function toTitleCase($string)
{
    $string = trim($string);
    return ucwords(strtolower($string));
}
//this function is used to convert a string to lowercase
function toLowerCase($string)
{
    $string = trim($string);
    return strtolower($string);
}
