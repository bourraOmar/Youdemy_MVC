<?php
require_once '../classes/conn.php';

class role
{
    private $id;
    private $name;

    function __construct($name)
    {
        $this->name = $name;
    }

    static function getallroles()
    {
        $db = Dbconnection::getInstance()->getConnection();
        try {
            $sql = "SELECT * FROM role WHERE role_id <> 1";
            $stmt = $db->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception('there is an error in roles show ' . $e->getMessage());
        }
    }
}
