<?php
session_start();
require_once '../classes/cours.php';

if (isset($_GET['id'])) {
  try {
    Cours::DeleteCourse($_GET['id']);

    $_SESSION['message'] = [
      'type' => 'success',
      'text' => 'Course Deleted success!'
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
