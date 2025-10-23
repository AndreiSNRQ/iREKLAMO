<?php
    $currentPage = basename($_SERVER['PHP_SELF']);
?>

<nav>
    <ul class="flex items-center space-x-4">
        <li>
            <a href="landing.php" class="px-3 py-2 rounded-md transition-colors duration-200 border <?php echo $currentPage == 'landing.php' ? 'bg-gray-600 text-white' : 'text-white hover:text-white hover:bg-gray-600'; ?>">
                Home
            </a>
        </li>
        <li>
            <a href="about.php" class="px-3 py-2 rounded-md transition-colors duration-200 border <?php echo $currentPage == 'about.php' ? 'bg-gray-600 text-white' : 'text-white hover:text-white hover:bg-gray-600'; ?>">
                About
            </a>
        </li>
        <li>
            <a href="login.php" class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-2 rounded-md transition-colors duration-200">
                Login
            </a>
        </li>
    </ul>
</nav>