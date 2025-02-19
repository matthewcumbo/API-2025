<?php 

class User{
    // db stuff 
    private $conn;
    private $table = "user";

    // table properties
    public $id;
    public $username;
    public $email;
    public $password;
    public $firstName;
    public $lastName;

    // constructor with db connection
    // a function that is triggered automatically when an instance of the class is created
    public function __construct($db){
        $this->conn = $db;
    }

    // Read all User records
    public function read(){
        $query = "SELECT *
                  FROM {$this->table} u
                  ORDER BY u.username ASC;";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }
}

?>