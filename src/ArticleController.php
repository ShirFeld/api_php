<?php

class ArticleController{

    public $gateway;
    public function __construct( ArticleGateway $gateway){
        // reference to ArticleGateway (functions)
        $this->gateway =  $gateway;
    } 

    public function processRequest(string $method , ?string $id) : void{        //?string $id -> can be null
        if($id){
            $this->processResourceRequest($method , $id);
        }
        else{
            $this->processCollectionRequest($method);
        }
    }


    private function processResourceRequest(string $method , string $id) : void{
        $article = $this->gateway->getArticle($id);

        if (!$article) {
            http_response_code(404);
            echo json_encode(["Message" => " Article not found "]);
            return;
        }

        switch ($method) {
            case "GET":
                http_response_code(200); 
                echo json_encode($article);
                break;

            // case "PATCH": // update
            //     $data = (array) json_decode(file_get_contents("php://input"), true);
                
            //     $errors = $this->getValidationErrors($data, false);
                
            //     if (!empty($errors)) {
            //         http_response_code(422); // 422 ->  the server was unable to process the instructions
            //         echo json_encode(["Errors" => $errors]);
            //         break;
            //     }

            //     $userId =  $_SESSION['id'];
            //     $rows = $this->gateway->update($article, $data , $id , $userId); // rows -> If the number is 0 it means no changes
            //     echo json_encode([
            //         "Message" => " Article $id updated ",
            //         "rows" => $rows
            //     ]);
            //     break;


            case "DELETE":
                $userId =  $_SESSION['id'];
                $rows = $this->gateway->delete($id , $userId );
                
                echo json_encode([
                    "Message" => " Article $id deleted ",
                    "rows" => $rows
                ]);
                break;
                
                
            default:
                http_response_code(405);
                header("Allow: GET, PATCH, DELETE");
        }



    }


    // for update method ->html
    public function controllerUpdate(string $method , $id , $name , $len , $date , $content ) : void{
        $article = $this->gateway->getArticle($id);

       
        if (!$article) {
            http_response_code(404);
            echo json_encode(["Message" => " Article not found "]);
            return;
        }

        if ($method == "PATCH" ){
            // update
            $data = array("id"=>$id,"article_name"=>$name,"length"=>$len,"publish_date"=>$date,"content"=>$content);

            // validation
            // $errors = $this->getValidationErrors($data, false);
            // if (!empty($errors)) {
            //     http_response_code(422); // 422 ->  the server was unable to process the instructions
            //     echo json_encode(["Errors" => $errors]);
            // }

            $userId =  $_SESSION['id'];
            $rows = $this->gateway->update($article, $data , $id , $userId); // rows -> If the number is 0 it means no changes
            echo json_encode([
                "Message" => " Article $id updated ",
                "rows" => $rows
            ]);
        } 
    }


    private function processCollectionRequest(string $method) : void{
        switch($method){
            case "GET":
                echo json_encode($this->gateway->getAll());
                break;

            case "POST":
                $data = (array) json_decode(file_get_contents("php://input"), true);

                // validation
                // $errors = $this->getValidationErrors($data);
                // if ( !empty($errors)) {
                //     http_response_code(422); // 422 ->  the server was unable to process the instructions
                //     echo json_encode(["errors" => $errors]);
                //     break;
                // }
                $userId =  $_SESSION['id'];
                $id = $this->gateway->create($data ,$userId  );     // a new object created

                http_response_code(201);
                echo json_encode([
                    "message" => "Article created",
                    "id" => $id
                ]);
                break;

            default:
                http_response_code(405); // status 405 -> Method Not Allowed
                header("Allow: GET, POST");

        }
    }


    // validation on input - not necessary now
    private function getValidationErrors(array $data, bool $is_new = true): array{
        /*
        This method is related to method create on ArticleGateway - (method)
        when no variables are entered in the url, then there is an error and here we test it.
        */
        $errors = [];
        
        if ($is_new && empty($data["article_name"])) {
            $errors[] = "article name is required";
        }
    
        if (array_key_exists("length", $data)) {
            if (filter_var($data["length"], FILTER_VALIDATE_INT) === false) {
                $errors[] = "length must be an integer";
            }
        }
        
        
        return $errors;
    }

}