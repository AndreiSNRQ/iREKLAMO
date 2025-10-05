<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $complainant = $_POST['complainant'];
    $respondent = $_POST['respondent'];
    $type = $_POST['type'];
    $details = $_POST['details'];
    $date = $_POST['date'];
    $location = $_POST['location'];
    
    // Process the data and generate the complaint document
    header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    header('Content-Disposition: attachment; filename="complaint_' . $id . '.docx"');
    
    // Read the template file
    $template = file_get_contents('print/complaint.docx');
    
    // Replace placeholders with actual data
    $template = str_replace('{{COMPLAINANT}}', $complainant, $template);
    $template = str_replace('{{RESPONDENT}}', $respondent, $template);
    $template = str_replace('{{TYPE}}', $type, $template);
    $template = str_replace('{{DETAILS}}', $details, $template);
    $template = str_replace('{{DATE}}', $date, $template);
    $template = str_replace('{{LOCATION}}', $location, $template);
    
    echo $template;
    header('Location: blotter.php');
    exit;
}
?>

<div id="printComplaintModal" class="hidden fixed inset-0 backdrop-blur-sm overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Print Complaint</h3>
            <button onclick="document.getElementById('printComplaintModal').classList.add('hidden')" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="mb-4">
            <form id="printComplaintForm" action="print/print_complaint.php" method="post" target="_blank">
                <input type="hidden" name="id" id="printId">
                <input type="hidden" name="c_name" id="printComplainant">
                <input type="hidden" name="r_name" id="printRespondent">
                <input type="hidden" name="type" id="printType">
                <input type="hidden" name="details" id="printDetails">
                <input type="hidden" name="date" id="printDate">
                <input type="hidden" name="location" id="printLocation">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Complainant</label>
                        <p class="text-gray-700" id="modalComplainant"></p>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Respondent</label>
                        <p class="text-gray-700" id="modalRespondent"></p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Case Type</label>
                        <p class="text-gray-700" id="modalType"></p>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Incident Date</label>
                        <p class="text-gray-700" id="modalDate"></p>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Incident Location</label>
                    <p class="text-gray-700" id="modalLocation"></p>
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Details</label>
                    <p class="text-gray-700" id="modalDetails"></p>
                </div>
                
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('printComplaintModal').classList.add('hidden')" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-print mr-2"></i>Print
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openPrintModal(item) {
    const complainant = item.complainant || item.c_name || '';
    const respondent = item.respondent || item.r_name || '';
    const id = item.id || item.id;
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
            document.getElementById('modalMonth').textContent = d.toLocaleString('default', { month: 'long' });
            document.getElementById('modalDay').textContent = d.getDate();
            document.getElementById('modalYear').textContent = d.getFullYear();
        }
    }
}
</script>