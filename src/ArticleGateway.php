<?php

class ArticleGateway{
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
    /*
    This function returns us all the information that is in the database about articles.      
     */
        $sql = "SELECT * FROM article";
                
        $query = $this->conn->query($sql);
        
        $data = [];
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        return $data;
    }

    public function getArticle(string $id){
    /*
    This function returns us the specific article by id.
    */
        $query = "SELECT * FROM article
                  where id = $id";
 
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($data === false){
            return false;
        }
            
        return $data;
    }

    public function create(array $data , $userId ): string{
    // we get the data from processCollectionRequest --> ArticleController

        $query = "INSERT INTO article (article_name, length, publish_date , author , content)
                  VALUES (:article_name , :length, :publish_date , $userId , content)";
                
        $stmt = $this->conn->prepare($query);
        /*
        Value binding tells the component to take the value of the field from the view-model and use it
        */

        $stmt->bindValue(":article_name", $data["article_name"] , PDO::PARAM_STR);
        $stmt->bindValue(":length", $data["length"], PDO::PARAM_INT);
        $stmt->bindValue(":publish_date" ,($data["publish_date"]), PDO::PARAM_STR);
       

        $stmt->execute();
        
        return $this->conn->lastInsertId();
    }

    public function update(array $current, array $new, $id , $userId): int{
    /*
    This function will update the data of an article (by id).
    */
      
        $query = "UPDATE article SET article_name = :article_name, length = :length, publish_date = :publish_date , content = :content
                  WHERE author = $userId and id = :id";    
                   
        $stmt = $this->conn->prepare($query);
        

        if ($new["article_name"] != ""){
         $stmt->bindValue(":article_name", $new["article_name"] , PDO::PARAM_STR);
        } 
        else{
            $stmt->bindValue(":article_name", $current["article_name"] , PDO::PARAM_STR);
        }
        if($new["length"] !=""){
            $stmt->bindValue(":length", $new["length"] , PDO::PARAM_INT);
        }
        else{
            $stmt->bindValue(":length", $current["length"] , PDO::PARAM_INT);
        }
        if($new["publish_date"] !=""){
            $stmt->bindValue(":publish_date", $new["publish_date"], PDO::PARAM_STR);
        }
        else{
            $stmt->bindValue(":publish_date", $current["publish_date"], PDO::PARAM_STR);
        }
        if($new["content"] !=""){
            $stmt->bindValue(":content",$new["content"] , PDO::PARAM_STR);
        }
        else{
            $stmt->bindValue(":content",$current["content"] , PDO::PARAM_STR);    
        }

        // $stmt->bindValue(":id", $current["id"], PDO::PARAM_INT);
        $stmt->bindValue(":id",$id, PDO::PARAM_INT);
        
        $stmt->execute();

        return $stmt->rowCount();  // tell us if something changed
    }

    
    public function delete($articleIid ,$userId ): int{
    /*
    This function deletes the data of an article (by id).
    */
        $sql = "DELETE FROM article 
        WHERE author = $userId and id = $articleIid";
                
        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindValue(":author", $userId, PDO::PARAM_INT);
        
        $stmt->execute();
        
        return $stmt->rowCount();
    }


}