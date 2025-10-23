<?php
$title = "Barangay Sta. Monica";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iREKLAMO+ | <?php echo $title; ?> - File Complaint</title>
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
                <a onclick="openLoginModal()" class="text-gray-600 hover:text-gray-800 px-2 py-1 rounded-md hover:bg-gray-200 cursor-pointer">Login</a>
            </div>
        </header>

        <!-- content -->
        <main class="flex-grow items-start w-full grid gap-4 p-8">
            <h1 class="text-3xl font-semibold text-gray-700">File a Complaint</h1>
            <div class="bg-white rounded-md shadow p-6 mt-4 w-full">
                <form id="complaintForm">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 mb-4">Complainant's Information</h2>
                            <div class="mb-4">
                                <label for="c_name" class="block text-gray-600">Name</label>
                                <input type="text" id="c_name" name="c_name" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                            </div>
                            <div class="mb-4">
                                <label for="c_contact" class="block text-gray-600">Contact Number</label>
                                <input type="text" id="c_contact" name="c_contact" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div class="mb-4">
                                <label for="c_address" class="block text-gray-600">Address</label>
                                <input type="text" id="c_address" name="c_address" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 mb-4">Respondent's Information</h2>
                            <div class="mb-4">
                                <label for="r_name" class="block text-gray-600">Name</label>
                                <input type="text" id="r_name" name="r_name" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                            </div>
                            <div class="mb-4">
                                <label for="r_contact" class="block text-gray-600">Contact Number</label>
                                <input type="text" id="r_contact" name="r_contact" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div class="mb-4">
                                <label for="r_address" class="block text-gray-600">Address</label>
                                <input type="text" id="r_address" name="r_address" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                        </div>
                    </div>
                    <div class="mt-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Complaint Details</h2>
                        <div class="mb-4">
                            <label for="type" class="block text-gray-600">Type of Complaint</label>
                            <select id="type" name="type" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                                <option>Verbal Abuse</option>
                                <option>Physical Abuse</option>
                                <option>Theft</option>
                                <option>Others</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="location" class="block text-gray-600">Location of Incident</label>
                            <input type="text" id="location" name="location" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                        </div>
                        <div class="mb-4">
                            <label for="date_time" class="block text-gray-600">Date and Time of Incident</label>
                            <input type="datetime-local" id="date_time" name="date_time" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        </div>
                        <div class="mb-4">
                            <label for="details" class="block text-gray-600">Details</label>
                            <textarea id="details" name="details" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md" required></textarea>
                        </div>
                    </div>
                    <div class="flex justify-end mt-6">
                        <button type="submit" class="bg-blue-900 text-white px-4 py-2 rounded-md hover:bg-blue-700">Submit Complaint</button>
                    </div>
                </form>
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
                    window.location.href = 'landing.php';
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while submitting the complaint.');
            });
        });
    </script>
</body>
</html>