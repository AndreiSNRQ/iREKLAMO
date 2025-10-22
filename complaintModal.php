<!-- input method selection modal -->
<div id="inputMethodModal" class="hidden fixed inset-0 backdrop-blur-sm flex justify-center items-center z-50">
    <div class="relative mx-auto p-6 w-[400px] shadow-lg rounded-lg bg-white animate-fade-in">
        <div class="flex justify-between items-center mb-4 border-b pb-2">
            <h3 class="text-lg font-semibold">Select Input Method</h3>
            <button onclick="document.getElementById('inputMethodModal').classList.add('hidden')" 
class="text-gray-500 hover:bg-gray-200 rounded-full p-2">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="flex flex-col space-y-4">
            <button onclick="showManualForm()" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg flex items-center justify-center">
                <i class="fas fa-keyboard mr-2"></i>Manual Input
            </button>
            <button onclick="showVoiceForm()" class="bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded-lg flex items-center justify-center">
                <i class="fas fa-microphone mr-2"></i>Voice Input
            </button>
        </div>
    </div>
</div>
<!-- voice complaintModal.php -->
<div id="voiceComplaintModal" class="hidden fixed inset-0 backdrop-blur-sm flex items-center justify-center z-50">
  <div class="bg-white w-[700px] max-h-[90vh] overflow-y-auto rounded-xl shadow-lg p-8 relative">
    <div class="flex justify-between items-center mb-4 border-b pb-2">
      <h3 id="voiceModalTitle" class="text-lg font-semibold">Voice Complaint</h3>
      <button onclick="document.getElementById('voiceComplaintModal').classList.add('hidden')" class="text-gray-500 hover:text-gray-700">&times;</button>
    </div>

    <div class="mb-4">
  <label for="langSelect" class="block text-sm font-medium">Recognition Language</label>
  <select id="langSelect" class="border rounded p-2 w-full">
    <option value="en-US">English / Taglish (US)</option>
    <option value="en-PH">English (Philippines)</option>
    <option value="tl-PH">Tagalog (Philippines)</option>
  </select>
</div>


    <!-- Start Section -->
    <div id="startSection" class="text-center">
      <h4 class="text-xl font-bold mb-4">Start Voice Complaint</h4>
      <p class="mb-4 text-gray-600">Click the button below to begin answering questions using your voice.</p>
      <button onclick="startVoiceComplaint()" class="bg-green-600 text-white px-6 py-3 rounded-lg font-medium"> 🎤 Start Voice Input </button>
    </div>

    <!-- Question Section -->
    <div id="questionSection" class="text-center">
      <h4 id="questionTitle" class="text-xl font-bold mb-4"></h4>
      <input type="text" id="voiceAnswer" class="w-full border rounded p-2 mb-4" placeholder="Your answer will appear here..." readonly>
      <div class="flex justify-center gap-4">
        <button id="micBtn" onclick="restartRecognition()" class="bg-red-500 text-white px-4 py-2 rounded">🎤 Speak</button>
        <button id="nextBtn" onclick="nextQuestion()" class="bg-blue-500 text-white px-4 py-2 rounded">Next</button>
      </div>
    </div>

    <!-- Review Section -->
    <form id="voiceComplaintForm" action="addComplaint.php" method="POST" class="hidden">
      <h4 class="text-lg font-bold mb-4">Review Complaint</h4>

      <div class="mb-2">
        <label>Complainant Name</label>
        <input type="text" name="c_name" id="reviewComplainant" class="w-full border rounded p-2">
      </div>
      <div class="mb-2">
        <label>Complainant Contact</label>
        <input type="text" name="c_contact" id="reviewComplainantContact" class="w-full border rounded p-2">
      </div>
      <div class="mb-2">
        <label>Complainant Address</label>
        <input type="text" name="c_address" id="reviewComplainantAddress" class="w-full border rounded p-2">
      </div>

      <div class="mb-2">
        <label>Respondent Name</label>
        <input type="text" name="r_name" id="reviewRespondent" class="w-full border rounded p-2">
      </div>
      <div class="mb-2">
        <label>Respondent Contact</label>
        <input type="text" name="r_contact" id="reviewRespondentContact" class="w-full border rounded p-2">
      </div>
      <div class="mb-2">
        <label>Respondent Address</label>
        <input type="text" name="r_address" id="reviewRespondentAddress" class="w-full border rounded p-2">
      </div>

      <div class="mb-2">
        <label>Incident Location</label>
        <input type="text" name="location" id="reviewLocation" class="w-full border rounded p-2">
      </div>

      <div class="mb-2">
        <label>Date & Time</label>
        <input type="text" name="date_time" id="reviewDateTime" class="w-full border rounded p-2">
      </div>

      <div class="mb-2">
        <label>Details</label>
        <textarea name="details" id="reviewDetails" class="w-full border rounded p-2"></textarea>
      </div>

      <div class="mb-2">
        <label>Type of Complaint</label>
        <select name="type" id="reviewType" class="w-full border rounded p-2">
          <option value="">-- Select Type --</option>
          <option value="Physical Injury">Physical Injury</option>
          <option value="Theft">Theft</option>
          <option value="Property Damage">Property Damage</option>
          <option value="Verbal Abuse">Verbal Abuse</option>
        </select>
      </div>

      <div class="flex justify-end gap-2 mt-4">
        <button type="button" onclick="readBackAnswers()" class="bg-yellow-500 text-white px-4 py-2 rounded">
          🔊 Read Back Answers
        </button>
        <button type="button" onclick="document.getElementById('voiceComplaintModal').classList.add('hidden')" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
        <button type="button" class="bg-green-600 text-white px-4 py-2 rounded" onclick="submitVoiceComplaint()">Submit</button>
      </div>
    </form>
  </div>
</div>

<script>

  document.getElementById('voiceComplaintModal').addEventListener('click', function(e) {
  if (e.target === this) { // click outside modal
    resetVoiceComplaint();
  }
});

function resetVoiceComplaint() {
  document.getElementById('startSection').classList.remove('hidden');
  document.getElementById('questionSection').classList.add('hidden');
  document.getElementById('voiceComplaintForm').classList.add('hidden');
  currentQuestion = 0;
}

let recognition;
let currentQuestion = 0;
const questions = [
  { field: 'reviewComplainant', title: 'Complainant Name' },
  { field: 'reviewComplainantContact', title: 'Complainant Contact' },
  { field: 'reviewComplainantAddress', title: 'Complainant Address' },
  { field: 'reviewRespondent', title: 'Respondent Name' },
  { field: 'reviewRespondentContact', title: 'Respondent Contact' },
  { field: 'reviewRespondentAddress', title: 'Respondent Address' },
  { field: 'reviewLocation', title: 'Incident Location' },
  { field: 'reviewDateTime', title: 'Date & Time of Incident' },
  { field: 'reviewDetails', title: 'Details of Complaint' }
];

function startVoiceComplaint() {
  currentQuestion = 0;
  document.getElementById('questionSection').classList.remove('hidden');
  document.getElementById('voiceComplaintForm').classList.add('hidden');
  showQuestion();
  startRecognition();
}

function showQuestion() {
  document.getElementById('questionTitle').textContent = questions[currentQuestion].title;
  document.getElementById('voiceAnswer').value = "";
}

function startRecognition() {
  if (!('webkitSpeechRecognition' in window)) {
    alert("Speech Recognition not supported in this browser.");
    return;
  }

  recognition = new webkitSpeechRecognition();
  recognition.lang = document.getElementById('langSelect') 
      ? document.getElementById('langSelect').value 
      : 'en-US'; // default
  recognition.continuous = true; // keep listening
  recognition.interimResults = true; // get live results

  recognition.onresult = function(event) {
    let transcript = "";
    let confidence = 0;
    for (let i = event.resultIndex; i < event.results.length; i++) {
      transcript += event.results[i][0].transcript;
      confidence = event.results[i][0].confidence;
    }
    document.getElementById('voiceAnswer').value = transcript.trim();
    console.log("Confidence:", confidence);
  };

  recognition.onerror = function(event) {
    console.error("Recognition error:", event.error);
  };

  recognition.onend = function() {
    console.log("Recognition ended, restarting...");
    recognition.start(); // auto-restart for continuous listening
  };

  recognition.start();
}

function stopSpeaking() {
  if ('speechSynthesis' in window) {
    window.speechSynthesis.cancel(); // stop any ongoing speech
  }
}

function restartRecognition() {
  if (recognition) recognition.stop();
  startRecognition();
}

function nextQuestion() {
  const answer = document.getElementById('voiceAnswer').value.trim();
  if (!answer) {
    alert("Please provide an answer before proceeding.");
    return;
  }

  // Save the answer into the mapped review field
  const fieldId = questions[currentQuestion].field;
  document.getElementById(fieldId).value = answer;

  // Go to next question
  currentQuestion++;
  if (currentQuestion < questions.length) {
    showQuestion();
  } else {
document.getElementById('questionSection').classList.add('hidden');
    document.getElementById('voiceComplaintForm').classList.remove('hidden');
  }
}


function showQuestion() {
  const questionText = questions[currentQuestion].title;
  document.getElementById('questionTitle').textContent = questionText;
  document.getElementById('voiceAnswer').value = "";

  // 🔊 Speak the question in English/Tagalog voice
  speakQuestion(questionText, () => {
    setTimeout(() => {
      startRecognition(); // 🎙️ start listening
    }, 700);
  });
}

function speakQuestion(text, callback) {
  if ('speechSynthesis' in window) {
    const utterance = new SpeechSynthesisUtterance(text);
    utterance.lang = 'en-PH'; // 🇵🇭 read in PH English voice
    utterance.onend = function() {
      if (callback) callback();
    };
    window.speechSynthesis.cancel();
    window.speechSynthesis.speak(utterance);
  } else {
    if (callback) callback();
  }
}

// 🔊 Read back all answers in Review Section
function readBackAnswers() {
  if (!('speechSynthesis' in window)) return;

  let summary = "Here are your complaint details. ";
  summary += "Complainant name: " + (document.getElementById('reviewComplainant').value || "not provided") + ". ";
  summary += "Complainant contact: " + (document.getElementById('reviewComplainantContact').value || "not provided") + ". ";
  summary += "Complainant address: " + (document.getElementById('reviewComplainantAddress').value || "not provided") + ". ";
  summary += "Respondent name: " + (document.getElementById('reviewRespondent').value || "not provided") + ". ";
  summary += "Respondent contact: " + (document.getElementById('reviewRespondentContact').value || "not provided") + ". ";
  summary += "Respondent address: " + (document.getElementById('reviewRespondentAddress').value || "not provided") + ". ";
  summary += "Incident location: " + (document.getElementById('reviewLocation').value || "not provided") + ". ";
  summary += "Date and time: " + (document.getElementById('reviewDateTime').value || "not provided") + ". ";
  summary += "Details: " + (document.getElementById('reviewDetails').value || "not provided") + ". ";

  const utterance = new SpeechSynthesisUtterance(summary);
  utterance.lang = 'en-US';
  window.speechSynthesis.cancel();
  window.speechSynthesis.speak(utterance);
}

function submitVoiceComplaint() {
    stopSpeaking();
    const form = document.getElementById('voiceComplaintForm');
    const formData = new FormData(form);
    
    fetch('addComplaint.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('voiceComplaintModal').classList.add('hidden');
            window.location.href = 'complaints.php';
        } else {
            alert(data.message || 'Error submitting complaint');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while submitting the complaint');
    });
}

// Function to open the restore complaint modal
function openRestoreModal(id, complainantName) {
  document.getElementById('restoreComplaintId').value = id;
  document.getElementById('restoreComplaintText').textContent = `Are you sure you want to restore this complaint by ${complainantName}?`;
  document.getElementById('restoreComplaintModal').classList.remove('hidden');
}

// Example JavaScript function to open the edit modal (add/update this)
function openEditModal(complaint) {
  document.getElementById('editComplaintId').value = complaint.id;
  document.getElementById('editCName').value = complaint.complainant; 
  document.getElementById('editCAddress').value = complaint.c_address; // Corrected key
  document.getElementById('editCContact').value = complaint.c_contact; // Corrected key
  document.getElementById('editRName').value = complaint.respondent; 
  document.getElementById('editRAddress').value = complaint.r_address; // Corrected key
  document.getElementById('editRContact').value = complaint.r_contact; // Corrected key
  document.getElementById('editType').value = complaint.type;
  document.getElementById('editLocation').value = complaint.location;
  document.getElementById('editDetails').value = complaint.details;
  
  // Format date_time for datetime-local input
  const dateTime = new Date(complaint.date_time);
  const year = dateTime.getFullYear();
  const month = (dateTime.getMonth() + 1).toString().padStart(2, '0');
  const day = dateTime.getDate().toString().padStart(2, '0');
  const hours = dateTime.getHours().toString().padStart(2, '0');
  const minutes = dateTime.getMinutes().toString().padStart(2, '0');
  document.getElementById('editDateTime').value = `${year}-${month}-${day}T${hours}:${minutes}`;

  document.getElementById('editStatus').value = complaint.status;
  
  document.getElementById('editComplaintModal').classList.remove('hidden');
}
</script>


<!-- manual input form modal -->
<div id="manualComplaintModal" class="hidden fixed inset-0 backdrop-blur-sm flex justify-center items-center z-50">
    <div class="relative mx-auto p-6 w-full max-w-md shadow-lg rounded-lg bg-white animate-fade-in max-h-screen overflow-y-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4 border-b pb-2">
            <h3 class="text-lg font-semibold">Add New Complaint</h3>
            <button onclick="document.getElementById('manualComplaintModal').classList.add('hidden')" 
                    class="text-gray-500 hover:bg-gray-200 rounded-full p-2">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Form -->
        <form id="complaintForm" action="addComplaint.php" method="POST" class="space-y-4">
            <!-- Complainant -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="c_name" class="block text-sm font-medium text-gray-600">Complainant Name</label>
                    <input name="c_name" id="c_name" type="text" required
                        class="w-full border rounded px-2 py-1 focus:ring focus:ring-indigo-300 focus:outline-none">
                </div>
                <div>
                    <label for="c_contact" class="block text-sm font-medium text-gray-600">Contact</label>
                    <input name="c_contact" id="c_contact" type="text" required
                        class="w-full border rounded px-2 py-1 focus:ring focus:ring-indigo-300 focus:outline-none">
                </div>
            </div>
            <div>
                <label for="c_address" class="block text-sm font-medium text-gray-600">Address</label>
                <input name="c_address" id="c_address" type="text" required
                    class="w-full border rounded px-2 py-1 focus:ring focus:ring-indigo-300 focus:outline-none">
            </div>

            <hr class="border-gray-200">

            <!-- Respondent -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="r_name" class="block text-sm font-medium text-gray-600">Respondent Name</label>
                    <input name="r_name" id="r_name" type="text" required
                        class="w-full border rounded px-2 py-1 focus:ring focus:ring-indigo-300 focus:outline-none">
                </div>
                <div>
                    <label for="r_contact" class="block text-sm font-medium text-gray-600">Contact</label>
                    <input name="r_contact" id="r_contact" type="text" required
                        class="w-full border rounded px-2 py-1 focus:ring focus:ring-indigo-300 focus:outline-none">
                </div>
            </div>
            <div>
<label for="r_address" class="block text-sm font-medium text-gray-600">Address</label>
                <input name="r_address" id="r_address" type="text" required
                    class="w-full border rounded px-2 py-1 focus:ring focus:ring-indigo-300 focus:outline-none">
            </div>

            <hr class="border-gray-200">

            <!-- Incident -->
            <div>
                <label for="details" class="block text-sm font-medium text-gray-600">Incident Details</label>
                <textarea name="details" id="details" rows="4" required
                    class="w-full border rounded px-2 py-1 focus:ring focus:ring-indigo-300 focus:outline-none"></textarea>
            </div>
            <div>
                <label for="date_time" class="block text-sm font-medium text-gray-600">Incident Date & Time</label>
                <input name="date_time" id="date_time" type="datetime-local" required
                    class="w-full border rounded px-2 py-1 focus:ring focus:ring-indigo-300 focus:outline-none">
            </div>
            <div>
                <label for="location" class="block text-sm font-medium text-gray-600">Incident Location</label>
                <input name="location" id="location" type="text" required
                    class="w-full border rounded px-2 py-1 focus:ring focus:ring-indigo-300 focus:outline-none">
            </div>
            
            <!-- type -->
            <div>
                <label for="type" class="block text-sm font-medium text-gray-600">Incident Type</label>
                <select name="type" id="type" required
                    class="w-full border rounded px-2 py-1 focus:ring focus:ring-indigo-300 focus:outline-none">
                    <option value="" disabled selected>Select Type</option>
                    <option value="Theft">Theft</option>
                    <option value="Vandalism">Vandalism</option>
                    <option value="Assault">Assault</option>
                    <option value="Domestic Dispute">Domestic Dispute</option>
                    <option value="Noise Complaint">Noise Complaint</option>
                    <option value="Others">Others</option>
                </select>
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

        

            <!-- Actions -->
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="window.location.href='complaints.php'" 
        class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium py-2 px-4 rounded">
    Cancel
</button>

                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded" id="submitBtn">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Handle form submission
const complaintForm = document.getElementById('complaintForm');
if (complaintForm) {
    complaintForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Disable submit button to prevent multiple submissions
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Submitting...';
        
        // Submit form via fetch
        fetch('addComplaint.php', {
            method: 'POST',
            body: new FormData(this)
        })
        .then(response => response.json())
        .then(data => {
if (data.success) {
                alert('Complaint submitted successfully!');
                document.getElementById('manualComplaintModal').classList.add('hidden');
                location.reload(); // Refresh to show new complaint
            } else {
                alert(data.message || 'Error submitting complaint');
}
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while submitting the complaint');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Submit';
        });
    });
}
</script>

<!-- archived case modal -->
<div id="archivedModal" class="hidden fixed inset-0 backdrop-blur-sm -mt-13 h-full w-full">
    <div class="relative top-20 mx-auto p-5 drop-shadow-lg w-fit shadow-lg rounded-md animate-fade-in bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Archived</h3>
            <button onclick="document.getElementById('archivedModal').classList.add('hidden')" class="text-gray-500 rounded-full hover:bg-gray-500 px-3 p-2 hover:text-white">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class=" my-3">
          <button onclick="document.getElementById('addArchivedModal').classList.remove('hidden')" class="bg-gray-400 hover:bg-gray-500 text-white px-3 py-1 text-md rounded-lg transition-colors"><i class="fas fa-plus mr-2"></i>Archive</button>
        </div>
        <!-- archived case table -->
        <table>
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Case No.</th>
                    <th class="px-4 py-2">Complainant</th>
                    <th class="px-4 py-2">Respondent</th>
                    <th class="px-4 py-2">Incident Date</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody id="archivedTableBody">
                <?php

                foreach ($archivedcomplaints as $archivedComplaint):  
                    if ($archivedComplaint['status'] == 'archived'):
                ?>
                <tr>
                    <?php static $rowNum = 1; ?>
                    <td class="border-y border-gray-200 px-4 py-2"><?php echo $rowNum++; ?></td>
                    <td class="border-y border-gray-200 px-4 py-2">C-<?php echo htmlspecialchars($archivedComplaint['id']); ?></td>
                    <td class="border-y border-gray-200 px-4 py-2"><?php echo htmlspecialchars($archivedComplaint['complainant']); ?></td>
                    <td class="border-y border-gray-200 px-4 py-2"><?php echo htmlspecialchars($archivedComplaint['respondent']); ?></td>
                    <?php 
                        $dateTime = new DateTime($archivedComplaint['date']);
                        $date = $dateTime->format('m-d-Y');
                        $time = $dateTime->format('H:i');
                    ?>
<td class="border-y border-gray-200 px-4 py-2"><?php echo htmlspecialchars($date); ?></td>
                    <td class="border-y border-gray-200 px-4 py-2"><?php echo htmlspecialchars($archivedComplaint['status']); ?></td>
                    <td class="border-y border-gray-200 px-4 py-2">
<button onclick="openRestoreModal(<?= $archivedComplaint['id'] ?>)" class="bg-green-600 text-white px-3 py-1 rounded">Restore</button>
<button onclick="document.getElementById('viewArchivedViewModal').classList.remove('hidden'); openArchiveViewModal(<?= htmlspecialchars(json_encode($archivedComplaint)) ?>)" class="bg-indigo-600 text-white px-3 py-1 rounded">View</button>
                    </td>
                </tr>
                <?php
                    endif;
                endforeach;
                ?>
            </tbody>
</table>
</div>
</div>

<!-- Archive Complaints Modal -->
<div id="addArchivedModal" class="hidden fixed inset-0 backdrop-blur-sm flex justify-center items-center z-50">
  <div class="relative mx-auto p-6 w-[800px] shadow-lg rounded-lg bg-white animate-fade-in">
    
    <!-- Header -->
    <div class="flex justify-between items-center mb-4 border-b pb-2">
      <h3 class="text-lg font-semibold">Archive Complaints</h3>
      <button onclick="document.getElementById('addArchivedModal').classList.add('hidden')" 
              class="text-gray-500 hover:bg-gray-200 rounded-full p-2">
        <i class="fas fa-times"></i>
      </button>
    </div>

    <!-- Filter -->
    <div class="flex items-center gap-3 mb-3">
      <label for="archiveMonth" class="font-medium text-sm">Filter by Month:</label>
      <input type="month" id="archiveMonth" class="border px-3 py-2 rounded" onchange="filterArchiveTable()">
</div>

    <!-- Table -->
    <form id="archiveForm" action="archiveComplaint.php" method="POST">
      <div class="overflow-y-auto max-h-[400px] border rounded">
        <table class="min-w-full text-sm text-left">
          <thead class="bg-gray-100 sticky top-0">
            <tr>
              <th class="px-4 py-2"><input type="checkbox" id="checkAll"></th>
              <th class="px-4 py-2">Case No.</th>
              <th class="px-4 py-2">Complainant</th>
              <th class="px-4 py-2">Respondent</th>
<th class="px-4 py-2">Type</th>
              <th class="px-4 py-2">Date</th>
            </tr>
          </thead>
          <tbody id="archiveTableBody">
            <?php
            require 'config.php';
$stmt = $conn->query("SELECT id, c_name, r_name, type, date_time FROM complaint WHERE status='active'");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
              <tr class="border-b">
                <td class="px-4 py-2">
                  <input type="checkbox" name="complaint_ids[]" value="<?= $row['id'] ?>">
                </td>
                <td class="px-4 py-2">C-<?= $row['id'] ?></td>
                <td class="px-4 py-2"><?= htmlspecialchars($row['c_name']) ?></td>
                <td class="px-4 py-2"><?= htmlspecialchars($row['r_name']) ?></td>
                <td class="px-4 py-2"><?= htmlspecialchars($row['type']) ?></td>
                <td class="px-4 py-2"><?= date('Y-m-d', strtotime($row['date_time'])) ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>

      <!-- Actions -->
      <div class="flex justify-end mt-4 gap-2">
        <button type="button" onclick="document.getElementById('addArchivedModal').classList.add('hidden')" 
                class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded">
          Cancel
        </button>
        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
          Archive Selected
        </button>
      </div>
    </form>
</div>
</div>

<!-- View Archived Complaint Modal -->
<div id="viewArchivedViewModal" class="hidden fixed inset-0 backdrop-blur-sm flex items-center justify-center z-50">
  <div class="bg-white w-[850px] max-h-[90vh] overflow-y-auto rounded-xl shadow-lg p-8 relative animate-fade-in">
    <div class="flex justify-between items-center mb-4 border-b pb-2">
      <h3 class="text-lg font-semibold">View Archived Complaint</h3>
      <button onclick="document.getElementById('viewArchivedViewModal').classList.add('hidden')" 
        class="text-gray-500 hover:bg-gray-200 rounded-full p-2">
        <i class="fas fa-times"></i>
      </button>
    </div>

    <!-- Header Fields -->
    <div class="grid grid-cols-2 gap-4 mb-6">
      <div>
        <p class="mb-3"><span class="font-semibold">Complainant(s):</span> <span id="viewArchivedComplainant" class="ml-2 text-gray-700"></span></p>
        <p><span class="font-semibold">Respondent(s):</span> <span id="viewArchivedRespondent" class="ml-2 text-gray-700"></span></p>
      </div>
      <div>
        <p class="mb-3"><span class="font-semibold">Barangay Case No.:</span>C- <span id="viewArchivedCaseNo" class="ml-2 text-gray-700"></span></p>
        <p><span class="font-semibold">For:</span> <span id="viewArchivedFor" class="ml-2 text-gray-700"></span></p>
</div>
    </div>

    <!-- Title -->
    <h2 class="text-center font-bold underline text-lg mb-6">COMPLAINT SHEET</h2>

    <!-- Complaint Body -->
    <div id="viewArchivedComplaintDetails" class="w-full min-h-[300px] border border-gray-400 rounded leading-5 text-start px-4 whitespace-pre-line text-gray-800 pt-3">
      <p></p>
    </div>

    <!-- Footer -->
    <div class="mt-8 text-sm">
      <p class="mb-6">
        Subscribed and sworn to me before this 
        <span id="viewArchivedDay" class="mx-1 inline-block border-b border-black w-24 text-center"></span>    
        day of 
        <span id="viewArchivedMonth" class="mx-1 inline-block border-b border-black w-32 text-center"></span>
        at Barangay Sta. Monica.
      </p>

      <div class="flex justify-between mt-12">
        <div class="w-60">
          <p class="text-center">
            <span id="viewArchivedCreatedBy" class="text-center"></span>
            <hr>
            <span class="border-t border-black text-center">Received By</span>
          </p>
        </div>
        <div class="w-60">
          <p class="text-center">
            <span id="viewArchivedComplainantFooter" class="text-center"></span>
              <hr>
            <span class="border-t border-black text-center">
              Complainant
            </span>
          </p>
        </div>
      </div>

      <p class="mt-10">Control No.: <span id="viewArchivedControlNo" class="ml-2"></span></p>
    </div>
  </div>
</div>




<!-- restore -->
<div id="restoreComplaintModal" class="hidden fixed inset-0 backdrop-blur-sm w-full flex justify-center h-full">
  <div class="bg-white rounded-md shadow-lg w-fit h-fit p-6 relative border-gray-200 animate-fade-in border-2 mt-20">
    <h2 class="text-lg font-bold mb-4">Restore Complaint</h2>
    <p id="restoreComplaintText" class="mb-4">Are you sure you want to restore this complaint?</p>
    <!-- Add this hidden input field -->
    <input type="hidden" id="restoreComplaintId" name="id">
    <div class="flex justify-end gap-2">
      <button onclick="document.getElementById('restoreComplaintModal').classList.add('hidden')" class="bg-gray-400 text-white px-4 py-2 rounded">Cancel</button>
      <button id="confirmRestoreBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Restore</button>
    </div>
  </div>
</div>

<!-- View Complaint Modal -->
<div id="viewComplaintModal" class="hidden fixed inset-0 backdrop-blur-sm flex items-center justify-center z-50">
  <div class="bg-white w-[700px] max-h-[90vh] overflow-y-auto rounded-xl shadow-lg p-8 relative animate-fade-in">
    <div class="flex justify-between items-center mb-4 border-b pb-2">
      <h3 class="text-lg font-semibold">View Complaint</h3>
      <button onclick="document.getElementById('viewComplaintModal').classList.add('hidden')" 
        class="text-gray-500 hover:bg-gray-200 rounded-full p-2">
        <i class="fas fa-times"></i>
      </button>
    </div>

    <form id="viewComplaintForm">
      <input type="hidden" id="viewComplaintId">

      <div class="grid grid-cols-2 gap-4">
        <!-- Complainant -->
        <div>
          <label class="block text-sm font-medium text-gray-700">Complainant</label>
          <input type="text" id="viewCName" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100" readonly>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Respondent</label>
          <input type="text" id="viewRName" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100" readonly>
        </div>
      </div>

      <div class="grid grid-cols-2 gap-4 mt-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Type</label>
          <input type="text" id="viewtype" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100" readonly>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Location</label>
          <input type="text" id="viewlocation" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100" readonly>
        </div>
      </div>

      <div class="mt-4">
        <label class="block text-sm font-medium text-gray-700">Details</label>
        <textarea id="viewdetails" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100" readonly></textarea>
      </div>

      <div class="flex justify-end mt-6 gap-2">
        <button type="button" onclick="document.getElementById('viewComplaintModal').classList.add('hidden')" class="bg-gray-400 text-white px-4 py-2 rounded">Close</button>
      </div>
    </form>
  </div>
</div>

<!-- Edit Complaint Modal -->
<div id="editComplaintModal" class="hidden fixed inset-0 backdrop-blur-sm flex items-center justify-center z-50">
  <div class="bg-white w-[700px] max-h-[90vh] overflow-y-auto rounded-xl shadow-lg p-8 relative animate-fade-in">
    <h2 class="text-lg font-bold mb-4">Edit Complaint</h2>
    
    <form id="editComplaintForm" method="POST" action="updateComplaint.php">
      <input type="hidden" id="editComplaintId" name="id">

      <div class="grid grid-cols-2 gap-4">
        <!-- Complainant -->
        <div>
          <label class="block text-sm font-medium text-gray-700">Complainant Name</label>
          <input type="text" id="editCName" name="complainant_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        </div>
        <!-- Respondent -->
        <div>
          <label class="block text-sm font-medium text-gray-700">Respondent Name</label>
          <input type="text" id="editRName" name="respondent_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        </div>
      </div>

      <div class="grid grid-cols-2 gap-4 mt-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Type</label>
          <input type="text" id="editType" name="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Location</label>
          <input type="text" id="editLocation" name="location" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        </div>
      </div>

      <div class="mt-4">
        <label class="block text-sm font-medium text-gray-700">Details</label>
        <textarea id="editDetails" name="details" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
      </div>

      <!-- Date & Time Field -->
      <div class="mt-4">
        <label class="block text-sm font-medium text-gray-700">Date & Time</label>
        <input type="datetime-local" id="editDateTime" name="date_time" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
      </div>

      <!-- Editable Status -->
      <div class="mt-4">
        <label class="block text-sm font-medium text-gray-700">Status</label>
        <select id="editStatus" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
          <option value="active">Active</option>
          <option value="archived">Archived</option>
          <option value="transfer">Transfer</option>
        </select>
      </div>

      <div class="flex justify-end mt-6 gap-2">
        <button type="button" onclick="document.getElementById('editComplaintModal').classList.add('hidden')" class="bg-gray-400 text-white px-4 py-2 rounded">Cancel</button>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Save</button>
      </div>
    </form>
  </div>
</div>

<script>
  // Check all functionality
  document.getElementById('checkAll').addEventListener('change', function () {
    document.querySelectorAll('#archiveTableBody input[type="checkbox"]').forEach(cb => cb.checked = this.checked);
  });

  // Voice Form Functionality
function showVoiceForm() {
  const modal = document.getElementById('voiceComplaintModal');
  if (modal) {
    modal.classList.remove('hidden');
  }
}

function showManualForm() {
  const modal = document.getElementById('manualComplaintModal');
  if (modal) {
    modal.classList.remove('hidden');
  }
}

function filterArchiveTable() {
    var monthInput, typeInput, monthFilter, typeFilter, table, tr, tdMonth, tdType, i, monthTxtValue, typeTxtValue;
    
    monthInput = document.getElementById("archiveMonth");
    monthFilter = monthInput.value; // e.g., "2023-10"

    typeInput = document.getElementById("archiveType");
    typeFilter = typeInput.trim().toLowerCase(); // Trim and convert to lowercase

    table = document.getElementById("archiveTableBody");
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
        // Date is in the 6th column (index 5)
        tdMonth = tr[i].getElementsByTagName("td")[5]; 
        // Type is in the 5th column (index 4)
        tdType = tr[i].getElementsByTagName("td")[4];

        var showRow = true;

        if (tdMonth) {
            monthTxtValue = tdMonth.textContent || tdMonth.innerText;
            var rowMonth = monthTxtValue.substring(0, 7); // "YYYY-MM"
            if (monthFilter !== "" && rowMonth !== monthFilter) {
                showRow = false;
            }
        } else {
            showRow = false; // Hide row if date column is missing
        }

        if (tdType) {
            typeTxtValue = (tdType.textContent || tdType.innerText).trim().toLowerCase(); // Trim and convert to lowercase
            if (typeFilter !== "" && typeTxtValue !== typeFilter) {
                showRow = false;
            }
        } else {
            showRow = false; // Hide row if type column is missing
        }
        
        if (showRow) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }
    }
}

// Handle edit form submission
const editForm = document.getElementById('editComplaintForm');
if (editForm) {
    editForm.addEventListener('submit', function(e) {
        e.preventDefault();
        console.log('Edit form submitted.'); // Debug: Form submission detected
        
        fetch(this.action, {
            method: 'POST',
            body: new FormData(this)
        })
        .then(res => res.json())
        .then(data => {
            console.log('Server response:', data); // Debug: Log server response
            if (data.success) {
                const complaintId = document.getElementById('editComplaintId').value;
                const tableBody = document.getElementById('complaintTableBody');
                console.log('Complaint ID:', complaintId); // Debug: Log complaint ID
                console.log('Table Body found:', tableBody); // Debug: Check if tableBody is found

                if (tableBody) {
                    const rows = tableBody.getElementsByTagName('tr');
                    let rowFound = false;
                    for (let i = 0; i < rows.length; i++) {
                        const row = rows[i];
                        const caseNumberCell = row.cells[1]; 
                        if (caseNumberCell && caseNumberCell.textContent.trim() === `C-${complaintId}`) {
                            rowFound = true;
                            console.log('Row found for Complaint ID:', complaintId, row); // Debug: Log the found row

                            const newStatus = document.getElementById('editStatus').value;
                            console.log('New Status:', newStatus); // Debug: Log the new status

                            if (newStatus === 'archived') {
                                // If status is archived, remove the row from the table
                                row.remove();
                                console.log('Row removed due to archived status.');
                            } else {
                                // Update the row with new data from the form
                                row.cells[2].textContent = document.getElementById('editCName').value; // Complainant
                                row.cells[3].textContent = document.getElementById('editRName').value; // Respondent
                                row.cells[4].textContent = document.getElementById('editType').value; // Incident Type
                                row.cells[6].textContent = document.getElementById('editLocation').value; // Incident Location
                                console.log('Row content updated.');
                            }
                            break;
                        }
                    }
                    if (!rowFound) {
                        console.log('No matching row found in the table for Complaint ID:', complaintId);
                    }
                }

                document.getElementById('editComplaintModal').classList.add('hidden');
                alert(data.message); // Display success message
            } else {
                alert(data.message || 'Error updating complaint');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating the complaint');
        });
    });
}

// Function to open the restore complaint modal
function openRestoreModal(id) {
  document.getElementById('restoreComplaintId').value = id;
  document.getElementById('restoreComplaintModal').classList.remove('hidden');
}

// Function to open the archive view modal
function openArchiveViewModal(id) {
  // In a real application, you would fetch the archived complaint details using the ID
  // and populate the viewArchivedViewModal with that data.
  // For now, we'll just show the modal and set a placeholder ID.
  document.getElementById('viewArchivedComplaintId').textContent = id; // Assuming you have an element to display the ID
  document.getElementById('viewArchivedViewModal').classList.remove('hidden');
}

// Handle restore complaint confirmation
const confirmRestoreBtn = document.getElementById('confirmRestoreBtn');
if (confirmRestoreBtn) {
    confirmRestoreBtn.addEventListener('click', function() {
        const complaintId = document.getElementById('restoreComplaintId').value;
        
        fetch('restoreComplaint.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=${complaintId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                document.getElementById('restoreComplaintModal').classList.add('hidden');
                // Optionally, refresh the page or remove the row from the archived table
                location.reload(); // This will refresh the page to show the updated status
            } else {
                alert(data.message || 'Error restoring complaint');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while restoring the complaint');
        });
    });
}
</script>
</body>
</html>