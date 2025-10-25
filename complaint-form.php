<?php
$summary = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['complaint'])) {
    $sentence = $_POST['complaint'];
    $command = 'python summarize.py ' . escapeshellarg($sentence) . ' 2>&1';
    $summary = shell_exec($command);
    if (empty($summary) || strpos($summary, 'Traceback') !== false) {
        $error = 'Error summarizing.';
        $summary = '';
    }
}
?>

<?php if (!empty($error)): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
        <?php echo $error; ?>
    </div>
<?php endif; ?>

<?php if (!empty($summary)): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
        <strong>Summary:</strong> <?php echo htmlspecialchars($summary); ?>
    </div>
<?php endif; ?>

<form id="complaintForm">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 min-w-[600px] w-1/2">
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
            <button type="button" id="summarizeBtn" class="mt-2 bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Summarize</button>
            <div id="summaryContainer" class="mt-2 hidden">
                <label class="block text-gray-600">Summarized Details</label>
                <div id="summarizedDetails" class="bg-gray-100 p-2 rounded text-sm"></div>
            </div>
        </div>
    </div>

    <!-- Consent Letter -->
    <div class="mt-6 border-t pt-4">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Data Privacy Consent</h3>
        <p class="text-sm text-gray-600 mb-4">
            By submitting this form, you agree to the collection and processing of your personal data for the purpose of addressing your complaint, in accordance with the Data Privacy Act of 2012. Your information will be kept confidential and will only be used for official barangay purposes.
        </p>
        <div class="flex items-center">
            <input type="checkbox" id="consent" name="consent" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" required>
            <label for="consent" class="ml-2 block text-sm text-gray-900">I agree to the terms and conditions.</label>
        </div>
    </div>

    <div class="flex justify-end mt-6 gap-4">
        <button type="button" onclick="hideManualForm()" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Cancel</button>
        <button type="submit" class="bg-blue-900 text-white px-4 py-2 rounded-md hover:bg-blue-700">Submit Complaint</button>
    </div>
</form>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 min-w-[600px] w-1/2">
    <form method="post" class="col-span-2">
        <label for="complaint" class="block mb-2 font-bold">Enter Complaint:</label>
        <textarea name="complaint" id="complaint" rows="5" cols="40" class="w-full p-2 border rounded mb-4" required></textarea>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Summarize</button>
    </form>
</div>