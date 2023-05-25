<?php
require_once 'connection.php';
$sql1="DROP PROCEDURE IF EXISTS DeleteNote";
$sql2="CREATE PROCEDURE DeleteNote(
    IN intId int
)
BEGIN
    DELETE FROM notes WHERE id=intId;
END;";
$stmt1=$con->prepare($sql1);
$stmt2=$con->prepare($sql2);
$stmt1->execute();
$stmt2->execute();
/////////////////////////////////////////////
//punem un trigger in care sa scriem nume, data si ora (ca la update)
//$sql3="DROP TRIGGER IF EXISTS MysqlTrigger4";
//$sql4="CREATE TRIGGER MysqlTrigger4 BEFORE DELETE ON flori FOR EACH ROW
//    BEGIN
//    INSERT INTO flower_update(nume,status,edtime)VALUES(OLD.nume,'DELETED',NOW());
//    END;";
//$stmt3=$con->prepare($sql3);
//$stmt3->execute();
//$stmt4=$con->prepare($sql4);
//$stmt4->execute();        
////////////////////////////////////////////
$id=$_POST['id'];
$sql="CALL DeleteNote('{$id}')" ;
$q=$con->query($sql);
if($q){
    header('location: index.php');
}
else{
    echo "There was an error.";
}
?>
<br/><br/>
<a href="index.php">Back</a>
