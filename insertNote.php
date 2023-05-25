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
$category='';

///////////////
//$sql30="DROP TRIGGER IF EXISTS MysqlTrigger3";
//$sql3="CREATE TRIGGER MysqlTrigger3 BEFORE INSERT ON flori FOR EACH ROW
//    BEGIN
//    INSERT INTO flower_update(nume,status,edtime) VALUES(NEW.nume,'INSERTED',NOW());
//    END;";
//$stmt3=$con->prepare($sql3);
//$stmt3->execute();
//$stmt30=$con->prepare($sql30);
//$stmt30->execute();        
////////////////////////////////////////

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
