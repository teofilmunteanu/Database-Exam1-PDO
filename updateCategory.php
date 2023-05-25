<?php
require_once 'connection.php';

$sql1="DROP PROCEDURE IF EXISTS UpdateCategory";
$sql2="CREATE PROCEDURE UpdateCategory(
    IN intId int,
    IN strCategory varchar(30)
)
BEGIN
    UPDATE notes SET category=strCategory WHERE id=intId;
END;";
$stmt1=$con->prepare($sql1);
$stmt2=$con->prepare($sql2);
$stmt1->execute();
$stmt2->execute();


if (isset($_POST['categories'])) {
    $category = $_POST['categories'];
    $id = $_POST['id'];
    $sqlUpdate="CALL UpdateCategory('{$id}','{$category}')";
    $q=$con->query($sqlUpdate);
    if($q){
        header('location: index.php');
        echo $id;
    }
    else{
        echo "There was an error.";
    }
}
