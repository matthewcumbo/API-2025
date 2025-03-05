<?php 

class Post{
    // db stuff
    private $conn;
    private $table = "post";
    private $alias = "p";

    // table properties
    public $id;
    public $userId;
    public $title;
    public $content;


public function __construct($db){
    $this->conn = $db;
}

// Read all Post records
public function read(){
    $query = "SELECT * 
                FROM {$this->table} {$this->alias}
                ORDER BY id DESC";

    $stmt = $this->conn->prepare($query);

    $stmt->execute();

    return $stmt;
}

// Read a single Post record
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
        $this->userId     = $row["userId"];
        $this->title      = $row["title"];
        $this->content    = $row["content"];
    }

    return $stmt;
}

public function readPostsByUserId(){
    $query = "SELECT * 
                FROM {$this->table} {$this->alias}
                WHERE {$this->alias}.userId = ?;";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->userId);
    $stmt->execute();

    return $stmt;
}

// Create a new User record
public function create(){
    $query = "INSERT INTO {$this->table} 
                (userId, title, content)
                VALUES(:userId, :title, :content);";

    $stmt = $this->conn->prepare($query);

    // clean data sent by user (for security)
    $this->userId = htmlspecialchars(strip_tags($this->userId));
    $this->title = htmlspecialchars(strip_tags($this->title));
    $this->content = htmlspecialchars(strip_tags($this->content));

    // bind parameters to sql statment
    $stmt->bindParam(":userId", $this->userId);
    $stmt->bindParam(":title", $this->title);
    $stmt->bindParam(":content", $this->content);

    if($stmt->execute()){
        return true;
    }

    printf("Error %s. \n", $stmt->error);
    return false;
}

}
?>