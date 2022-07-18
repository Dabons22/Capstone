<?php 
 
 
 //database constants
 $conn = mysqli_connect("localhost", "id18437919_micradb", "Micradbthesis2@", "id18437919_micra");
 //Checking if any error occured while connecting
 if (mysqli_connect_errno()) {
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
 die();
 }
 


 //creating a query
 $stmt = $conn->prepare("SELECT id,
title,
date,
image,
description,
postedBy
 FROM announce");
 
 //executing the query 
 $stmt->execute();
 
 //binding results to the query 
 $stmt->bind_result($id,
$title,
$date,
$image,
$description,
$postedBy
);
 
 $reports = array(); 
 
 //traversing through all the result 
 while($stmt->fetch()){
 $temp = array();
 $temp['id'] = $id; 
 $temp['title'] =$title; 
 $temp['date'] =$date; 
 $temp['image'] = $image;
 $temp['description'] = $description;
 $temp['postedBy'] = $postedBy;

 array_push($reports, $temp);
 }
 
 //displaying the result in json format 
 echo json_encode($reports);
 ?>