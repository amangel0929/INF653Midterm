<?php
    class Quote{
        private $conn;
        private $table = 'quotes';

        //Quote Properties
        public $id;
        public $quote;
        public $author;
        public $category;


        public function __construct($db) {
            $this->conn = $db;
        }
        
        public function read(){
            //Create query
            $query = "SELECT 
                c.category,
                a.author,
                q.quote,
                q.id 

                FROM
                " . $this->table . " q 
                LEFT JOIN
                    categories c ON q.category_id = c.category
                LEFT JOIN
                    authors a ON q.author_id = a.author";

            //Prepare statement
            $stmt = $this->conn->prepare($query);
            //Execute statement
            $stmt->execute();

            return $stmt;
        }
    

        //Get Single Post
        public function read_single() {
            $query = "SELECT
                c.category,
                a.author,
                q.quote

            FROM
                " . $this->table . " q
            LEFT JOIN
                categories c ON q.category_id = c.category
            LEFT JOIN
                authors a ON q.author_id = a.author
            WHERE
                id = ?
            LIMIT 0,1";

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Bind ID
            $stmt->bindParam(1, $this->id);

            //Execute statement
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->quote = $row['quote'];
            $this->category = $row['category'];
            $this->author = $row['author'];

        }

        //Create Quote
        public function create() {
            $query = "INSERT INTO " . $this->table . " q
            SET
                quote = :quote,
                category = :c.category,
                author = :a.author
            LEFT JOIN
                categories c ON q.category_id = c.category
            LEFT JOIN
                authors a ON q.author_id = a.author";

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category = htmlspecialchars(strip_tags($this->category));

            //Bind data
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':authors.author', $this->author);
            $stmt->bindParam(':categories.category', $this->category);
            
            //Execute query
            if($stmt->execute()){
                return true;
            }

            printf("Missing Required Parameters", $stmt->error);

            return false;
        }

        //Update Quote
        public function update() {
            $query = "UPDATE " . $this->table . " q
            SET
                quote = :quote,
                category = :c.category,
                author = :a.author
            LEFT JOIN
                categories c ON q.category_id = c.category
            LEFT JOIN
                authors c ON q.author_id = a.author
            WHERE
                id = :id";

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category = htmlspecialchars(strip_tags($this->category));

            //Bind data
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':a.author', $this->author);
            $stmt->bindParam(':c.category', $this->category);
            
            //Execute query
            if($stmt->execute()){
                return true;
            }

            printf("Missing Required Parameters", $stmt->error);

            return false;
        }

        //Delete Quote
        public function delete() {
            $query = "DELETE FROM " . $this->table . " WHERE id = :id";

             //Prepare statement
             $stmt = $this->conn->prepare($query);

            //Clean data
             $this->id = htmlspecialchars(strip_tags($this->id));

            //Bind data
            $stmt->bindParam(':id', $this->id);

            //Execute query
            if($stmt->execute()){
                return true;
            }

            //Print error if something goes wrong
            printf("Missing Required Parameters", $stmt->error);

            return false;
        }
    }
?>