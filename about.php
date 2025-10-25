<?php
$title = "Barangay Sta. Monica";

$announcement=[
    [

        "id"=>1,
        "img"=>"pics/qc.jpg",
        "date"=>"2025-01-01",
        "title"=>"Resident Registration",
        "description"=>"The resident registration is scheduled for tomorrow at 7:00 PM. Please arrive by 6:00 PM."
    ],
    [
        "id"=>2,
        "img"=>"pics/qc4.jpg",
        "date"=>"2025-01-02",
        "title"=>"eServices",
        "description"=>"The eServices is now available. You can access it by clicking the eServices."
    ],
    [
        "id"=>3,
        "img"=>"pics/qc3.jpg",
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

<style>

</style>
<body class="bg-gray-100">
    <div class="container grid h-screen max-w-screen">
        
        <!-- content -->
        <div class="min-h-full items-start w-full grid gap-4">
            <!-- Announcement Slider -->
            <div class="bg-[url('pics/qc.jpg')] bg-cover bg-center bg-blend-multiply bg-gray-400">
                <!-- header -->
                <header class="row-span-1 min-h-29 sticky top-0 z-50 bg-transparent flex items-center justify-between px-5 ">
                    <div>
                        <h1 class="text-4xl font-bold text-white">iREKLAMO+</h1>
                    </div>

                    <div class="flex items-center">
                        <?php include 'navlanding.php'; ?>
                    </div>
                </header>
                <div class="flex justify-center items-center text-center py-20">
                    <div class="mr-5">
                        <img src="pics/brgylogo.png" alt="Barangay Sta. Monica" class="w-full h-auto rounded-md shadow-md max-h-45 min-h-45">
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold text-white">Barangay Sta. Monica </h1><span class="text-2xl font-semibold text-white">Moises St., Jordan Plaines Subd., Brgy Sta.Monica Novaliches, QC</span>
                    </div>
                    <div class=" ml-5">
                        <img src="pics/brgy.jpg" alt="Quezon City" class="w-full max-h-20 min-h-20   rounded-md shadow-md">
                    </div>
                </div>
                
            </div>
            <!-- Announcement Slider -->
            <div class="px-20 py-10 h-150">
                <h1 class="text-3xl font-bold mt-2 mb-2 text-black">About:</h1>
                <div class="grid grid-cols-2 gap-10 text-2xl h-100">
                    <div class="flex flex-col">
                        <span class="text-xl text-start text-gray-400">Barangay Sta. Monica</span> <br>
                        <h1 class="text-lg shadow-lg inset-shadow-sm bg-white rounded-md p-5">Barangay Santa Monica is strategically located in the Novaliches area, forming part of the Fifth Legislative District of Quezon City. It is bounded by several other Novaliches barangays: to the north by Pasong Putik Proper, to the east by Santa Lucia and Gulod, to the south by Novaliches Proper, and to the west by Kaligayahan. This barangay is a major residential and commercial hub in its district, with key thoroughfares like Quirino Highway and parts of Mindanao Avenue running through or near it. As a relatively large barangay, it had a population of 51,834 residents as of the 2020 Census</h1>
                    </div>
                    <div class="h-100"><img src="pics/image6.png"  alt="" class="shadow-lg inset-shadow-sm w-full"></div>
                </div>
            </div>

            <!-- Services Section -->
            <?php include 'contact.php'; ?>

            <!-- Upcoming Events -->
            <div class="py-3">
                <div class="bg-white rounded-md shadow-lg p-4 w-full flex-col flex items-center">
                    <h3 class="text-lg font-semibold">© 2025 iREKLAMO+. All rights reserved.</h3>
                    <p class="text-gray-600"><a href="https://www.facebook.com/barangay.stamonica.3"><i class="fa-brands fa-facebook"></i></a></p>
                </div>
            </div>
        </div>

        <!-- Manual Complaint Modal -->
        <div id="manualComplaintModal" class="hidden fixed inset-0 z-50 backdrop-blur-sm flex items-center justify-center">
            <div class="relative mx-auto p-5 border w-full max-w-3xl max-h-[90vh] overflow-y-auto shadow-lg rounded-md bg-white">
                <div class="flex justify-between items-center mb-4 border-b pb-2">
                    <h3 class="text-xl font-bold text-gray-900">Make an Appointment</h3>
                    <button onclick="hideManualForm()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
                <div class="mt-3">
                    <?php include 'complaint-form.php'; ?>
                </div>
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