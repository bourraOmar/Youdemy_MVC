<?php
require_once '../classes/Teacher.php';
require_once '../classes/cours.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 2) {
    header('Location: ../index.php');
    exit();
}

if ($_SESSION['user_status'] === 'waiting') {
    header("Location: ../pages/statusBending.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <title>Professor | Dashboard</title>
</head>
<body class="bg-gradient-to-r from-orange-50 to-teal-50">

    <!-- Preloader -->
    <div id="preloader" class="fixed inset-0 z-50 flex items-center justify-center bg-white">
        <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-teal-500"></div>
    </div>

    <!-- Navigation -->
    <nav class="bg-gradient-to-r from-teal-500 to-orange-500 shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <span class="text-2xl font-bold text-white">YouDemy</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-white">Welcome, <?php echo $_SESSION['user_nom'] . " " . $_SESSION['user_prenom'] ?></span>
                    <a href="../Handling/authentification.php">
                        <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition duration-300">Logout</button>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <?php
    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        $type = $message['type'];
        $text = $message['text'];

        echo "
            <script>
                Swal.fire({
                    icon: '$type',
                    title: '$type',
                    text: '$text',
                    confirmButtonText: 'OK'
                });
            </script>
        ";

        unset($_SESSION['message']);
    }
    ?>

    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg h-screen">
            <div class="p-4">
                <ul class="space-y-2">
                    <a href="../profdashboard/dashboardTeacher.php">
                        <li class="bg-teal-100 text-teal-700 p-2 rounded-lg hover:bg-teal-200 transition duration-300">Dashboard</li>
                    </a>
                    <a href="../profdashboard/createCours.php">
                        <li class="text-gray-600 hover:bg-teal-50 p-2 rounded-lg transition duration-300">Create Course</li>
                    </a>
                    <a href="../profdashboard/myCourse.php">
                        <li class="text-gray-600 hover:bg-teal-50 p-2 rounded-lg transition duration-300">My Courses</li>
                    </a>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <h1 class="text-3xl font-bold mb-8 text-gray-800 animate__animated animate__fadeIn">Dashboard Overview</h1>
            
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-lg shadow-lg animate__animated animate__fadeInLeft">
                    <h3 class="text-gray-500 text-sm mb-1">Total Students</h3>
                    <p class="text-3xl font-bold text-teal-600"><?php echo Teacher::GetTotalEnrolledStudents($_SESSION['user_id']) ?></p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-lg animate__animated animate__fadeInRight">
                    <h3 class="text-gray-500 text-sm mb-1">Active Courses</h3>
                    <p class="text-3xl font-bold text-orange-600"><?php echo Teacher::GetTotalCourses($_SESSION['user_id']) ?></p>
                </div>
            </div>

            <!-- Popular Courses -->
            <div class="bg-white p-6 rounded-lg shadow-lg animate__animated animate__fadeInUp">
                <h2 class="text-xl font-bold mb-4 text-gray-800">Your Popular Courses</h2>
                <div class="space-y-4">
                    <?php 
                    $cours = Teacher::GetMostEnrolledCourses($_SESSION['user_id']);
                    foreach($cours as $cour) {
                    ?>
                    <div class="flex items-center justify-between p-4 rounded-lg hover:shadow-md transition duration-300">
                        <div class="flex items-center">
                            <img src="<?php echo $cour->courseimage ?>" alt="Course" class="w-12 h-12 rounded-lg object-cover mr-4"/>
                            <div>
                                <p class="font-semibold text-gray-800"><?php echo $cour->title ?></p>
                                <p class="text-gray-500"><?php echo $cour->enrollments_count ?> students</p>
                            </div>
                        </div>
                        <a href="../pages/coursDetail.php" class="text-teal-500 hover:text-teal-700 transition duration-300">View Details</a>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-16">
        <div class="container mx-auto px-6">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm">&copy; 2023 YouDemy. Tous droits réservés.</p>
                </div>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white transition duration-300">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition duration-300">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition duration-300">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition duration-300">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Preloader Script -->
    <script>
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            preloader.style.display = 'none';
        });
    </script>

</body>
</html>