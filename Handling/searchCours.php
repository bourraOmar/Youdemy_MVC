<?php
require_once '../classes/cours.php';
require_once '../classes/tag.php';

if (isset($_GET['searchfield'])) {
    $searchTerm = $_GET['searchfield'];

    $courses = Cours::CoursSearch($searchTerm);

    foreach ($courses as $cour) {
?>
<div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-300">
  <!-- Course Thumbnail -->
  <div class="relative">
    <img src="<?php echo $cour->getcourseImage() ?>" alt="Course thumbnail" class="w-full h-48 object-cover" />
    <!-- course type -->
    <?php if ($cour->cours_type == 'video') { ?>
    <span
      class="absolute top-4 left-4 bg-white/90 px-2 py-1 rounded text-xs font-medium text-white bg-purple-600 rounded-full">
      Video
    </span>
    <?php } else if ($cour->cours_type == 'document') { ?>
    <span
      class="absolute top-4 left-4 bg-white/90 px-2 py-1 rounded text-xs font-medium text-white bg-green-600 rounded-full">
      document
    </span>
    <?php } ?>
  </div>

  <div class="p-6">
    <!-- Course Title -->
    <div class="flex justify-between items-start mb-2">
      <h3 class="font-semibold hover:text-purple-600 transition-colors">
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
      <span class="text-sm text-gray-600">Updated
        <?php echo (new DateTime($cour->creationdate))->format('F j, Y') ?></span>
    </div>

    <!-- Course Stats -->
    <?php
                $counts = Cours::CountenrollCourses($cour->getId());
                ?>
    <div class="flex items-center space-x-4 mb-4">
      <div class="flex items-center text-sm text-gray-600">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
          </path>
        </svg>
        <?php echo $counts['enroll_Count'] ?>
      </div>
      <span class="mx-2">•</span>
      <div>
        <?php
                        $tags = Tag::gettagsforCours($cour->getId());
                        foreach ($tags as $tag) {
                        ?>
        <span
          class="bg-gray-100 px-3 py-1 rounded-full text-sm"><?php echo strlen($tag->getname()) > 10 ? substr($tag->getname(), 0, 10) . '...' : $tag->getname(); ?></span>
        <?php
                        }
                        ?>
      </div>
    </div>
    <!-- Price and Enroll Button -->
    <div class="flex items-center justify-between mt-4">
      <span class="text-lg font-bold text-purple-600"><?php echo $cour->getprice() ?>$</span>
      <a href="../Handling/enrollCours.php?course_id=<?php echo $cour->getId() ?>"><button
          class="bg-purple-600 text-white px-6 py-2 rounded-full hover:bg-purple-700 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50">
          Enroll Now
        </button></a>
    </div>
  </div>
</div>
<?php
    }
}
?>