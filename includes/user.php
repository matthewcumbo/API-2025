<?php 

class User{
    // db stuff 
    private $conn;
    private $table = "user";
    private $alias = "u";

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
                    FROM {$this->table} {$this->alias}
                    ORDER BY {$this->alias}.username ASC;";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    // Read a single User record
    public function readSingle(){
        $query = "SELECT * 
                    FROM {$this->table} {$this->alias}
                    WHERE {$this->alias}.id = ?
                    LIMIT 1;";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row > 0){
            $this->username     = $row["username"];
            $this->email        = $row["email"];
            $this->password     = $row["password"];
            $this->firstName    = $row["firstName"];
            $this->lastName     = $row["lastName"];
        }

        return $stmt;
    }
}

?>