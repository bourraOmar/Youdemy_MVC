<?php
require_once '../classes/admin.php';

if (isset($_POST['user_id']) && isset($_POST['action'])) {
    Admin::changeEnseignant($_POST['user_id'], $_POST['action']);
    header('Location: ../pages/adminDashboard.php');
    exit();
}
