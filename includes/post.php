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

}
?>