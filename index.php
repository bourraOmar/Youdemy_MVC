<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (isset($_SESSION['user_status']) && isset($_SESSION['user_role'])) {
    // Check if user is suspended
    if ($_SESSION['user_status'] === 'suspended') {
        header("Location: ../Youdemy/pages/status_banned.php");
        exit();
    }
    if ($_SESSION['user_role'] == 1) {
        header('Location: ../Youdemy/pages/adminDashboard.php');
        exit();
    } else if ($_SESSION['user_role'] == 2) {
        header('Location: ../Youdemy/pages/prof_dashboard.php');
        exit();
    }
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
    <title>Courses | Education</title>
</head>

<body class="bg-gradient-to-r from-orange-50 to-teal-50">
    <!-- Preloader -->
    <div id="preloader-active" class="fixed inset-0 w-full h-full bg-white flex items-center justify-center z-50">
        <div class="preloader-inner relative">
            <div class="preloader-circle animate-spin rounded-full border-4 border-t-4 border-gray-200 h-12 w-12"></div>
            <div class="preloader-img absolute inset-0 flex justify-center items-center">
                <img src="../Youdemy/assets/img/logo/loder.png" alt="Loading..." class="h-8">
            </div>
        </div>
    </div>

    <!-- Header -->
    <header class="bg-gradient-to-r from-teal-500 to-orange-500 text-white sticky top-0 z-40">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="logo">
                    <a href="../Youdemy/index.php"><img src="../Youdemy/assets/img/logo/logo.png" alt="Logo" class="h-8"></a>
                </div>
                <nav class="hidden md:flex space-x-8 items-center">
                    <a href="index.php" class="text-gray-700 hover:text-teal-500 transition duration-300">Home</a>
                    <a href="../Youdemy/pages/cours.php" class="text-gray-700 hover:text-teal-500 transition duration-300">Courses</a>
                    <a href="../Youdemy/pages/about.php" class="text-gray-700 hover:text-teal-500 transition duration-300">About</a>
                    <a href="../Youdemy/pages/contact.php" class="text-gray-700 hover:text-teal-500 transition duration-300">Contact</a>

                    <?php if (!isset($_SESSION['user_role'])): ?>
                        <a href="./pages/sign_up.php" class="bg-teal-500 text-white px-4 py-2 rounded hover:bg-teal-600 transition duration-300">Join</a>
                        <a href="./pages/login.php" class="bg-teal-500 border border-teal-500 text-white px-4 py-2 rounded hover:bg-teal-500 hover:text-white transition duration-300">Log in</a>
                    <?php elseif($_SESSION['']): ?>
                        <div>
                            <a href="../Youdemy/pages/etudient.php"><img width="25px" class="bg-white rounded-full shadow-soft" src="../youdemy/imgs/profile-major.svg" alt="Profile"></a>
                        </div>
                    <?php else: ?>
                        <div>
                            <a href="../Youdemy/pages/etudient.php"><img width="25px" class="bg-white rounded-full shadow-soft" src="../youdemy/imgs/profile-major.svg" alt="Profile"></a>
                        </div>
                    <?php endif; ?>
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
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#7C3AED'
                            });
                        </script>
                    ";
                    unset($_SESSION['message']);
                }
                ?>
                <div class="md:hidden">
                    <button class="mobile-menu-button">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        <!-- Hero Section -->
        <section class="bg-gradient-to-r from-teal-500 to-orange-500 text-white py-24">
            <div class="container mx-auto px-6 text-center">
                <h1 class="text-5xl font-bold mb-4 animate__animated animate__fadeInDown">Online Learning Platform</h1>
                <p class="text-xl mb-8 animate__animated animate__fadeInUp">Build skills with courses, certificates, and degrees online from world-class universities and companies.</p>
                <a href="#" class="bg-white text-teal-500 px-6 py-2 rounded hover:bg-gray-100 transition duration-300 animate__animated animate__fadeInUp">Join for Free</a>
            </div>
        </section>

        <!-- Services Section -->
        <div class="container mx-auto px-6 py-16">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition duration-300 animate__animated animate__fadeInLeft">
                    <img src="../Youdemy/assets/img/icon/icon1.svg" alt="UX Courses" class="mx-auto mb-4 h-16 w-16">
                    <h3 class="text-xl font-bold mb-2">60+ UX Courses</h3>
                    <p class="text-gray-600">The automated process all your website tasks.</p>
                </div>
                <div class="text-center bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition duration-300 animate__animated animate__fadeInUp">
                    <img src="../Youdemy/assets/img/icon/icon2.svg" alt="Expert Instructors" class="mx-auto mb-4 h-16 w-16">
                    <h3 class="text-xl font-bold mb-2">Expert Instructors</h3>
                    <p class="text-gray-600">The automated process all your website tasks.</p>
                </div>
                <div class="text-center bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition duration-300 animate__animated animate__fadeInRight">
                    <img src="../Youdemy/assets/img/icon/icon3.svg" alt="Lifetime Access" class="mx-auto mb-4 h-16 w-16">
                    <h3 class="text-xl font-bold mb-2">Lifetime Access</h3>
                    <p class="text-gray-600">The automated process all your website tasks.</p>
                </div>
            </div>
        </div>

        <!-- Featured Courses Section -->
        <div class="bg-gray-50 py-16">
            <div class="container mx-auto px-6">
                <h2 class="text-3xl font-bold text-center mb-8 animate__animated animate__fadeInDown">Our Featured Courses</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Course Card -->
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden hover:shadow-xl transition duration-300 animate__animated animate__fadeInUp">
                        <img src="../Youdemy/assets/img/gallery/featured1.png" alt="Course Image" class="w-full">
                        <div class="p-6">
                            <p class="text-gray-600">User Experience</p>
                            <h3 class="text-xl font-bold mb-2">Fundamental of UX for Application Design</h3>
                            <p class="text-gray-600 mb-4">The automated process all your website tasks. Discover tools and techniques to engage effectively with vulnerable children and young people.</p>
                            <div class="flex justify-between items-center mb-4">
                                <div class="flex items-center">
                                    <span class="text-yellow-400">★★★★☆</span>
                                    <span class="text-gray-600 ml-2">(4.5)</span>
                                </div>
                                <span class="text-teal-500 font-bold">$135</span>
                            </div>
                            <a href="#" class="border border-teal-500 text-teal-500 px-4 py-2 rounded hover:bg-teal-500 hover:text-white transition duration-300">Find out more</a>
                        </div>
                    </div>
                    <!-- Repeat for other courses -->
                </div>
            </div>
        </div>

        <!-- About Section -->
        <section class="container mx-auto px-6 py-16">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2">
                    <h2 class="text-3xl font-bold mb-4 animate__animated animate__fadeInLeft">Learn New Skills Online with Top Educators</h2>
                    <p class="text-gray-600 mb-8 animate__animated animate__fadeInLeft">The automated process all your website tasks. Discover tools and techniques to engage effectively with vulnerable children and young people.</p>
                    <ul class="space-y-4 animate__animated animate__fadeInLeft">
                        <li class="flex items-center">
                            <img src="../Youdemy/assets/img/icon/right-icon.svg" alt="Check" class="mr-2">
                            <p class="text-gray-600">Techniques to engage effectively with vulnerable children and young people.</p>
                        </li>
                        <li class="flex items-center">
                            <img src="../Youdemy/assets/img/icon/right-icon.svg" alt="Check" class="mr-2">
                            <p class="text-gray-600">Join millions of people from around the world learning together.</p>
                        </li>
                        <li class="flex items-center">
                            <img src="../Youdemy/assets/img/icon/right-icon.svg" alt="Check" class="mr-2">
                            <p class="text-gray-600">Online learning is as easy and natural.</p>
                        </li>
                    </ul>
                </div>
                <div class="md:w-1/2 mt-8 md:mt-0 animate__animated animate__fadeInRight">
                    <img src="../Youdemy/assets/img/gallery/about3.png" alt="About Image" >
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white py-12">
            <div class="container mx-auto px-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <img src="assets/img/logo/logo2_footer.png" alt="Footer Logo" class="mb-4">
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
                            <li><a href="#" class="text-gray-400 hover:text-white">Programing</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white">Architecture</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold mb-4">Support</h4>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-400 hover:text-white">Design & Creatives</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white">Telecommunication</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white">Restaurant</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white">Programing</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white">Architecture</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold mb-4">Company</h4>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-400 hover:text-white">Design & Creatives</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white">Telecommunication</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white">Restaurant</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white">Programing</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white">Architecture</a></li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                    <p class="text-gray-400">© 2023 All rights reserved | This template is made with <i class="fa fa-heart text-red-500"></i> by <a href="https://colorlib.com" class="text-teal-500 hover:text-teal-400">Colorlib</a></p>
                </div>
            </div>
        </footer>
    </main>

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
    </script>
</body>

</html>