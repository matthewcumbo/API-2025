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
    public $posts;

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

    // Create a new User record
    public function create(){
        $query = "INSERT INTO {$this->table} 
                    (username, email, password, firstName, lastName)
                    VALUES(:username, :email, :password, :firstName, :lastName);";

        $stmt = $this->conn->prepare($query);

        // clean data sent by user (for security)
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->firstName = htmlspecialchars(strip_tags($this->firstName));
        $this->lastName = htmlspecialchars(strip_tags($this->lastName));

        // bind parameters to sql statment
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":firstName", $this->firstName);
        $stmt->bindParam(":lastName", $this->lastName);

        if($stmt->execute()){
            return true;
        }

        printf("Error %s. \n", $stmt->error);
        return false;
    }

    // Read a single User record including their Posts
    public function getUserWithPosts(){
        $user = $this->readSingle();
        
        $post = new Post($this->conn);
        $post->userId = $this->id;

        $postsResult = $post->readPostsByUserId();
        $num = $postsResult->rowCount();
        if($num > 0){
            $this->posts = array();
        
            while($row = $postsResult->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $post_item = array(
                    "id"        => $id,
                    "title"     => $title,
                    "content"   => $content
                );
        
                array_push($this->posts, $post_item);
            }
        }
        else{
            $this->posts = "No Posts by this user.";
        }

        return $user;
    }

    // Update User details
    public function update(){
        $query = "UPDATE {$this->table}
                    SET username = :username,
                    email = :email,
                    password = :password,
                    firstName = :firstName,
                    lastName = :lastName
                    WHERE id = :id;";

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->firstName = htmlspecialchars(strip_tags($this->firstName));
        $this->lastName = htmlspecialchars(strip_tags($this->lastName));

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":firstName", $this->firstName);
        $stmt->bindParam(":lastName", $this->lastName);

        if($stmt->execute()){
            return true;
        }

        printf("Error %s. \n", $stmt->error);
        return false;
    }

    // Update User's Password
    public function updatePassword(){
        $query = "UPDATE {$this->table}
                    SET password = :password
                    WHERE id = :id;";

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":password", $this->password);

        if($stmt->execute()){
            return true;
        }

        printf("Error %s. \n", $stmt->error);
        return false;
    }

    // Delete User record
    public function delete(){
        $query = "DELETE FROM {$this->table} WHERE id = :id;";

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()){
            return true;
        }

        printf("Error %s. \n", $stmt->error);
        return false;
    }

}

?>