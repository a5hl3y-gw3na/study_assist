<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Study Assist - Home</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <style>
    /* === Key Animations === */
    @keyframes flyIn {
      0% { transform: translateX(-150%) rotate(-10deg); opacity: 0; }
      50% { opacity: 1; }
      100% { transform: translateX(100vw) rotate(10deg); opacity: 0; }
    }

    @keyframes float {
      0% { transform: translateY(0); }
      50% { transform: translateY(-15px); }
      100% { transform: translateY(0); }
    }

    @keyframes fadeIn {
      0% { opacity: 0; transform: translateY(20px); }
      100% { opacity: 1; transform: translateY(0); }
    }

    /* === General Reset === */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      background: url('books-bg.png') repeat;
      background-size: 200px;
      color: #1a1a1a;
      overflow-x: hidden;
    }

    .navbar {
      background-color: #2c3e50;
      color: white;
      padding: 15px;
      text-align: center;
      position: sticky;
      top: 0;
      z-index: 1000;
    }

    .navbar a {
      color: white;
      margin: 0 15px;
      text-decoration: none;
      font-weight: bold;
      transition: color 0.3s ease;
    }

    .navbar a:hover {
      color: #27ae60;
    }

    .hero {
      text-align: center;
      padding: 100px 20px;
      background: rgba(255, 255, 255, 0.85);
      animation: fadeIn 2s ease;
    }

    .hero h1 {
      font-size: 3rem;
      margin-bottom: 15px;
      color: #2c3e50;
    }

    .hero p {
      font-size: 1.25rem;
      margin-bottom: 20px;
      color: #2c3e50;
    }

    .btn-get-started {
      display: inline-block;
      padding: 14px 30px;
      font-size: 18px;
      background-color: #27ae60;
      color: white;
      text-decoration: none;
      border-radius: 6px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
      transition: background 0.3s ease, transform 0.2s ease;
    }

    .btn-get-started:hover {
      background-color: #1e8449;
      transform: translateY(-2px);
    }

    .animated-owl {
      position: absolute;
      top: 80px;
      left: -100px;
      width: 80px;
      animation: flyIn 10s linear infinite;
      z-index: 999;
    }

    .speech-bubble {
      position: absolute;
      top: 170px;
      left: 80px;
      background: #fff;
      border-radius: 10px;
      padding: 10px 15px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      font-weight: bold;
      color: #2c3e50;
      animation: fadeIn 3s ease-in-out 2s both;
    }

    .video-section {
      display: flex;
      justify-content: center;
      gap: 30px;
      flex-wrap: wrap;
      padding: 40px 20px;
      background: rgba(255, 255, 255, 0.95);
      animation: fadeIn 2s ease;
    }

    .video-wrapper {
      position: relative;
      width: 100%;
      max-width: 480px;
      padding-bottom: 56.25%;
      height: 0;
    }

    .video-wrapper iframe {
      position: absolute;
      width: 100%;
      height: 100%;
      border: none;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0,0,0,0.2);
    }

    .testimonials {
      background: #f9f9f9;
      padding: 60px 20px;
      text-align: center;
      animation: fadeIn 2s ease-in-out;
    }

    .testimonial {
      max-width: 700px;
      margin: 0 auto 40px;
      font-style: italic;
      color: #444;
    }

    .testimonial::before {
      content: "“";
      font-size: 40px;
      color: #2c3e50;
      display: block;
    }

    .testimonial::after {
      content: "”";
      font-size: 40px;
      color: #2c3e50;
      display: block;
      text-align: right;
    }

    .testimonial-author {
      font-weight: bold;
      margin-top: 10px;
      color: #2c3e50;
    }

    .footer {
      background-color: #2c3e50;
      color: white;
      text-align: center;
      padding: 20px;
      width: 100%;
    }
  </style>
</head>
<body>
  <!-- Flying Owl -->
  <img src="https://emojicdn.elk.sh/🦉" alt="Flying Owl" class="animated-owl" aria-hidden="true"/>
  <div class="speech-bubble" aria-label="Owl Greeting">Hello there!</div>

  <!-- Navigation -->
<div class="navbar">
  <?php if ($isLoggedIn): ?>
    <!-- Optionally, you can add a logout link here -->
    <a href="login.php">Login</a>
     <a href="signup.php">Register</a>
  <?php else: ?>
    <a href="login.php">Login</a>
    <a href="signup.php">Register</a>
  <?php endif; ?>
</div>

  <!-- Hero Section -->
  <div class="hero">
    <h1>Welcome to Study Assist</h1>
    <p>Your all-in-one academic companion. Plan, track, and succeed.</p>
    <?php if (!$isLoggedIn): ?>
      <a href="login.php" class="btn-get-started" aria-label="Start your academic journey">Commence the Journey</a>
    <?php endif; ?>
  </div>

  <!-- Video Section -->
<div class="video-section">
  <div class="video-wrapper">
    <iframe 
      src="https://www.youtube.com/embed/tlFGOSEI_lo?si=_3KY1RrCgxQTG944"
      title="Video 1"
      frameborder="0"
      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
      allowfullscreen>
    </iframe>
  </div>

  <div class="video-wrapper">
    <iframe 
      src="https://www.youtube.com/embed/iDbdXTMnOmE?si=wxqjJ0qQgGcLIr_M"
      title="Video 2"
      frameborder="0"
      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
      allowfullscreen>
    </iframe>
  </div>
</div>

  <!-- Testimonials -->
  <div class="testimonials">
    <div class="testimonial">
     I am finally feel on top of things! No longer disorganized.
      <div class="testimonial-author">– Rachael J., Optometry</div>
    </div>
    <div class="testimonial">
      The mind mapping system is a game-changer. I don't forget concepts easily anymore.
      <div class="testimonial-author">– Moeketsi M., Computer Science</div>
    </div>
    <div class="testimonial">
      I love how easy it is to manage my study sessions. 10/10 would recommend.
      <div class="testimonial-author">– Richard N., Agricultural Engineering</div>
    </div>
  </div>

  <!-- Footer -->
  <div class="footer">
    &copy; <?php echo date("Y"); ?> Study Assist. All rights reserved.
  </div>
  <script>
  const observers = document.querySelectorAll('.video-wrapper');

  const options = {
    threshold: 0.3
  };

  const onScroll = (entries, observer) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  };

  const observer = new IntersectionObserver(onScroll, options);

  observers.forEach(el => {
    observer.observe(el);
  });
</script>

</body>
</html>
