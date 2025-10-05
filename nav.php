<?php
$currentPage = basename($_SERVER['PHP_SELF']); 

// Complaints section pages
$complaintsPages = ['complaints.php', 'new_complaint.php', 'resolved.php'];

// Modules section pages
$modulePages = ['reports.php', 'settings.php'];

// Check if current page belongs to complaints or module group
$complaintsOpen = in_array($currentPage, $complaintsPages);
$moduleOpen = in_array($currentPage, $modulePages);
?>

<div class="pt-2">
  <h1 class="text-4xl font-bold text-[1.7rem] px-6 py-2 xl:text-2xl lg:text-lg md:text-md sm:text-sm">
    <a href="dashboard.php">
    <i class="fa-sharp fas fa-hand-fist text-[2.5rem] xl:text-4xl lg:text-2xl md:text-xl sm:text-md m-2"></i>
    <span class=" tracking-wide"> iREKLAMO+</span></a>
    <!-- <span class="bg-gradient-to-r from-slate-900 to-red-600 bg-clip-text text-transparent  tracking-wide"> iREKLAMO+</span> -->
  </h1>
</div>
<hr class="border-t border-gray-300 py-2" />

<ul class="flex flex-col h-full nav font-light mx-2">

    <!-- Dashboard -->
    <li class="my-1">
        <a href="dashboard.php"
        class="text-md px-8 py-3 font-semibold rounded-lg flex items-center
        <?= $currentPage == 'dashboard.php' ? 'text-white bg-blue-900' : 'hover:bg-blue-700 hover:text-white text-gray-500'; ?>">
        <i class="fa fa-home mr-8"></i> Dashboard
        </a>
    </li>
    <!-- <hr class="border-gray-300"> -->
    <!-- Blotter -->
    <li class="my-1">
        <a href="blotter.php"
        class="text-md px-8 py-3 font-semibold rounded-lg flex items-center
        <?= $currentPage == 'blotter.php' ? 'text-white bg-blue-900' : 'hover:bg-blue-700 hover:text-white text-gray-500'; ?>">
        <i class="fa fa-file-alt mr-8"></i> Blotter
        </a>
    </li>
    <!-- <li class="my-1">
      <a href="active.php"
        class="text-md px-8 py-3 font-semibold rounded-lg flex items-center
        <?= $currentPage == 'active.php' ? 'text-white bg-blue-900' : 'hover:bg-blue-700 hover:text-white text-gray-500'; ?>">
        <i class="fa fa-file-alt mr-8"></i> Active Cases
      </a>
    </li> -->
    <!-- <hr class="border-gray-300"> -->
    <!-- Complaints -->
    <li class="my-1">
        <a href="complaints.php"
        class="text-md px-8 py-3 font-semibold rounded-lg flex items-center
        <?= $currentPage == 'complaints.php' ? 'text-white bg-blue-900' : 'hover:bg-blue-700 hover:text-white text-gray-500'; ?>">
        <i class="fa fa-comment-dots mr-8"></i> Complaints
        </a>
    </li>
    <!-- Reports -->
    <li class="my-1">
        <a href="reports.php"
        class="text-md px-8 py-3 font-semibold rounded-lg flex items-center
        <?= $currentPage == 'reports.php' ? 'text-white bg-blue-900' : 'hover:bg-blue-700 hover:text-white text-gray-500'; ?>">
        <i class="fa fa-folder mr-8"></i> Reports
        </a>
    </li>

  </ul>
<ul class="w-full border-t border-gray-300 ">
      <!-- Settings -->
    <li class="my-1">
        <a href="settings.php"
        class="text-md px-8 py-3 font-semibold rounded-lg flex items-center
        <?= $currentPage == 'settings.php' ? 'text-white bg-blue-900' : 'hover:bg-blue-700 hover:text-white text-gray-500'; ?>">
        <i class="fa fa-cog mr-8"></i> Settings
        </a>
    </li>
    <hr class="border-gray-300">
  <li>
    <a href="index.php"
      class="text-2xl py-3 font-semibold rounded-lg flex gap-2 bg-gray-100 items-center hover:bg-blue-700 hover:text-white sticky-bottom text-gray-500">
      <i class="fa fa-sign-out-alt mx-8"></i>
      <h1 class="text-lg text-center">Logout</h1>
    </a>
  </li>
</ul>

<script>
  function toggleDropdown(id) {
    document.getElementById(id).classList.toggle("hidden");
  }
</script>
