<?php
class Database
{
    private $host = 'localhost';
    private $user = 'root';
    private $pass = 'exercise';
    private $db = 'database_db';

    private $dbh;
    private $error;
    private $stmt;

    public function __construct()
    {
        //Set Connection
//        $dsn = 'mysql:host='. $this->host . ';dbname='. $this->db;

        //Set Options
        $options = array(
            PDO::ATTR_PERSISTENT    => true,
            PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION
        );
        // Create new PDO
        try {
            $this->dbh = new PDO("mysql:host=" . $this->host, $this->user, $this->pass, $options);
            $db = "`".str_replace("`","``",$this->db)."`";
            $this->dbh->query("CREATE DATABASE IF NOT EXISTS $this->db CHARACTER SET utf8 COLLATE utf8_general_ci;");
            $this->dbh->query("use $db");

        } catch(PDOException $e)
        {
            echo $this->error = $e->getMessage();
        }
    }

    public function query($query)
    {
        $this->stmt = $this->dbh->prepare($query);
    }

    public function bind($param, $value, $type=null)
    {
        if(is_null($type)){
            switch(true) {

                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;

                default:
                    $type = PDO::PARAM_STR;

            }

        }

        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute()
    {
        return $this->stmt->execute();
    }


    public function lastInsertId()
    {
        $this->dbh->lastInsertId();
    }

    public function resultset()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function resultArray()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}