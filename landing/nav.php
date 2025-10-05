<?php
    $currentPage=$_SERVER['PHP_SELF'];
?>

<nav>
    <ul class="grid grid-cols-4  items-center">
        <li><a href="landing.php" class="text-gray-600 text-gray-800 px-2 py-1 hover:bg-gray-200 hover:rounded-md
            <?= $currentPage == 'landing.php' ? 'text-white bg-blue-900' : 'text-gray-500'; ?>">Home</a></li>
        <li><a href="services.php" class="text-gray-600 text-gray-800 px-2 py-1 hover:bg-gray-200 hover:rounded-md
            <?= $currentPage == 'services.php' ? 'text-white bg-blue-900' : 'text-gray-500'; ?>">Services</a></li>
        <li><a href="about.php" class="text-gray-600 text-gray-800 px-2 py-1 hover:bg-gray-200 hover:rounded-md
            <?= $currentPage == 'about.php' ? 'text-white bg-blue-900' : 'text-gray-500'; ?>">About</a></li>
        <li><a href="contact.php" class="text-gray-600 text-gray-800 px-2 py-1 hover:bg-gray-200 hover:rounded-md
            <?= $currentPage == 'contact.php' ? 'text-white bg-blue-900' : 'text-gray-500'; ?>">Contact</a></li>
    </ul>
</nav>