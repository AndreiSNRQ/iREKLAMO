<?php

// connection
require_once 'config.php';
// complaint
// require_once 'complaintC/addComplaint.php';
// require_once 'complaintC/archiveComplaint.php';
// require_once 'complaintC/complaintModal.php';
// require_once 'complaintC/restoreComplaint.php';
// require_once 'complaintC/updateComplaint.php';
// Blotter
include 'blotterModal.php';


?>
<!doctype html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>iREKLAMO+ | <?php echo $title; ?></title>
    <link rel="icon" href="pics/brgylogo.png"/>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap');

      .permanent-marker-regular {
          font-family: "Permanent Marker", cursive;
          font-weight: 400;
          font-style: normal;
      }
      .nav li a {
          transition: all 0.3s ease;
      }
    </style>
  </head>
  <body class="bg-[#f3f5ff]">
    <div class="grid grid-cols-13 min-h-screen">
      
      <!-- Sidebar -->
      <div class="sidenav col-span-2 bg-white border-r border-gray-200 flex flex-col sticky top-0 h-screen">
        <?php require_once 'nav.php' ?>
      </div>

      <!-- Main Content -->
      <div class="col-span-11 flex flex-col px-2 py-2 md:px-5 transition-all">
        <?php require_once 'header.php'; ?>