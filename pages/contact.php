<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_role']) || $_SESSION['user_status'] === 'suspended') {
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | Education</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.ico">
</head>
<body class="bg-gradient-to-r from-orange-50 to-teal-50">
    <!-- Preloader -->
    <div id="preloader-active" class="fixed inset-0 w-full h-full bg-white flex items-center justify-center z-50">
        <div class="preloader-inner relative">
            <div class="preloader-circle animate-spin rounded-full border-4 border-t-4 border-gray-200 h-12 w-12"></div>
            <div class="preloader-img absolute inset-0 flex justify-center items-center">
                <img src="assets/img/logo/loder.png" alt="Loading..." class="h-8">
            </div>
        </div>
    </div>

    <!-- Header -->
    <header class="bg-gradient-to-r from-teal-500 to-orange-500 text-white sticky top-0 z-40">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="logo">
                    <a href="../Youdemy/index.php"><img src="../assets/img/logo/logo.png" alt="Logo" class="h-8"></a>
                </div>
                <nav class="hidden md:flex space-x-8 items-center">
                    <a href="../index.php" class="text-gray-700 hover:text-teal-500 transition duration-300">Home</a>
                    <a href="../pages/cours.php" class="text-gray-700 hover:text-teal-500 transition duration-300">Courses</a>
                    <a href="../pages/about.php" class="text-gray-700 hover:text-teal-500 transition duration-300">About</a>
                    <a href="../pages/contact.php" class="text-gray-700 hover:text-teal-500 transition duration-300">Contact</a>

                    <?php if (!isset($_SESSION['user_role'])): ?>
                        <a href="../pages/sign_up.php" class="bg-teal-500 text-white px-4 py-2 rounded hover:bg-teal-600 transition duration-300">Join</a>
                        <a href="../pages/login.php" class="bg-teal-500 border border-teal-500 text-white px-4 py-2 rounded hover:bg-teal-600 hover:text-white transition duration-300">Log in</a>
                    <?php else: ?>
                        <div>
                            <a href="../pages/etudient.php"><img width="25px" class="bg-white rounded-full shadow-soft" src="../imgs/profile-major.svg" alt="Profile"></a>
                        </div>
                    <?php endif; ?>

                </nav>
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
                <h1 class="text-5xl font-bold mb-4 animate__animated animate__fadeInDown">Contact Us</h1>
                <nav aria-label="breadcrumb" class="animate__animated animate__fadeInUp">
                    <ol class="flex justify-center space-x-2">
                        <li><a href="index.html" class="text-white hover:text-gray-200">Home</a></li>
                        <li class="text-gray-200">/</li>
                        <li><a href="#" class="text-white hover:text-gray-200">Contact</a></li>
                    </ol>
                </nav>
            </div>
        </section>

        <!-- Contact Section -->
        <section class="container mx-auto px-6 py-16">
            <div class="mb-16 text-center">
                <h2 class="text-3xl font-bold mb-4 animate__animated animate__fadeInDown">Get in Touch</h2>
                <p class="text-gray-600 animate__animated animate__fadeInUp">We'd love to hear from you! Reach out to us for any inquiries or feedback.</p>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Contact Form -->
                <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition duration-300 animate__animated animate__fadeInLeft">
                    <form class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <input type="text" placeholder="Enter your name" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                            </div>
                            <div>
                                <input type="email" placeholder="Email" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                            </div>
                        </div>
                        <div>
                            <input type="text" placeholder="Enter Subject" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        </div>
                        <div>
                            <textarea placeholder="Enter Message" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent" rows="6"></textarea>
                        </div>
                        <div>
                            <button type="submit" class="bg-teal-500 text-white px-6 py-2 rounded hover:bg-teal-600 transition duration-300">Send</button>
                        </div>
                    </form>
                </div>

                <!-- Contact Info -->
                <div class="space-y-6 animate__animated animate__fadeInRight">
                    <div class="flex items-start space-x-4 bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300">
                        <span class="text-teal-500 text-2xl"><i class="fas fa-map-marker-alt"></i></span>
                        <div>
                            <h3 class="text-xl font-bold">Buttonwood, California.</h3>
                            <p class="text-gray-600">Rosemead, CA 91770</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4 bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300">
                        <span class="text-teal-500 text-2xl"><i class="fas fa-phone-alt"></i></span>
                        <div>
                            <h3 class="text-xl font-bold">+1 253 565 2365</h3>
                            <p class="text-gray-600">Mon to Fri 9am to 6pm</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4 bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300">
                        <span class="text-teal-500 text-2xl"><i class="fas fa-envelope"></i></span>
                        <div>
                            <h3 class="text-xl font-bold">support@colorlib.com</h3>
                            <p class="text-gray-600">Send us your query anytime!</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

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
                    <h4 class="text-lg font-bold mb-4">Our solutions</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Design & creatives</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Telecommunication</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Restaurant</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Programing</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Architecture</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-4">Support</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Design & creatives</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Telecommunication</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Restaurant</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Programing</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Architecture</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-4">Company</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Design & creatives</a></li>
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