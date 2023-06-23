<?php 

$username = "root";
$passwrod = "";
$host = "localhost";
$database = "SATM";

$conn = mysqli_connect($host,$username,$passwrod,$database);

if(!$conn){
    die(" Connection lost ");
}
