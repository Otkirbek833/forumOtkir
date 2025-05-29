<?php 
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: pages/home.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="uz">
<head>
  <meta charset="UTF-8">
  <title>BAS BET</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Inter', sans-serif;
    }

    body {
      background: linear-gradient(135deg, #ece9e6, #ffffff);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: background 0.5s ease-in-out;
    }

    .container {
      width: 100%;
      max-width: 400px;
      padding: 20px;
    }

    .card {
      background: #fff;
      border-radius: 16px;
      padding: 40px 30px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      text-align: center;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }

    .card h2 {
      margin-bottom: 15px;
      color: #333;
      font-size: 24px;
    }

    .card p {
      color: #555;
      font-size: 16px;
    }

    .button-group {
      display: flex;
      gap: 12px;
      justify-content: center;
      margin-top: 25px;
    }

    .btn {
      background: #4a90e2;
      color: white;
      border: none;
      padding: 12px 20px;
      border-radius: 8px;
      font-size: 15px;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.3s ease, transform 0.2s ease;
    }

    .btn:hover {
      background: #357ABD;
      transform: scale(1.05);
    }

    a {
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="card">
      <h2>Xosh keldińiz!</h2>
      <p>Iltimas, sistemaǵa kiriń yaki dizimnen ótiń.</p>
      <div class="button-group">
        <a href="login.html"><button class="btn">DIZIMGE KIRIW</button></a>
        <a href="register.html"><button class="btn">DIZIMNEN ÓTIW</button></a>
      </div>
    </div>
  </div>
</body>
</html>
