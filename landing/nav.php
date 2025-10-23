<?php
    $currentPage = basename($_SERVER['PHP_SELF']);
?>

<nav>
    <ul class="flex items-center space-x-4">
        <li>
            <a href="landing.php" class="px-3 py-2 rounded-md transition-colors duration-200 <?= $currentPage == 'landing.php' ? 'text-white bg-blue-900' : 'text-white hover:text-gray-800 hover:bg-gray-200'; ?>">
                Home
            </a>
        </li>
        <li>
            <a href="about.php" class="px-3 py-2 rounded-md transition-colors duration-200 <?= $currentPage == 'about.php' ? 'text-white bg-blue-900' : 'text-white hover:text-gray-800 hover:bg-gray-200'; ?>">
                About
            </a>
        </li>
        <li>
            <a href="contact.php" class="px-3 py-2 rounded-md transition-colors duration-200 <?= $currentPage == 'contact.php' ? 'text-white bg-blue-900' : 'text-white hover:text-gray-800 hover:bg-gray-200'; ?>">
                Contact
            </a>
        </li>
        <li>
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-md transition-colors duration-200">
                <a href="login.php">Login</a>
            </button>
        </li>
    </ul>
</nav>