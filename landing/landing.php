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
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iREKLAMO+ | <?php echo $title; ?></title>
    <link rel="icon" href="../brgy.png"/>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
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
                <a href="../login.php" class="text-gray-600 hover:text-gray-800 px-2 py-1 rounded-md hover:bg-gray-200 cursor-pointer">Login</a>
            </div>
        </header>
        
        <!-- content -->
        <div class="min-h-full items-start w-full grid gap-4">
            <!-- Announcement Slider -->
            <div class="py-3 px-4">
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

            <!-- Services Section -->
            <?php include 'services-content.php'; ?>

            <!-- Upcoming Events -->
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
            <p class="text-gray-600">&copy; 2025 iREKLAMO+. All rights reserved.</p>
        </footer>
    </div>

    <!-- Manual Complaint Modal -->
    <div id="manualComplaintModal" class="hidden fixed inset-0 z-50 backdrop-blur-sm flex items-center justify-center">
        <div class="relative mx-auto p-5 border w-full max-w-3xl max-h-[90vh] overflow-y-auto shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4 border-b pb-2">
                <h3 class="text-xl font-bold text-gray-900">File a Complaint</h3>
                <button onclick="hideManualForm()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            <div class="mt-3">
                <?php include 'complaint-form.php'; ?>
            </div>
        </div>
    </div>

    <script>
        function showManualForm() {
            document.getElementById('inputMethodModal').classList.add('hidden');
            document.getElementById('manualComplaintModal').classList.remove('hidden');
        }

        function hideManualForm() {
            document.getElementById('manualComplaintModal').classList.add('hidden');
        }

        document.getElementById('complaintForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('addManualComplaint.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    hideManualForm();
                    this.reset();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while submitting the complaint.');
            });
        });

        // Announcement slider script
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
</body>
</html>