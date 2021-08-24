<?php
$submitted = !empty($_POST);

$db = new PDO(
    'mysql:host=127.0.0.1:3307;dbname=elevator',    //Data source name 
    'root',                                         //Username
    ''                                              //Password
);

//Return arrays with keys that are the name of the fields
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

$query = 'INSERT INTO loginInfo (name,password,date,time,nodeID)
          VALUES (:name,:password,:date,:time,:nodeID)';   //formatted query. parameters identified by ':'

$statement = $db->prepare($query);      //Object created from query that contains methods for executing (inserting) and fetching
$params = [
    'date' => '2021-03-10',     //Array containing the data
    'time' => '10:10:20',
    'status' => 1,
    'currentFloor' => 1,
    'requestedFloor' => 1,
    'otherInfo' => 'na'
];
$result = $statement->execute($params);     //execute is the method for inserting the formatted array into the database
var_dump($result);                          //true if successfully added to the database

/*$query = 'SELECT * FROM elevatorOperation WHERE nodeID = :nodeID';  //Formatted query, parameters identifiewd by ':'

$statement = $db->prepare($query);      //Object created from query that contains methods for fetching data
$statement->bindValue('nodeID', 1);     //Query all entries with nodeID = 1

$result = $statement->execute();        //execute is the method for retrieving data using prepare (parameterized query)
$rows = $statement->fetchAll();         //Returns a list of all rows as arrays
var_dump($rows);*/

/* *********FOR ADDING PREDETERMINED DATA***************
$query = 'INSERT INTO elevatorOperation (date,time,nodeID,status,currentFloor,requestedFloor,otherInfo) VALUES ("2020-02-22", "12-05-02",3,1,1,1, "na")

$result = $db->exec($query);
var_dump($result); //true
echo "<br />";
$error = $db->errorInfo()[2];
var_dump($error); //NULL since no error
echo "<br />";

$rows = $db->query('SELECT * FROM elevatorOperation ORDER BY nodeID');
foreach ($rows as $row){
    var_dump($row);
    echo "<br />";
    echo "<br />";
}*/

?>
<!DOCTYPE html>
<html>
    <head><title>Form Handler Page</title></head>
    <body>
        <p>Form Submitted? <?php echo (int) $submitted; ?> </p>
        <p>Your login info is</p>
        <ul>
            <li><b>username</b>: <?php echo $_POST['username']; ?></li>
            <li><b>password</b>: <?php echo $_POST['password']; ?></li>
        </ul>
    </body>
</html>