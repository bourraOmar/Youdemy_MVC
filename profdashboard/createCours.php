<?php
require_once '../classes/category.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 2) {
    header('Location: ../index.php');
    exit();
}

if ($_SESSION['user_status'] === 'waiting') {
    header("Location: ../pages/status_pending.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" integrity="sha512-xmGTNt20S0t62wHLmQec2DauG9T+owP9e6VU8GigI0anN7OXLip9i7IwEhelasml2osdxX71XcYm6BQunTQeQg==" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js" integrity="sha512-9UR1ynHntZdqHnwXKTaOm1s6V9fExqejKvg5XMawEMToW4sSw+3jtLrYfZPijvnwnnE8Uol1O9BcAskoxgec+g==" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.ico">

    <title>Create Course | Education</title>
    <style>
        .bootstrap-tagsinput .tag {
            background: #0D9488;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 14px;
        }

        .bootstrap-tagsinput {
            width: 100%;
            padding: 8px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .preloader-circle {
            border-top-color: #F97316;
        }
    </style>
</head>

<body class="bg-gradient-to-r from-orange-50 to-teal-50 font-sans">

    <!-- Preloader -->
    <div id="preloader-active" class="fixed inset-0 w-full h-full bg-white flex items-center justify-center z-50">
        <div class="preloader-inner relative">
            <div class="preloader-circle animate-spin rounded-full border-4 border-t-4 border-gray-200 h-12 w-12"></div>
            <div class="preloader-img absolute inset-0 flex justify-center items-center">
                <img src="../assets/img/logo/loder.png" alt="Loading..." class="h-8">
            </div>
        </div>
    </div>

    <!-- Header -->
    <nav class="bg-gradient-to-r from-teal-500 to-orange-500 sticky shadow-lg">
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
        <div class="w-64 bg-white shadow-lg sticky min-h-full">
            <div class="p-4">
                <ul class="space-y-2">
                    <a href="../profdashboard/dashboardTeacher.php">
                        <li class="text-gray-600 p-2 rounded-lg hover:bg-teal-200 transition duration-300">Dashboard</li>
                    </a>
                    <a href="../profdashboard/createCours.php">
                        <li class="bg-teal-100 text-teal-700 hover:bg-teal-50 p-2 rounded-lg transition duration-300">Create Course</li>
                    </a>
                    <a href="../profdashboard/myCourse.php">
                        <li class="text-gray-600 hover:bg-teal-50 p-2 rounded-lg transition duration-300">My Courses</li>
                    </a>
                </ul>
            </div>
        </div>
        <!-- Main Content -->
        <div class="flex-1 p-8">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-3xl font-bold mb-8 text-teal-800">Create New Course</h1>

                <form class="space-y-8" method="post" action="../Handling/courseHandl.php" enctype="multipart/form-data">
                    <!-- Basic Information -->
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <h2 class="text-xl font-semibold mb-6 text-teal-800">Basic Information</h2>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Course Title</label>
                                <input type="text" name="course_title" class="w-full p-2 border rounded-md focus:ring-2 focus:ring-orange-500" placeholder="Enter course title" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Course Image</label>
                                <input type="file" name="course_image" class="w-full p-2 border rounded-md" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Course Description</label>
                                <textarea name="course_description" class="w-full p-2 border rounded-md h-32 focus:ring-2 focus:ring-orange-500" placeholder="Enter course description"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
                                <input name="tags" id="tagsInput" type="text" class="w-full p-2 border rounded-md focus:ring-2 focus:ring-orange-500" placeholder="Enter course tags" />
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                                    <select class="w-full p-2 border rounded-md focus:ring-2 focus:ring-orange-500" name="categories_select">
                                        <?php
                                        $rows = Category::showCategories();
                                        foreach ($rows as $row) { ?>
                                            <option value="<?php echo $row['category_id'] ?>"><?php echo $row['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Course Type:</label>
                                    <select name="course_type" id="course_type" class="w-full p-2 border rounded-md focus:ring-2 focus:ring-orange-500" required onchange="toggleFields()">
                                        <option value="video">Video</option>
                                        <option value="document">Document</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Course Content -->
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <h2 class="text-xl font-semibold mb-6 text-teal-800">Course Content</h2>
                        <div id="video_fields" style="display:none;">
                            <label for="video_file" class="block text-sm font-medium text-gray-700 mb-2">Upload Video (MP4 only):</label>
                            <input type="file" name="video_file" class="w-full p-2 border rounded-md focus:ring-2 focus:ring-orange-500" accept="video/mp4"><br>
                        </div>
                        <div id="document_fields" style="display:none;">
                            <label for="document_content" class="block text-sm font-medium text-gray-700 mb-2">Document Content (Text):</label>
                            <textarea placeholder="Enter Your Course Content.." name="document_content" rows="10" cols="50" class="w-full p-2 border rounded-md focus:ring-2 focus:ring-orange-500"></textarea><br>
                        </div>
                    </div>

                    <!-- Pricing -->
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <h2 class="text-xl font-semibold mb-6 text-teal-800">Pricing</h2>
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Price ($)</label>
                                    <input type="number" name="course_price" class="w-full p-2 border rounded-md focus:ring-2 focus:ring-orange-500" placeholder="Enter price" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end space-x-4">
                        <button type="submit" name="CreateCourseSub" class="bg-teal-500 text-white px-6 py-2 rounded-md hover:bg-teal-600 transition duration-300">
                            Publish Course
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <img src="../assets/img/logo/logo2_footer.png" alt="Footer Logo" class="mb-4">
                    <p class="text-gray-400">The automated process starts as soon as your clothes go into the machine.</p>
                    <div class="flex space-x-4 mt-4">
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-pinterest-p"></i></a>
                    </div>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-4">Our Solutions</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Design & Creatives</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Telecommunication</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Restaurant</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Programming</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Architecture</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-4">Support</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Design & Creatives</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Telecommunication</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Restaurant</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Programming</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Architecture</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-4">Company</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Design & Creatives</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Telecommunication</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Restaurant</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Programming</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Architecture</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p class="text-gray-400">© 2023 All rights reserved | This template is made with <i class="fa fa-heart text-red-500"></i> by <a href="https://colorlib.com" class="text-blue-500 hover:text-blue-400">Colorlib</a></p>
            </div>
        </div>
    </footer>

    <!-- Scroll Up Button -->
    <div id="back-top" class="fixed bottom-4 right-4">
        <a href="#" class="bg-teal-500 text-white p-3 rounded-full shadow-lg hover:bg-teal-600 transition duration-300">
            <i class="fas fa-level-up-alt"></i>
        </a>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <script>
        // Preloader
        window.addEventListener('load', function() {
            document.getElementById('preloader-active').style.display = 'none';
        });

        // Mobile Menu
        document.querySelector('.mobile-menu-button').addEventListener('click', function() {
            document.querySelector('nav').classList.toggle('hidden');
        });

        function toggleFields() {
            const courseType = document.getElementById('course_type').value;

            if (courseType === 'video') {
                document.getElementById('video_fields').style.display = 'block';
                document.getElementById('document_fields').style.display = 'none';
            } else if (courseType === 'document') {
                document.getElementById('video_fields').style.display = 'none';
                document.getElementById('document_fields').style.display = 'block';
            }
        }

        window.onload = toggleFields;

        $(document).ready(function() {
            $('#tagsInput').tagsinput();
        });
    </script>
</body>

</html>