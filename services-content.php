<?php
// services-content.php - This contains only the services content
?>
<div class="py-3 px-10 rounded-sm">
    <h1 class="text-2xl font-semibold text-gray-600 mb-2">Our Services:</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
        <!-- Blotter Service -->
        <div class="bg-white rounded-md shadow-lg py-20 px-10">
            <div class="flex items-center gap-4 mb-4">
                <i class="fa-solid fa-scale-balanced text-3xl"></i>
                <h3 class="text-4xl font-semibold">Barangay Blotter</h3>
            </div>
            <p class="text-gray-600 text-xl mb-4">View reported incidents and blotter records for Barangay Sta. Monica.</p>
            <button onclick="openAdminOnlyModal()" class="bg-gray-400 hover:bg-gray-700 text-xl text-white px-4 py-2 rounded-md hover:bg-blue-700 inline-block">Open Blotter</button>
        </div>

        <!-- Complaint Service -->
        <div class="bg-white rounded-md shadow-lg py-20 px-10">
            <div class="flex items-center gap-4 mb-4">
                <i class="fa-solid fa-file-pen text-3xl"></i>
                <h3 class="text-4xl font-semibold">Complaint Request</h3>
            </div>
            <p class="text-gray-600 text-xl mb-4">File a complaint or follow up on an existing complaint with barangay officials.</p>
            <button onclick="openInputMethodModal()" class="bg-gray-400 text-white text-xl px-4 py-2 rounded-md hover:bg-gray-700 inline-block">Make a Complaint</button>
        </div>
    </div>
</div>

<!-- Admin Only Modal -->
<div id="adminOnlyModal" class="hidden fixed inset-0 z-50 backdrop-blur-sm overflow-y-auto h-full w-full">
    <div class="relative top-1/4 mx-auto p-5 drop-shadow-lg w-full max-w-md shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4 border-b pb-2">
            <h3 class="text-xl font-bold text-gray-900">Access Denied</h3>
            <button onclick="document.getElementById('adminOnlyModal').classList.add('hidden')" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        <div class="text-center">
            <p class="text-gray-700">Only an admin can access this feature.</p>
        </div>
    </div>
</div>

<!-- Input Method Selection Modal -->
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

<!-- Voice Complaint Modal -->
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
    <div id="questionSection" class="hidden text-center">
      <h4 id="questionTitle" class="text-xl font-bold mb-4"></h4>
      <input type="text" id="voiceAnswer" class="w-full border rounded p-2 mb-4" placeholder="Your answer will appear here..." readonly>
      <div class="flex justify-center gap-4">
        <button id="micBtn" onclick="restartRecognition()" class="bg-red-500 text-white px-4 py-2 rounded">🎤 Speak</button>
        <button id="nextBtn" onclick="nextQuestion()" class="bg-blue-500 text-white px-4 py-2 rounded">Next</button>
      </div>
    </div>

    <!-- Review Section -->
    <form id="voiceComplaintForm" action="../addComplaint.php" method="POST" class="hidden">
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
    function openAdminOnlyModal() {
        document.getElementById('adminOnlyModal').classList.remove('hidden');
    }

    function openInputMethodModal() {
        document.getElementById('inputMethodModal').classList.remove('hidden');
    }

    function showVoiceForm() {
        document.getElementById('inputMethodModal').classList.add('hidden');
        document.getElementById('voiceComplaintModal').classList.remove('hidden');
    }

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
        document.getElementById('startSection').classList.add('hidden');
        document.getElementById('questionSection').classList.remove('hidden');
        document.getElementById('voiceComplaintForm').classList.add('hidden');
        showQuestion();
        startRecognition();
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
            if (currentQuestion < questions.length) {
                recognition.start(); // auto-restart for continuous listening
            }
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
            if (recognition) recognition.stop();
        }
    }

    function speakQuestion(text, callback) {
        if ('speechSynthesis' in window) {
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.onend = callback;
            window.speechSynthesis.speak(utterance);
        } else {
            callback();
        }
    }

    function readBackAnswers() {
        let textToRead = "";
        questions.forEach(q => {
            const answer = document.getElementById(q.field).value;
            textToRead += `${q.title}: ${answer}. `;
        });
        speakQuestion(textToRead, () => {});
    }

    function submitVoiceComplaint() {
        document.getElementById('voiceComplaintForm').submit();
    }
</script>