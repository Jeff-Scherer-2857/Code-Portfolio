<?php
    function redirectTo($page) {
        header("Location:" . $page);
        exit();
    }

    date_default_timezone_set('America/New_York');

    $usern = $_POST['username'];
    $passw = sha1($_POST['password']);
    $newpassw = sha1($_POST['newpassword']);

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

    try{
        $sql = "UPDATE loginInfo SET password='" . $newpassw . "' WHERE username='" . $usern . "'";
        if ($db->query($sql) == TRUE) {
            echo "Record Updated Successfully";
        } else {
            throw new UpdateException();
            //echo "Error updating record: " . $db->error;
        }
    } catch (UpdateException $e){
        echo "Error updating record: ". $db->error;
    }

?>