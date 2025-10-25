<?php
$title = "Barangay Sta. Monica";

$announcement=[
    [

        "id"=>1,
        "img"=>"pics/announce.jpg",
        "date"=>"2025-01-01",
        "title"=>"Resident Registration",
        "description"=>"The resident registration is scheduled for tomorrow at 7:00 PM. Please arrive by 6:00 PM."
    ],
    [
        "id"=>2,
        "img"=>"pics/announce1.jpg",
        "date"=>"2025-01-02",
        "title"=>"eServices",
        "description"=>"The eServices is now available. You can access it by clicking the eServices."
    ],

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
                        <img src="pics/brgy.jpg" alt="Quezon City" class="w-full max-h-35 min-h-35 rounded-md shadow-md">
                    </div>
                </div>
                
            </div>
            <!-- Announcement Slider -->
            <div class="px-20">
                <h1 class="text-2xl font-semibold text-black text-center">Announcements:</h1>
                <div class="relative overflow-hidden shadow-lg inset-shadow-sm rounded-md border-gray-600 bg-white">
                    <div class="flex transition-transform duration-1000 ease-in-out min-h-100" id="announcement-slider">
                        <?php foreach($announcement as $item): ?>
                        <div class="w-full flex-shrink-0 px-15 py-8 flex flex-col justify-center items-center text-center">
                           <a href="https://www.facebook.com/barangay.stamonica.3"> <img src="<?php echo $item['img']; ?>" alt="Announcement Image" class="w-full max-w-3xl h-full h-auto object-cover rounded-md mb-4 shadow-md" /></a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button class="absolute px-3 h-full top-1/2 transform -translate-y-1/2 bg-transparent hover:bg-gray-100" id="prev-btn">
                        <i class="  fa-solid fa-circle-arrow-left text-4xl hover:text-gray-700 text-gray-600"></i>
                    </button>
                    <button class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-transparent h-full px-3 hover:bg-gray-100" id="next-btn">
                        <i class="fa-solid fa-circle-arrow-right text-4xl hover:text-gray-700 text-gray-600"></i>
                    </button>
                </div>
            </div>

            <!-- Services Section -->
            <?php include 'services-content.php'; ?>

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
                <div class="flex justify-center">
                    <button id="summarizeBtn">Summarize</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to Top Button -->
    <button id="backToTopBtn" class="fixed bottom-8 right-8 z-50 bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-full shadow-lg hover:bg-gray-900 transition-opacity duration-300 opacity-0 pointer-events-none">
        <i class="fa fa-arrow-up"></i> Back to Top
    </button>

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

        // Back to Top Button Script
        const backToTopBtn = document.getElementById('backToTopBtn');
        window.addEventListener('scroll', () => {
            if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 50) {
                backToTopBtn.style.opacity = '1';
                backToTopBtn.style.pointerEvents = 'auto';
            } else {
                backToTopBtn.style.opacity = '0';
                backToTopBtn.style.pointerEvents = 'none';
            }
        });
        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
        document.getElementById('summarizeBtn').addEventListener('click', async function() {
            const details = document.getElementById('details').value;
            if (!details.trim()) {
                alert('Please enter details to summarize.');
                return;
            }
            // Show loading
            const summaryDiv = document.getElementById('summarizedDetails');
            summaryDiv.textContent = 'Summarizing...';
            document.getElementById('summaryContainer').classList.remove('hidden');
        
            // GPT API call (replace with your endpoint)
            try {
                const response = await fetch('summarize.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ text: details })
                });
                const result = await response.json();
                if (result.summary) {
                    summaryDiv.textContent = result.summary;
                } else {
                    summaryDiv.textContent = 'Could not summarize.';
                }
            } catch (err) {
                summaryDiv.textContent = 'Error summarizing.';
            }
        });
    </script>
</body>
</html>