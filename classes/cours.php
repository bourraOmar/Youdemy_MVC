<?php
require_once '../classes/conn.php';

abstract class Cours
{
    protected $id;
    protected $title;
    protected $description;
    protected $course_image;
    protected $price;
    protected $category_id;
    protected $teacher_id;
    public $personName;
    public $creationdate;
    public $cours_type;

    public function __construct($title, $description, $course_image, $price, $category_id, $teacher_id)
    {
        $this->title = $title;
        $this->description = $description;
        $this->course_image = $course_image;
        $this->price = $price;
        $this->category_id = $category_id;
        $this->teacher_id = $teacher_id;
    }

    function getId()
    {
        return $this->id;
    }
    function gettitle()
    {
        return $this->title;
    }
    function getdescription()
    {
        return $this->description;
    }
    function getcourseImage()
    {
        return $this->course_image;
    }
    function getprice()
    {
        return $this->price;
    }
    function getcategory_id()
    {
        return $this->category_id;
    }
    function getteacher_id()
    {
        return $this->teacher_id;
    }

    abstract public function ajouterCours();

    static abstract public function afficherCours();

    static public function showAllCours()
    {
        $db = Dbconnection::getInstance()->getConnection();

        try {
            $sql = "SELECT c.*, u.prenom, u.nom, u.user_id 
                    FROM courses c
                    LEFT JOIN users u ON c.teacher_id = u.user_id";

            $stmt = $db->prepare($sql);
            $stmt->execute();

            $courseData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $courses = [];

            foreach ($courseData as $cours) {
                if ($cours['course_type'] === 'video') {
                    $course = new VideoCours(
                        $cours['title'],
                        $cours['description'],
                        $cours['course_image'],
                        $cours['video_url'],
                        $cours['price'],
                        $cours['category_id'],
                        $cours['teacher_id']
                    );
                } elseif ($cours['course_type'] === 'document') {
                    $course = new DocumentCours(
                        $cours['title'],
                        $cours['description'],
                        $cours['course_image'],
                        $cours['document_content'],
                        $cours['price'],
                        $cours['category_id'],
                        $cours['teacher_id']
                    );
                } else {
                    continue;
                }

                $course->id = $cours['course_id'];
                $course->personName = $cours['prenom'] . " " . $cours['nom'];
                $course->creationdate = $cours['date_creation'];
                $course->cours_type = $cours['course_type'];
                $courses[] = $course;
            }

            return $courses;
        } catch (PDOException $e) {
            throw new Exception("Error while fetching all courses: " . $e->getMessage());
            return [];
        }
    }

    static public function showspecificsCours($teacher_id)
    {
        $db = Dbconnection::getInstance()->getConnection();

        try {
            $sql = "SELECT c.*, u.prenom, u.nom, u.user_id 
                    FROM courses c
                    LEFT JOIN users u ON c.teacher_id = u.user_id
                    WHERE c.teacher_id = :teacher_id";

            $stmt = $db->prepare($sql);
            $stmt->bindParam("teacher_id", $teacher_id);
            $stmt->execute();

            $courseData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $courses = [];

            foreach ($courseData as $cours) {
                if ($cours['course_type'] === 'video') {
                    $course = new VideoCours(
                        $cours['title'],
                        $cours['description'],
                        $cours['course_image'],
                        $cours['video_url'],
                        $cours['price'],
                        $cours['category_id'],
                        $cours['teacher_id']
                    );
                } elseif ($cours['course_type'] === 'document') {
                    $course = new DocumentCours(
                        $cours['title'],
                        $cours['description'],
                        $cours['course_image'],
                        $cours['document_content'],
                        $cours['price'],
                        $cours['category_id'],
                        $cours['teacher_id']
                    );
                } else {
                    continue;
                }

                $course->id = $cours['course_id'];
                $course->personName = $cours['prenom'] . " " . $cours['nom'];
                $course->creationdate = $cours['date_creation'];
                $courses[] = $course;
            }

            return $courses;
        } catch (PDOException $e) {
            throw new Exception("Error while fetching all courses: " . $e->getMessage());
        }
    }

    static function getCourseById($course_id)
    {
        $db = Dbconnection::getInstance()->getConnection();

        try {
            $sql = "SELECT c.*, u.prenom, u.nom, u.user_id
                    FROM courses c
                    LEFT JOIN users u ON c.teacher_id = u.user_id
                    WHERE c.course_id = :course_id";

            $stmt = $db->prepare($sql);
            $stmt->bindParam(":course_id", $course_id);
            $stmt->execute();

            $courseData = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$courseData) {
                return null;
            }

            if ($courseData['course_type'] === 'video') {
                $course = new VideoCours(
                    $courseData['title'],
                    $courseData['description'],
                    $courseData['course_image'],
                    $courseData['video_url'],
                    $courseData['price'],
                    $courseData['category_id'],
                    $courseData['teacher_id']
                );
            } elseif ($courseData['course_type'] === 'document') {
                $course = new DocumentCours(
                    $courseData['title'],
                    $courseData['description'],
                    $courseData['course_image'],
                    $courseData['document_content'],
                    $courseData['price'],
                    $courseData['category_id'],
                    $courseData['teacher_id']
                );
            } else {
                throw new Exception("Unknown course type: " . $courseData['course_type']);
            }

            $course->id = $courseData['course_id'];
            $course->personName = $courseData['prenom'] . " " . $courseData['nom'];
            $course->creationdate = $courseData['date_creation'];
            $course->cours_type = $courseData['course_type'];

            return $course;
        } catch (PDOException $e) {
            throw new Exception("Error while fetching the course: " . $e->getMessage());
        }
    }

    static function getEnrolledCourses($student_id)
    {
        $db = Dbconnection::getInstance()->getConnection();
        try {
            $sql = "SELECT e.*, c.*, CONCAT(n.prenom , ' ' , n.nom) AS teacher_name, u.prenom, u.nom, u.user_id
                    FROM enrollments e
                    LEFT JOIN courses c ON c.course_id = e.course_id
                    LEFT JOIN users u ON e.student_id = u.user_id
                    LEFT JOIN users n ON c.teacher_id = n.user_id
                    WHERE e.student_id = :student_id";

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':student_id', $student_id);

            $stmt->execute();

            $eCourses = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $courses = [];

            foreach ($eCourses as $cour) {
                if ($cour['course_type'] === 'video') {
                    $course = new VideoCours(
                        $cour['title'],
                        $cour['description'],
                        $cour['course_image'],
                        $cour['video_url'],
                        $cour['price'],
                        $cour['category_id'],
                        $cour['teacher_id']
                    );
                } else if ($cour['course_type'] === 'document') {
                    $course = new DocumentCours(
                        $cour['title'],
                        $cour['description'],
                        $cour['course_image'],
                        $cour['document_content'],
                        $cour['price'],
                        $cour['category_id'],
                        $cour['teacher_id']
                    );
                } else {
                    continue;
                }
                $course->id = $cour['course_id'];
                $course->personName = $cour['teacher_name'];
                $course->creationdate = $cour['inscription_date'];
                $course->cours_type = $cour['course_type'];
                $courses[] = $course;
            }
            return $courses;
        } catch (PDOException $e) {
            throw new Exception('there is an error while get enrolled courses for student ' . $e->getMessage());
            return [];
        }
    }

    static function CountenrollCourses($course_id)
    {
        $db = Dbconnection::getInstance()->getConnection();

        try {
            $sql = "SELECT COUNT(*) AS enroll_Count
                    FROM enrollments e
                    WHERE e.course_id = :course_id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':course_id', $course_id);

            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception('There is an error while count how much person enrolled cours' . $e->getMessage());
        }
    }
    // Search function
    static function CoursSearch($cours_name)
    {
        $db = Dbconnection::getInstance()->getConnection();

        try {
            $sql = "SELECT c.*, e.*, CONCAT(n.prenom, ' ', n.nom) AS teacher_name 
                FROM courses c
                LEFT JOIN enrollments e ON c.course_id = e.course_id
                LEFT JOIN users n ON c.teacher_id = n.user_id
                WHERE c.title LIKE :course_name
                GROUP BY c.course_id";

            $stmt = $db->prepare($sql);
            $like = "%" . $cours_name . "%";
            $stmt->bindParam(':course_name', $like);
            $stmt->execute();

            $searchedCours = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $search = [];

            foreach ($searchedCours as $cour) {
                if ($cour['course_type'] == 'video') {
                    $course = new VideoCours(
                        $cour['title'],
                        $cour['description'],
                        $cour['course_image'],
                        $cour['video_url'],
                        $cour['price'],
                        $cour['category_id'],
                        $cour['teacher_id']
                    );
                } else if ($cour['course_type'] == 'document') {
                    $course = new DocumentCours(
                        $cour['title'],
                        $cour['description'],
                        $cour['course_image'],
                        $cour['document_content'],
                        $cour['price'],
                        $cour['category_id'],
                        $cour['teacher_id']
                    );
                } else {
                    continue;
                }
                $course->id = $cour['course_id'];
                $course->personName = $cour['teacher_name'];
                $course->creationdate = $cour['inscription_date'];
                $course->cours_type = $cour['course_type'];
                $search[] = $course;
            }
            return $search;
        } catch (PDOException $e) {
            throw new Exception('There is an error while searching' . $e->getMessage());
            return [];
        }
    }

    static function updateCourse($course_id, $title, $description, $price, $category_id, $course_type, $content)
    {
        $db = Dbconnection::getInstance()->getConnection();

        try {
            $sql = "UPDATE courses 
                    SET title = :title, description = :description,
                        price = :price, category_id = :category_id, course_type = :course_type
                    WHERE course_id = :course_id";

            $stmt = $db->prepare($sql);
            $stmt->bindParam(":title", $title);
            $stmt->bindParam(":description", $description);
            $stmt->bindParam(":price", $price);
            $stmt->bindParam(":category_id", $category_id);
            $stmt->bindParam(":course_type", $course_type);
            $stmt->bindParam(":course_id", $course_id);
            $stmt->execute();

            if ($course_type == 'video') {
                $sqlContent = "UPDATE courses SET video_url = :content WHERE course_id = :course_id";
            } elseif ($course_type == 'document') {
                $sqlContent = "UPDATE courses SET document_content = :content WHERE course_id = :course_id";
            }

            if (isset($sqlContent)) {
                $stmtContent = $db->prepare($sqlContent);
                $stmtContent->bindParam(":content", $content);
                $stmtContent->bindParam(":course_id", $course_id);
                $stmtContent->execute();
            }

            $sqlFetch = "SELECT c.*, u.prenom, u.nom, u.user_id 
                         FROM courses c
                         LEFT JOIN users u ON c.teacher_id = u.user_id
                         WHERE c.course_id = :course_id";

            $stmtFetch = $db->prepare($sqlFetch);
            $stmtFetch->bindParam(":course_id", $course_id);
            $stmtFetch->execute();

            $courseData = $stmtFetch->fetch(PDO::FETCH_ASSOC);

            if ($courseData['course_type'] === 'video') {
                $course = new VideoCours(
                    $courseData['title'],
                    $courseData['description'],
                    $courseData['course_image'],
                    $courseData['video_url'],
                    $courseData['price'],
                    $courseData['category_id'],
                    $courseData['teacher_id']
                );
            } elseif ($courseData['course_type'] === 'document') {
                $course = new DocumentCours(
                    $courseData['title'],
                    $courseData['description'],
                    $courseData['course_image'],
                    $courseData['document_content'],
                    $courseData['price'],
                    $courseData['category_id'],
                    $courseData['teacher_id']
                );
            } else {
                throw new Exception("Unknown course type.");
            }

            $course->id = $courseData['course_id'];
            $course->personName = $courseData['prenom'] . " " . $courseData['nom'];
            $course->creationdate = $courseData['date_creation'];
            $course->cours_type = $courseData['course_type'];

            return $course;
        } catch (PDOException $e) {
            throw new Exception("Error while updating course: " . $e->getMessage());
        }
    }


    static function GetTotalEnrolledStudents()
    {

        $db = Dbconnection::getInstance()->getConnection();

        $sql = "SELECT COUNT(student_id) AS total_enrolled_students
                FROM enrollments";

        $stmt = $db->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_OBJ);

        return $result->total_enrolled_students;
    }

    static function DeleteCourse($course_id)
    {
        $db = Dbconnection::getInstance()->getConnection();
        try {
            $sql = "DELETE FROM courses
                WHERE course_id = :course_id";

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':course_id', $course_id);

            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("THere is an error while Delete Course " . $e->getMessage());
        }
    }
}

class VideoCours extends Cours
{
    private $videoUrl;
    public $course_type;

    public function __construct($title, $description, $course_image, $videoUrl, $price, $category_id, $teacher_id)
    {
        parent::__construct($title, $description, $course_image, $price, $category_id, $teacher_id);
        $this->videoUrl = $videoUrl;
    }

    function getvedioUrl()
    {
        return $this->videoUrl;
    }

    public function ajouterCours()
    {
        $db = Dbconnection::getInstance()->getConnection();

        try {
            $sql = "INSERT INTO courses (title, description, course_image, course_type, video_url, price, category_id, teacher_id)
                    VALUES (:title, :description, :course_image, 'video', :video_url, :price, :category_id, :teacher_id)";
            $stmt = $db->prepare($sql);

            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':course_image', $this->course_image);
            $stmt->bindParam(':video_url', $this->videoUrl);
            $stmt->bindParam(':price', $this->price);
            $stmt->bindParam(':category_id', $this->category_id);
            $stmt->bindParam(':teacher_id', $this->teacher_id);

            $stmt->execute();

            $this->id = $db->lastInsertId();
            return $this->id;
        } catch (PDOException $e) {
            throw new Exception("There is an error while create Course with video!" . $e->getMessage());
        }
    }

    static public function afficherCours()
    {
        $db = Dbconnection::getInstance()->getConnection();

        try {
            $sql = "SELECT c.*, u.*
                    FROM courses c
                    LEFT JOIN users u ON c.teacher_id = u.user_id
                    WHERE course_type = 'video'";

            $stmt = $db->prepare($sql);
            $stmt->execute();

            $courseData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $courses = [];

            foreach ($courseData as $cours) {
                $videoCourse = new VideoCours(
                    $cours['title'],
                    $cours['description'],
                    $cours['course_image'],
                    $cours['video_url'],
                    $cours['price'],
                    $cours['category_id'],
                    $cours['teacher_id']
                );
                $videoCourse->id = $cours['course_id'];
                $videoCourse->personName = $cours['prenom'] . " " . $cours['nom'];
                $videoCourse->creationdate = $cours['date_creation'];
                $videoCourse->course_type = $cours['course_type'];
                $courses[] = $videoCourse;
            }

            return $courses;
        } catch (PDOException $e) {
            throw new Exception("Error while fetching video courses: " . $e->getMessage());
            return [];
        }
    }

    static function getCourseById($course_id)
    {
        $db = Dbconnection::getInstance()->getConnection();

        try {
            $sql = "SELECT c.*, u.*
                    FROM courses c
                    LEFT JOIN users u ON c.teacher_id = u.user_id
                    WHERE c.course_id = :course_id AND c.course_type = 'video'";

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':course_id', $course_id);
            $stmt->execute();

            $courseData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($courseData) {
                $videoCourse = new VideoCours(
                    $courseData['title'],
                    $courseData['description'],
                    $courseData['course_image'],
                    $courseData['video_url'],
                    $courseData['price'],
                    $courseData['category_id'],



                    $courseData['teacher_id']
                );

                $videoCourse->id = $courseData['course_id'];
                $videoCourse->personName = $courseData['prenom'] . " " . $courseData['nom'];
                $videoCourse->creationdate = $courseData['date_creation'];

                return $videoCourse;
            } else {
                throw new Exception("No course found with ID: $course_id");
            }
        } catch (PDOException $e) {
            throw new Exception("Error while fetching course by ID: " . $e->getMessage());
        }
    }
}

class DocumentCours extends Cours
{
    private $documentText;

    public function __construct($title, $description, $course_image, $documentText, $price, $category_id, $teacher_id)
    {
        parent::__construct($title, $description, $course_image, $price, $category_id, $teacher_id);
        $this->documentText = $documentText;
    }

    function getdocumentText()
    {
        return $this->documentText;
    }

    public function ajouterCours()
    {
        $db = Dbconnection::getInstance()->getConnection();

        try {
            $sql = "INSERT INTO courses (title, description, course_image, course_type, document_content, price, category_id, teacher_id)
                    VALUES (:title, :description, :course_image, 'document', :document_content, :price, :category_id, :teacher_id)";

            $stmt = $db->prepare($sql);

            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':course_image', $this->course_image);
            $stmt->bindParam(':document_content', $this->documentText);
            $stmt->bindParam(':price', $this->price);
            $stmt->bindParam(':category_id', $this->category_id);
            $stmt->bindParam(':teacher_id', $this->teacher_id);

            $stmt->execute();

            $this->id = $db->lastInsertId();
            return $this->id;
        } catch (PDOException $e) {
            throw new Exception("There is an error while create Course with doc text!" . $e->getMessage());
        }
    }

    static public function afficherCours()
    {
        $db = Dbconnection::getInstance()->getConnection();

        try {
            $sql = "SELECT c.*, u.*
                    FROM courses c
                    LEFT JOIN users u ON c.teacher_id = u.user_id
                    WHERE course_type = 'document'";
            $stmt = $db->prepare($sql);
            $stmt->execute();

            $courseData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $courses = [];

            foreach ($courseData as $cours) {
                $videoCourse = new DocumentCours(
                    $cours['title'],
                    $cours['description'],
                    $cours['course_image'],
                    $cours['document_content'],
                    $cours['price'],
                    $cours['category_id'],
                    $cours['teacher_id']
                );
                $videoCourse->id = $cours['course_id'];
                $videoCourse->personName = $cours['prenom'] . " " . $cours['nom'];
                $videoCourse->creationdate = $cours['date_creation'];
                $courses[] = $videoCourse;
            }

            return $courses;
        } catch (PDOException $e) {
            throw new Exception("Error while fetching video courses: " . $e->getMessage());
            return [];
        }
    }
}
