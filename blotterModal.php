<?php
include 'config.php';

// Fetch resolved blotters for the Resolved Modal
$sql_resolved = "SELECT id, c_name AS complainant, r_name AS respondent, type AS blotter_type, details AS incident_details, date_time AS date_reported
FROM blotter 
WHERE status = 'resolved'
ORDER BY date_time DESC";
$result = $conn->query($sql_resolved);
?>


<!--add Modal -->
<div id="addBlotterModal" class="hidden fixed inset-0 z-50 backdrop-blur-sm overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 drop-shadow-lg w-full max-w-2xl shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4 border-b pb-2">
            <h3 class="text-xl font-bold text-gray-900">Add New Blotter</h3>
            <button onclick="document.getElementById('addBlotterModal').classList.add('hidden')" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <form id="addBlotterForm" class="space-y-4" onsubmit="event.preventDefault(); submitBlotterForm();">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="complainant">Complainant</label>
                    <input id="complainant" name="c_name" type="text" required placeholder="Enter Fullname"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="respondent">Respondent</label>
                    <input id="respondent" name="r_name" type="text" required placeholder="Enter Fullname"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="complainant_contact">Complainant Contact</label>
                    <input id="complainant_contact" name="c_contact" type="text" placeholder="Enter Phone Number (10-11 digits)"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="respondent_contact">Respondent Contact</label>
                    <input id="respondent_contact" name="r_contact" type="text" placeholder="Enter Phone Number (10-11 digits)"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="complainant_address">Complainant Address</label>
                    <input id="complainant_address" name="c_address" rows="2" required placeholder="Enter Address"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500"></input>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="respondent_address">Respondent Address</label>
                    <input id="respondent_address" name="r_address" rows="2" required placeholder="Enter Address"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500"></input>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1" for="details">Blotter Details</label>
                <div class="flex items-start gap-2">
                    <textarea id="details" name="details" rows="5" required placeholder="Enter Incident Details"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500 resize-y"></textarea>
                </div>
            </div>

            <div>
                <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Incident Location</label>
                <div>
                    <input type="text" name="location" id="location" required placeholder="Enter Incident Location"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <div>
                <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date of Incident</label>
                <div>
                    <input class="border p-2 rounded-sm border-gray-300" type="date" name="date" id="date">
                </div>
            </div>

            <div>
                <label class="block">Blotter Type</label>
                <select name="type" class="border border-gray-300 rounded-sm p-2 w-full mb-3" required>
                    <option value="">-- Select Type --</option>
                    <option value="Theft">Theft</option>
                    <option value="Assault">Assault</option>
                    <option value="Property Damage">Property Damage</option>
                    <option value="Dispute">Dispute</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="flex justify-end pt-2">
                <button type="button" onclick="document.getElementById('addBlotterModal').classList.add('hidden')" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg mr-2 transition-colors">Cancel</button>
                <button type="submit" id="submitBlotterBtn" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">Submit</button>
<script>
async function submitBlotterForm() {
    const form = document.getElementById('addBlotterForm');
    const submitBtn = document.getElementById('submitBlotterBtn');
    
    // Clear previous errors
    document.querySelectorAll('.error-message').forEach(el => el.remove());
    document.querySelectorAll('.border-red-500').forEach(el => 
        el.classList.remove('border-red-500'));
    
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Submitting...';
    
    try {
        const formData = new FormData(form);
        const response = await fetch('http://localhost/barangay/save_blotter.php', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        
        if (!response.ok) {
            // Handle validation errors
            if (data.errors) {
                Object.entries(data.errors).forEach(([field, message]) => {
                    const input = form.querySelector(`[name="${field}"]`);
                    if (input) {
                        input.classList.add('border-red-500');
                        const errorEl = document.createElement('p');
                        errorEl.className = 'error-message text-red-500 text-xs mt-1';
                        errorEl.textContent = message;
                        input.parentNode.appendChild(errorEl);
                    }
                });
                showToast('Please fix the highlighted errors', 'error');
            } else {
                showToast(data.error || 'Error submitting blotter', 'error');
            }
            return;
        }
        
        // Success - close modal and refresh data
        document.getElementById('addBlotterModal').classList.add('hidden');
        showToast(data.message || 'Blotter added successfully');
        window.location.reload();
    } catch (error) {
        showToast('Network error. Please check your connection.', 'error');
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Submit';
    }
}
</script>
            </div>
        </form>
    </div>
</div>

<!-- Archived Blotter View Modal -->
<div id="archivedBlotterViewModal" class="fixed hidden inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Archived Blotter Details</h3>
            <div class="mt-2 px-7 py-3">
                <div class="text-left mb-4">
                    <p class="text-sm text-gray-500">ID: <span id="archivedBlotterId"></span></p>
                    <p class="text-sm text-gray-500">Complainant: <span id="archivedBlotterComplainant"></span></p>
                    <p class="text-sm text-gray-500">Respondent: <span id="archivedBlotterRespondent"></span></p>
                    <p class="text-sm text-gray-500">Status: <span id="archivedBlotterStatus"></span></p>
                    <p class="text-sm text-gray-500">Details: <span id="archivedBlotterDetails"></span></p>
                </div>
            </div>
            <div class="items-center px-4 py-3">
                <button onclick="document.getElementById('archivedBlotterViewModal').classList.add('hidden')" 
                    class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function openArchivedBlotterViewModal(blotter) {
    const modal = document.getElementById('archivedBlotterViewModal');
    if (!modal) return;
    
    const idEl = document.getElementById('archivedBlotterId');
    const complainantEl = document.getElementById('archivedBlotterComplainant');
    const respondentEl = document.getElementById('archivedBlotterRespondent');
    const statusEl = document.getElementById('archivedBlotterStatus');
    const detailsEl = document.getElementById('archivedBlotterDetails');
    
    if (idEl) idEl.textContent = blotter.id || 'N/A';
    if (complainantEl) complainantEl.textContent = blotter.c_name || 'N/A';
    if (respondentEl) respondentEl.textContent = blotter.r_name || 'N/A';
    if (statusEl) statusEl.textContent = blotter.status || 'N/A';
    if (detailsEl) detailsEl.textContent = blotter.details || 'N/A';
    
    modal.classList.remove('hidden');
}
</script>

<!-- Resolved Cases Modal -->
 <?php
// ensure variables exist to avoid undefined variable warnings
$resolved ??= [];
$offset ??= 0;
?>
<div id="resolvedBlotterModal" class="hidden fixed inset-0 backdrop-blur-sm z-50 flex justify-center" >
  <div class="bg-white rounded-lg p-6 pb-30 shadow-lg w-full max-w-4xl mt-10 h-3/4" >
    <h2 class="text-xl font-bold mb-4">Resolved Blotters</h2>
    <div class="overflow-y-auto h-full">
      <table class="w-full">
        <thead>
          <tr class="bg-gray-100">
            <th class="p-2 border-b border-gray-200">#</th>
            <th class="p-2 border-b border-gray-200">Blotter No.</th>
            <th class="p-2 border-b border-gray-200">Complainant</th>
            <th class="p-2 border-b border-gray-200">Respondent</th>
            <th class="p-2 border-b border-gray-200">Type</th>
            <th class="p-2 border-b border-gray-200">Date Reported</th>
            <th class="p-2 border-b border-gray-200">Action</th>
          </tr>
        </thead>
        <tbody>
        <?php if ($result && $result->rowCount() > 0): ?>
            <?php $rowCountIndex = 0; ?>
            <?php while($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td class="px-3 py-2 border-b border-gray-300"><?= ++$rowCountIndex; ?></td>
                <td class="p-2 border-b border-gray-200">B-<?= htmlspecialchars($row['id']); ?></td>
                <td class="p-2 border-b border-gray-200"><?= htmlspecialchars($row['complainant']); ?></td>
                <td class="p-2 border-b border-gray-200"><?= htmlspecialchars($row['respondent']); ?></td>
                <td class="p-2 border-b border-gray-200"><?= htmlspecialchars($row['blotter_type']); ?></td>
                <td class="p-2 border-b border-gray-200"><?= htmlspecialchars($row['date_reported']); ?></td>
                <td class="p-2 border-b border-gray-200">
                    <button class="text-blue-600" onclick="openResolvedViewModal(<?= (int)$row['id'] ?>)">View</button>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" class="p-2 text-center text-gray-500">No resolved cases found.</td>
            </tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>

    <div class="flex justify-end mt-4">
      <button onclick="closeResolvedBlotterModal()" class="bg-gray-300 px-4 py-2 rounded">Close</button>
    </div>
  </div>
</div>

<!-- Print Options Modal -->
<div id="printOptionsModal" class="hidden fixed inset-0 z-50 backdrop-blur-sm flex items-center justify-center">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-md mx-4">
    <div class="flex items-center justify-between px-6 py-4 border-b">
      <h3 class="text-lg font-semibold">Select Print Option</h3>
      <button type="button" onclick="closePrintOptionsModal()" class="text-gray-500 hover:text-gray-700 rounded p-2">
        <i class="fas fa-times"></i>
      </button>
    </div>

    <div class="px-6 py-4">
      <div class="space-y-4">
        <button onclick="openCFAModal(currentBlotterId)" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition-colors mb-2">Print CFA</button>
        <button onclick="openSummonFormModal(currentBlotterId)" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-colors">Print Summon</button>
      </div>
    </div>

    <div class="flex justify-end px-6 py-4 border-t">
      <button type="button" onclick="closePrintOptionsModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">Cancel</button>
    </div>
  </div>
</div>

<!-- CFA Modal -->
<div id="cfaModal" class="hidden fixed inset-0 z-50 backdrop-blur-sm flex items-center justify-center">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-md mx-4">
    <div class="flex items-center justify-between px-6 py-4 border-b">
      <h3 class="text-lg font-semibold">Generate CFA Document</h3>
      <button type="button" onclick="closeCFAModal()" class="text-gray-500 hover:text-gray-700 rounded p-2">
        <i class="fas fa-times"></i>
      </button>
    </div>

    <form id="cfaForm" class="px-6 py-4">
      <input type="hidden" name="id" id="cfaBlotterId">
      
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
        <div class="grid grid-cols-3 gap-2">
          <input type="number" name="day" min="1" max="31" required placeholder="Day" class="border p-2 rounded-sm border-gray-300">
          <input type="number" name="month" min="1" max="12" required placeholder="Month" class="border p-2 rounded-sm border-gray-300">
          <input type="number" name="year" min="2000" max="2100" required placeholder="Year" class="border p-2 rounded-sm border-gray-300">
        </div>
      </div>
      
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
        <input type="text" name="location" required class="w-full border p-2 rounded-sm border-gray-300">
      </div>

      <div class="flex justify-end gap-2">
        <button type="button" onclick="closeCFAModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">Cancel</button>
        <button type="button" onclick="generateCFADocument()" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition-colors">Generate CFA</button>
      </div>
    </form>
  </div>
</div>

<!-- Summons Form Modal -->
<div id="summonsFormModal" class="hidden fixed inset-0 z-50 backdrop-blur-sm flex items-center justify-center">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-md mx-4">
    <div class="flex items-center justify-between px-6 py-4 border-b">
      <h3 class="text-lg font-semibold">Summons Details</h3>
      <button type="button" onclick="document.getElementById('summonsFormModal').classList.add('hidden')" class="text-gray-500 hover:text-gray-700 rounded p-2">
        <i class="fas fa-times"></i>
      </button>
    </div>

    <form id="summonsForm" action="print/summon.php" method="POST" target="_blank" class="px-6 py-4">
      <input type="hidden" name="id" id="summonsBlotterId">
      <input type="hidden" name="r_name" id="summonsRespondent">
      <input type="hidden" name="c_name" id="summonsComplainant">
      <input type="hidden" name="type" id="summonsType">
      
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Summon Date</label>
        <div class="grid grid-cols-3 gap-2">
          <input type="number" name="day" min="1" max="31" required placeholder="Day" class="border p-2 rounded-sm border-gray-300">
          <input type="number" name="month" min="1" max="12" required placeholder="Month" class="border p-2 rounded-sm border-gray-300">
          <input type="number" name="year" min="2000" max="2100" required placeholder="Year" class="border p-2 rounded-sm border-gray-300">
        </div>
      </div>
      
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Time (12-hour format)</label>
        <input type="number" name="time" min="1" max="12" required class="w-full border p-2 rounded-sm border-gray-300">
      </div>
      
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
        <input type="text" name="location" required class="w-full border p-2 rounded-sm border-gray-300">
      </div>
      <input type="hidden" name="type" id="summonsType">

      <div class="flex justify-end gap-2 pt-2">
        <button type="button" onclick="document.getElementById('summonsFormModal').classList.add('hidden')" 
                class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">Cancel</button>
        <button type="button" onclick="generateSummons()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-colors">
          Generate Summons
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Resolved Blotter - View Modal (styled like complaint view) -->
<div id="resolvedViewModal" class="hidden fixed inset-0 z-50 backdrop-blur-sm flex items-center justify-center">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl mx-4">
    <div class="flex items-center justify-between px-6 py-4 border-b">
      <h3 class="text-lg font-semibold">Resolved Blotter Details</h3>
      <button type="button" onclick="closeResolvedViewModal()" class="text-gray-500 hover:text-gray-700 rounded p-2">
        <i class="fas fa-times"></i>
      </button>
    </div>

    <div class="px-6 py-4 max-h-[70vh] overflow-y-auto">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
        <div>
          <div class="text-xs text-gray-500">Blotter Cases</div>
          <div id="rv_id" class="text-sm font-medium text-gray-800">-</div>
        </div>
        <div>
          <div class="text-xs text-gray-500">Date Reported</div>
          <div id="rv_date" class="text-sm font-medium text-gray-800">-</div>
        </div>

        <div>
          <div class="text-xs text-gray-500">Complainant</div>
          <div id="rv_c_name" class="text-sm font-medium text-gray-800">-</div>
        </div>
        <div>
          <div class="text-xs text-gray-500">Complainant Contact</div>
          <div id="rv_c_contact" class="text-sm font-medium text-gray-800">-</div>
        </div>

        <div class="md:col-span-2">
          <div class="text-xs text-gray-500">Complainant Address</div>
          <div id="rv_c_address" class="text-sm text-gray-800">-</div>
        </div>

        <div>
          <div class="text-xs text-gray-500">Respondent</div>
          <div id="rv_r_name" class="text-sm font-medium text-gray-800">-</div>
        </div>
        <div>
          <div class="text-xs text-gray-500">Respondent Contact</div>
          <div id="rv_r_contact" class="text-sm font-medium text-gray-800">-</div>
        </div>

        <div class="md:col-span-2">
          <div class="text-xs text-gray-500">Respondent Address</div>
          <div id="rv_r_address" class="text-sm text-gray-800">-</div>
        </div>

        <div>
          <div class="text-xs text-gray-500">Type</div>
          <div id="rv_type" class="text-sm text-gray-800">-</div>
        </div>

        <div class="md:col-span-2">
          <div class="text-xs text-gray-500">Location</div>
          <div id="rv_location" class="text-sm text-gray-800">-</div>
        </div>

        <div class="md:col-span-2">
          <div class="text-xs text-gray-500">Details</div>
          <div id="rv_details" class="text-sm text-gray-800 whitespace-pre-wrap">-</div>
        </div>
      </div>
    </div>

    <div class="flex justify-end px-6 py-4 border-t">
      <button type="button" onclick="closeResolvedViewModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">Close</button>
    </div>
  </div>
</div>

<script>
function generateSummons() {
    const form = document.getElementById('summonsForm');
    const formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.blob())
    .then(blob => {
        // Create and trigger download
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'summons.docx';
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);
        document.body.removeChild(a);

        // Close modal and refresh page
        document.getElementById('summonsFormModal').classList.add('hidden');
        location.reload();
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error generating summons document');
    });
}

function openArchivedBlotterViewModal(id) {
        const loadingIndicator = document.createElement('div');
        loadingIndicator.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
        loadingIndicator.innerHTML = '<div class="bg-white p-4 rounded-lg"><i class="fas fa-spinner fa-spin mr-2"></i>Loading blotter details...</div>';
        document.body.appendChild(loadingIndicator);

        fetch(`get_blotter.php?id=${id}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                const modal = document.getElementById('archivedBlotterViewModal');
                if (!modal) {
                    throw new Error('archivedBlotterViewModal not found');
                }
                modal.style.display = 'block';
                
                const elements = {
                    id: document.getElementById('archivedBlotterId'),
                    complainant: document.getElementById('archivedBlotterComplainant'),
                    respondent: document.getElementById('archivedBlotterRespondent'),
                    status: document.getElementById('archivedBlotterStatus'),
                    details: document.getElementById('archivedBlotterDetails')
                };
                
                // Verify all elements exist before proceeding
                const missingElements = Object.entries(elements)
                    .filter(([key, el]) => !el)
                    .map(([key]) => key);
                
                if (missingElements.length > 0) {
                    throw new Error(`Missing required elements: ${missingElements.join(', ')}`);
                }
                
                if (data.success && data.data) {
                    const blotter = data.data;
                    Object.entries(elements).forEach(([key, el]) => {
                        el.textContent = blotter[key] || 'N/A';
                    });
                } else {
                    throw new Error(data.message || 'Failed to load blotter data');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast(error.message || 'Failed to load blotter details', 'error');
            })
            .finally(() => {
                document.body.removeChild(loadingIndicator);
            });
    }

    function openResolvedViewModal(id) {
    const loadingIndicator = document.createElement('div');
    loadingIndicator.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    loadingIndicator.innerHTML = '<div class="bg-white p-4 rounded-lg"><i class="fas fa-spinner fa-spin mr-2"></i>Loading blotter details...</div>';
    document.body.appendChild(loadingIndicator);

    fetch(`get_blotter.php?id=${id}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                const blotter = data.data;
                document.getElementById('rv_id').textContent = 'B-' + (blotter.id || '-');
                document.getElementById('rv_date').textContent = blotter.date_time ? new Date(blotter.date_time).toLocaleDateString() : '-';
                document.getElementById('rv_c_name').textContent = blotter.c_name || '-';
                document.getElementById('rv_c_contact').textContent = blotter.c_contact || '-';
                document.getElementById('rv_c_address').textContent = blotter.c_address || '-';
                document.getElementById('rv_r_name').textContent = blotter.r_name || '-';
                document.getElementById('rv_r_contact').textContent = blotter.r_contact || '-';
                document.getElementById('rv_r_address').textContent = blotter.r_address || '-';
                document.getElementById('rv_type').textContent = blotter.type || '-';
                document.getElementById('rv_status').textContent = blotter.status || '-';
                document.getElementById('rv_location').textContent = blotter.location || '-';
                document.getElementById('rv_details').textContent = blotter.details || '-';
                document.getElementById('rv_created_by').textContent = blotter.created_by || '-';
                document.getElementById('resolvedViewModal').classList.remove('hidden');
    document.getElementById('resolvedViewModal').style.zIndex = '60';
            } else {
                showToast(data.message || 'Failed to load blotter details', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast(error.message || 'Network error loading blotter details', 'error');
        })
        .finally(() => {
            document.body.removeChild(loadingIndicator);
        });
}

function closeResolvedViewModal() {
    document.getElementById('resolvedViewModal').classList.add('hidden');
}

async function loadArchivedBlotters() {
    const table = document.getElementById('archivedBlottersTable');
    if (!table) return console.warn('archivedBlottersTable not found');

    const statusFilter = document.getElementById('archiveStatusFilter').value;
    const dateFrom = document.getElementById('archiveDateFrom').value;
    const dateTo = document.getElementById('archiveDateTo').value;

    tbody.innerHTML = '<tr><td colspan="7" class="p-4 text-center">Loading...</td></tr>';

    try {
        const res = await fetch('fetch_archived_blotters.php', { cache: 'no-store' });
        if (!res.ok) {
            const txt = await res.text();
            console.error('fetch_archived_blotters.php returned', res.status, txt);
            tbody.innerHTML = `<tr><td colspan="7" class="p-4 text-center">Server error: ${res.status}</td></tr>`;
            return;
        }

        const json = await res.json();
        if (!json.success || !Array.isArray(json.data) || json.data.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" class="p-4 text-center">No archived cases found.</td></tr>';
            return;
        }

        // Filter the data based on status and date range
        const filteredData = json.data.filter(r => {
            const matchesStatus = statusFilter === 'all' || r.status === statusFilter;
            if (!matchesStatus) return false;

            if (dateFrom && dateTo) {
                const recordDate = new Date(r.date_time).toISOString().split('T')[0];
                return recordDate >= dateFrom && recordDate <= dateTo;
            }
            return true;
        });

        tbody.innerHTML = '';
        let rowIndex = 0;
        filteredData.forEach(r => {
            rowIndex++;
            const date = r.date_time ?? r.date_reported ?? r.date ?? '';
            const complainant = r.complainant ?? r.c_name ?? '';
            const respondent  = r.respondent  ?? r.r_name ?? '';
            const type        = r.blotter_type ?? r.type ?? '';

            const tr = document.createElement('tr');
            tr.className = 'hover:bg-gray-50';
            tr.innerHTML = `
                <td class="px-3 py-2 border-b border-gray-300">${rowIndex}</td>
                <td class="px-3 py-2 border-b border-gray-300">B-${escapeHtml(r.id)}</td>
                <td class="px-3 py-2 border-b border-gray-300">${escapeHtml(complainant)}</td>
                <td class="px-3 py-2 border-b border-gray-300">${escapeHtml(respondent)}</td>
                <td class="px-3 py-2 border-b border-gray-300">${escapeHtml(type)}</td>
                <td class="px-3 py-2 border-b border-gray-300">${escapeHtml(date)}</td>
                <td class="px-3 py-2 border-b border-gray-300">${escapeHtml(r.status)}</td>
                <td class="px-3 py-2 border-b border-gray-300">
                    <button onclick="openResolvedViewModal(${parseInt(r.id,10)})" class="bg-blue-500 text-white px-2 py-1 rounded-md hover:bg-blue-600">View</button>
                    <button onclick="openArchivedBlotterViewModal(${parseInt(r.id,10)})" class="bg-blue-500 text-white px-2 py-1 rounded-md hover:bg-blue-600 ml-2">View Archived</button>
                </td>
            `;
            tbody.appendChild(tr);
        });

        if (filteredData.length === 0) {
            tbody.innerHTML = '<tr><td colspan="8" class="p-4 text-center">No records found matching the selected filters.</td></tr>';
        }
    } catch (err) {
        console.error('Fetch error:', err);
        tbody.innerHTML = '<tr><td colspan="8" class="p-4 text-center">Error loading archived cases.</td></tr>';
    }
}

// Add event listeners for filter changes
document.getElementById('archiveStatusFilter')?.addEventListener('change', loadArchivedBlotters);
document.getElementById('archiveDateFrom')?.addEventListener('change', loadArchivedBlotters);
document.getElementById('archiveDateTo')?.addEventListener('change', loadArchivedBlotters);
</script>


<!-- View Modal -->
<div id="viewDetailsModal" class="hidden fixed inset-0 z-50 backdrop-blur-sm flex items-center justify-center">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl mx-4">
    <div class="flex items-center justify-between px-6 py-4 border-b">
      <h3 class="text-lg font-semibold">Blotter Details</h3>
      <button type="button" onclick="closeViewModal()" class="text-gray-500 hover:text-gray-700 rounded p-2">
        <i class="fas fa-times"></i>
      </button>
    </div>

    <div class="px-6 py-4 max-h-[70vh] overflow-y-auto">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
        <div>
          <div class="text-xs text-gray-500">Blotter Number</div>
          <div id="viewBlotterNo" class="text-sm font-medium text-gray-800">-</div>
        </div>
        <div>
          <div class="text-xs text-gray-500">Date Reported</div>
          <div id="viewDate" class="text-sm font-medium text-gray-800">-</div>
        </div>

        <div>
          <div class="text-xs text-gray-500">Complainant</div>
          <div id="viewComplainant" class="text-sm font-medium text-gray-800">-</div>
        </div>
        <div>
          <div class="text-xs text-gray-500">Respondent</div>
          <div id="viewRespondent" class="text-sm font-medium text-gray-800">-</div>
        </div>

        <div class="md:col-span-2">
          <div class="text-xs text-gray-500">Type</div>
          <div id="viewType" class="text-sm text-gray-800">-</div>
        </div>

        <div class="md:col-span-2">
          <div class="text-xs text-gray-500">Location</div>
          <div id="viewLocation" class="text-sm text-gray-800">-</div>
        </div>

        <div class="md:col-span-2">
          <div class="text-xs text-gray-500">Details</div>
          <div id="viewDetails" class="text-sm text-gray-800 whitespace-pre-wrap">-</div>
        </div>

        <div>
          <div class="text-xs text-gray-500">Status</div>
          <div id="viewStatus" class="text-sm text-gray-800">-</div>
        </div>
      </div>
    </div>

    <div class="flex justify-end px-6 py-4 border-t">
      <button type="button" onclick="closeViewModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">Close</button>
    </div>
  </div>
</div>

<!-- edit modal -->
<div id="editStatusModal" class="hidden fixed inset-0 z-50 backdrop-blur-sm flex items-center justify-center">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-md mx-4">
    <div class="flex items-center justify-between px-6 py-4 border-b">
      <h3 class="text-lg font-semibold">Edit Blotter Status</h3>
      <button type="button" onclick="document.getElementById('editStatusModal').classList.add('hidden')" class="text-gray-500 hover:text-gray-700 rounded p-2">
        <i class="fas fa-times"></i>
      </button>
    </div>

    <form id="editStatusForm" action="update_blotter_status.php" method="POST" class="px-6 py-4">
      <input type="hidden" name="id" id="edit_status_id" value="">
      <div class="mb-3">
        <label class="text-xs text-gray-500">Current Status</label>
        <div id="edit_status_current" class="text-sm text-gray-800 mb-2">-</div>
      </div>

      <div class="mb-4">
        <label for="edit_status_new" class="block text-sm font-medium text-gray-700 mb-1">New Status</label>
        <select id="edit_status_new" name="new_status" class="w-full border rounded px-3 py-2 text-sm">
          <option value="pending">Pending</option>
          <option value="summon">Summon</option>
          <option value="cfa">CFA</option>
          <option value="withdraw">Withdraw</option>
          <option value="resolved">Resolved</option>
          <option value="archived">Archived</option>
        </select>
      </div>

      <div class="flex justify-end space-x-2">
        <button type="button" onclick="document.getElementById('editStatusModal').classList.add('hidden')" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">Cancel</button>
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Save</button>
      </div>
    </form>
  </div>
</div>


<script>
// View Modal Functions
function openViewModal(id) {
    const loadingIndicator = document.createElement('div');
    loadingIndicator.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    loadingIndicator.innerHTML = '<div class="bg-white p-4 rounded-lg"><i class="fas fa-spinner fa-spin mr-2"></i>Loading blotter details...</div>';
    document.body.appendChild(loadingIndicator);

    fetch(`get_blotter.php?id=${id}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                const blotter = data.data;
                document.getElementById('viewBlotterNo').textContent = 'B-' + blotter.id;
                document.getElementById('viewDate').textContent = blotter.date_time ? new Date(blotter.date_time).toLocaleDateString() : 'N/A';
                document.getElementById('viewComplainant').textContent = blotter.c_name || 'N/A';
                document.getElementById('viewRespondent').textContent = blotter.r_name || 'N/A';
                document.getElementById('viewType').textContent = blotter.type || 'N/A';
                document.getElementById('viewLocation').textContent = blotter.location || 'N/A';
                document.getElementById('viewDetails').textContent = blotter.details || 'N/A';
                document.getElementById('viewStatus').textContent = blotter.status || 'N/A';
                document.getElementById('viewDetailsModal').classList.remove('hidden');
            } else {
                showToast(data.message || 'Failed to load blotter details', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast(error.message || 'Network error loading blotter details', 'error');
        })
        .finally(() => {
            document.body.removeChild(loadingIndicator);
        });
}

function closeViewModal() {
    const m = document.getElementById('viewDetailsModal');
    if (!m) return;
    m.classList.add('hidden');
}

// Edit Modal Functions
function openEditModal(id) {
    const loadingIndicator = document.createElement('div');
    loadingIndicator.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    loadingIndicator.innerHTML = '<div class="bg-white p-4 rounded-lg"><i class="fas fa-spinner fa-spin mr-2"></i>Loading blotter details...</div>';
    document.body.appendChild(loadingIndicator);

    fetch(`get_blotter.php?id=${id}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                document.getElementById('edit_status_id').value = data.data.id;
                document.getElementById('edit_status_current').textContent = data.data.status || 'N/A';
                document.getElementById('editStatusModal').classList.remove('hidden');
            } else {
                showToast(data.message || 'Failed to load blotter details', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast(error.message || 'Network error loading blotter details', 'error');
        })
        .finally(() => {
            document.body.removeChild(loadingIndicator);
        });
}

function closeEditModal() {
    const m = document.getElementById('editStatusModal');
    if (!m) return;
    m.classList.add('hidden');
}

document.addEventListener('click', function(e) {
  ['viewDetailsModal','editStatusModal'].forEach(id => {
    const m = document.getElementById(id);
    if (!m || m.classList.contains('hidden')) return;
    if (e.target === m) m.classList.add('hidden');
  });
});
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    ['viewDetailsModal','editStatusModal'].forEach(id => document.getElementById(id)?.classList.add('hidden'));
  }
});

// Toast notification function
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `fixed bottom-4 right-4 px-4 py-2 rounded-md shadow-lg text-white ${type === 'error' ? 'bg-red-500' : 'bg-green-500'}`;
    toast.textContent = message;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.classList.add('opacity-0', 'transition-opacity', 'duration-300');
        setTimeout(() => document.body.removeChild(toast), 300);
    }, 3000);
}

// backdrop click closes both modals
document.addEventListener('click', function(e){
    const view = document.getElementById('viewDetailsModal');
    const edit = document.getElementById('editStatusModal');
    if (view && !view.classList.contains('hidden') && e.target === view) closeViewModal();
    if (edit && !edit.classList.contains('hidden') && e.target === edit) closeEditModal();
});

// optional: prevent double submit on edit form
document.getElementById('editStatusForm')?.addEventListener('submit', function(e){
    const btn = this.querySelector('button[type="submit"]');
    if (btn) { btn.disabled = true; btn.textContent = 'Saving...'; }
});

async function loadResolvedBlotters() {
    const modal = document.getElementById('resolvedBlotterModal');
    if (!modal) return console.warn('resolvedBlotterModal not found');
    const tbody = modal.querySelector('tbody');
    if (!tbody) return console.warn('resolved modal tbody not found');

    tbody.innerHTML = '<tr><td colspan="7" class="p-4 text-center">Loading...</td></tr>';

    try {
        const res = await fetch('fetch_resolved_blotters.php', { cache: 'no-store' });
        if (!res.ok) {
            const txt = await res.text();
            console.error('fetch_resolved_blotters.php returned', res.status, txt);
            tbody.innerHTML = `<tr><td colspan="7" class="p-4 text-center">Server error: ${res.status}</td></tr>`;
            return;
        }

        const json = await res.json();
        if (!json.success || !Array.isArray(json.data) || json.data.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" class="p-4 text-center">No resolved cases found.</td></tr>';
            return;
        }

        tbody.innerHTML = '';
        let rowIndex = 0;
        json.data.forEach(r => {
            rowIndex++;
            const date = r.date_time ?? r.date_reported ?? r.date ?? '';
            const complainant = r.complainant ?? r.c_name ?? '';
            const respondent  = r.respondent  ?? r.r_name ?? '';
            const type        = r.blotter_type ?? r.type ?? '';

            const tr = document.createElement('tr');
            tr.className = 'hover:bg-gray-50';
            tr.innerHTML = `
                <td class="px-3 py-2 border-b border-gray-300">${rowIndex}</td>
                <td class="px-3 py-2 border-b border-gray-300">B-${escapeHtml(r.id)}</td>
                <td class="px-3 py-2 border-b border-gray-300">${escapeHtml(complainant)}</td>
                <td class="px-3 py-2 border-b border-gray-300">${escapeHtml(respondent)}</td>
                <td class="px-3 py-2 border-b border-gray-300">${escapeHtml(type)}</td>
                <td class="px-3 py-2 border-b border-gray-300">${escapeHtml(date)}</td>
                <td class="px-3 py-2 border-b border-gray-300">
                    <button onclick="openResolvedViewModal(${parseInt(r.id,10)})" class="bg-blue-500 text-white px-2 py-1 rounded-md hover:bg-blue-600">View</button>
                </td>
            `;
            tbody.appendChild(tr);
        });
    } catch (err) {
        console.error('Fetch error:', err);
        tbody.innerHTML = '<tr><td colspan="7" class="p-4 text-center">Error loading resolved cases.</td></tr>';
    }
}

// Print Options Modal functions
function openPrintOptionsModal(id) {
    document.getElementById('printOptionsModal').classList.remove('hidden');
    // Store the blotter ID for printing
    document.getElementById('printOptionsModal').dataset.blotterId = id;
    currentBlotterId = id;
}

function closePrintOptionsModal() {
    document.getElementById('printOptionsModal').classList.add('hidden');
}

// CFA Modal functions
function openCFAModal(id) {
    document.getElementById('cfaModal').classList.remove('hidden');
    document.getElementById('cfaModal').dataset.blotterId = id;
    document.getElementById('cfaBlotterId').value = id;
    
    // Set current date as default
    const now = new Date();
    const form = document.getElementById('cfaForm');
    form.querySelector('[name="day"]').value = now.getDate();
    form.querySelector('[name="month"]').value = now.getMonth() + 1;
    form.querySelector('[name="year"]').value = now.getFullYear();
    
    closePrintOptionsModal();
}

function closeCFAModal() {
    document.getElementById('cfaModal').classList.add('hidden');
}

function generateCFADocument() {
    const form = document.getElementById('cfaForm');
    const id = document.getElementById('cfaModal').dataset.blotterId;
    
    if (!id) {
        showToast('Blotter ID not found', 'error');
        return;
    }
    
    // Get form values
    const day = form.querySelector('[name="day"]').value;
    const month = form.querySelector('[name="month"]').value;
    const year = form.querySelector('[name="year"]').value;
    const location = form.querySelector('[name="location"]').value;
    
    if (!day || !month || !year || !location) {
        showToast('Please fill all fields', 'error');
        return;
    }
    
    // Update status to CFA
    updateBlotterStatus(id, 'cfa', () => {
        // Generate and download CFA document with date and location parameters
        window.open(`print/printcfa.php?id=${id}&day=${day}&month=${month}&year=${year}&location=${encodeURIComponent(location)}`, '_blank');
        closeCFAModal();
        window.location.reload();
    });
}
// Function to make the AJAX call to update the blotter status
function updateBlotterStatus(id, new_status, callback) {
    if (!id || !new_status) {
        console.error('Missing ID or status for update.');
        if (typeof callback === 'function') {
            callback(); // Still proceed with print if data is missing
        }
        return;
    }

    fetch('update_status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        // Send the blotter ID and the new status
        body: `id=${id}&status=${new_status}` 
    })
    .then(response => {
        // update_status.php executes the update statement for 'summon' or 'cfa'
        if (response.ok) {
            console.log(`Status updated to ${new_status} for ID: ${id}`);
        } else {
            console.error('Server error updating status.');
        }
    })
    .catch(error => {
        console.error('Network error during status update:', error);
        // Alert is generally disruptive, but useful for error reporting
        // alert('Failed to automatically update blotter status. Please refresh the page.'); 
    })
    .finally(() => {
        // Execute the print/modal function regardless of the status update success
        if (typeof callback === 'function') {
            callback();
        }
        // A simple page reload is the easiest way to refresh the blotter table view
        window.location.reload();
    });
}

// 1. Function for Print CFA


// 2. Function for Print Summon
function printSummon(id) {
    if (!id) {
        alert('Blotter ID not found for Summon print.');
        return;
    }

    // Step 1: Trigger status update to 'summon'
    fetch('update_blotter_status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `id=${id}&status=summon`
    })
    .then(response => {
        if (!response.ok) throw new Error('Status update failed');
        return response.json();
    })
    .then(data => {
        if (!data.success) throw new Error(data.message || 'Status update failed');
        
        // Step 2: Open the summons form modal
        document.getElementById('summonsBlotterId').value = id;
        document.getElementById('summonsFormModal').classList.remove('hidden');
        closePrintOptionsModal();
        
        // Refresh the page to show updated status
        window.location.reload();
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Failed to update status: ' + error.message, 'error');
    });
}



function printSummon(id) {
    if (!id) {
        alert('Blotter ID not found for Summon print.');
        return;
    }

    // Step 1: Trigger status update to 'summon'
    updateBlotterStatus(id, 'summon', () => {
        // Step 2: On callback, open the summons form modal
        // The summons form (summonsFormModal) is used to collect details before final generation/print.
        document.getElementById('summonsBlotterId').value = id;
        // Assume other details are loaded into the form elsewhere (like respondent name, etc.)
        document.getElementById('summonsFormModal').classList.remove('hidden');
        
        // Close the print options modal
        closePrintOptionsModal();
    });
}

function printSummons() {
    const id = document.getElementById('printOptionsModal').dataset.blotterId;
    const row = document.querySelector(`tr[data-id="${id}"]`);
    const now = new Date();
    
    // Set form values
    document.getElementById('summonsBlotterId').value = id;
    document.getElementById('summonsRespondent').value = row.dataset.rName;
    document.getElementById('summonsComplainant').value = row.dataset.cName;
    document.getElementById('summonsType').value = row.dataset.type;
    document.getElementById('summonsForm').querySelector('input[name="year"]').value = now.getFullYear();
    const monthSelect = document.createElement('select');
    monthSelect.name = 'month';
    monthSelect.className = 'w-full p-2 border rounded';
    const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    months.forEach(month => {
        const option = document.createElement('option');
        option.value = month;
        option.textContent = month;
        if (month === now.toLocaleString('default', { month: 'long' })) {
            option.selected = true;
        }
        monthSelect.appendChild(option);
    });
    const monthInput = document.getElementById('summonsForm').querySelector('input[name="month"]');
    monthInput.replaceWith(monthSelect);
    document.getElementById('summonsForm').querySelector('input[name="day"]').value = now.getDate();
    document.getElementById('summonsForm').querySelector('input[name="location"]').value = row.dataset.location;
    document.getElementById('summonsForm').querySelector('input[name="time"]').value = now.getHours();
    
    // Show modal
    document.getElementById('summonsFormModal').classList.remove('hidden');
    closePrintOptionsModal();
}

// Fetch and display a single blotter in the Resolved View modal
async function openResolvedViewModal(id) {
    const modal = document.getElementById('resolvedViewModal');
    if (!modal) return console.warn('resolvedViewModal not found');

    // reset UI
    ['rv_id','rv_date','rv_c_name','rv_c_contact','rv_c_address','rv_r_name','rv_r_contact','rv_r_address','rv_type','rv_location','rv_details']
      .forEach(i => document.getElementById(i).textContent = 'Loading...');

    try {
        const response = await fetch(`get_blotter.php?id=${encodeURIComponent(id)}`, { cache: 'no-store' });
        if (!response.ok) throw new Error('Server returned ' + response.status);
        const json = await response.json();
        if (!json.success) throw new Error(json.message || 'Failed to load blotter');

        const b = json.data;
        document.getElementById('rv_id').textContent = b.id ?? '-';
        document.getElementById('rv_date').textContent = b.date_time ? new Date(b.date_time).toLocaleString() : '-';
        document.getElementById('rv_c_name').textContent = b.c_name || '-';
        document.getElementById('rv_c_contact').textContent = b.c_contact || '-';
        document.getElementById('rv_c_address').textContent = b.c_address || '-';
        document.getElementById('rv_r_name').textContent = b.r_name || '-';
        document.getElementById('rv_r_contact').textContent = b.r_contact || '-';
        document.getElementById('rv_r_address').textContent = b.r_address || '-';
        document.getElementById('rv_type').textContent = b.type || '-';
        document.getElementById('rv_location').textContent = b.location || '-';
        document.getElementById('rv_details').textContent = b.details || '-';

        modal.classList.remove('hidden');
    } catch (err) {
        console.error(err);
        showToast('Failed to load blotter details: ' + (err.message || 'Unknown error'), 'error');
        // clear Loading... text on error
        ['rv_id','rv_date','rv_c_name','rv_c_contact','rv_c_address','rv_r_name','rv_r_contact','rv_r_address','rv_type','rv_location','rv_details']
          .forEach(i => document.getElementById(i).textContent = ' -');
    }
}

function closeResolvedViewModal() {
    const modal = document.getElementById('resolvedViewModal');
    if (!modal) return;
    modal.classList.add('hidden');
    modal.style.zIndex = '';
}

// click backdrop to close
document.addEventListener('click', function(e){
    const modal = document.getElementById('resolvedViewModal');
    if (!modal || modal.classList.contains('hidden')) return;
    if (e.target === modal) closeResolvedViewModal();
    

});



</script>

<script>
function validateAddBlotterForm() {
    const form = document.getElementById('addBlotterForm');
    const submitBtn = document.getElementById('submitBlotterBtn');
    
    // Disable submit button to prevent multiple submissions
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Submitting...';
    
    // Basic validation - ensure required fields are filled
    const requiredFields = ['c_name', 'r_name', 'details', 'location'];
    let isValid = true;
    
    requiredFields.forEach(field => {
        const input = form.querySelector(`[name="${field}"]`);
        if (!input || !input.value.trim()) {
            isValid = false;
            input.classList.add('border-red-500');
        } else {
            input.classList.remove('border-red-500');
        }
    });
    
    if (!isValid) {
        showToast('Please fill all required fields', 'error');
        submitBtn.disabled = false;
        submitBtn.textContent = 'Submit';
        return false;
    }
    
    // If validation passes, allow form submission
    return true;
}
</script>

<div id="archivedBlotterModal" class="hidden fixed inset-0 z-40 backdrop-blur-sm flex items-center justify-center">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-6xl mx-4 h-3/4">
    <div class="flex items-center justify-between px-6 py-4 border-b">
      <h3 class="text-lg font-semibold">Archived Blotters</h3>
      <button type="button" onclick="closeArchivedBlotterModal()" class="text-gray-500 hover:text-gray-700 rounded p-2">
        <i class="fas fa-times"></i>
      </button>
    </div>

    <div class="px-6 py-4">
      <div class="flex justify-between mb-4">
        <div class="flex items-center gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status Filter</label>
            <select id="archiveStatusFilter" class="border rounded px-3 py-1 text-sm">
              <option value="all">All Statuses</option>
              <option value="resolved">Resolved</option>
              <option value="withdraw">Withdrawn</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
            <input type="date" id="archiveDateFrom" class="border rounded px-3 py-1 text-sm">
            <span class="mx-2">to</span>
            <input type="date" id="archiveDateTo" class="border rounded px-3 py-1 text-sm">
          </div>
        </div>
        <div>
          <input type="text" id="archiveSearchInput" placeholder="Search..." class="border rounded px-3 py-1 text-sm">
        </div>
      </div>

      <div class="overflow-y-auto h-130">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Blotter No.</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Complainant</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Respondent</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody id="archivedBlottersTable" class="bg-white divide-y divide-gray-200">
            <!-- Data will be loaded here -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>


function openSummonFormModal(blotterId) {
    // Close print options modal
    document.getElementById('printOptionsModal').classList.add('hidden');
    
    // Fetch blotter details and populate form
    fetch('get_blotter.php?id=' + blotterId)
        .then(response => response.json())
        .then(data => {
            document.getElementById('summonsBlotterId').value = blotterId;
            document.getElementById('summonsRespondent').value = data.r_name;
            document.getElementById('summonsComplainant').value = data.c_name;
            document.getElementById('summonsType').value = data.type;
            
            // Open summon form modal
            document.getElementById('summonsFormModal').classList.remove('hidden');
        });
}

function closeSummonFormModal() {
    document.getElementById('summonsFormModal').classList.add('hidden');
}

async function loadArchivedBlotters() {
  const table = document.getElementById('archivedBlottersTable');
  const statusFilter = document.getElementById('archiveStatusFilter').value;
  const dateFrom = document.getElementById('archiveDateFrom').value;
  const dateTo = document.getElementById('archiveDateTo').value;
  const searchInput = document.getElementById('archiveSearchInput').value.toLowerCase();

  table.innerHTML = '<tr><td colspan="8" class="px-6 py-4 text-center">Loading...</td></tr>';

  try {
    const response = await fetch('fetch_archived_blotters.php', { 
      headers: { 'Accept': 'application/json' },
      cache: 'no-store'
    });
    
    const contentType = response.headers.get('content-type');
    if (!contentType || !contentType.includes('application/json')) {
      const text = await response.text();
      throw new Error(`Expected JSON but got: ${text.substring(0, 100)}`);
    }
    
    const data = await response.json();
    
    if (!data.success || !data.data.length) {
      table.innerHTML = '<tr><td colspan="8" class="px-6 py-4 text-center">No archived cases found.</td></tr>';
      return;
    }

    const filteredData = data.data.filter(blotter => {
      // Status filter
      if (statusFilter !== 'all' && blotter.status !== statusFilter) return false;

      // Date filter
      if (dateFrom && dateTo) {
        const blotterDate = new Date(blotter.date_time).toISOString().split('T')[0];
        if (blotterDate < dateFrom || blotterDate > dateTo) return false;
      }

      // Search filter
      if (searchInput) {
        const searchFields = [
          blotter.id,
          blotter.c_name,
          blotter.r_name,
          blotter.type,
          blotter.status
        ].map(field => (field || '').toString().toLowerCase());
        
        return searchFields.some(field => field.includes(searchInput));
      }

      return true;
    });

    if (filteredData.length === 0) {
      table.innerHTML = '<tr><td colspan="8" class="px-6 py-4 text-center">No matching records found.</td></tr>';
      return;
    }

    table.innerHTML = '';
    filteredData.forEach(blotter => {
      const row = document.createElement('tr');
      row.className = 'hover:bg-gray-50';
      row.innerHTML = `
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${table.rows.length + 1}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">B-${blotter.id}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${escapeHtml(blotter.c_name)}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${escapeHtml(blotter.r_name)}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${escapeHtml(blotter.type)}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${new Date(blotter.date_time).toLocaleDateString()}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${escapeHtml(blotter.status)}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
          <button onclick="openArchivedBlotterViewModal(${blotter.id})" class="text-blue-600 hover:text-blue-900 px-2 py-1 rounded-md bg-blue-100">View</button>
        </td>
      `;
      table.appendChild(row);
    });
  } catch (error) {
    console.error('Error loading archived blotters:', error);
    showToast('Failed to load archived blotters: ' + error.message, 'error');
    table.innerHTML = '<tr><td colspan="8" class="px-6 py-4 text-center text-red-500">Error loading data: ' + escapeHtml(error.message) + '</td></tr>';
  }
}

// Add event listeners for filters
document.getElementById('archiveStatusFilter').addEventListener('change', loadArchivedBlotters);
document.getElementById('archiveDateFrom').addEventListener('change', loadArchivedBlotters);
document.getElementById('archiveDateTo').addEventListener('change', loadArchivedBlotters);
document.getElementById('archiveSearchInput').addEventListener('input', debounce(loadArchivedBlotters, 300));

// Debounce function to prevent too many API calls
function debounce(func, wait) {
  let timeout;
  return function executedFunction(...args) {
    const later = () => {
      clearTimeout(timeout);
      func(...args);
    };
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
  };
}

async function openArchivedBlotterViewModal(id) {
  try {
    const response = await fetch(`get_blotter.php?id=${id}`, {
      headers: { 'Accept': 'application/json' },
      cache: 'no-store'
    });
    
    const data = await response.json();
    if (!data.success) throw new Error(data.message || 'Failed to load blotter');
    
    const b = data.data;
    document.getElementById('rv_id').textContent = b.id || '-';
    document.getElementById('rv_date').textContent = new Date(b.date_time).toLocaleString() || '-';
    document.getElementById('rv_c_name').textContent = b.c_name || '-';
    document.getElementById('rv_c_contact').textContent = b.c_contact || '-';
    document.getElementById('rv_c_address').textContent = b.c_address || '-';
    document.getElementById('rv_r_name').textContent = b.r_name || '-';
    document.getElementById('rv_r_contact').textContent = b.r_contact || '-';
    document.getElementById('rv_r_address').textContent = b.r_address || '-';
    document.getElementById('rv_type').textContent = b.type || '-';
    document.getElementById('rv_location').textContent = b.location || '-';
    document.getElementById('rv_details').textContent = b.details || '-';
    document.getElementById('rv_status').textContent = b.status || '-';
    document.getElementById('rv_created_by').textContent = b.created_by || '-';
    
    document.getElementById('resolvedViewModal').classList.remove('hidden');
  } catch (err) {
    console.error(err);
    showToast('Failed to load blotter details: ' + (err.message || 'Unknown error'), 'error');
  }
}

function openArchivedBlotterModal() {
  const modal = document.getElementById('archivedBlotterModal');
  modal.classList.remove('hidden');
  loadArchivedBlotters();
}

function closeArchivedBlotterModal() {
  document.getElementById('archivedBlotterModal').classList.add('hidden');
}
</script>