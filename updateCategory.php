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
    
/////////////////////////////////////////////
    $sql3="DROP TRIGGER IF EXISTS UpdateCategoryTrigger";
    $sql4="CREATE TRIGGER UpdateCategoryTrigger AFTER UPDATE ON notes FOR EACH ROW
        BEGIN
        INSERT INTO notes_update_logs(title,prevCategory,currentCategory,updateTime) VALUES(OLD.title,OLD.category,NEW.category,NOW());
        END;";
    $stmt3=$con->prepare($sql3);
    $stmt3->execute();
    $stmt4=$con->prepare($sql4);
    $stmt4->execute();        
////////////////////////////////////////////
 
    if($q){
        header('location: index.php');
        echo $id;
    }
    else{
        echo "There was an error.";
    }
}
