<?php

class DbOperation
{
    private $conn;

    //Constructor
    function __construct()
    {
        require_once dirname(__FILE__) . '/config.php';
        require_once dirname(__FILE__) . '/connect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }

    //Function to create a new user
    public function createTeam($email, $name, $password, $admin)
    {
        $stmt = $this->conn->prepare("INSERT INTO users(user_email, user_name, user_password, admin) values(?, ?, ?, ?)");
        $stmt->bind_param("sssi", $email, $name, $password, $admin);
        $result = $stmt->execute();
        $stmt->close();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

}

?>