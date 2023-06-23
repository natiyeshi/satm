<?php
$username = "root";
$password = "";
$host = "localhost";
$database = "SATM";

$conn = mysqli_connect($host,$username,$password,$database);

if(!$conn){
    die("Connection error");
} 
