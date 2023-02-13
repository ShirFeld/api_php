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
                $id = $this->gateway->create($data);     // a new object created

                echo json_encode([
                    "message" => "Article created",
                    "id" => $id
                ]);
                break;
        }
    }

}