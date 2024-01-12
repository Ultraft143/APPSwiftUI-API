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
    public function createUser($email, $name, $password, $admin)
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

    public function getUser($name, $password)
    {
        $sql = "SELECT * FROM `users` WHERE `user_name`='$name' AND `user_password`='$password'";
        $query = mysqli_query($this->conn, $sql);
        $row_num = mysqli_num_rows($query);
        if ($row_num != 0) {
            return true;
        } else {
            return false;
        }
    }

}
?>