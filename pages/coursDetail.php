<?php
require_once '../classes/cours.php';
require_once '../classes/Tag.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$course_id = $_GET['course_id'] ?? null;
$course = Cours::getCourseById($course_id);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
  <title>Course View | Education</title>
</head>

<body class="bg-gradient-to-r from-orange-50 to-teal-50">

  <!-- Navigation -->
  <nav class="bg-gradient-to-r from-teal-500 to-orange-500 shadow-lg">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
      <div class="text-xl font-semibold text-white">Mon Profil</div>
      <div class='flex items-center gap-4'>
        <a href="../index.php" class="text-gray-700 hover:text-teal-500 transition duration-300">Home</a>
        <a href="../pages/cours.php" class="text-gray-700 hover:text-teal-500 transition duration-300">Courses</a>
        <a href="../pages/about.php" class="text-gray-700 hover:text-teal-500 transition duration-300">About</a>
        <a href="../pages/contact.php" class="text-gray-700 hover:text-teal-500 transition duration-300">Contact</a>
        <a href="../Handling/authentification.php">
          <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition duration-300">Déconnexion</button>
        </a>
      </div>
    </div>
  </nav>

  <!-- Course Header Bar -->
  <div class="bg-gradient-to-r from-teal-500 to-orange-500 pt-16">
    <div class="max-w-7xl mx-auto px-4 py-8">
      <h1 class="text-2xl font-bold text-white mb-4 animate__animated animate__fadeIn"><?php echo $course->gettitle(); ?></h1>
      <div class="flex items-center space-x-4 text-gray-200 text-sm">
        <div class="flex items-center space-x-2">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
          </svg>
          <span><?php echo $course->personName; ?></span>
        </div>
        <span>•</span>
        <span>Last updated <?php echo (new DateTime($course->creationdate))->format('M Y'); ?></span>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
      <!-- Left Column - Course Content -->
      <div class="lg:w-2/3">
        <?php if ($course->cours_type == 'video'): ?>
          <!-- Video Player -->
          <div class="bg-black rounded-lg overflow-hidden mb-8 sticky top-20 animate__animated animate__fadeInLeft">
            <div class="aspect-video">
              <video class="w-full h-full" controls>
                <source src="<?php echo $course->getvedioUrl(); ?>" type="video/mp4">
                Your browser does not support the video tag.
              </video>
            </div>
          </div>
        <?php else: ?>
          <!-- Document Content -->
          <div class="bg-white rounded-lg border border-gray-200 p-6 mb-8 animate__animated animate__fadeInLeft">
            <div class="prose max-w-none">
              <p class="text-gray-700 leading-relaxed"><?php echo $course->getdocumentText(); ?></p>
            </div>
          </div>
        <?php endif; ?>

        <!-- Course Description -->
        <div class="bg-white rounded-lg border border-gray-200 p-6 animate__animated animate__fadeInLeft">
          <h2 class="text-xl font-bold mb-4">About This Course</h2>
          <div class="prose max-w-none">
            <p class="text-gray-700 leading-relaxed"><?php echo htmlspecialchars($course->getdescription(), ENT_QUOTES, 'UTF-8'); ?></p>
          </div>
        </div>
      </div>

      <!-- Right Column - Course Details -->
      <div class="lg:w-1/3">
        <div class="bg-white rounded-lg border border-gray-200 p-6 sticky top-20 animate__animated animate__fadeInRight shadow-lg">
          <h3 class="text-xl font-bold mb-4 text-gray-800">Course Content</h3>

          <!-- Course Features -->
          <div class="space-y-4 mb-6">
            <div class="flex items-center space-x-3 text-sm text-gray-600">
              <svg class="w-5 h-5 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
              </svg>
              <span><?php echo $course->getdescription() ?></span>
            </div>
          </div>

          <!-- Tags Section -->
          <div class="mb-6">
            <h4 class="text-sm font-semibold mb-2 text-gray-700">Topics</h4>
            <div class="flex flex-wrap gap-2">
              <?php
              $tags = Tag::gettagsforCours($course->getId());
              foreach ($tags as $tag) {
              ?>
                <span class="bg-gradient-to-r from-teal-50 to-orange-50 text-gray-700 px-3 py-1 rounded-full text-xs font-medium hover:bg-gradient-to-r hover:from-teal-100 hover:to-orange-100 transition duration-300">
                  <?php echo htmlspecialchars($tag->getname(), ENT_QUOTES, 'UTF-8'); ?>
                </span>
              <?php } ?>
            </div>
          </div>

          <!-- Already Enrolled Notice -->
          <div class="bg-gradient-to-r from-teal-50 to-orange-50 border border-teal-100 rounded-lg p-4 text-center animate__animated animate__fadeIn">
            <span class="text-teal-700 font-medium">✓ You're enrolled in this course</span>
          </div>
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

</body>

</html>