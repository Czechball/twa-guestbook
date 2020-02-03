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
        function getUserIpAddr()
    {
        if(!empty($_SERVER['HTTP_CLIENT_IP']))
            {   //ip from share internet
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
                elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            {
                //ip pass from proxy
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }   else
            {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
    return $ip;
    }
        $ip = getUserIpAddr();
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

    public function deletePost($id)
    {
        try
        {
            $stmt = $this->conn->prepare("DELETE FROM `gbook_2020` WHERE id = :id;");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
    }

}    

    public function getPosts()
    {
        try
        {
            $stmt = $this->conn->prepare("SELECT * FROM `gbook_2020` ORDER BY `date` DESC;");
            $stmt->bindParam(':jmeno', $_POST['jmeno']);
            $stmt->execute();
            $dotaz = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $dotaz;
        } catch (PDOException $e)
        {
            echo "Chyba čtení tabulky: ";
            echo $e->getMessage();
        }
    }

    public function verifyAdmin($name, $password)
    {
        $stmt = $this->conn->prepare("SELECT password FROM `credentials` WHERE username = :username ORDER BY id ASC;");
        $stmt->bindParam(':username', $name);
        $stmt->execute();
        if($stmt->rowCount() == 0)
            return false;
        $dotaz = $stmt->fetch(PDO::FETCH_OBJ);
        return(password_verify($password, $dotaz->password));
    }

}
?>