<?php
require_once '../classes/conn.php';

class Category
{
    private $id;
    private $name;

    function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    function saveCategorie()
    {
        $db = Dbconnection::getInstance()->getConnection();

        if ($this->id) {
            try {
                $sql = "UPDATE categories
                        SET name = :name
                        WHERE category_id = :category_id";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':name', $this->name);
                $stmt->bindParam(':category_id', $this->id);
                $stmt->execute();

                return $this->id;
            } catch (PDOException $e) {
                throw new Exception('there is an error while create category');
            }
        } else {
            try {
                $sql = "INSERT INTO categories(name)
                    VALUES (:name)";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':name', $this->name);
                $stmt->execute();

                $this->id = $db->lastInsertId();
            } catch (PDOException $e) {
                throw new Exception('there is an error while create category');
            }
            return $this->id;
        }
    }

    static function CreateCategorie($name)
    {
        $name = htmlspecialchars($name);

        $category = new Category(null, $name);

        $category->saveCategorie();
    }

    static function showCategories()
    {
        $db = Dbconnection::getInstance()->getConnection();

        try {
            $sql = "SELECT category_id, name FROM categories";
            $stmt = $db->prepare($sql);
            $stmt->execute();

            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $categories;
        } catch (PDOException $e) {
            throw new Exception('Error while retrieving categories');
        }
    }
}
