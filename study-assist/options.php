<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
$email = $_SESSION['email'] ?? '';
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Professor Hootsworth's Dashboard</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background: linear-gradient(135deg, #0f1117, #1a1c25);
      height: 100vh;
      font-family: 'Segoe UI', sans-serif;
      color: #ffffff;
      overflow: hidden;
    }
.settings {
  position: absolute;
  top: 20px;
  right: 30px;
  font-size: 1.5rem;
  z-index: 10;
}

.settings .menu {
  position: absolute;
  right: 0;
  top: 30px;
  background: #1e1e2f;
  border: 1px solid #444;
  border-radius: 8px;
  padding: 10px 0;
  list-style: none;
  min-width: 160px;
  z-index: 1000;
  box-shadow: 0 8px 16px rgba(0,0,0,0.4);
}

.settings .menu.hidden {
  display: none;
}

.settings .menu li {
  padding: 10px 20px;
  color: white;
  cursor: pointer;
  transition: background 0.2s;
}

.settings .menu li:hover {
  background: #333;
}

.settings .menu li a {
  color: white;
  text-decoration: none;
}

body.green-mode {
  background: #0be749;
  color: #1b3a1b;
}

body.green-mode .card {
  background-color: rgba(60, 179, 113, 0.15); /* Light green with opacity */
  border-color: rgba(34, 139, 34, 0.6);
}

body.green-mode .settings .menu {
  background: #07ca5f;
  color: #1b3a1b;
}

body.green-mode .settings .menu li {
  color: #1b3a1b;
}

body.green-mode .settings .menu li:hover {
  background: #04ef5b;
}


    .top-bar {
      position: absolute;
      top: 0;
      width: 100%;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 30px;
      background: rgba(15, 17, 23, 0.85);
      z-index: 5;
    }

    .top-bar h1 {
      font-size: 1.8em;
      color: #8ef9fc;
      text-shadow: 0 0 15px #8ef9fc88;
      font-family: 'Courier New', Courier, monospace;
    }

    .top-bar .icons {
      font-size: 1.4em;
      cursor: pointer;
    }

    .wrapper {
      width: 100%;
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .inner {
      --w: 140px;
      --h: 190px;
      --translateZ: calc((var(--w) + var(--h)) + 70px);
      --rotateX: -15deg;
      --perspective: 1100px;
      position: relative;
      width: var(--w);
      height: var(--h);
      transform-style: preserve-3d;
      animation: rotating 20s linear infinite;
    }

    @keyframes rotating {
      from {
        transform: perspective(var(--perspective)) rotateX(var(--rotateX)) rotateY(0deg);
      }
      to {
        transform: perspective(var(--perspective)) rotateX(var(--rotateX)) rotateY(1turn);
      }
    }

    .card {
      position: absolute;
      border: 2px solid rgba(var(--color-card), 0.8);
      border-radius: 12px;
      inset: 0;
      transform: rotateY(calc((360deg / var(--quantity)) * var(--index))) translateZ(var(--translateZ));
      cursor: pointer;
      text-decoration: none;
      background-color: rgba(var(--color-card), 0.15);
      transition: transform 0.4s ease, box-shadow 0.4s ease;
      z-index: 1;
      backdrop-filter: blur(4px);
    }

    .card:hover {
      transform: rotateY(calc((360deg / var(--quantity)) * var(--index))) translateZ(calc(var(--translateZ) + 30px)) scale(1.1);
      box-shadow: 0 0 25px rgba(var(--color-card), 0.9);
      z-index: 10;
    }

    .img {
      width: 100%;
      height: 100%;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 12px;
      text-align: center;
      background: radial-gradient(circle,
        rgba(var(--color-card), 0.15) 0%,
        rgba(var(--color-card), 0.4) 70%,
        rgba(var(--color-card), 0.9) 100%);
      color: #fff;
      font-size: 0.9rem;
      border-radius: 10px;
    }

    .img .icon {
      font-size: 2.2rem;
      margin-bottom: 10px;
      text-shadow: 0 0 6px #000;
    }

    .img span {
      font-weight: bold;
      text-shadow: 0 0 3px rgba(0, 0, 0, 0.6);
    }

    .img::after {
      content: attr(data-description);
      display: block;
      margin-top: 6px;
      font-size: 0.75rem;
      color: #ddd;
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .card:hover .img::after {
      opacity: 1;
    }
    .welcome-message {
  position: absolute;
  top: 80px;
  width: 100%;
  text-align: center;
  font-weight: bold;
  color: #0be749;
  font-size: 4.4rem;
  text-shadow: 0 0 10px #0be74980, 0 0 20px #065f2c;
  animation: fadeIn 1.2s ease-in-out both;
  font-family: 'Segoe UI', sans-serif;
  z-index: 5;
}

  </style>
</head>
<div class="settings">
  <span onclick="toggleMenu()">⚙️</span>
  <ul id="settingsMenu" class="menu hidden">
    <li onclick="toggleTheme()">🌓 Toggle Theme</li>
    <li><a href="about.php">ℹ️ About</a></li>
    <li><a href="logout.php">🚪 Logout</a></li>
  </ul>
</div>
<body>
  <div class="top-bar">
    <h1>🦉 Study Assist</h1>
  </div>
<?php if ($isLoggedIn): ?>
  <p class="welcome-message">
    Hello, <?php echo htmlspecialchars(explode('@', $email)[0]); ?>!
  </p>
<?php endif; ?>


  <div class="wrapper">
    <div class="inner" id="cardPanel" style="--quantity: 5;">
      <a href="mindmap/index.html" class="card" style="--index: 0; --color-card: 142, 249, 252;">
        <div class="img" data-description="Visualise and link ideas creatively">
          <div class="icon">🧠</div>
          <span>Mind Map</span>
        </div>
      </a>
      <a href="chatbot/loading.html" class="card" style="--index: 1; --color-card: 142, 252, 204;">
        <div class="img" data-description="Ask Professor Hootsworth anything">
          <div class="icon">🦉</div>
          <span>Chatbot</span>
        </div>
      </a>
      <a href="assist.php" class="card" style="--index: 2; --color-card: 252, 208, 142;">
        <div class="img" data-description="Generate your custom study plan">
          <div class="icon">📅</div>
          <span>Scheduler</span>
        </div>
      </a>
      <a href="flashcard.html" class="card" style="--index: 3; --color-card: 252, 142, 239;">
        <div class="img" data-description="Revise quickly with smart cards">
          <div class="icon">🃏</div>
          <span>Flash Cards</span>
        </div>
      </a>
      <a href="pomodoro.php" class="card" style="--index: 4; --color-card: 204, 142, 252;">
        <div class="img" data-description="Stay focused with Pomodoro">
          <div class="icon">⏰</div>
          <span>Pomodoro</span>
        </div>
      </a>
    </div>
  </div>
  <script>
  function toggleMenu() {
    document.getElementById('settingsMenu').classList.toggle('hidden');
  }

  function toggleTheme() {
    document.body.classList.toggle('green-mode');
  }
</script>

</body>
</html>
