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


    public function addPost($name, $subject, $text)
    {
        $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        try
        {
            $stmt = $this->conn->prepare("INSERT INTO `gbook_2020` (`id`, `name`, `subject`, `text`, `date`, `ip`) VALUES (NULL, :name, :subject, :text, NULL, :ip);");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':subject', $subject);
            $stmt->bindParam(':text', $text);
            $stmt->bindParam(':ip', $ip);
//            $stmt->bindParam(':datum',$datum);
            $stmt->execute();
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
    }

}
}
?>