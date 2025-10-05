<?php
$title = "Dashboard";

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once 'config.php'; // db connection
require_once 'head.php';


// --- Complaints per month (exclude transfer & archived)
// FIX: Using '%b %Y' for month name display and '%Y-%m' for correct ordering.
$complaintsPerMonth = $conn->query("
    SELECT 
        DATE_FORMAT(date_time, '%Y-%m') AS sort_month,
        DATE_FORMAT(date_time, '%b %Y') AS month,
        COUNT(*) AS total
    FROM complaint
    WHERE LOWER(status) = 'active'
    GROUP BY sort_month, month
    ORDER BY sort_month ASC
")->fetchAll(PDO::FETCH_ASSOC);


// --- Blotter type trends
$blotterTrends = $conn->query("
    SELECT type, COUNT(*) AS total
    FROM blotter
    WHERE status NOT IN ('resolved','withdraw')
    GROUP BY type
    ORDER BY total DESC
")->fetchAll(PDO::FETCH_ASSOC);

// --- Resolved per month (complaints + blotter)
// FIX: Query modified to only count 'resolved' cases from the blotter table.
$resolvedPerMonth = $conn->query("
    SELECT 
        DATE_FORMAT(updated_at, '%Y-%m') AS sort_month,
        DATE_FORMAT(updated_at, '%b %Y') AS month,
        COUNT(*) AS total
    FROM blotter 
    WHERE status = 'resolved'
    GROUP BY sort_month, month
    ORDER BY sort_month ASC
")->fetchAll(PDO::FETCH_ASSOC);

// --- Totals
$totalBlotter = $conn->query("
    SELECT COUNT(*) FROM blotter where status != 'withdraw' AND status != 'resolved'
")->fetchColumn();

$totalComplaints = $conn->query("
    SELECT COUNT(*) FROM complaint WHERE status = 'active'
")->fetchColumn();

// --- FIXED: Total Resolved (Only counts 'resolved' status from the blotter table)
$totalResolved = $conn->query("
    SELECT COUNT(*) FROM blotter WHERE status = 'resolved'
")->fetchColumn();


// echo count(array_filter($activeBlotters, fn($b) => $b['status'] === 'resolved'));

// Fetch officials from database
$brgy_official = $conn->query("SELECT name, position FROM barangay_officials ORDER BY position")->fetchAll(PDO::FETCH_ASSOC);
if(empty($brgy_official)) {
    $brgy_official = [];
    // Fallback data if table doesn't exist yet
    $brgy_official[] = ['name' => 'Charles Dj. Manalad', 'position' => 'Punong Barangay'];
    $brgy_official[] = ['name' => 'Nandy L. San Buenaventura', 'position' => 'Barangay Secretary'];
    $brgy_official[] = ['name' => 'Ramil T. Borre', 'position' => 'Barangay Kagawad'];
    $brgy_official[] = ['name' => 'Manuel S. Paguyo', 'position' => 'President'];
    $brgy_official[] = ['name' => 'Sammer D. Hadjimanan', 'position' => 'Vice President'];
}
?>
<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td {
        border-bottom: 1px solid #ddd;
        padding: 4px;
    }
    th {
        text-align: left;
    }
</style>

    <div class=" grid gap-2 w-full md:gap-2">
      <div class="row row-span-15 grid sm:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-5">
        <div class="col bg-white rounded-lg inset-shadow-md shadow-sm grid grid-cols-3 hover:shadow-md">
          <div class="col-span-2 border-r border-[#dbeafe] flex justify-center items-center text-2xl text-wrap font-bold"><h1>Blotter Cases</h1></div>
          <div class="flex justify-center items-center bg-[#dbeafe] text-[#1d4ed8] text-3xl font-bold"><p class="blotter-count"><?php echo $totalBlotter; ?></p></div>
        </div>
        <div class="col bg-white rounded-lg grid grid-cols-3">
          <div class="col-span-2 flex justify-center items-center text-2xl font-bold">
            <h1>Complaint Cases</h1>
          </div>
          <div class="flex justify-center items-center bg-[#fef3c7] text-[#b45309] text-3xl font-bold">
            <p class="complaint-count"><?php echo $totalComplaints; ?></p>
          </div>
        </div>

        <div class="col bg-white rounded-lg inset-shadow-md shadow-sm grid grid-cols-3 hover:shadow-md">
          <div class="col-span-2 border-r border-[#dcfce7] flex justify-center items-center text-2xl text-wrap font-bold"><h1>Resolved Cases </h1></div>
          <div class="flex justify-center items-center bg-[#dcfce7] text-[#166534] text-3xl font-bold"><p class="resolved-count"><?php echo $totalResolved; ?></p></div>
        </div>
      </div>

      <div class="row row-span-52 grid rounded-lg gap-3
      xl:grid-cols-4 xl:grid-rows-1
      lg:grid-cols-4 lg:grid-rows-1
      md:grid-rows-3 md:grid-cols-1
      sm:grid-rows-3 sm:grid-cols-1">
        <div class="rounded-lg h-full grid gap-2 md:gap-3 
        xl:col-span-1
        lg:col-span-1
        sm:row-span-1 sm:grid-cols-2
        xl:grid-rows-2 xl:grid-cols-1 
        lg:grid-rows-2 xl:grid-cols-1
        md:row-span-1 md:grid-cols-2">
          
          <div class="row-span-1 bg-white inset-shadow-sm p-2 md:p-4 shadow-md grid grid-row-7 gap-2">
            <div class="text-center font-bold bg-gray-300"><h2 class="text-lg">Barangay Official</h2></div>
            <div class="row-span-6 grid grid-rows-4 h-full max-h-[300px] overflow-y-auto">
              <?php foreach ($brgy_official as $official): ?>
              <div class="grid grid-rows-2 text-center">
                <div class="name">
                  <h1 class="text-lg font-semibold"><?php echo $official['name']; ?></h1>
                </div>
                <div class="position text-gray-600 text-sm">
                  <p class="text-sm "><?php echo $official['position']; ?></p>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
          </div>

          <div class="row-span-1 bg-white inset-shadow-sm p-2 md:p-4 shadow-md">
            <h1 class="text-center font-bold text-lg">Resolved Cases per Month</h1>
            <div class="relative h-full max-h-[300px] overflow-y-auto p-2"> 
                <canvas id="resolvedChart" class="w-full h-full"></canvas>
            </div>
          </div>
        </div>

        <div class="h-full rounded-lg grid grid-rows-2
        xl:col-span-3
        md:row-span-2 gap-2
        sm:row-span-2">


          <div class="row-span-1 bg-white rounded-md inset-shadow-sm px-2 md:p-4 shadow-md">
            <h1 class="text-center font-bold text-lg">Total of Complaints per Months</h1>
            <div class="relative h-full max-h-[300px] overflow-y-auto p-1">
                <canvas id="complaintsChart" class="w-full h-full"></canvas>
            </div>
          </div>

          <div class="row-span-1 bg-white rounded-md inset-shadow-sm px-2 md:p-4 shadow-md">
            <h1 class="text-center font-bold text-lg">Blotter Type Trends</h1>
            <div class="relative h-full max-h-[300px] overflow-y-auto p-2">
                <canvas id="blotterChart" class="w-full h-full"></canvas> 
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

<script>
const complaintsPerMonth = <?php echo json_encode($complaintsPerMonth); ?>;
const blotterTrends = <?php echo json_encode($blotterTrends); ?>;
const resolvedPerMonth = <?php echo json_encode($resolvedPerMonth); ?>;

const totalBlotter = <?php echo (int)$totalBlotter; ?>;
const totalComplaints = <?php echo (int)$totalComplaints; ?>;
const totalResolved = <?php echo (int)$totalResolved; ?>;
</script>

<script>
document.addEventListener("DOMContentLoaded", () => {
    
    // Configuration object to fix blurriness and responsiveness
    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false, // Prevents chart from expanding infinitely based on its own ratio
        plugins: {
            legend: {
                position: 'top',
            },
        }
    };
    
    // Complaints per month
    new Chart(document.getElementById("complaintsChart"), {
        type: "bar",
        data: {
            // Using the 'month' field which is now 'Mon YYYY'
            labels: complaintsPerMonth.map(r => r.month), 
            datasets: [{
                label: "Complaints",
                data: complaintsPerMonth.map(r => r.total),
                backgroundColor: "#f59e0b"
            }]
        },
        options: chartOptions
    });

    // Blotter trends
    new Chart(document.getElementById("blotterChart"), {
        type: "pie",
        data: {
            labels: blotterTrends.map(r => r.type),
            datasets: [{
                label: "Blotter Cases",
                data: blotterTrends.map(r => r.total),
                backgroundColor: ["#3b82f6","#10b981","#f59e0b","#ef4444","#6366f1"]
            }]
        },
        options: chartOptions
    });

    // Resolved cases per month
    new Chart(document.getElementById("resolvedChart"), {
        type: "line",
        data: {
            // Using the 'month' field which is now 'Mon YYYY'
            labels: resolvedPerMonth.map(r => r.month), 
            datasets: [{
                label: "Resolved",
                data: resolvedPerMonth.map(r => r.total),
                borderColor: "#16a34a",
                backgroundColor: "rgba(22,163,74,0.2)",
                fill: true
            }]
        },
        options: chartOptions
    });
});
</script> 

<!-- <script>
fetch('data.php')
  .then(r => r.json())
  .then(data => {
    // Complaints per month
    const ctx1 = document.getElementById('complaintsChart').getContext('2d');
    new Chart(ctx1, {
      type: 'bar',
      data: {
        labels: data.months,
        datasets: [{
          label: 'Active Complaints',
          data: data.complaintsPerMonth,
          borderWidth: 1
        }]
      }
    });

    // Resolved per month
    const ctx2 = document.getElementById('resolvedChart').getContext('2d');
    new Chart(ctx2, {
      type: 'line',
      data: {
        labels: data.months,
        datasets: [{
          label: 'Resolved',
          data: data.resolvedPerMonth,
          borderWidth: ,
          fill: false
        }]
      }
    });

    // You can also build blotter trends from data.blotterTrends
    console.log('totals', data.totals);
    document.querySelector('.blotter-count').textContent = data.totals.totalBlotter;
    document.querySelector('.complaint-count').textContent = data.totals.totalComplaints;
    document.querySelector('.resolved-count').textContent = data.totals.totalResolved;
  });
</script> -->