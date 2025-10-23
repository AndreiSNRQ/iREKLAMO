<?php
$title = "Barangay Sta. Monica";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iREKLAMO+ | <?php echo $title; ?> - About</title>
    <link rel="icon" href="../brgy.png"/>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
            <h1 class="text-3xl font-semibold text-gray-700">About iReklamo+</h1>
            <div class="bg-white rounded-md shadow p-6 mt-4">
                <h2 class="text-2xl font-semibold text-gray-700 mt-6">Empowering Communities Through Digital Innovation</h2>
                <p class="text-gray-700 mt-4">iReklamo+ is a community-focused digital platform designed to modernize public service operations at the barangay level. Born from the need to address the inefficiencies of manual, paper-based systems, iReklamo+ leverages automation and secure record management to transform how citizens report concerns and how barangays manage critical data.</p>

                <h2 class="text-2xl font-semibold text-gray-700 mt-6">Our Mission</h2>
                <p class="text-gray-700 mt-4">To enhance trust between citizens and their local government by providing a transparent, efficient, and reliable digital system for complaint and blotter reporting. We aim to minimize administrative burdens, reduce human error, and support data-driven decision-making for better community governance.</p>

                <h2 class="text-2xl font-semibold text-gray-700 mt-6">The Challenge We Address</h2>
                <p class="text-gray-700 mt-4">In an increasingly digital world, many local government units (LGUs) in the Philippines, including Barangay Sta. Monica, Quezon City, still rely on outdated manual processes. These traditional methods—often involving handwritten logs and physical filing systems—are prone to delays, misplaced files, and data loss, ultimately hindering effective and transparent service delivery.</p>

                <h2 class="text-2xl font-semibold text-gray-700 mt-6">Our Solution</h2>
                <p class="text-gray-700 mt-4">iReklamo+ is specifically designed to overcome these challenges by:</p>
                <ul class="list-disc list-inside text-gray-700 mt-4">
                    <li><strong>Centralizing Records:</strong> Moving from scattered paper files to a single, secure digital database.</li>
                    <li><strong>Minimizing Human Error:</strong> Automating data entry and record-keeping to ensure accuracy and integrity.</li>
                    <li><strong>Enabling Real-Time Access:</strong> Providing barangay officials with instant access to records for faster response and resolution.</li>
                    <li><strong>Simplifying Reporting:</strong> Offering a streamlined and user-friendly process for citizens to file complaints and reports.</li>
                </ul>

                <h2 class="text-2xl font-semibold text-gray-700 mt-6">Our Vision for the Future</h2>
                <p class="text-gray-700 mt-4">iReklamo+ is more than just a software solution; it is a step towards the future of digital governance in the Philippines. By successfully implementing this system in Barangay Sta. Monica, we aim to create a scalable and adaptable model that can be adopted by other barangays across the nation, fostering a new standard of efficiency, accountability, and citizen trust.</p>
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