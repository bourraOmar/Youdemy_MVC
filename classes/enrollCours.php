
<?php
require_once '../classes/conn.php';

class Enrollments {
    private $id;
    private $course_id;
    private $student_id;

    public function __construct($course_id, $student_id, $id = null) {
        $this->id = $id;
        $this->course_id = $course_id;
        $this->student_id = $student_id;
    }

    public function getId() {return $this->id;}

    public function getCourseId() {return $this->course_id;}

    public function getStudentId() {return $this->student_id;}

    public function setId($id) {$this->id = $id;}

    public function setCourseId($course_id) { $this->course_id = $course_id;}

    public function setStudentId($student_id) {$this->student_id = $student_id;}

    public function save() {
        $db = Dbconnection::getInstance()->getConnection();

        try {
            if ($this->isAlreadyEnrolled($this->course_id, $this->student_id)) {
                throw new Exception("Student is already enrolled in this course.");
            }

            $sql = "INSERT INTO enrollments (course_id, student_id) VALUES (:course_id, :student_id)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':course_id', $this->course_id);
            $stmt->bindParam(':student_id', $this->student_id);
            $stmt->execute();

        } catch (PDOException $e) {
            throw new Exception("Error enrolling in the course: " . $e->getMessage());
        }
    }

    public static function makeEnrollment($student_id, $course_id) {
        $db = Dbconnection::getInstance()->getConnection();

        try {
            if (self::isAlreadyEnrolled($course_id, $student_id)) {
                throw new Exception("You are already enrolld in this course!!");
            }

            $sql = "INSERT INTO enrollments (course_id, student_id) VALUES (:course_id, :student_id)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':course_id', $course_id);
            $stmt->bindParam(':student_id', $student_id);
            $stmt->execute();

        } catch (PDOException $e) {
            throw new Exception("Error enrolling in the course: " . $e->getMessage());
        }
    }

    private function isAlreadyEnrolled($course_id, $student_id) {
        $db = Dbconnection::getInstance()->getConnection();

        try {
            $sql = "SELECT * FROM enrollments WHERE course_id = :course_id AND student_id = :student_id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':course_id', $course_id);
            $stmt->bindParam(':student_id', $student_id);
            $stmt->execute();

            return $stmt->rowCount() > 0;

        } catch (PDOException $e) {
            throw new Exception("Error checking enrollment: " . $e->getMessage());
        }
    }

    public static function getAllEnrollments() {
        $db = Dbconnection::getInstance()->getConnection();

        try {
            $sql = "SELECT * FROM enrollments";
            $stmt = $db->prepare($sql);
            $stmt->execute();

            $enrollments = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $enrollments[] = new Enrollments($row['course_id'], $row['student_id'], $row['id']);
            }
            return $enrollments;

        } catch (PDOException $e) {
            throw new Exception("Error fetching enrollments: " . $e->getMessage());
        }
    }
}
?>
