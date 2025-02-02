<?php
require_once '../classes/cours.php';
require_once '../classes/category.php';
session_start();

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 2) {
  header('Location: ../index.php');
  exit();
}

if (!isset($_GET['id'])) {
  header('Location: ../index.php');
  exit();
}
if (isset($_GET['id'])) {
  $courseid = $_GET['id'];
  $course = Cours::getCourseById($courseid);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Course Management</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

  <!-- Edit Course Modal -->
  <div id="editCourseModal" class="fixed inset-0 overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-bold text-gray-900">Edit Course</h3>
        <button onclick="closeModal()" class="text-gray-400 hover:text-gray-500">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <form class="space-y-4" method="post" action="../Handling/updateCours.php" enctype="multipart/form-data">
        <div>
          <label class="block text-gray-700 text-sm font-bold mb-2">Course Title</label>
          <input type="text" name="title" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-purple-600" value="<?php echo $course->gettitle() ?>">
        </div>

        <div>
          <label class="block text-gray-700 text-sm font-bold mb-2">Course Description</label>
          <textarea name="description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-purple-600"><?php echo $course->getdescription() ?></textarea>
        </div>

        <input type="hidden" value="<?php echo $course->getId() ?>" name="course_id">
        <input type="hidden" name="cours_type" value="<?php echo $course->cours_type; ?>">

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">Price</label>
            <input type="number" name="price" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-purple-600" value="<?php echo $course->getprice() ?>">
          </div>
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">Category</label>
            <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-purple-600">
              <?php
              $Category = Category::showCategories();
              foreach ($Category as $cat) { ?>
                <option value='<?php echo $cat['category_id'] ?>'><?php echo $cat['name'] ?></option>
              <?php } ?>
            </select>
          </div>
        </div>

        <?php if ($course->cours_type == 'video'):  ?>
          <div class="flex justify-around">
            <div>
              <label class="block text-gray-700 text-sm font-bold mb-2">Course Video</label>
              <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                <div class="space-y-1 text-center">
                  <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  <div class="flex text-gray-600">
                    <label class="relative cursor-pointer bg-white rounded-md font-medium text-purple-600 hover:text-purple-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-purple-500">
                      <span class="text-center">Upload a file</span>
                      <input type="file" class="sr-only" name="coursecontent">
                    </label>
                  </div>
                  <p class="text-xs text-gray-500">.mp4</p>
                </div>
              </div>
            </div>
            <div>
              <label class="block text-gray-700 text-sm font-bold mb-2">Current course Video</label>
              <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md w-[310px]">
                <video class="w-full h-full rounded-lg" controls>
                  <source src="<?php echo $course->getvedioUrl(); ?>" type="video/mp4">
                  Your browser does not support the video tag.
                </video>
              </div>
            </div>
          </div>
        <?php else: ?>
          <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <label class="block text-gray-700 text-sm font-bold mb-2">Course Content</label>
            <textarea name="content" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-purple-600" name="coursecontent"><?php echo $course->getdocumentText() ?></textarea>
          </div>
        <?php endif; ?>

        <div class="flex justify-end space-x-3 mt-6">
          <a href="../profdashboard/myCourse.php"><button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300">
              Cancel
            </button></a>
          <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500">
            Save Changes
          </button>
        </div>
      </form>
    </div>
  </div>
</body>

</html>