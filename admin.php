<?php
session_start();

include "koneksi.php";

//check jika belum ada user yang login arahkan ke halaman login
if (!isset($_SESSION['username'])) {
  header("location:login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>My Daily Journal | Admin</title>
  <link rel="icon" href="img/logo.png" />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
    crossorigin="anonymous" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
  <style>
    html {
      height: 100%;
    }

    body {
      min-height: 100%;
      display: flex;
      flex-direction: column;
      margin: 0;
    }

    /* Content area grows to fill available space */
    #content {
      flex: 1 0 auto;
    }

    /* Style agar tampilan cropper rapi */
    .img-container {
      width: 100%;
      max-height: 70vh;
      overflow: hidden;
    }

    #image-to-crop {
      max-width: 100%;
      display: block;
    }

    footer {
      flex-shrink: 0;
      width: 100%;
    }

    /* ========================================
       RESPONSIVE STYLES FOR MOBILE
    ======================================== */
    
    /* Modal responsive untuk HP */
    @media (max-width: 768px) {
      /* Fix modal z-index issues */
      .modal {
        z-index: 1055 !important;
      }
      
      .modal-backdrop {
        z-index: 1050 !important;
      }
      
      .modal-dialog {
        margin: 0 !important;
        max-width: 100% !important;
        height: 100%;
        z-index: 1056 !important;
        pointer-events: auto !important;
      }
      
      .modal-dialog.modal-lg {
        max-width: 100% !important;
      }
      
      .modal-content {
        height: 100%;
        max-height: 100vh;
        overflow-y: auto;
        border-radius: 0 !important;
        z-index: 1057 !important;
        pointer-events: auto !important;
        position: relative !important;
      }
      
      .modal-body {
        padding: 1rem;
        overflow-y: auto;
        pointer-events: auto !important;
        position: relative !important;
        z-index: 1058 !important;
      }
      
      /* Ensure all form elements are clickable */
      .modal-body .form-control,
      .modal-body textarea,
      .modal-body input,
      .modal-body button,
      .modal-body .btn {
        pointer-events: auto !important;
        position: relative !important;
        z-index: 1059 !important;
      }
      
      .modal-header,
      .modal-footer {
        padding: 0.75rem 1rem;
        flex-wrap: wrap;
        gap: 0.5rem;
        pointer-events: auto !important;
        position: relative !important;
        z-index: 1058 !important;
      }
      
      .modal-footer .btn,
      .modal-footer input[type="submit"] {
        flex: 1 1 auto;
        min-width: 100px;
        pointer-events: auto !important;
      }
      
      /* Remove any blocking overlays */
      .table-responsive {
        overflow: visible !important;
        position: static !important;
      }
      
      .modal-container {
        position: relative;
        z-index: auto;
      }
      
      .modal-header,
      .modal-footer {
        padding: 0.75rem 1rem;
        flex-wrap: wrap;
        gap: 0.5rem;
      }
      
      .modal-footer .btn {
        flex: 1 1 auto;
        min-width: 100px;
      }
      
      /* Input group responsive */
      .input-group {
        flex-wrap: wrap;
      }
      
      .input-group > .form-control,
      .input-group > textarea.form-control {
        flex: 1 1 100% !important;
        width: 100% !important;
        margin-bottom: 0.5rem;
        border-radius: 0.375rem !important;
      }
      
      .input-group > .btn {
        flex: 1 1 100% !important;
        width: 100% !important;
        border-radius: 0.375rem !important;
      }
      
      /* AI card specific fix */
      .card.bg-light .card-body .input-group {
        display: flex;
        flex-direction: column;
      }
      
      .card.bg-light .card-body .input-group > input,
      .card.bg-light .card-body .input-group > .btn {
        width: 100% !important;
        flex: none !important;
      }
      
      /* Modal input-group fix for Edit/Delete modals */
      .modal .input-group {
        display: flex !important;
        flex-direction: column !important;
      }
      
      .modal .input-group > .form-control,
      .modal .input-group > textarea.form-control,
      .modal .input-group > input[type="text"],
      .modal .input-group > input[type="file"] {
        flex: none !important;
        width: 100% !important;
        margin-bottom: 0.5rem;
        border-radius: 0.375rem !important;
      }
      
      .modal .input-group > .btn,
      .modal .input-group > button {
        flex: none !important;
        width: 100% !important;
        border-radius: 0.375rem !important;
      }
      
      /* Modal form controls full width */
      .modal .form-control,
      .modal textarea.form-control {
        width: 100% !important;
      }
      
      /* Modal body padding for mobile */
      .modal-body .mb-3 {
        width: 100%;
      }
      
      .modal-body .form-control {
        width: 100% !important;
      }
      
      /* Section padding responsive */
      #content {
        padding: 1rem !important;
      }
      
      /* Table responsive */
      .table-responsive {
        font-size: 0.875rem;
      }
      
      .table td,
      .table th {
        padding: 0.5rem;
        vertical-align: middle;
      }
      
      .table img {
        max-width: 80px;
        height: auto;
      }
      
      /* Dashboard cards responsive */
      .card {
        margin-bottom: 1rem;
      }
      
      .card-body {
        padding: 0.75rem;
      }
      
      .card-body .d-flex {
        flex-wrap: wrap;
      }
      
      .card-body .p-3 {
        padding: 0.5rem !important;
      }
      
      /* Form elements responsive */
      .form-control,
      .form-select {
        font-size: 16px; /* Prevents zoom on iOS */
      }
      
      textarea.form-control {
        min-height: 100px;
      }
      
      /* Button responsive */
      .btn {
        padding: 0.5rem 0.75rem;
        font-size: 0.9rem;
      }
      
      /* Cropper modal responsive */
      #modalCrop .modal-body {
        padding: 0.5rem;
      }
      
      #modalCrop .img-container {
        max-height: 50vh;
      }
      
      #modalCrop .modal-footer {
        flex-direction: column;
        align-items: stretch;
      }
      
      #modalCrop .modal-footer .me-auto {
        margin: 0 0 0.5rem 0 !important;
        display: flex;
        justify-content: center;
        gap: 0.5rem;
      }
      
      /* AI generation section responsive */
      .card.bg-light .input-group {
        flex-direction: column;
      }
      
      .card.bg-light .input-group .form-control {
        border-radius: 0.375rem !important;
        margin-bottom: 0.5rem;
      }
      
      .card.bg-light .input-group .btn {
        border-radius: 0.375rem !important;
        width: 100%;
      }
      
      /* List group responsive */
      .list-group-item {
        padding: 0.75rem;
      }
      
      .list-group-item h6 {
        font-size: 0.9rem;
      }
      
      /* Navbar responsive */
      .navbar-brand {
        font-size: 1rem;
      }
      
      /* Footer responsive */
      footer {
        position: relative;
        height: auto;
        padding: 1.5rem !important;
      }
      
      footer h6 {
        font-size: 0.85rem;
      }
      
      /* Page title responsive */
      .display-6 {
        font-size: 1.5rem;
      }
      
      /* Pagination responsive */
      .pagination {
        flex-wrap: wrap;
        gap: 0.25rem;
      }
      
      .page-link {
        padding: 0.375rem 0.5rem;
        font-size: 0.85rem;
      }
    }
    
    /* Extra small screens */
    @media (max-width: 480px) {
      .modal-title {
        font-size: 1rem;
      }
      
      .form-label {
        font-size: 0.9rem;
      }
      
      .table {
        font-size: 0.8rem;
      }
      
      .badge {
        font-size: 0.7rem;
        padding: 0.3rem 0.5rem;
      }
      
      /* Stack action buttons */
      td .badge {
        display: inline-block;
        margin: 0.1rem;
      }
    }
  </style>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js" defer></script>

</head>

<body>
  <!-- nav begin -->
  <nav class="navbar navbar-expand-sm bg-body-tertiary sticky-top bg-danger-subtle">
    <div class="container">
      <a class="navbar-brand" target="_blank" href=".">My Daily Journal</a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 text-dark">
          <li class="nav-item">
            <a class="nav-link" href="admin.php?page=dashboard">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="admin.php?page=article">Article</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-danger fw-bold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <?= $_SESSION['username'] ?>
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="logout.php">Logout</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- nav end -->

  <!-- content begin -->
  <section id="content" class="p-5">
    <div class="container">
      <?php
      if (isset($_GET['page'])) {
      ?>
        <h4 class="lead display-6 pb-2 border-bottom border-danger-subtle"><?= ucfirst($_GET['page']) ?></h4>
      <?php
        include($_GET['page'] . ".php");
      } else {
      ?>
        <h4 class="lead display-6 pb-2 border-bottom border-danger-subtle">Dashboard</h4>
      <?php
        include("dashboard.php");
      }
      ?>
    </div>
  </section>

  <!-- content end -->
  <!-- footer begin -->
  <footer id="footer" class="text-center p-5 bg-danger-subtle">
      <h6><span class="text-footer">Kelompok 1 </span>Pemrograman Berbasis Web &copy; 2026</h6>
  </footer>
  <!-- footer end -->
</body>

</html>