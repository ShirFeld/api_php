<?php

class ProductController{

    public $gateway;
    public function __construct( ProductGateway $gateway){
        $this->gateway =  $gateway;
    } // reference to ProductGateway (functions)

    public function processRequest(string $method , ?string $id) : void{        //?string $id -> can be null
        if($id){
            $this->processResourceRequest($method , $id);
        }
        else{
            $this->processCollectionRequest($method);
        }
    }


    private function processResourceRequest(string $method , string $id) : void{

    }

    private function processCollectionRequest(string $method) : void{
        switch($method){
            case "GET":
                echo json_encode($this->gateway->getAll());
                break;

            case "POST":
                $data = (array) json_decode(file_get_contents("php://input"), true);

                $errors = $this->getValidationErrors($data);
                if ( !empty($errors)) {
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }

                $id = $this->gateway->create($data);     // a new object created

                http_response_code(201);
                echo json_encode([
                    "message" => "Article created",
                    "id" => $id
                ]);
                break;
        }
    }

    /*
    This method is related to method create on ProductGateway - 
    when no variables are entered, then there is an error and here we test it.
    */
    private function getValidationErrors(array $data, bool $is_new = true): array{
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