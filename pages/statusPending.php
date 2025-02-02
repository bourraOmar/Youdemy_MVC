<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Account Pending | Education</title>
    <style>
        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .animate-pulse-slow {
            animation: pulse 3s infinite;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-gray-50 to-purple-50 min-h-screen">
    <!-- Navigation -->
    <header class="bg-white shadow-lg sticky top-0 z-40">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="logo">
                    <a href="../Youdemy/index.php">
                        <img src="assets/img/logo/logo.png" alt="Logo" class="h-8">
                    </a>
                </div>
                <nav class="hidden md:flex space-x-8 items-center">
                    <a href="../Handling/AuthHandl.php">
                        <button class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-all duration-300 transform hover:scale-105">
                            Déconnexion
                        </button>
                    </a>
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
    <!-- Status Pending Content -->
    <div class="max-w-2xl mx-auto mt-20 px-4">
        <div class="bg-white rounded-xl shadow-2xl p-8 text-center transform transition-all duration-500 hover:shadow-3xl hover:-translate-y-2">
            <!-- Pending Animation Circle -->
            <div class="mb-8">
                <div class="mx-auto w-24 h-24 rounded-full border-4 border-purple-200 border-t-purple-600 animate-spin"></div>
            </div>

            <!-- Heading -->
            <h1 class="text-3xl font-bold text-gray-800 mb-6 animate-pulse-slow">Account Pending Approval</h1>

            <!-- Main Content -->
            <div class="space-y-6 text-gray-600">
                <p class="text-lg leading-relaxed">Our team will verify your information and activate your account soon.</p>
            </div>

            <!-- Logout Button -->
            <div class="mt-8">
                <a href="../Handling/AuthHandl.php">
                    <button type="submit" name="logout"
                        class="bg-gray-100 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-200 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                        Logout
                    </button>
                </a>
            </div>
        </div>
    </div> <!-- Simple Footer -->
    <footer class="mt-20 pb-8">
        <div class="text-center text-gray-500 text-sm">
            <p>&copy; 2025 YouDemy. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>