<?php
session_start();
require_once '../classes/cours.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['course_id'])) {
  $course_id = $_POST['course_id'];
  $title = $_POST['title'];
  $description = $_POST['description'];
  $price = $_POST['price'];
  $category_id = $_POST['category'];
  $course_type = $_POST['cours_type'];

  $course = Cours::getCourseById($course_id);

  if ($course_type == 'video') {
    if (isset($_FILES['coursecontent'])) {

      $file = $_FILES['coursecontent'];
      $uploadFile = '../uploads/videos/' . time() . '-' . $file['name'];

      move_uploaded_file($file['tmp_name'], $uploadFile);
      $content = $uploadFile;
    } else {
      $content = $course->getvedioUrl();
    }
  }

  try {
    Cours::updateCourse($course_id, $title, $description, $price, $category_id, $course_type, $content);

    $_SESSION['message'] = [
      'type' => 'success',
      'text' => 'You have update course success!'
    ];
    header('Location: ../profdashboard/myCourse.php');
    exit();
  } catch (Exception $e) {
    $_SESSION['message'] = [
      'type' => 'error',
      'text' => $e->getMessage()
    ];
    header('Location: ../profdashboard/myCourse.php');
    exit();
  }
}
