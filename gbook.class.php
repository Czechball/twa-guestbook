<?php
class gbook
{
    public $conn;
        /**
         * Konstruktor se připojí k DB ASW
         */
    public function __construct($host, $port, $dbname, $user, $pass)
    {
        $dsn = "mysql:host=$host;dbname=$dbname;port=$port";
        echo $dsn;
        $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        try
            {
                $this->conn = new PDO($dsn, $user, $pass, $options);
            }
        catch(PDOException $e)
            {
                echo "Nelze se připojit k MySQL: ";  echo $e->getMessage();
            }
    }
}
?>