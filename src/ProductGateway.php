<?php

class ProductGateway{
/*
The purpose of this class is to create a connection to the database.
After the connection we will do some queries.
*/
    private PDO $conn;
    // the __construct create the connection to db (he received the details from index.php)
    public function __construct(Database $database){
        $this->conn = $database->getConnection();
    }


    public function getAll(): array{
        $sql = "SELECT * FROM article";
                
        $query = $this->conn->query($sql);
        
        $data = [];
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        return $data;
    }

    public function create(array $data): string{
        $query = "INSERT INTO product (article_name, length, publish_date , author)
                VALUES (:article_name , :length, :publish_date , :author)";
                
        $statement = $this->conn->prepare($query);
        
        $statement->bindValue(":article_name", $data["article_name"], PDO::PARAM_STR);
        $statement->bindValue(":length", $data["length"] ?? 0, PDO::PARAM_INT);
        $statement->bindValue(":publish_date", ($data["publish_date"]), PDO::PARAM_DATE);
        $statement->bindValue(":author", ($data["author"] ), PDO::PARAM_STR);

        $statement->execute();
        
        return $this->conn->lastInsertId();
    }

}