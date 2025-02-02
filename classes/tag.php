<?php
require_once '../classes/conn.php';

class Tag
{
    private $id;
    private $name;

    function __construct($name)
    {
        $this->name = $name;
    }

    function getid()
    {
        return $this->id;
    }
    function getname()
    {
        return $this->name;
    }



    static function addMultipleTags($tags)
    {
        $db = Dbconnection::getInstance()->getConnection();
        try {
            $stmt_check = $db->prepare("SELECT tag_id FROM tags WHERE name = :tag_name");
            $stmt_insert = $db->prepare("INSERT INTO tags (name) VALUES (:tag_name)");

            $lastInsertIds = [];

            foreach ($tags as $tag) {
                $stmt_check->bindParam(':tag_name', $tag);
                $stmt_check->execute();

                if ($stmt_check->rowCount() == 0) {
                    $stmt_insert->bindParam(':tag_name', $tag);
                    $stmt_insert->execute();
                    $lastInsertIds[] = $db->lastInsertId();
                } else {
                    $existingTag = $stmt_check->fetch(PDO::FETCH_ASSOC);
                    $lastInsertIds[] = $existingTag['tag_id'];
                }
            }
            return $lastInsertIds;
        } catch (PDOException $e) {
            throw new Exception('There is an error while adding tags');
        }
    }

    static function gettagsforCours($cours_id)
    {
        $db = Dbconnection::getInstance()->getConnection();
        try {
            $sql = "SELECT t.*
                from tags t 
                INNER join course_tags ct on ct.tag_id = t.tag_id 
                where ct.course_id = :course_id";

            $stmt = $db->prepare($sql);

            $stmt->bindParam(':course_id', $cours_id);

            $stmt->execute();

            $tags = $stmt->fetchAll(pdo::FETCH_ASSOC);

            $tagsData = [];

            foreach ($tags as $tag) {
                $tagsData[] = new Tag($tag['name']);
            }
            return $tagsData;
        } catch (PDOException $e) {
            throw new Exception('there is an error while show course tags' . $e->getMessage());
            return [];
        }
    }
}
