<?php
require_once '../classes/conn.php';
require_once '../classes/user.php';

class Admin extends user
{

    public function __construct($id, $nom, $prenom, $email, $role, $status, $hashedPassword = null)
    {
        parent::__construct($id, $nom, $prenom, $email, $role, $status, $hashedPassword);
    }

    public static function getallusers()
    {
        $db = Dbconnection::getInstance()->getconnection();

        try {
            $sql = "SELECT u.*, r.name
                    FROM users u
                    LEFT JOIN role r ON u.role_id = r.role_id
                    WHERE u.role_id <> 1";
            $stmt = $db->prepare($sql);
            $stmt->execute();

            $usersData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $users = [];
            foreach ($usersData as $data) {
                $users[] = new User($data['user_id'], $data['nom'], $data['prenom'], $data['email'], $data['name'], $data['status']);
            }

            return $users;
        } catch (PDOException $e) {
            throw new Exception("Error while getting all users: " . $e->getMessage());
        }
    }

    public static function changeEnseignant($userId, $newStatus)
    {
        $db = Dbconnection::getInstance()->getConnection();

        try {
            $sql = "UPDATE users SET status = :status WHERE user_id = :user_id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':status', $newStatus);
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error changing user status: " . $e->getMessage());
        }
    }
}
