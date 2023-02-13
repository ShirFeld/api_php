<?php

class Database{
    public $host;
    public $dbName;
    public $user;
    public $password;

    public function __construct(string $host , string $dbName , string $user , string $password){
        $this->host = $host;
        $this->dbName = $dbName;
        $this->user = $user;
        $this->password = $password;
    }

    public function getConnection(): PDO{
        $dsn = "mysql:host={$this->host}; dbname={$this->dbName}; charset=utf8";
        return new PDO($dsn , $this->user , $this->password , [
            //if those methods will be true so the data that is not string will be string.
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_STRINGIFY_FETCHES => false
        ]);
    }
}