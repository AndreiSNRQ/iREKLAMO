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
        $stmt = $conn->prepare("SELECT id,c_name AS complainant, c_address, c_contact, r_name AS respondent, r_address, r_contact, details, date_time AS date, type, location, status , created_by FROM complaint WHERE status = 'active' ORDER BY id DESC");
        $stmt->execute();
        $complaints = $stmt->fetchAll();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        $complaints = [];
    } ?>
<?php try {
        $stmt = $conn->prepare("SELECT id,c_name AS complainant, c_address, c_contact, r_name AS respondent, r_address, r_contact, details, date_time AS date, type, location, status , created_by FROM complaint WHERE status = 'archived'");
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
                                <select id="complaintStatusFilter" class="border border-gray-300 rounded px-3 py-2" onchange="complaintStatusFilter()">
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
                                        'c_address' => $item['c_address'],
                                        'c_contact' => $item['c_contact'],
                                        'respondent' => $item['respondent'],
                                        'r_address' => $item['r_address'],
                                        'r_contact' => $item['r_contact'],
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
                                        'c_address' => $item['c_address'],
                                        'c_contact' => $item['c_contact'],
                                        'respondent' => $item['respondent'],
                                        'r_address' => $item['r_address'],
                                        'r_contact' => $item['r_contact'],
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
                                        'c_address' => $item['c_address'],
                                        'c_contact' => $item['c_contact'],
                                        'respondent' => $item['respondent'],
                                        'r_address' => $item['r_address'],
                                        'r_contact' => $item['r_contact'],
                                        'type' => $item['type'],
                                        'details' => $item['details'],
                                        'date_time' => $item['date'],
                                        'location' => $item['location'],
                                        'created_by' => $item['created_by']
                                    ]), ENT_QUOTES, 'UTF-8') ?>'
                                    onclick="openPrintModal(<?= htmlspecialchars(json_encode([
                                        'id' => $item['id'],
                                        'complainant' => $item['complainant'],
                                        'c_address' => $item['c_address'],
                                        'c_contact' => $item['c_contact'],
                                        'respondent' => $item['respondent'],
                                        'r_address' => $item['r_address'],
                                        'r_contact' => $item['r_contact'],
                                        'type' => $item['type'],
                                        'details' => $item['details'],
                                        'date_time' => $item['date'],
                                        'location' => $item['location'],
                                        'created_by' => $item['created_by']
                                    ]), ENT_QUOTES, 'UTF-8') ?>)">
                                    <i class="fas fa-print mr-1"></i>Print
                                </button>
                            </td>
                        </tr>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
  </div>
    </main>

    <script>
        function complaintStatusFilter() {
            const filterValue = document.getElementById('complaintStatusFilter').value.toLowerCase();
            const tableBody = document.getElementById('complaintTableBody'); // Corrected ID
            if (!tableBody) {
                console.error('Table body with ID "complaintTableBody" not found.');
                return;
            }

            const rows = tableBody.getElementsByTagName('tr');
            const incidentTypeColumnIndex = 4; // Incident Type is the 5th column (0-indexed)

            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];
                const typeCell = row.getElementsByTagName('td')[incidentTypeColumnIndex];

                if (typeCell) {
                    const typeText = typeCell.textContent.trim().toLowerCase();

                    if (filterValue === 'all' || typeText === filterValue) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            }
        }

        function openViewModal(button) {
            const complaint = JSON.parse(button.getAttribute('data-item'));

            // Populate all fields with complaint data
            const viewComplaintId = document.getElementById("viewComplaintId");
            const viewCName = document.getElementById("viewCName");
            const viewRName = document.getElementById("viewRName");
            const viewtype = document.getElementById("viewtype");
            const viewlocation = document.getElementById("viewlocation");
            const viewdetails = document.getElementById("viewdetails");

            if (viewComplaintId) viewComplaintId.value = complaint.id || '';
            if (viewCName) viewCName.value = complaint.complainant || 'N/A';
            if (viewRName) viewRName.value = complaint.respondent || 'N/A';
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
            console.log("openEditModal called with item:", item);
            const editComplaintId = document.getElementById('editComplaintId');
            const editCName = document.getElementById('editCName');
            const editRName = document.getElementById('editRName');
            const editType = document.getElementById('editType');
            const editLocation = document.getElementById('editLocation');
            const editDetails = document.getElementById('editDetails');
            const editStatus = document.getElementById('editStatus');

            if (editComplaintId) editComplaintId.value = item.id || '';
            if (editCName) editCName.value = item.complainant || '';
            if (editRName) editRName.value = item.respondent || '';
            if (editType) editType.value = item.type || '';
            if (editLocation) editLocation.value = item.location || '';
            if (editDetails) editDetails.value = item.details || '';
            if (editStatus) editStatus.value = item.status || 'active';

            const editModal = document.getElementById('editComplaintModal');
            if (editModal && editModal.classList) {
                editModal.classList.remove('hidden');
            }
        }

        // Search functionality
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('complaintSearchInput');
            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    const filter = searchInput.value.toLowerCase();
                    const tableBody = document.getElementById('complaintTableBody');
                    if (!tableBody) return;

                    const rows = tableBody.getElementsByTagName('tr');
                    for (let i = 0; i < rows.length; i++) {
                        const row = rows[i];
                        const complainantCell = row.getElementsByTagName('td')[2]; // Complainant is the 3rd column (0-indexed)
                        if (complainantCell) {
                            const complainantText = complainantCell.textContent.toLowerCase();
                            if (complainantText.includes(filter)) {
                                row.style.display = '';
                            } else {
                                row.style.display = 'none';
                            }
                        }
                    }
                });
            }

            // Ensure the complaint status filter is reset to "All Types" on page load
            const complaintStatusFilterElement = document.getElementById('complaintStatusFilter');
            if (complaintStatusFilterElement) {
                complaintStatusFilterElement.value = 'all';
                complaintStatusFilter(); // Apply the filter
            }
        });

    </script>
    <?php include 'printComplaintModal.php'; ?>
</body>
</html>