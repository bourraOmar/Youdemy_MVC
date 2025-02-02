<?php
session_start();
require_once '../classes/category.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        if (empty($_POST['cat_name'])) {
            throw new Exception('Category name cannot be empty.');
        }

        Category::CreateCategorie($_POST['cat_name']);
        $_SESSION['message'] = [
            'type' => 'success',
            'text' => 'Category created successfully!'
        ];
    } catch (Exception $e) {
        $_SESSION['message'] = [
            'type' => 'error',
            'text' => $e->getMessage()
        ];
    }

    header('Location: ../pages/adminDashboard.php');
    exit;
}
