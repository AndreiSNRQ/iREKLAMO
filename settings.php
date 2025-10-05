<?php
session_start();
$title = "Settings";

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
require_once 'head.php';
?>

<div class="flex flex-col w-full gap-2 main">
    <div class="flex items-center mb-4 gap-3">
        <button onclick="openProfileModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
            <i class="fas fa-user mr-2"></i>Update Profile
        </button>
        <button onclick="openOfficialsModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
            <i class="fas fa-users mr-2"></i>Update Officials
        </button>
        <button onclick="openPasswordModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
            <i class="fas fa-lock mr-2"></i>Update Password
        </button>
    </div>
    <hr class="mb-2 border-gray-300">

    <!-- Profile Modal -->
    <div id="profileModal" class="fixed inset-0 backdrop-blur-sm overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Update Profile</h3>
                <button onclick="closeProfileModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="profileForm" method="POST" action="update_profile.php">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                    <input type="text" name="name" class="border rounded w-full py-2 px-3 text-gray-700" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" name="email" class="border rounded w-full py-2 px-3 text-gray-700" required>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Officials Modal -->
    <div id="officialsModal" class="fixed inset-0 backdrop-blur-sm overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Update Officials</h3>
                <button onclick="closeOfficialsModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="officialsForm" method="POST" action="update_officials.php">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Barangay Captain</label>
                    <input type="text" name="captain" class="border rounded w-full py-2 px-3 text-gray-700" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Secretary</label>
                    <input type="text" name="secretary" class="border rounded w-full py-2 px-3 text-gray-700" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Kagawad</label>
                    <input type="text" name="kagawad" class="border rounded w-full py-2 px-3 text-gray-700" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">President</label>
                    <input type="text" name="president" class="border rounded w-full py-2 px-3 text-gray-700" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Vice President</label>
                    <input type="text" name="vp" class="border rounded w-full py-2 px-3 text-gray-700" required>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Update Officials
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Password Modal -->
    <div id="passwordModal" class="fixed inset-0 backdrop-blur-sm overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Update Password</h3>
                <button onclick="closePasswordModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="passwordForm" method="POST" action="update_password.php">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Current Password</label>
                    <input type="password" name="current_password" class="border rounded w-full py-2 px-3 text-gray-700" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">New Password</label>
                    <input type="password" name="new_password" class="border rounded w-full py-2 px-3 text-gray-700" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Confirm New Password</label>
                    <input type="password" name="confirm_password" class="border rounded w-full py-2 px-3 text-gray-700" required>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Main -->
    <div class="officials grid">
        <div class="capt">
            <h3 class="text-lg font-semibold">Punong Barangay</h3>
            <p id="captain"><span id="captainName"></span></p>
        </div>
        <div class="sec">
            <h3 class="text-lg font-semibold">Secretary</h3>
            <p id="secretary"><span id="secretaryName"></span></p>
        </div>
        <div class="capt">
            <h3 class="text-lg font-semibold">Barangay Kagawad</h3>
            <p id="kagawad"><span id="kagawadName"></span></p>
        </div>
        <div class="pres">
            <h3 class="text-lg font-semibold">Barangay President</h3>
            <p id="president"><span id="presidentName"></span></p>
        </div><div class="capt">
            <h3 class="text-lg font-semibold">Barangay Vice President</h3>
            <p id="vp"><span id="vpName"></span></p>
        </div>

    </div>

    <script>
    function openProfileModal() {
        document.getElementById('profileModal').classList.remove('hidden');
    }

    function closeProfileModal() {
        document.getElementById('profileModal').classList.add('hidden');
    }

    function openOfficialsModal() {
        document.getElementById('officialsModal').classList.remove('hidden');
    }

    function closeOfficialsModal() {
        document.getElementById('officialsModal').classList.add('hidden');
    }

    function openPasswordModal() {
        document.getElementById('passwordModal').classList.remove('hidden');
    }

    function closePasswordModal() {
        document.getElementById('passwordModal').classList.add('hidden');
    }

    // Fetch officials data
    document.addEventListener('DOMContentLoaded', function() {
        fetch('fetch_officials.php')
            .then(response => response.json())
            .then(data => {
                if (data.captain) document.getElementById('captainName').textContent = data.captain;
                if (data.secretary) document.getElementById('secretaryName').textContent = data.secretary;
                if (data.kagawad) document.getElementById('kagawadName').textContent = data.kagawad;
                if (data.president) document.getElementById('presidentName').textContent = data.president;
                if (data.vp) document.getElementById('vpName').textContent = data.vp;
            })
            .catch(error => console.error('Error fetching officials:', error));
    });
    </script>