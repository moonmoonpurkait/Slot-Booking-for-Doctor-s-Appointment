<?php
class Amwell {
    public static function connect() {
        try {
            $db_name = "teledoc";  // Change to your local database name
            $localhost = "localhost";  // Use localhost for local server
            $username = "root"; // Default MySQL username
            $password = ""; // Default MySQL password (leave empty if not set)
            // port = 3306; // Usually not needed for localhost unless changed

            $con = new PDO("mysql:host=$localhost;dbname=$db_name", $username, $password);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $con; // Return the PDO connection object
        } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return null; 
        }
    }
}
?>
