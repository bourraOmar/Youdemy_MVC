
<?php
session_start();
require_once '../classes/user.php';

class Teacher extends User
{

  static function GetMostEnrolledCourses($teacher_id)
  {

    $db = Dbconnection::getInstance()->getConnection();

    $sql = "SELECT c.course_image, c.course_id, c.title, COUNT(e.student_id) AS enrollments_count
                FROM courses c
                JOIN enrollments e ON c.course_id = e.course_id
                WHERE c.teacher_id = :teacher_id
                GROUP BY c.course_id
                ORDER BY enrollments_count DESC
                LIMIT 3";

    $stmt = $db->prepare($sql);

    $stmt->bindParam(':teacher_id', $teacher_id);

    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_OBJ);

    $courses = [];
    foreach ($result as $row) {
      $course = new stdClass();
      $course->course_id = $row->course_id;
      $course->courseimage = $row->course_image;
      $course->title = $row->title;
      $course->enrollments_count = $row->enrollments_count;
      $courses[] = $course;
    }

    return $courses;
  }

  static function GetTotalEnrolledStudents($teacher_id)
  {
    $db = Dbconnection::getInstance()->getConnection();

    $sql = "SELECT COUNT(e.student_id) AS total_enrolled_students
                FROM enrollments e
                JOIN courses c ON e.course_id = c.course_id
                WHERE c.teacher_id = :teacher_id";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':teacher_id', $teacher_id);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_OBJ);

    return $result->total_enrolled_students;
  }

  static function GetTotalCourses($teacher_id)
  {

    $db = Dbconnection::getInstance()->getConnection();

    $sql = "SELECT COUNT(course_id) AS total_courses
                FROM courses
                WHERE teacher_id = :teacher_id";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':teacher_id', $teacher_id);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_OBJ);

    return $result->total_courses;
  }
}
?>
