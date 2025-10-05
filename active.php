<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once 'config.php'; // db connection
require_once 'head.php';
$title = "Blotter";

// Include blotter modals

// $sql = "SELECT * FROM blotter ORDER BY date_time DESC";
// $stmt = $conn->query($sql);
// $blotters = $stmt->fetchAll(PDO::FETCH_ASSOC);
$blotter = [
    [
        'id'=> '1', 'c_name' => 'Andrei', 'r_name'=>'okey', 'details'=>'fds', 'date_time'=> '01-12-2025','status'=>'1st trial'
    ],
    [
        'id'=> '2', 'c_name' => 'Andrei', 'r_name'=>'okey', 'details'=>'fds', 'date_time'=> '01-12-2025','status'=>'2nd trial'
    ],
    [
        'id'=> '3', 'c_name' => 'Andrei', 'r_name'=>'okey', 'details'=>'fds', 'date_time'=> '01-12-2025','status'=>'3rd trial'
    ],
    [
        'id'=> '4', 'c_name' => 'Andrei', 'r_name'=>'okey', 'details'=>'fds', 'date_time'=> '01-12-2025','status'=>'1st trial'
    ],
    ]

?>

<?php 
    // try {
    //     $stmt = $conn->prepare("SELECT id,c_name, r_name, details, date_time AS date, type, location, status , created_by FROM blotter WHERE status = 'withdraw'");
    //     $stmt->execute();
    //     $withdraw = $stmt->fetchAll();
    // } catch(PDOException $e) {
    //     echo "Error: " . $e->getMessage();
    //     $withdraw = [];
    // } 

    // try {
    //     $stmt = $conn->prepare("SELECT id,c_name, r_name, details, date_time AS date, type, location, status , created_by FROM blotter WHERE status = 'archived'");
    //     $stmt->execute();
    //     $archived = $stmt->fetchAll();
    // } catch(PDOException $e) {
    //     echo "Error: " . $e->getMessage();
    //     $archived = [];
    // } 
    // try {
    //     $stmt = $conn->prepare("SELECT id,c_name, r_name, details, date_time AS date, type, location, status , created_by FROM blotter WHERE status = 'resolved'");
    //     $stmt->execute();
    //     $resolved = $stmt->fetchAll();
    // } catch(PDOException $e) {
    //     echo "Error: " . $e->getMessage();
    //     $resolved = [];
    // } 

include 'blotterModal.php';


    ?>
<div class="flex flex-col w-full">
    <!-- Blotter Status Counters -->
    <div class="grid grid-cols-9 p-2 gap-3">
        <div class="bg-white rounded-md shadow-md p-2 grid grid-rows-2">
            <div class="text-sm text-gray-500 mt-3">Active Cases</div>
            <div class="text-xl font-semibold "><?php echo count($blotter) ?></div>
        </div>
        <div class="bg-white rounded-md shadow-md p-2 grid grid-rows-2">
            <div class="text-sm text-gray-500 mt-3">First Trial</div>
            <div class="text-xl font-semibold "><?php echo count(array_filter( $blotter,fn($b) => $b['status'] === '1st trial')); ?></div>
        </div>
        <div class="bg-white rounded-md shadow-md p-2 grid grid-rows-2">
            <div class="text-sm text-gray-500 mt-3">Second Trial</div>
            <div class="text-xl font-semibold "><?php echo count(array_filter($blotter, fn($b) => $b['status'] === '2nd trial')); ?></div>
        </div>
        <div class="bg-white rounded-md shadow-md p-2 grid grid-rows-2">
            <div class="text-sm text-gray-500 mt-3">Third Trial</div>
            <div class="text-xl font-semibold "><?php echo count(array_filter($blotter, fn($b) => $b['status'] === '3rd trial')); ?></div>
        </div>
    </div>
    
    <!-- Session Messages -->
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            <p><?= htmlspecialchars($_SESSION['success_message']) ?></p>
            <?php unset($_SESSION['success_message']); ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['form_errors'])): ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            <?php foreach ($_SESSION['form_errors'] as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
            <?php unset($_SESSION['form_errors']); ?>
        </div>
    <?php endif; ?>
    
    <!-- Blotter Filter -->
    <div class="bg-white rounded-lg inset-shadow-md shadow-md mt-4 p-3 md:p-5">
        <div class="px-4 py-3 flex flex-col md:flex-row justify-between items-start md:items-center bg-gray-50 gap-4">
            <div class="flex flex-col md:flex-row items-start md:items-center gap-2 w-full md:w-auto">
                <label class="text-sm">Filter:</label>
                <select class="border rounded px-2 py-1 text-sm w-full md:w-auto" id="statusFilter">
                    <option value="all">All Statuses</option>
                    <option value="1st trial">First Trial</option>
                    <option value="2nd trial">Second Trial</option>
                    <option value="3rd trial">Third Trial</option>
                </select>
            </div>
            <div class="relative w-full md:w-auto">
                <input type="text" placeholder="Search..." class="border rounded px-3 py-1 text-sm w-full" id="searchInput">
            </div>
        </div>
    <!-- Blotter Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 table-fixed">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-3 md:px-6 py-3 w-1/16 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="sortTable(0)">ID <i class="fas fa-sort"></i></th>
                    <th class="px-3 md:px-6 py-3 w-1/8 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Blotter Number</th>
                    <th class="px-3 md:px-6 py-3 w-1/8 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Complainant</th>
                    <th class="px-3 md:px-6 py-3 w-1/8 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Respondent</th>
                    <th class="px-3 md:px-6 py-3 w-1/8 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="sortTable(1)">Date <i class="fas fa-sort"></i></th>
                    <th class="px-3 md:px-6 py-3 w-1/8 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="sortTable(3)">Status <i class="fas fa-sort"></i></th>
                    <th class="px-3 md:px-6 py-3 w-1/16 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200" id="complaintsTable">
                <?php                
                // Pagination logic
                $itemsPerPage = 10;
                $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $filteredBlotters = array_filter($blotters, fn($b) => $b['status'] !== '1st trial' && $b['status'] !== '2nd trial' && $b['status'] !== '3rd trial');
                $totalPages = ceil(count($filteredBlotters) / $itemsPerPage);
                $currentPage = max(1, min($currentPage, $totalPages));
                $offset = ($currentPage - 1) * $itemsPerPage;
                $paginatedBlotters = array_slice($filteredBlotters, $offset, $itemsPerPage);

                foreach($paginatedBlotters as $blotter):
                    $statusColor = [
                        '1st trial' => 'bg-blue-100 text-blue-800',
                        '2nd trial' => 'bg-red-100 text-red-800',
                        '3rd trial' => 'bg-red-200 text-red-900',
                    ][$blotter['status']] ?? 'bg-gray-100 text-gray-800';
                ?>
                <tr class="blotter-row" data-status="<?= $blotter['status'] ?>" data-id="<?= $blotter['id'] ?>" data-r-name="<?= $blotter['r_name'] ?>" data-c-name="<?= $blotter['c_name'] ?>" data-type="<?= $blotter['type'] ?>">
                    <td class="px-3 md:px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo $offset + array_search($blotter, $paginatedBlotters) + 1; ?></td>
                    <td class="px-3 md:px-6 py-4 whitespace-nowrap text-sm text-gray-500">B-<?= $blotter['id'] ?></td>
                    <td class="px-3 md:px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $blotter['c_name'] ?></td>
                    <td class="px-3 md:px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $blotter['r_name'] ?></td>
                    <td class="px-3 md:px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= date('M d, Y', strtotime($blotter['date_time'])) ?></td>
                    <td class="px-3 md:px-6 py-4 whitespace-nowrap text-sm">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold <?= $statusColor ?>">
                            <?= ucfirst($blotter['status']) ?>
                        </span>
                    </td>
                    <td class="px-3 md:px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <button onclick="openViewModal(<?= $blotter['id'] ?>)" class="text-blue-600 hover:text-blue-900 mx-3"><i class="fas fa-eye mr-1"></i>View</button>
                        <button onclick="openEditModal(<?= $blotter['id'] ?>)" class="text-green-600 hover:text-green-900 mx-3"><i class="fas fa-edit mr-1"></i>Edit</button>
                        <button onclick="openPrintModal(<?= $blotter['id'] ?>)" class="text-red-600 hover:text-red-900 mx-3"><i class="fas fa-print mr-1"></i>Print</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="px-4 py-2 flex items-center justify-between border-t border-gray-200 bg-gray-50">
        <div class="flex-1 flex justify-between sm:hidden">
            <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">Previous</a>
            <a href="#" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">Next</a>
        </div>
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Showing <span class="font-medium"><?= $offset + 1 ?></span> to <span class="font-medium"><?= min($offset + $itemsPerPage, count($blotters)) ?></span> of <span class="font-medium"><?= count($blotters) ?></span> results
                </p>
            </div>
            <div>
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                    <a href="?page=<?= max(1, $currentPage - 1) ?>" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 <?= $currentPage == 1 ? 'opacity-50 cursor-not-allowed' : '' ?>">
                        <span class="sr-only">Previous</span>
                        <i class="fas fa-chevron-left"></i>
                    </a>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?= $i ?>" class="relative inline-flex items-center px-4 py-2 border text-sm font-medium <?= $i == $currentPage ? 'bg-blue-50 border-blue-500 text-blue-600' : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>
                    <a href="?page=<?= min($totalPages, $currentPage + 1) ?>" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 <?= $currentPage == $totalPages ? 'opacity-50 cursor-not-allowed' : '' ?>">
                        <span class="sr-only">Next</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </nav>
            </div>
        </div>
    </div>
</div>

<script>
// Sorting functionality
let sortDirection = 1;
function sortTable(columnIndex) {
    const table = document.getElementById('complaintsTable');
    const rows = Array.from(table.querySelectorAll('tr'));
    
    rows.sort((a, b) => {
        const aValue = a.cells[columnIndex].textContent.trim();
        const bValue = b.cells[columnIndex].textContent.trim();
        return aValue.localeCompare(bValue) * sortDirection;
    });
    
    // Rebuild table
    rows.forEach(row => table.appendChild(row));
    sortDirection *= -1;
}

// Filter functionality
document.getElementById('statusFilter').addEventListener('change', function() {
    const status = this.value;
    document.querySelectorAll('.blotter-row').forEach(row => {
        if (status === 'all') {
            // show all except archived
            row.style.display = row.dataset.status === 'archived' ? 'none' : '';
        } else if (status === 'archived') {
            // show only archived
            row.style.display = row.dataset.status === 'archived' ? '' : 'none';
        } else {
            // show only matching, exclude archived
            row.style.display = (row.dataset.status === status && row.dataset.status !== 'archived') ? '' : 'none';
        }
    });
});

// Search functionality
document.getElementById('searchInput').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    document.querySelectorAll('.blotter-row').forEach(row => {
        const text = row.innerText.toLowerCase();
        if (row.style.display !== 'none') {
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        }
    });
});

// Modal functions
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
                const blotter = data.data;
                document.getElementById('edit_status_id').value = blotter.id;
                document.getElementById('edit_status_current').textContent = blotter.status;
                document.getElementById('editStatusModal').classList.remove('hidden');
                
                // Set the current status in the dropdown
                const statusSelect = document.getElementById('edit_status');
                if (statusSelect) {
                    statusSelect.value = blotter.status;
                }
                
                // Enable form fields after loading
                document.querySelectorAll('#editStatusModal input, #editStatusModal select, #editStatusModal textarea')
                    .forEach(field => field.disabled = false);
                
                // Add form submission handler
                document.getElementById('editStatusForm').addEventListener('submit', function(e) {
                    e.preventDefault();
                    const formData = new FormData(this);
                    
                    fetch(this.action, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast('Status updated successfully', 'success');
                            document.getElementById('editStatusModal').classList.add('hidden');
                            if (data.refresh) {
                                location.reload();
                            }
                        } else {
                            showToast(data.message || 'Failed to update status', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('Network error updating status', 'error');
                    });
                });
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

let currentBlotterId;

function openPrintModal(id) {
    currentBlotterId = id;
    openPrintOptionsModal(id);
}

function openAddModal() {
    document.getElementById('addBlotterModal').classList.remove('hidden');
}

function closeAddModal() {
    document.getElementById('addBlotterModal').classList.add('hidden');
}

function openResolvedCasesModal() {
    const modal = document.getElementById('resolvedBlotterModal');
    if (!modal) return console.warn('resolvedBlotterModal not found');
    modal.classList.remove('hidden');
    loadResolvedBlotters();
}

function closeResolvedBlotlerModal() {
    const modal = document.getElementById('resolvedBlotterModal');
    if (!modal) return;
    modal.classList.add('hidden');
}

// ensure the Close button calls closeResolvedBlotlerModal() (note spelling) or change as needed
function closeResolvedBlotterModal() { // safer duplicate with correct spelling
    const modal = document.getElementById('resolvedBlotterModal');
    if (!modal) return;
    modal.classList.add('hidden');
}

function escapeHtml(s) {
    if (s == null) return '';
    return String(s)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
}

function loadBlotterCasesForReport() {
    // This would typically be an AJAX call to get active blotter cases
    console.log('Loading blotter cases for report generation...');
    // For now, we'll just add a placeholder option
    const select = document.getElementById('report_blotter_id');
    // Clear existing options except the first one
    while (select.options.length > 1) {
        select.remove(1);
    }
    // Add a placeholder option
    const option = document.createElement('option');
    option.value = 'placeholder';
    option.text = 'Sample Blotter Case';
    select.add(option);
}

function loadPendingReports() {
    // This would typically be an AJAX call to get pending reports
    console.log('Loading pending reports...');
    // For now, we'll just show a placeholder message
    document.getElementById('pendingReportsTableBody').innerHTML = '<tr><td colspan="6" class="px-6 py-4 text-center">Loading pending reports...</td></tr>';
}

function printSummon(blotterId) {
    fetch(`print/summon.php?id=${blotterId}`, {
            headers: {
                'Accept': 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.blob();
        })
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'summon.docx';
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
            document.body.removeChild(a);
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Failed to download summon document', 'error');
        });
}
</script>