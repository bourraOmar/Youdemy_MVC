
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Account Banned | Education</title>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-lg sticky top-0 z-40">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="logo">
                    <a href="../Youdemy/index.php"><img src="assets/img/logo/logo.png" alt="Logo" class="h-8"></a>
                </div>
                <nav class="hidden md:flex space-x-8 items-center">
                    <span class="text-gray-600">Admin Panel</span>
                    <a href="../Handling/AuthHandl.php">
                        <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Déconnexion</button></a>

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

    <!-- Ban Content -->
    <div class="max-w-2xl mx-auto mt-20 px-4">
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <div class="mb-6">
                <!-- Ban Icon -->
                <div class="mx-auto w-24 h-24 rounded-full bg-red-50 flex items-center justify-center">
                    <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                    </svg>
                </div>
            </div>
            
            <h1 class="text-2xl font-bold text-gray-800 mb-4">Account Banned</h1>
            
            <div class="space-y-4 text-gray-600">
                <p>Your account has been suspended due to violation of our community guidelines.</p>
                
                <div class="bg-red-50 rounded-lg p-6 mt-6">
                    <h2 class="font-semibold text-red-800 mb-2">What this means:</h2>
                    <ul class="text-left text-red-700 space-y-2">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 ²1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                            You cannot access your account or its content
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                            You cannot create new accounts
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                            Your existing content has been removed
                        </li>
                    </ul>
                </div>

                <div class="mt-8 p-4 bg-gray-50 rounded-lg">
                    <p class="text-gray-700">Ban Type: <span class="font-semibold">Permanent</span></p>
                </div>

                <div class="mt-8">
                    <p class="text-sm text-gray-500">If you believe this is a mistake, you can appeal this decision by contacting our support team at</p>
                    <a href="mailto:support@youdemy.com" class="text-purple-600 hover:text-purple-700 font-medium">support@youdemy.com</a>
                </div>
            </div>

            <div class="mt-8">
                <a href="../Handling/authentification.php">
                    <button type="button" class="bg-gray-100 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-200 transition-colors duration-200">
                        Return to Homepage
                    </button>
                </a>
            </div>
        </div>
    </div>

    <!-- Simple Footer -->
    <footer class="mt-20 pb-8">
        <div class="text-center text-gray-500 text-sm">
            <p>&copy; 2025 YouDemy. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>