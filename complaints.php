<?php
$title = "Complaints";

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once 'head.php';

?>

<?php if (isset($_SESSION['success'])): ?>
  <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
    <?= $_SESSION['success']; unset($_SESSION['success']); ?>
  </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
  <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
        <?= $_SESSION['error']; unset($_SESSION['error']); ?>
  </div>
<?php endif; ?>
<?php try {
        $stmt = $conn->prepare("SELECT id,c_name AS complainant, r_name AS respondent, details, date_time AS date, type, location, status , created_by FROM complaint WHERE status = 'active' ORDER BY id DESC");
        $stmt->execute();
        $complaints = $stmt->fetchAll();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        $complaints = [];
    } ?>
<?php try {
        $stmt = $conn->prepare("SELECT id,c_name AS complainant, r_name AS respondent, details, date_time AS date, type, location, status , created_by FROM complaint WHERE status = 'archived'");
        $stmt->execute();
        $archivedcomplaints = $stmt->fetchAll();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        $archivedcomplaints = [];
    } ?>
<?php try {
        $stmt = $conn->prepare("SELECT id,c_name AS complainant, r_name AS respondent, details, date_time AS date, type, location, status , created_by FROM complaint WHERE status = 'transfer'");
        $stmt->execute();
        $transferredcomplaints = $stmt->fetchAll();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        $transferredcomplaints = [];
    } ?>

    <div class="flex flex-col w-full">
        <div class="grid grid-cols-6 p-2 gap-3">
            <div class="bg-white rounded-md shadow-md p-2 grid grid-rows-2">
                <div class="text-xl text-gray-500 mt-3">Active</div>
                <div class="text-3xl font-semibold "><?php echo count(array_filter($complaints, fn($b) => $b['status'] === 'active')); ?></div>
            </div>
            <div class="bg-white rounded-md shadow-md p-2 grid grid-rows-2">
                <div class="text-xl text-gray-500 mt-3">Transferred</div>
                <div class="text-3xl font-semibold "><?php echo count(array_filter($transferredcomplaints, fn($b) => $b['status'] === 'transfer')); ?></div>
            </div>
            <div class="bg-gray-100 rounded-md shadow-md p-2 grid grid-rows-2">
                <div class="text-xl text-gray-500 mt-3">Archived</div>
                <div class="text-3xl font-semibold "><?php echo count(array_filter($archivedcomplaints, fn($b) => $b['status'] === 'archived')); ?></div>
            </div>
        </div>
        <hr class="my-2 mb-3 border-gray-300">
        <div class="flex items-center mb-3 gap-2 ">
            <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
            <script>
                alert("Complaint added successfully!");
            </script>
            <?php endif; ?>
            <?php require 'complaintModal.php'; ?>
            <button onclick="document.getElementById('inputMethodModal').classList.remove('hidden');" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                <i class="fas fa-plus mr-2"></i>Add New Complaint
            </button>
            <button onclick="document.getElementById('archivedModal').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                <i class="fas fa-folder-open mr-2"></i>Archived Case
            </button>
            <!-- <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                <a href="archive.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'archive.php' ? : 'hover:bg-blue-700'; ?>"><p class="text-end" >Archives</p></a>
            </button> -->
        </div>
        <div class="bg-white rounded-lg shadow-md p-3 md:p-5">
            <div style="min-height: 600px; overflow-y: auto;">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-2">
                                <label for="complaintStatusFilter" class="font-semibold">Filter by Type:</label>
                                <?php $incidentTypes = array_unique(array_map(fn($item) => $item['type'], $complaints)); sort($incidentTypes); ?>
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">Case Number</th>
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
                        foreach ($paginatedComplaints as $item): 
                            if ($item['status'] == 'active'):?>
                        <tr class="hover:bg-gray-50">
                            <?php static $rowNum = 1; ?>
                            <td class="border-y border-gray-200 px-4 py-2"><?php echo $rowNum++; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">C-<?php echo htmlspecialchars($item['id']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($item['complainant']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($item['respondent']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($item['type']); ?></td>
                            <?php
                                $itemDateTime = new DateTime($item['date']);
                                $itemDate = $itemDateTime->format('m-d-Y');
                            ?>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($itemDate); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($item['location']); ?></td>
                            <td class="px-6 text-center md:px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <button class="text-blue-600 hover:text-blue-900 mr-3 view-btn" 
                                    data-item='<?= htmlspecialchars(json_encode([
                                        'id' => $item['id'],
                                        'complainant' => $item['complainant'],
                                        'respondent' => $item['respondent'],
                                        'type' => $item['type'],
                                        'details' => $item['details'],
                                        'date_time' => $item['date'],
                                        'location' => $item['location'],
                                        'created_by' => $item['created_by']
                                    ]), ENT_QUOTES, 'UTF-8') ?>'
                                    onclick="openViewModal(this)">
                                    <i class="fas fa-eye mr-1"></i>View
                                </button>
                                <button class="text-green-600 hover:text-green-900 edit-btn" 
                                    data-item='<?= htmlspecialchars(json_encode([
                                        'id' => $item['id'],
                                        'complainant' => $item['complainant'],
                                        'respondent' => $item['respondent'],
                                        'type' => $item['type'],
                                        'details' => $item['details'],
                                        'date_time' => $item['date'],
                                        'location' => $item['location'],
                                        'status' => $item['status'],
                                        'created_by' => $item['created_by']
                                    ]), ENT_QUOTES, 'UTF-8') ?>'
                                    onclick="openEditModal(JSON.parse(this.getAttribute('data-item')))">
                                    <i class="fas fa-edit mr-1"></i>Edit
                                </button>
                                <button class="text-purple-600 hover:text-purple-900 print-btn" 
                                    data-item='<?= htmlspecialchars(json_encode([
                                        'id' => $item['id'],
                                        'complainant' => $item['complainant'],
                                        'respondent' => $item['respondent'],
                                        'type' => $item['type'],
                                        'details' => $item['details'],
                                        'date_time' => $item['date'],
                                        'location' => $item['location'],
                                        'created_by' => $item['created_by']
                                    ]), ENT_QUOTES, 'UTF-8') ?>'
                                    onclick="const printModal = document.getElementById('printComplaintModal');
                                        if (printModal && printModal.classList) {
                                            printModal.classList.remove('hidden');
                                        }
                                        openPrintModal(JSON.parse(this.getAttribute('data-item')))">
                                    <i class="fas fa-print mr-1"></i>Print
                                </button>
                            </td>
                        </tr>
                        <?php endif; ?>
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
    </div>
</div>

<?php require 'printComplaintModal.php'; ?>
<script>
  const complaintStatusFilter = document.getElementById('complaintStatusFilter');
  const complaintSearchInput = document.getElementById('complaintSearchInput');
  const complaintTableBody = document.getElementById('complaintTableBody');

  function filterComplaintTable() {
    if (!complaintStatusFilter || !complaintSearchInput || !complaintTableBody) return;
    
    const filterValue = complaintStatusFilter.value.toLowerCase();
    const searchTerm = complaintSearchInput.value.toLowerCase();

    Array.from(complaintTableBody.getElementsByTagName('tr')).forEach(row => {
      const typeCell = row.cells[3]?.textContent.toLowerCase();
      const complainantCell = row.cells[1]?.textContent.toLowerCase();
      const respondentCell = row.cells[2]?.textContent.toLowerCase();

      const matchesFilter = filterValue === 'all' || typeCell === filterValue;
      const matchesSearch = complainantCell?.includes(searchTerm) || respondentCell?.includes(searchTerm);

      row.style.display = matchesFilter && matchesSearch ? '' : 'none';
    });
  }

  if (complaintStatusFilter && complaintSearchInput && complaintTableBody) {
    complaintStatusFilter.addEventListener('change', filterComplaintTable);
    complaintSearchInput.addEventListener('input', filterComplaintTable);
  }

  document.addEventListener("DOMContentLoaded", () => {
  try {
    // Check if elements exist before adding event listeners
    const viewButtons = document.querySelectorAll(".view-btn");
    if (viewButtons.length > 0) {
      viewButtons.forEach(btn => {
        if (btn) {
          btn.addEventListener("click", function() {
            try {
              const item = JSON.parse(this.getAttribute('data-item'));
              openViewModal(item);
            } catch (e) {
              console.error('Error parsing complaint data:', e);
            }
          });
        }
      });
    }

    const editButtons = document.querySelectorAll(".edit-btn");
    if (editButtons.length > 0) {
      editButtons.forEach(btn => {
        if (btn) {
          btn.addEventListener("click", function() {
            try {
              const item = JSON.parse(this.getAttribute('data-item'));
              openEditModal(item);
            } catch (e) {
              console.error('Error parsing complaint data:', e);
            }
          });
        }
      });
    }

    // Add null checks for filter elements
    if (complaintStatusFilter && complaintStatusFilter.addEventListener) {
      complaintStatusFilter.addEventListener('change', filterComplaintTable);
    }
    if (complaintSearchInput && complaintSearchInput.addEventListener) {
      complaintSearchInput.addEventListener('input', filterComplaintTable);
    }
  } catch (e) {
    console.error('Error initializing event listeners:', e);
  }
});

function openViewModal(complaint) {
    // Ensure complaint data exists
    if (!complaint) {
        console.error('No complaint data provided');
        return;
    }
    
    // Populate all fields with complaint data
    const viewComplaintId = document.getElementById("viewComplaintId");
    const viewCName = document.getElementById("viewCName");
    const viewRName = document.getElementById("viewRName");
    const viewtype = document.getElementById("viewtype");
    const viewlocation = document.getElementById("viewlocation");
    const viewdetails = document.getElementById("viewdetails");
    
    if (viewComplaintId) viewComplaintId.value = complaint.id || '';
    if (viewCName) viewCName.value = complaint.complainant || complaint.c_name || 'N/A';
    if (viewRName) viewRName.value = complaint.respondent || complaint.r_name || 'N/A';
    if (viewtype) viewtype.value = complaint.type || 'N/A';
    if (viewlocation) viewlocation.value = complaint.location || 'N/A';
    if (viewdetails) viewdetails.value = complaint.details || 'No details provided';
    
    // Show the modal with null check
    const viewModal = document.getElementById("viewComplaintModal");
    if (viewModal && viewModal.classList) {
        viewModal.classList.remove("hidden");
    }
}

function openEditModal(item) {
    const id = item.id || item.id;
    const editComplaintId = document.getElementById('editComplaintId');
    const editCName = document.getElementById('editCName');
    const editRName = document.getElementById('editRName');
    const editType = document.getElementById('editType');
    const editLocation = document.getElementById('editLocation');
    const editDetails = document.getElementById('editDetails');
    const editStatus = document.getElementById('editStatus');
    
    if (editComplaintId) editComplaintId.value = id;
    if (editCName) editCName.value = item.complainant || item.c_name || '';
    if (editRName) editRName.value = item.respondent || item.r_name || '';
    if (editType) editType.value = item.type || '';
    if (editLocation) editLocation.value = item.location || '';
    if (editDetails) editDetails.value = item.details || '';
    if (editStatus) editStatus.value = item.status || 'active';
    
    const editModal = document.getElementById('editComplaintModal');
    if (editModal && editModal.classList) {
        editModal.classList.remove('hidden');
    }
}

function openPrintModal(item) {
    const id = item.id || item.id;
    const complainant = item.complainant || item.c_name || '';
    const respondent = item.respondent || item.r_name || '';
    const type = item.type || '';
    const details = item.details || '';
    const dateTime = item.date_time || item.date || '';
    const location = item.location || '';

    document.getElementById('printId').value = id;
    document.getElementById('printComplainant').value = complainant;
    document.getElementById('printRespondent').value = respondent;
    document.getElementById('printType').value = type;
    document.getElementById('printDetails').value = details;
    document.getElementById('printDate').value = dateTime;
    document.getElementById('printLocation').value = location;
    
    document.getElementById('modalComplainant').textContent = complainant;
    document.getElementById('modalRespondent').textContent = respondent;
    document.getElementById('modalType').textContent = type;
    document.getElementById('modalDetails').textContent = details;
    document.getElementById('modalLocation').textContent = location;
    
    if (dateTime) {
        const d = new Date(dateTime);
        if (!isNaN(d)) {
            document.getElementById('modalDate').textContent = d.toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            });
        }
    }
}
</script>