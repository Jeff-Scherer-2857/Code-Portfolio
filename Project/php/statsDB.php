<?php
    try {
        $db = new PDO(
            'mysql:host=127.0.0.1;port=3306;dbname=elevator',     //Data source name
            'webuser',                                                 //Username
            '12345678'                                                      //Password
        );
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "connection successful";
    } catch(PDOException $e) {
        //echo "Connection failed: " . $e->getMessage();
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    //Return arrays with keys that are the name of the fields
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $query = 'SELECT currentFloor, requestedFloor, calledFloor FROM elevatorInfo'; 

    //$statement = $db->prepare($query);      //Object created from query that contains methods for executing (inserting) and fetching
    //$params = [
       // 'username' => $username
    //];
    //$statement->execute($params);     //execute is the method for inserting the formatted array into the database

    $result = $query->fetch();

    $numrows = $statement->rowCount($result);
?>