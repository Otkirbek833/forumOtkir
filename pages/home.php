<?php
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'DOSTIM';
?>

<!DOCTYPE html>
<html lang="uz">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>BAS BET</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      background-image: url('https://www.jamie-anderson.com/wp-content/uploads/2013/05/make-money-on-internet-forums.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      color: white;
    }

    .overlay {
      background-color: rgba(0, 0, 0, 0.6); /* qora shaffof fon */
      min-height: 100vh;
      padding-top: 50px;
    }

    .navbar, .card {
      background-color: rgba(0, 0, 0, 0.8) !important;
    }
  </style>
</head>
<body>

<div class="overlay">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand" href="#">ONLINE FORUM PLATFORMASI</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
           
           <?php if (isset($_SESSION['username'])): ?>
            <li class="nav-item"><a class="nav-link" href="logout.php">SHIǴIW</a></li>
          <?php else: ?>
            <li class="nav-item"><a class="nav-link" href="../login.html">DIZIMGE KIRIW</a></li>
            <li class="nav-item"><a class="nav-link" href="../register.html">DIZIMNEN ÓTIW</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <!-- xosh kelipsiz -->
  <div class="container text-center mt-5">
    <h2>SÁLEM, <?= htmlspecialchars($username) ?>!</h2>
    <p>Forumǵa xosh keldińiz! Eń sońǵı postlar menen tanısıń.</p>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>