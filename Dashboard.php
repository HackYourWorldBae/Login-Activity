<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard - Secure System</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome for icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <style>
    #wrapper {
      display: flex;
      height: 100vh;
    }

    #sidebar {
      width: 250px;
      background-color: #343a40;
      color: white;
      padding: 20px;
      height: 100%;
      position: fixed;
    }

    #sidebar .nav-item {
      margin-bottom: 15px;
    }

    #sidebar .nav-link {
      color: white;
      font-size: 18px;
      font-weight: 500;
    }

    #sidebar .nav-link:hover {
      color: #007bff;
    }

    #page-content-wrapper {
      margin-left: 250px;
      padding: 40px;
      flex-grow: 1;
    }

    .motivational-card {
      background: #f8f9fa;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      padding: 40px;
      text-align: center;
      max-width: 600px;
      margin: 0 auto;
      height: 100%;
    }

    .motivational-card h1 {
      font-size: 36px;
      font-weight: 700;
      color: #333;
    }

    .motivational-card p {
      font-size: 18px;
      color: #666;
      margin-top: 20px;
    }

    .card-footer {
      background-color: transparent;
      border-top: none;
      padding: 0;
    }

    @media (max-width: 768px) {
      #wrapper {
        flex-direction: column;
      }
      #sidebar {
        position: relative;
        height: auto;
        width: 100%;
      }
      #page-content-wrapper {
        margin-left: 0;
      }
    }
  </style>
</head>
<body>

  <div id="sidebar">
    <h3 class="text-center mb-4">Dashboard</h3>
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link" href="Dashboard.php">
          <i class="fas fa-home"></i> Home
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Profile.php">
          <i class="fas fa-user"></i> Profile
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Contacts.php">
          <i class="fas fa-address-book"></i> Contacts
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Logout.php">
          <i class="fas fa-sign-out-alt"></i> Logout
        </a>
      </li>
    </ul>
  </div>

  <div id="page-content-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h1 class="text-dark">Welcome, <?php echo $_SESSION['username']; ?>!</h1>
      <div id="date-time" class="text-muted"></div>
    </div>

    <div class="motivational-card">
      <h1 id="motivational-message">"The best time to plant a tree was 20 years ago. The second best time is now."</h1>
      <p id="author">- Chinese Proverb</p>
    </div>
  </div>

  <!-- Bootstrap Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    function updateDateTime() {
      const options = { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric', 
        hour: '2-digit', 
        minute: '2-digit', 
        second: '2-digit',
        hour12: true,
      };
      const philippinesTime = new Date().toLocaleString('en-US', { timeZone: 'Asia/Manila', ...options });
      document.getElementById("date-time").innerHTML = philippinesTime;
    }

    updateDateTime();
    setInterval(updateDateTime, 1000);

    const motivationalMessages = [
      { quote: "The best time to plant a tree was 20 years ago. The second best time is now.", author: "- Chinese Proverb" },
      { quote: "Success is not final, failure is not fatal: It is the courage to continue that counts.", author: "- Winston Churchill" },
      { quote: "Believe you can and you're halfway there.", author: "- Theodore Roosevelt" },
      { quote: "It always seems impossible until it’s done.", author: "- Nelson Mandela" },
      { quote: "The only way to do great work is to love what you do.", author: "- Steve Jobs" }
    ];

    function displayMotivationalMessage() {
      const randomIndex = Math.floor(Math.random() * motivationalMessages.length);
      const message = motivationalMessages[randomIndex];
      document.getElementById("motivational-message").innerHTML = `"${message.quote}"`;
      document.getElementById("author").innerHTML = message.author;
    }

    displayMotivationalMessage();
    setInterval(displayMotivationalMessage, 60000);
  </script>

</body>
</html>
