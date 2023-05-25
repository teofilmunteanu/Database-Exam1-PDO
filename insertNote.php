<?php //SAME THING AS insert, BUT MORE SECURE
require_once 'connection.php';
$sql1="DROP PROCEDURE IF EXISTS InsertProcedure";
$sql2="CREATE PROCEDURE InsertProcedure(
    IN strTitle varchar(30),
    IN strText varchar(300),
    IN strCategory varchar(30)
)
BEGIN
    SET @titleToSet=strTitle;
    SET @textToSet=strText;
    SET @categoryToSet=strCategory;
    
    PREPARE STMT FROM
    'INSERT INTO notes(title,text,category) VALUES(?,?,?)';
    EXECUTE STMT USING @titleToSet, @textToSet, @categoryToSet;
END;";

$stmt1=$con->prepare($sql1);
$stmt2=$con->prepare($sql2);
$stmt1->execute();
$stmt2->execute();

$title=$_POST['title'];
$text=$_POST['description'];
$category='All';

/////////////
    $sql3="DROP TRIGGER IF EXISTS InsertTrigger";
    $sql4="CREATE TRIGGER InsertTrigger AFTER INSERT ON notes FOR EACH ROW
        BEGIN
        INSERT INTO notes_logs(title,text,status,updateTime) VALUES(NEW.title,NEW.text,'INSERTED',NOW());
        END;";
    $stmt3=$con->prepare($sql3);
    $stmt3->execute();
    $stmt4=$con->prepare($sql4);
    $stmt4->execute();    
//////////////////////////////////////

$sqlInsert="CALL InsertProcedure('{$title}','{$text}','{$category}')";
$q=$con->query($sqlInsert);
if($q){
    header('location: index.php');
}
else{
    echo "There was an error.";
}
?>
<br/><br/>
<a href="index.php">Back</a>
