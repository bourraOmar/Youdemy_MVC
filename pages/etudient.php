<?php
require_once '../classes/cours.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (isset($_SESSION['user_status']) && isset($_SESSION['user_role'])) {
    // Check if user is suspended
    if ($_SESSION['user_status'] === 'suspended') {
        header("Location: ../Youdemy/pages/statusBanned.php");
        exit();
    }

    if ($_SESSION['user_role'] == 1) {
        header('Location: ../pages/adminDashboard.php');
        exit();
    } else if ($_SESSION['user_role'] == 2) {
        header('Location: ../Youdemy/profdashboard/dashboardTeacher.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil | Student</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-r from-orange-50 to-teal-50">

    <!-- Navbar -->
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

    <!-- Profile Section -->
    <div class="container mx-auto px-6 py-8">
        <div class="bg-white shadow-lg rounded-lg p-6 animate__animated animate__fadeIn">
            <div class="flex items-center space-x-6">
                <img class="h-24 w-24 bg-white rounded-full shadow-soft" src="../imgs/profile-major.svg" alt="Profile">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800"><?php echo $_SESSION['user_nom'] . " " . $_SESSION['user_prenom'] ?></h1>
                    <p class="text-gray-600"><?php echo $_SESSION['user_email'] ?></p>
                </div>
            </div>
        </div>

        <!-- Tables Section -->
        <div class="mt-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Mes Informations</h2>
            <div class="bg-white shadow-lg rounded-lg overflow-hidden animate__animated animate__fadeInUp">
                <table class="min-w-full">
                    <thead class="bg-gradient-to-r from-teal-500 to-orange-500">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Attribut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Valeur</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Nom</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo $_SESSION['user_nom'] . " " . $_SESSION['user_prenom'] ?></td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Email</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo $_SESSION['user_email'] ?></td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Téléphone</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">+1 234 567 890</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Adresse</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">123 Rue de l'Exemple, Ville, Pays</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Enrolled Courses Section -->
        <div class="mt-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Mes Cours Inscrits</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <?php
                $courses = Cours::getEnrolledCourses($_SESSION['user_id']);
                foreach ($courses as $cour) {
                ?>
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-300 animate__animated animate__fadeInUp">
                        <div class="relative">
                            <img src="<?php echo $cour->getcourseImage() ?>" alt="Course thumbnail" class="w-full h-48 object-cover" />
                            <?php if ($cour->cours_type == 'video'): ?>
                                <span class="absolute top-4 left-4 px-2 py-1 rounded text-xs font-medium text-white bg-teal-600 rounded-full">
                                    <?php echo $cour->cours_type ?>
                                </span>
                            <?php elseif ($cour->cours_type == 'document'): ?>
                                <span class="absolute top-4 left-4 px-2 py-1 rounded text-xs font-medium text-white bg-orange-600 rounded-full">
                                    <?php echo $cour->cours_type ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="p-6">
                            <h3 class="font-semibold mb-2 hover:text-teal-600 transition-colors">
                                <?php echo strlen($cour->gettitle()) > 40 ? substr($cour->gettitle(), 0, 40) . '...' : $cour->gettitle(); ?>
                            </h3>
                            <p class="text-gray-600 text-sm mb-4">
                                <?php echo strlen($cour->getdescription()) > 100 ? substr($cour->getdescription(), 0, 50) . '...' : $cour->getdescription(); ?>
                            </p>

                            <div class="flex items-center mb-4">
                                <span class="text-sm text-gray-600">Par <?php echo $cour->personName ?></span>
                                <span class="mx-2">•</span>
                                <span class="text-sm text-gray-600">Inscrit le <?php echo (new DateTime($cour->creationdate))->format('d/m/Y') ?></span>
                            </div>

                            <a href="../pages/CoursDetail.php?course_id=<?php echo $cour->getId() ?>">
                                <button class="w-full bg-teal-600 text-white px-6 py-2 rounded-full hover:bg-teal-700 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-opacity-50">
                                    Voir le Cours
                                </button>
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-16">
        <div class="container mx-auto px-6">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm">&copy; 2023 Mon Profil. Tous droits réservés.</p>
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