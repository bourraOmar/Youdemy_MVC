<?php

require_once '../classes/cours.php';
require_once '../classes/tag.php';
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
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Courses | Education</title>
</head>

<body class="bg-gradient-to-r from-orange-50 to-teal-50">

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
                        <a href="../pages/login.php" class="bg-teal-500 border border-teal-500 text-white px-4 py-2 rounded hover:bg-teal-500 hover:text-white transition duration-300">Log in</a>
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
                <h1 class="text-5xl font-bold mb-4 animate__animated animate__fadeInDown">Our Courses</h1>
                <nav aria-label="breadcrumb" class="animate__animated animate__fadeInUp">
                    <ol class="flex justify-center space-x-2">
                        <li><a href="index.html" class="text-white hover:text-gray-200">Home</a></li>
                        <li class="text-gray-200">/</li>
                        <li><a href="#" class="text-white hover:text-gray-200">Courses</a></li>
                    </ol>
                </nav>
            </div>
        </section>

        <!-- Courses Section -->
        <div class="container mx-auto px-6 py-16">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold mb-4 animate__animated animate__fadeInDown">Our Featured Courses</h2>
                <p class="text-gray-600 animate__animated animate__fadeInUp">Explore our top courses designed to help you achieve your goals.</p>
            </div>
            <div id="results" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Course Card 1 -->
                <?php
                $cours = VideoCours::showAllCours();
                foreach ($cours as $cour) {
                ?>
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-xl transition duration-300 animate__animated animate__fadeInUp">
                        <!-- Course Thumbnail -->
                        <div class="relative">
                            <img src="<?php echo $cour->getcourseImage() ?>" alt="Course thumbnail" class="w-full h-48 object-cover" />
                            <!-- Course Type Badge -->
                            <?php if ($cour->cours_type == 'video') { ?>
                                <span class="absolute top-4 left-4 bg-teal-500 text-white px-2 py-1 rounded-full text-xs font-medium">
                                    Video
                                </span>
                            <?php } else if ($cour->cours_type == 'document') { ?>
                                <span class="absolute top-4 left-4 bg-orange-500 text-white px-2 py-1 rounded-full text-xs font-medium">
                                    Document
                                </span>
                            <?php } ?>
                        </div>

                        <div class="p-6">
                            <!-- Course Title -->
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-semibold text-teal-800 hover:text-teal-600 transition-colors">
                                    <?php echo strlen($cour->gettitle()) > 40 ? substr($cour->gettitle(), 0, 40) . '...' : $cour->gettitle(); ?>
                                </h3>
                            </div>

                            <!-- Course Description -->
                            <p class="text-gray-600 text-sm mb-4">
                                <?php echo strlen($cour->getdescription()) > 100 ? substr($cour->getdescription(), 0, 50) . '...' : $cour->getdescription(); ?>
                            </p>

                            <!-- Instructor & Date -->
                            <div class="flex items-center mb-3">
                                <span class="text-sm text-gray-600">By <?php echo $cour->personName ?></span>
                                <span class="mx-2">•</span>
                                <span class="text-sm text-gray-600">Updated <?php echo (new DateTime($cour->creationdate))->format('F j, Y') ?></span>
                            </div>

                            <!-- Course Stats -->
                            <?php
                            $counts = Cours::CountenrollCourses($cour->getId());
                            ?>
                            <div class="flex items-center space-x-4 mb-4">
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                    <?php echo $counts['enroll_Count'] ?>
                                </div>
                                <span class="mx-2">•</span>
                                <div>
                                    <?php
                                    $tags = Tag::gettagsforCours($cour->getId());
                                    foreach ($tags as $tag) {
                                    ?>
                                        <span class="bg-gray-100 px-3 py-1 rounded-full text-sm text-gray-600 hover:bg-gray-200 transition-colors">
                                            <?php echo strlen($tag->getname()) > 10 ? substr($tag->getname(), 0, 10) . '...' : $tag->getname(); ?>
                                        </span>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>

                            <!-- Price and Enroll Button -->
                            <div class="flex items-center justify-between mt-4">
                                <span class="text-lg font-bold text-teal-500"><?php echo $cour->getprice() ?>$</span>
                                <?php if (!isset($_SESSION['user_role'])) : ?>
                                    <a href="../pages/login.php">
                                        <button class="bg-teal-500 text-white px-6 py-2 rounded-full hover:bg-teal-600 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-opacity-50">
                                            Join Now
                                        </button>
                                    </a>
                                <?php else : ?>
                                    <a href="../Handling/enrollCours.php?course_id=<?php echo $cour->getId() ?>">
                                        <button class="bg-teal-500 text-white px-6 py-2 rounded-full hover:bg-teal-600 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-opacity-50">
                                            Enroll Now
                                        </button>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="text-center mt-16">
                <a href="#" class="border border-teal-500 text-teal-500 px-6 py-2 rounded hover:bg-teal-500 hover:text-white transition duration-300">Load More</a>
            </div>
        </div>

        <!-- Top Subjects Section -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mx-8">
            <!-- Topic Cards -->
            <div class="single-topic text-center mb-8">
                <div class="topic-img relative overflow-hidden rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <img src="../assets/img/gallery/topic1.png" alt="Topic 1" class="w-full h-48 object-cover">
                    <div class="topic-content-box absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 opacity-0 hover:opacity-100 transition-opacity duration-300">
                        <div class="topic-content">
                            <h3 class="text-white text-xl font-bold"><a href="#" class="hover:text-teal-300 transition-colors duration-300">Programming</a></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="single-topic text-center mb-8">
                <div class="topic-img relative overflow-hidden rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <img src="../assets/img/gallery/topic2.png" alt="Topic 2" class="w-full h-48 object-cover">
                    <div class="topic-content-box absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 opacity-0 hover:opacity-100 transition-opacity duration-300">
                        <div class="topic-content">
                            <h3 class="text-white text-xl font-bold"><a href="#" class="hover:text-teal-300 transition-colors duration-300">Programming</a></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="single-topic text-center mb-8">
                <div class="topic-img relative overflow-hidden rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <img src="../assets/img/gallery/topic3.png" alt="Topic 3" class="w-full h-48 object-cover">
                    <div class="topic-content-box absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 opacity-0 hover:opacity-100 transition-opacity duration-300">
                        <div class="topic-content">
                            <h3 class="text-white text-xl font-bold"><a href="#" class="hover:text-teal-300 transition-colors duration-300">Programming</a></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="single-topic text-center mb-8">
                <div class="topic-img relative overflow-hidden rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <img src="../assets/img/gallery/topic4.png" alt="Topic 4" class="w-full h-48 object-cover">
                    <div class="topic-content-box absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 opacity-0 hover:opacity-100 transition-opacity duration-300">
                        <div class="topic-content">
                            <h3 class="text-white text-xl font-bold"><a href="#" class="hover:text-teal-300 transition-colors duration-300">Programming</a></h3>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="text-center mt-16">
            <a href="#" class="border border-teal-500 text-teal-500 px-6 py-2 rounded hover:bg-teal-500 hover:text-white transition duration-300">View More Subjects</a>
        </div>


        <!-- Services Section -->
        <div class="container mx-auto px-6 py-16">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition duration-300 animate__animated animate__fadeInLeft">
                    <img src="../assets/img/icon/icon1.svg" alt="UX Courses" class="mx-auto mb-4 h-16 w-16">
                    <h3 class="text-xl font-bold mb-2">60+ UX Courses</h3>
                    <p class="text-gray-600">The automated process all your website tasks.</p>
                </div>
                <div class="text-center bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition duration-300 animate__animated animate__fadeInUp">
                    <img src="../assets/img/icon/icon2.svg" alt="Expert Instructors" class="mx-auto mb-4 h-16 w-16">
                    <h3 class="text-xl font-bold mb-2">Expert Instructors</h3>
                    <p class="text-gray-600">The automated process all your website tasks.</p>
                </div>
                <div class="text-center bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition duration-300 animate__animated animate__fadeInRight">
                    <img src="../assets/img/icon/icon3.svg" alt="Lifetime Access" class="mx-auto mb-4 h-16 w-16">
                    <h3 class="text-xl font-bold mb-2">Lifetime Access</h3>
                    <p class="text-gray-600">The automated process all your website tasks.</p>
                </div>
            </div>
        </div>
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