<?php
require_once '../classes/conn.php';

class CourseTag
{
  private $tag_id;
  private $course_id;

  function __construct($tag_id, $course_id)
  {
    $this->tag_id = $tag_id;
    $this->course_id = $course_id;
  }

  function addTagToArticle()
  {
    $db = Dbconnection::getInstance()->getConnection();
    try {
      $sql = "INSERT INTO course_tags (course_id, tag_id)
                VALUES (:course_id, :tag_id)";

      $stmtt = $db->prepare($sql);

      $stmtt->bindParam(':course_id', $this->course_id);
      $stmtt->bindParam(':tag_id', $this->tag_id);

      $stmtt->execute();
    } catch (PDOException $e) {
      throw new Exception('there is an error while add tag to article on course_tag.php' . $e->getMessage());
    }
  }
}
