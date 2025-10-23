<?php
// Detect current page
$currentPage = basename($_SERVER['PHP_SELF']);

// Function to clean names for display
function cleanName($name) {
    return ucfirst(str_replace(
        [".php", "-", "_"],
        ["", " ", " "],
        $name
    ));
}

// Default breadcrumb path
$breadcrumbs = ["home" => "/Barangay/dashboard.php"];

// Routing logic
switch ($currentPage) {
    case "dashboard.php":
        $breadcrumbs["dashboard"] = "";
        break;
// blotter
    case "blotter.php":
        $breadcrumbs["dashboard"] = "/Barangay/dashboard.php";
        $breadcrumbs["blotter"] = "";
        break;
// complaints
    case "complaints.php":
        $breadcrumbs["dashboard"] = "/Barangay/dashboard.php";
        $breadcrumbs["complaints"] = "";
        break;
// reports
    case "reports.php":
        $breadcrumbs["dashboard"] = "/Barangay/dashboard.php";
        $breadcrumbs["reports"] = "";
        break;
// resident
    case "resident.php":
        $breadcrumbs["dashboard"] = "/Barangay/dashboard.php";
        $breadcrumbs["resident"] = "";
        break;
// settings
    case "settings.php":
        $breadcrumbs["dashboard"] = "/Barangay/dashboard.php";
        $breadcrumbs["settings"] = "";
        break;

    default:
        $breadcrumbs["dashboard"] = "/Barangay/dashboard.php";
        $breadcrumbs[cleanName($currentPage)] = "";
        break;
}
?>

<!-- Breadcrumb UI -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
    <nav class="flex text-sm text-gray-600 mt-2 md:mt-0" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2">
            <?php
            $last = array_key_last($breadcrumbs);
            foreach ($breadcrumbs as $name => $url) {
                $label = ucfirst($name);
                if ($name !== $last) {
                    echo '<li><a href="' . $url . '" class="text-gray-600 hover:text-blue-600">' . $label . '</a></li>';
                    echo '<li><span class="text-gray-400">/</span></li>';
                } else {
                    echo '<li class="text-gray-800 font-semibold">' . $label . '</li>';
                }
            }
            ?>
        </ol>
    </nav>
</div>
