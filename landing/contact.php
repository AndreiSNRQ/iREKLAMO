<?php
$title = "Barangay Sta. Monica";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iREKLAMO+ | <?php echo $title; ?> - Contact</title>
    <link rel="icon" href="../brgy.png"/>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
</head>
<body class="bg-gray-100">
    <div class="container flex flex-col min-h-screen max-w-screen">
        <!-- header -->
        <header class="h-20 sticky top-0 shadow-xs bg-white border-b border-gray-200 flex items-center justify-between px-5">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">iREKLAMO+</h1>
                <hr>
                <h1 class="text-sm text-gray-600">Barangay Sta. Monica</h1>
            </div>
            <?php include 'nav.php'; ?>
              <div class="flex items-center">
                <a href="../login.php" class="text-gray-600 hover:text-gray-800 px-2 py-1 rounded-md hover:bg-gray-200 cursor-pointer">Login</a>
            </div>
        </header>

        <!-- content -->
        <main class="flex-grow items-start w-full grid gap-4 p-8">
            <h1 class="text-3xl font-semibold text-gray-700">Contact Us</h1>
            <div class="bg-white rounded-md shadow p-6 mt-4">
                <p class="text-gray-700">If you have any questions or concerns, please feel free to contact us using the information below.</p>
                <ul class="list-disc list-inside text-gray-700 mt-4">
                    <li>Email: contact@ireklamo.plus</li>
                    <li>Phone: +63 912 345 6789</li>
                </ul>
            </div>
        </main>

        <!-- footer -->
        <footer class="h-12 bg-white border-t shadow-xs border-gray-200 flex items-center justify-center">
            <p class="text-gray-600">&copy; 2025 iREKLAMO+. All rights reserved.</p>
        </footer>
    </div>

    <!-- Login Modal -->
    <div id="loginModal" class="hidden fixed top-0 left-0 w-full h-full backdrop-blur-sm bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-8 rounded-md shadow-md">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Login</h2>
            <form action="../login.php" method="POST">
                <div class="mb-4">
                    <label for="username" class="block text-gray-600">Username</label>
                    <input type="text" id="username" name="username" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-600">Password</label>
                    <input type="password" id="password" name="password" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-900 text-white px-4 py-2 rounded-md hover:bg-blue-700">Login</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openLoginModal() {
            document.getElementById('loginModal').classList.remove('hidden');
        }
    </script>
</body>
</html>