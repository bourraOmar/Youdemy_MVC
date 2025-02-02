
<?php
session_start();

require_once '../classes/cours.php';
require_once '../classes/tag.php';
require_once '../classes/coursTag.php';

if (isset($_POST['CreateCourseSub'])) {
    $course_title = $_POST['course_title'];
    $course_description = $_POST['course_description'];
    $tags = explode(',', $_POST['tags']);
    $categories_select = $_POST['categories_select'];
    $course_price = $_POST['course_price'];
    $course_type = $_POST['course_type'];

    if (empty($course_title) || empty($course_description) || empty($tags) || empty($categories_select) || empty($course_price) || empty($course_type)) {
        $_SESSION['message'] = [
            'type' => 'error',
            'text' => 'please fill all fields!'
        ];
        header('Location: ../profdashboard/createCours.php');
        exit();
    }

    if ($course_type === 'video') {
        if (isset($_FILES['video_file']) && isset($_FILES['course_image'])) {
            $uploadDirVideo = '../uploads/videos/';
            if (!is_dir($uploadDirVideo)) {
                mkdir($uploadDirVideo, 0777, true);
            }
            $videoFile = $_FILES['video_file'];
            $videoPath = $uploadDirVideo . basename($videoFile['name']);

            $uploadDirImage = '../uploads/images/';
            if (!is_dir($uploadDirImage)) {
                mkdir($uploadDirImage, 0777, true);
            }
            $imageFile = $_FILES['course_image'];
            $imagePath = $uploadDirImage . basename($imageFile['name']);

            if (move_uploaded_file($videoFile['tmp_name'], $videoPath) && move_uploaded_file($imageFile['tmp_name'], $imagePath)) {
                $course = new VideoCours($course_title, $course_description, $imagePath, $videoPath, $course_price, $categories_select, $_SESSION['user_id']);
                try {
                    $course_id = $course->ajouterCours();
                    $tag_ids = Tag::addMultipleTags($tags);
                    foreach ($tag_ids as $tagID) {
                        $coursetag = new CourseTag($tagID, $course_id);
                        $coursetag->addTagToArticle();
                    }
                    $_SESSION['message'] = [
                        'type' => 'success',
                        'text' => 'Course created successfully!'
                    ];
                    header('Location: ../profdashboard/createCours.php');
                    exit();
                } catch (Exception $e) {
                    $_SESSION['message'] = [
                        'type' => 'error',
                        'text' => $e->getMessage()
                    ];
                    header('Location: ../profdashboard/createCours.php');
                    exit();
                }
            } else {
                $_SESSION['message'] = [
                    'type' => 'error',
                    'text' => 'Failed to upload the video or image.'
                ];
                header('Location: ../profdashboard/createCours.php');
                exit();
            }
        } else {
            $_SESSION['message'] = [
                'type' => 'error',
                'text' => 'Video and image files are required.'
            ];
            header('Location: ../profdashboard/createCours.php');
            exit();
        }
    } else if ($course_type === 'document') {
        if (isset($_FILES['course_image'])) {
            $uploadDirImage = '../uploads/images/';
            if (!is_dir($uploadDirImage)) {
                mkdir($uploadDirImage, 0777, true);
            }
            $imageFile = $_FILES['course_image'];
            $imagePath = $uploadDirImage . basename($imageFile['name']);

            if (move_uploaded_file($imageFile['tmp_name'], $imagePath)) {
                $content = $_POST['document_content'];
                $course = new DocumentCours($course_title, $course_description, $imagePath, $content, $course_price, $categories_select, $_SESSION['user_id']);
                try {
                    $course_id = $course->ajouterCours();
                    $tag_ids = Tag::addMultipleTags($tags);
                    foreach ($tag_ids as $tagID) {
                        $coursetag = new CourseTag($tagID, $course_id);
                        $coursetag->addTagToArticle();
                    }
                    $_SESSION['message'] = [
                        'type' => 'success',
                        'text' => "Course created successfully!"
                    ];
                    header('Location: ../profdashboard/createCours.php');
                    exit();
                } catch (Exception $e) {
                    $_SESSION['message'] = [
                        'type' => 'error',
                        'text' => $e->getMessage()
                    ];
                    header('Location: ../profdashboard/createCours.php');
                    exit();
                }
            } else {
                $_SESSION['message'] = [
                    'type' => 'error',
                    'text' => 'Failed to upload the image.'
                ];
                header('Location: ../profdashboard/createCours.php');
                exit();
            }
        }
    } else {
        $_SESSION['message'] = [
            'type' => 'error',
            'text' => 'Invalid course type.'
        ];
        header('Location: ../profdashboard/createCours.php');
        exit();
    }
}
?>
