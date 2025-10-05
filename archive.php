<?php
session_start();
$title = "Archives";
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
require_once 'head.php';

function processDocumentWithPython($content) {
    $pythonScript = __DIR__ . '/document_processor.py';
    $cmd = 'python "' . $pythonScript . '" "' . addslashes($content) . '"';
    
    $output = shell_exec($cmd);
    
    if ($output === null) {
        return ['error' => 'Python script execution failed'];
    }
    
    $result = json_decode($output, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        return ['error' => 'Invalid JSON output from Python script'];
    }
    
    return $result;
}

$complaints = [
    ['id' => 1, 'complainant' => 'Andrei Santos', 'respondent' => 'Juan Dela Cruz', 'details' => 'Stolen bike at the park', 'date' => '2024-10-10', 'type' => 'Theft', 'location' => 'Central Park'],
    ['id' => 2, 'complainant' => 'Maria Lopez', 'respondent' => 'Pedro Reyes', 'details' => 'Physical altercation at market', 'date' => '2024-11-11', 'type' => 'Assault', 'location' => 'Public Market'],
    ['id' => 3, 'complainant' => 'Carlos Lim', 'respondent' => 'Anna Cruz', 'details' => 'Lost wallet reported', 'date' => '2024-09-15', 'type' => 'Lost Item', 'location' => 'Bus Terminal'],
    ['id' => 4, 'complainant' => 'Liza Tan', 'respondent' => 'Ben Ramos', 'details' => 'Verbal dispute over property', 'date' => '2024-08-20', 'type' => 'Dispute', 'location' => 'Barangay Hall'],
    ['id' => 5, 'complainant' => 'Ramon Garcia', 'respondent' => 'Josefina Diaz', 'details' => 'Noise complaint at night', 'date' => '2024-07-05', 'type' => 'Disturbance', 'location' => 'Blk 3, Lot 7'],
    ['id' => 6, 'complainant' => 'Elena Cruz', 'respondent' => 'Miguel Santos', 'details' => 'Vandalism on wall', 'date' => '2024-06-18', 'type' => 'Vandalism', 'location' => 'School Zone'],
    ['id' => 7, 'complainant' => 'Victor Yu', 'respondent' => 'Samuel Ong', 'details' => 'Dog bite incident', 'date' => '2024-05-22', 'type' => 'Animal Bite', 'location' => 'Street 12'],
    ['id' => 8, 'complainant' => 'Grace Lim', 'respondent' => 'Cathy Tan', 'details' => 'Scam report', 'date' => '2024-04-30', 'type' => 'Fraud', 'location' => 'Online'],
    ['id' => 9, 'complainant' => 'Oscar dela Rosa', 'respondent' => 'Ricky Chan', 'details' => 'Car accident minor', 'date' => '2024-03-14', 'type' => 'Accident', 'location' => 'Main Avenue'],
    ['id' => 10, 'complainant' => 'Nina Bautista', 'respondent' => 'Lito Mendoza', 'details' => 'Trespassing in backyard', 'date' => '2024-02-28', 'type' => 'Trespassing', 'location' => 'Blk 5, Lot 2'],
    ['id' => 11, 'complainant' => 'Jorge Ramos', 'respondent' => 'Paula Cruz', 'details' => 'Threats received via SMS', 'date' => '2024-01-10', 'type' => 'Threat', 'location' => 'Unknown'],
    ['id' => 12, 'complainant' => 'Sofia Reyes', 'respondent' => 'Dino Lim', 'details' => 'Illegal parking complaint', 'date' => '2023-12-19', 'type' => 'Illegal Parking', 'location' => 'Street 8'],
    ['id' => 13, 'complainant' => 'Miguel Tan', 'respondent' => 'Rosa Yu', 'details' => 'Shoplifting at store', 'date' => '2023-11-23', 'type' => 'Shoplifting', 'location' => 'Mall'],
    ['id' => 14, 'complainant' => 'Patricia Ong', 'respondent' => 'Henry Lee', 'details' => 'Cyberbullying report', 'date' => '2023-10-05', 'type' => 'Cybercrime', 'location' => 'Internet'],
    ['id' => 15, 'complainant' => 'Dennis Cruz', 'respondent' => 'Mila Santos', 'details' => 'Child neglect observed', 'date' => '2023-09-17', 'type' => 'Neglect', 'location' => 'Blk 2, Lot 10'],
    ['id' => 16, 'complainant' => 'Arlene Mendoza', 'respondent' => 'Tomas Garcia', 'details' => 'Public intoxication', 'date' => '2023-08-29', 'type' => 'Intoxication', 'location' => 'Plaza'],
    ['id' => 17, 'complainant' => 'Felix Diaz', 'respondent' => 'Lara Ramos', 'details' => 'Illegal gambling', 'date' => '2023-07-13', 'type' => 'Gambling', 'location' => 'Alley 4'],
    ['id' => 18, 'complainant' => 'Cynthia Lee', 'respondent' => 'Mario Bautista', 'details' => 'Domestic violence', 'date' => '2023-06-21', 'type' => 'Violence', 'location' => 'Blk 1, Lot 3'],
];
?>
<div class="col-span-6 flex w-full p-2 md:px-5">
    <div class="flex flex-col w-full">
        <h1 class="text-2xl font-bold">Archives</h1>
        <div class="flex items-center mb-4 mt-3 gap-2 ">
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                <a href="complaints.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'complaints.php' ? : 'hover:bg-blue-700'; ?>"><p class="text-end" >Complaints</p></a>
            </button>

            <!-- complaint modal -->
            <div id="addComplaintModal" class="hidden fixed inset-0 bg-opacity-50 -mt-13 h-full w-full">
                <div class="relative top-20 mx-auto p-5 drop-shadow-lg w-96 w-[600px] shadow-lg rounded-md bg-white">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Add New Complaint</h3>
                        <button onclick="document.getElementById('addComplaintModal').classList.add('hidden')" class="text-gray-500 rounded-full hover:bg-gray-500 px-3 p-2 hover:text-white">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <!-- form -->
                    <form id="complaintForm">
                        <!-- complainant -->
                        <div class="mb-2 grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-md mb-2" for="complainant">Complainant Name</label>
                                <input class="shadow appearance-none border-gray-300 border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="complainant" type="text" required>
                            </div>
                            <div>
                                <label class="block text-md mb-2" for="complainant">Contact</label>
                                <input class="shadow appearance-none border-gray-300 border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="complainant" type="text" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-md mb-2" for="complainant">Address</label>
                            <input class="shadow appearance-none border-gray-300 border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="complainant" type="text" required>
                        </div>
                        <hr class="my-4 border-gray-300">
                        <!-- respondent -->
                        <div class="mb-2 grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-md mb-2" for="respondent">Respondent Name</label>
                                <input class="shadow appearance-none border-gray-300 border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="respondent" type="text" required>
                            </div>
                            <div>
                                <label class="block text-md mb-2" for="respondent">Contact</label>
                                <input class="shadow appearance-none border-gray-300 border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="respondent" type="text" required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-md mb-2" for="respondent">Address</label>
                            <input class="shadow appearance-none border-gray-300 border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="respondent" type="text" required>
                        </div>
                        <hr class="my-4 border-gray-300">
                        <!-- incident details -->
                        <div class="mb-4">
                            <label class="block text-md mb-2" for="incidentDetails">Incident Details</label>
                            <textarea class="shadow appearance-none border-gray-300 border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="incidentDetails" rows="4" required></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block text-md mb-2" for="incidentDate">Incident Date and Time</label>
                            <input class="shadow appearance-none border-gray-300 border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="incidentDate" type="datetime-local" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-md mb-2" for="incidentLocation">Incident Location</label>
                            <input class="shadow appearance-none border-gray-300 border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="incidentLocation" type="text" required>
                        </div>
                        <div class="flex justify-between mb-4">
                            <button type="button" onclick="document.getElementById('scanComplaintBtn').click()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors">
                                <i class="fas fa-camera mr-2"></i>Scan Document
                            </button>
                        </div>
                        <div class="flex justify-end">
                            <button onclick="document.getElementById('addComplaintModal').classList.add('hidden')" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mr-2">Cancel</button>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-3 md:p-5">
            <div style="min-height: 650px; overflow-y: auto;">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-2">
                                <label for="complaintStatusFilter" class="font-semibold">Filter by Type:</label>
                                <?php $incidentTypes = array_unique(array_map(function($item) { return $item['type']; }, $complaints)); sort($incidentTypes); ?>
                                <select id="complaintStatusFilter" class="border border-gray-300 rounded px-3 py-2">
                                    <option value="all">All Types</option>
                                    <?php foreach ($incidentTypes as $type): ?>
                                        <option value="<?php echo strtolower($type); ?>"><?php echo $type; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="flex items-center gap-2">
                                <label for="complaintSearchInput" class="font-semibold">Search:</label>
                                <input type="text" id="complaintSearchInput" placeholder="Search Complainant" class="border border-gray-300 rounded px-3 py-2 w-64" />
                            </div>
                        </div>
                        <tr>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">Complainant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">Respondent</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">Incident Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">Incident Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">Incident Location</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="complaintTableBody">
                        <?php
                        $itemsPerPage = 10;
                        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $totalItems = count($complaints);
                        $totalPages = ceil($totalItems / $itemsPerPage);
                        $currentPage = max(1, min($currentPage, $totalPages));
                        $offset = ($currentPage - 1) * $itemsPerPage;
                        $paginatedComplaints = array_slice($complaints, $offset, $itemsPerPage);
                        foreach ($paginatedComplaints as $item): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($item['id']); ?></td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($item['complainant']); ?></td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($item['respondent']); ?></td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($item['type']); ?></td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($item['date']); ?></td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($item['location']); ?></td>
                            <td class="px-3 text-center md:px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <button onclick="openViewModal(<?= $blotter['id'] ?>)" class="text-blue-600 hover:text-blue-900 mr-3"><i class="fas fa-eye mr-1"></i>View</button>
                                <button onclick="openEditModal(<?= $blotter['id'] ?>)" class="text-green-600 hover:text-green-900"><i class="fas fa-edit mr-1"></i>Edit</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 flex items-center justify-between border-t border-gray-200 bg-gray-50">
                <div class="flex-1 flex justify-between sm:hidden">
                    <a href="?page=<?php echo max(1, $currentPage - 1); ?>" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 <?php echo ($currentPage == 1) ? 'opacity-50 cursor-not-allowed' : ''; ?>">Previous</a>
                    <a href="?page=<?php echo min($totalPages, $currentPage + 1); ?>" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 <?php echo ($currentPage == $totalPages) ? 'opacity-50 cursor-not-allowed' : ''; ?>">Next</a>
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <p class="text-sm text-gray-700">
                        Showing <span class="font-medium"><?php echo $offset + 1; ?></span> to <span class="font-medium"><?php echo min($offset + $itemsPerPage, $totalItems); ?></span> of <span class="font-medium"><?php echo $totalItems; ?></span> results
                    </p>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <a href="?page=<?php echo $i; ?>" class="relative inline-flex items-center px-4 py-2 border text-sm font-medium <?php echo ($i == $currentPage) ? 'bg-blue-50 border-blue-500 text-blue-600' : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50'; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Residents content here -->
    </div>
</div>

<script>
// Image to text functionality for complaint
async function handleComplaintImageUpload(event) {
    const file = event.target.files[0];
    if (!file) return;

    try {
        let text = '';
        const reader = new FileReader();
        
        // Handle different file types
        if (file.type.startsWith('image/')) {
            // For images, we would typically use OCR here
            // For now, we'll just read as text (simulating OCR output)
            text = await file.text();
        }else if (file.type.startsWith('png/')){
            text = await file.text();
        } else if (file.name.endsWith('.pdf')) {
            // For PDFs, read as text directly
            text = await file.text();
        } else if (file.name.endsWith('.doc') || file.name.endsWith('.docx')) {
            // For DOCX files, we need to extract the actual text content
            alert('Please note: DOCX files will be processed as plain text. Some formatting may be lost.');
            text = await file.text();
            
            // Clean up DOCX-specific artifacts
            text = text.replace(/\[.*?\]/g, '')
                      .replace(/\{.*?\}/g, '')
                      .replace(/\s+/g, ' ');
        } else {
            throw new Error('Unsupported file type. Please upload an image, PDF, or DOCX file.');
        }
        
        // Send to PHP for Python processing
        const formData = new FormData();
        formData.append('file_content', text);
        formData.append('file_type', file.type);
        
        const response = await fetch('process_document.php', {
            method: 'POST',
            body: formData
        });
        
        // Clone response to allow multiple reads
        const responseClone = response.clone();
        let data;
        try {
            data = await response.json();
        } catch (e) {
            const errorText = await responseClone.text();
            throw new Error(`Failed to parse response: ${errorText.substring(0, 100)}`);
        }
        
        if (data.error) {
            let errorMsg = data.error;
            if (data.details) errorMsg += `: ${data.details}`;
            if (data.python_error) errorMsg += `\nPython Error: ${data.python_error}`;
            throw new Error(errorMsg);
        }
        
        text = data.text;
        
        // Analyze document content
        const result = analyzeDocumentContent(text);
        
        // Populate form fields
        document.getElementById('complainant').value = result.complainant || '';
        document.getElementById('respondent').value = result.respondent || '';
        document.getElementById('incidentDetails').value = result.details || '';
        document.getElementById('incidentDate').value = result.date || '';
        document.getElementById('incidentLocation').value = result.location || '';
        
        // Show detailed success message with extracted fields
        let successMessage = 'Document analyzed successfully!\n\nExtracted data:';
        if (result.complainant) successMessage += '\n- Complainant: ' + result.complainant;
        if (result.respondent) successMessage += '\n- Respondent: ' + result.respondent;
        if (result.details) successMessage += '\n- Details: ' + result.details;
        if (result.date) successMessage += '\n- Date: ' + result.date;
        if (result.location) successMessage += '\n- Location: ' + result.location;
        
        alert(successMessage);
    } catch (error) {
        console.error('Error analyzing document:', error);
        let errorMsg = 'Error processing document: ' + error.message;
        
        // Add specific troubleshooting tips based on error type
        if (error.message.includes('Unsupported file type')) {
            errorMsg += '\n\nSupported formats: JPG, PNG, PDF, DOC, DOCX';
        } else if (error.message.includes('failed') || error.message.includes('processing')) {
            errorMsg += '\n\nTroubleshooting:';
            errorMsg += '\n1. Check document contains clear text';
            errorMsg += '\n2. Ensure required fields are labeled (Complainant, Suspect, etc)';
            errorMsg += '\n3. Try a simpler document format (plain text works best)';
        }
        
        alert(errorMsg);
        throw error;
    }
}

function analyzeDocumentContent(text) {
    // Extract data from document text using field labels
    const extractedData = {
        complainant: extractField(text, 'Complainant:', 'Name:'),
        respondent: extractField(text, 'Suspect:', 'Name:'),
        details: extractField(text, 'Details of the Incident:'),
        date: extractField(text, 'Date of Incident:'),
        location: extractField(text, 'Location of Incident:')
    };
    
    return extractedData;
}

function extractField(text, startMarker, endMarker = null) {
    // Convert to uppercase for case-insensitive search
    const upperText = text.toUpperCase();
    
    // Try multiple variations of the start marker
    const markerVariations = [
        startMarker.toUpperCase(),
        startMarker.toUpperCase().replace(':', '').trim(),
        startMarker.toUpperCase().replace('of', '').trim()
    ];
    
    let startIndex = -1;
    let upperMarker = '';
    
    // Find the first matching variation
    for (const variation of markerVariations) {
        startIndex = upperText.indexOf(variation);
        if (startIndex !== -1) {
            upperMarker = variation;
            break;
        }
    }
    
    if (startIndex === -1) return '';
    
    const start = startIndex + upperMarker.length;
    let end;
    
    if (endMarker) {
        // Try multiple variations of the end marker
        const endMarkerVariations = [
            endMarker.toUpperCase(),
            endMarker.toUpperCase().replace(':', '').trim()
        ];
        
        for (const variation of endMarkerVariations) {
            end = upperText.indexOf(variation, start);
            if (end !== -1) break;
        }
        
        if (end === -1) end = text.length;
    } else {
        // Look for next line break or double newline
        const nextLine = upperText.indexOf('\n', start);
        const nextDoubleLine = upperText.indexOf('\n\n', start);
        
        end = Math.min(
            nextLine !== -1 ? nextLine : text.length,
            nextDoubleLine !== -1 ? nextDoubleLine : text.length
        );
    }
    
    // Extract original text (preserving case)
    const extracted = text.substring(start, end).trim();
    
    // Clean up common document artifacts
    return extracted
        .replace(/^[:\-\*\s]+/, '') // Remove leading punctuation/whitespace
        .replace(/[\r\n]+/g, ' ')     // Replace newlines with spaces
        .replace(/\s+/g, ' ')          // Collapse multiple spaces
        .trim();
}

document.getElementById('scanComplaintBtn').addEventListener('click', () => {
    const fileInput = document.createElement('input');
    fileInput.type = 'file';
    fileInput.accept = 'image/*,.pdf,.doc,.docx';
    fileInput.addEventListener('change', handleComplaintImageUpload);
    fileInput.click();
});

// New function to handle speech recognition
async function handleSpeechRecognition() {
    try {
        const response = await fetch('process_speech.php');
        if (!response.ok) {
            throw new Error('Speech recognition request failed');
        }
        const data = await response.json();
        if (data.error) {
            throw new Error(data.error);
        }
        // Assuming data.text contains recognized speech text
        const recognizedText = data.text || '';
        // Populate the incidentDetails field with recognized text
        document.getElementById('incidentDetails').value = recognizedText;
        alert('Speech recognized and populated in Incident Details field.');
    } catch (error) {
        alert('Error during speech recognition: ' + error.message);
    }
}

// Add a button for speech recognition
const speechBtn = document.createElement('button');
speechBtn.textContent = 'Start Speech Recognition';
speechBtn.className = 'bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-colors ml-2';
speechBtn.addEventListener('click', handleSpeechRecognition);

// Append the button next to scanComplaintBtn
const scanBtn = document.getElementById('scanComplaintBtn');
if (scanBtn && scanBtn.parentNode) {
    scanBtn.parentNode.appendChild(speechBtn);
}
</script>

<script>
  const complaintStatusFilter = document.getElementById('complaintStatusFilter');
  const complaintSearchInput = document.getElementById('complaintSearchInput');
  const complaintTableBody = document.getElementById('complaintTableBody');

  function filterComplaintTable() {
    const filterValue = complaintStatusFilter.value.toLowerCase();
    const searchTerm = complaintSearchInput.value.toLowerCase();

    Array.from(complaintTableBody.getElementsByTagName('tr')).forEach(row => {
      const typeCell = row.cells[3].textContent.toLowerCase();
      const complainantCell = row.cells[1].textContent.toLowerCase();

      const matchesFilter = filterValue === 'all' || typeCell === filterValue;
      const matchesSearch = complainantCell.includes(searchTerm);

      row.style.display = matchesFilter && matchesSearch ? '' : 'none';
    });
  }

  complaintStatusFilter.addEventListener('change', filterComplaintTable);
  complaintSearchInput.addEventListener('input', filterComplaintTable);
</script>