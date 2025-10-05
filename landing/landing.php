<?php
$title = "Barangay Sta. Monica";

$announcement=[
    [
        "id"=>1,
        "date"=>"2025-01-01",
        "title"=>"Resident Registration",
        "description"=>"The resident registration is scheduled for tomorrow at 7:00 PM. Please arrive by 6:00 PM."
    ],
    [
        "id"=>2,
        "date"=>"2025-01-02",
        "title"=>"eServices",
        "description"=>"The eServices is now available. You can access it by clicking the eServices."
    ],
    [
        "id"=>3,
        "date"=>"2025-01-03",
        "title"=>"Barangay-wide Meeting",
        "description"=>"The barangay-wide meeting is scheduled for tomorrow at 7:00 PM. Please arrive by 6:00 PM."
    ]
]
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iREKLAMO+ | <?php echo $title; ?></title>
    <link rel="icon" href="pics/brgylogo.png"/>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100">
    <div class="container grid h-screen max-w-screen">
        <!-- header -->
        <header class="row-span-1 h-20 sticky top-0 shadow-xs bg-white border-b border-gray-200 flex items-center justify-between px-5">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">iREKLAMO+</h1>
                <hr>
                <h1 class="text-sm text-gray-600">Barangay Sta. Monica</h1>
            </div>
                <?php include 'nav.php'; ?>
            <div class="flex items-center">
                <a onclick="openLoginModal()" class="text-gray-600 hover:text-gray-800 px-2 py-1 rounded-md hover:bg-gray-200 cursor-pointer">Login</a>
            </div>
        </header>
        <!-- content -->
        <div class="min-h-full items-start w-full grid gap-4">
            <!-- Announcement Slider -->
            <div class="py-3 px-15">
                <h1 class="text-2xl font-semibold text-gray-600 mb-2">Latest Announcements:</h1>
                <div class="relative overflow-hidden">
                    <div class="flex transition-transform duration-500 ease-in-out" id="announcement-slider">
                        <?php foreach($announcement as $item): ?>
                        <div class="w-full flex-shrink-0 px-10 py-4 bg-white rounded-md shadow-lg">
                            <h3 class="text-lg font-semibold"><?php echo $item['title']; ?></h3>
                            <p class="text-gray-600"><?php echo $item['description']; ?></p>
                            <p class="text-sm text-gray-500 mt-2"><?php echo $item['date']; ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button class="absolute left-2 top-1/2 transform -translate-y-1/2 rounded-full" id="prev-btn">
                        <i class="fa-solid fa-circle-arrow-left text-2xl hover:text-gray-800" style="color: #8787879d;"></i>
                    </button>
                    <button class="absolute right-2 top-1/2 transform -translate-y-1/2 rounded-full" id="next-btn">
                        <i class="fa-solid fa-circle-arrow-right text-2xl hover:text-gray-800" style="color: #8787879d;"></i>
                    </button>
                </div>
            </div>

            <div class="py-3 px-10">
                <h1 class="text-2xl font-semibold text-gray-600 mb-2">Upcoming Events:</h1>
                <div class="bg-white rounded-md shadow-lg p-4">
                    <h3 class="text-lg font-semibold">Barangay-wide Meeting</h3>
                    <p class="text-gray-600">The barangay-wide meeting is scheduled for tomorrow at 7:00 PM. Please arrive by 6:00 PM.</p>
                    <p class="text-sm text-gray-500 mt-2">2025-01-03</p>
                </div>
            </div>
        </div>
        <!-- footer -->
        <footer class="row-span-1 h-12 bg-white border-t shadow-xs sticky bottom-0 border-gray-200 flex items-center justify-center">
            <p class="text-gray-600">© 2025 iREKLAMO+. All rights reserved.</p>
        </footer>
    </div>

    <!-- Login Modal -->
    <div id="loginModal" class="hidden fixed top-0 left-0 w-full h-full backdrop-blur-sm bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-8 rounded-md shadow-md">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Login</h2>
            <form action="login.php" method="POST">
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

<script>
    const slider = document.getElementById('announcement-slider');
    const slides = document.querySelectorAll('#announcement-slider > div');
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    
    let currentSlide = 0;
    const slideCount = slides.length;
    
    function updateSlider() {
        slider.style.transform = `translateX(-${currentSlide * 100}%)`;
    }
    
    prevBtn.addEventListener('click', () => {
        currentSlide = (currentSlide - 1 + slideCount) % slideCount;
        updateSlider();
    });
    
    nextBtn.addEventListener('click', () => {
        currentSlide = (currentSlide + 1) % slideCount;
        updateSlider();
    });
    
    // Auto slide every 5 seconds
    setInterval(() => {
        currentSlide = (currentSlide + 1) % slideCount;
        updateSlider();
    }, 5000);
</script>