<?php
session_start();

include 'connect.php';
$connect = getDBConnection();

// $score = $_GET['score'];
// echo $score;

//Adding new score to database
$score = $_POST['score'];

//Retrieving total times quiz has been submitted and average score for this user
$sql = "INSERT INTO scores (username, score) 
        VALUES (:username, :score)";
$data = array(
    ":username" => $_SESSION['username'],
    ":score" => $score
);
$stmt = $connect->prepare($sql);
$stmt->execute($data);

$sql = "SELECT count(1) times, avg(score) average 
        FROM scores 
        WHERE username = :username";
$stmt = $connect->prepare($sql);
$stmt->execute(array(":username"=>$_SESSION['username']));
$result = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode($result);

?>