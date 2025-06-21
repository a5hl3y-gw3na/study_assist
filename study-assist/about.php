<?php
session_start();
$is_logged_in = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="about.css">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study Assist - About Us</title>
    <link rel="stylesheet" href="css/about.css">
   
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">


<style>
    html {
        scroll-behavior: smooth;
    }
</style>

</head>
<body>

    <header>
        <h1>About Study Assist</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                 <?php if ($is_logged_in): ?>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="signup.php">Sign Up</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main class="about-flex">
    <section class="about-content">
        <h2>My Mission</h2>
        <p>Study Assist was created with the goal of empowering students to take control of their learning process. I believe that effective organization and visualization are key to understanding complex subjects and achieving academic success.</p>

        <h2>What I Offer</h2>
        <p>My platform provides tools to help you:</p>
        <ul>
            <li>Structure and organize your study notes.</li>
            <li>Generate dynamic mind maps from your notes or keywords.</li>
            <li>Visualize relationships between concepts.</li>
            <li>Improve retention and recall.</li>
        </ul>

        <h2>My Story</h2>
        <p>The story of Study Assist starts with academic frustration, caffeine, and a chaotic mind. I was overwhelmed with textbooks and messy notes, struggling to understand tough concepts. Traditional notes weren’t enough, so I started doodling mind maps—branching diagrams that helped me see the big picture. But paper maps got out of control, torn, and hard to manage. </p>

        <p>Driven by the need to organize my notes better, I imagined turning these messy maps into a digital, interactive tool. It started small—just mind maps—but then I added notes, login, and it grew from there. There were moments of frustration, but each breakthrough kept me going—especially the satisfaction of understanding or finding what I needed instantly.</p>

        <p>That’s how Study Assist was born: a tool built to make learning easier, less chaotic, and more visual—because learning should be simple, and sometimes, all you need is a little digital help—and maybe coffee.</p>

        <h2>Contact Us</h2>
        <p>If you have any questions or feedback, please feel free to contact me at tadiwagwena@gmail.com or +263 777 367 773</p>
    </section>

    <aside class="profile-card">
        <img src="images/me_glasses.jpg" alt="Profile picture of Ser Tadiwa Ashley Gwena" class="profile-pic">
        <h3>Ser Tadiwa Ashley Gwena M.B.E</h3>
        <p class="bio">
            Behold, a young scholar of the digital arts, clad in robes of curiosity and armor of logic. With scrolls of code and quill of keystrokes, they tame the fiery beasts of algorithms and conjure spells of innovation, forging paths through the vast realm of unseen realms of knowledge.
        </p>
    </aside>
</main>


    <footer>
        <p>&copy; <?php echo date("Y"); ?> tadiwagwena. All rights reserved.</p>
    </footer>

    <script src="js/script.js"></script>
    <!-- Add any other common JavaScript files here -->
     <button id="backToTop" class="btn">↑ Top</button>
     <canvas id="snowfall"></canvas>
<script>
const canvas = document.getElementById('snowfall');
const ctx = canvas.getContext('2d');
let w = window.innerWidth;
let h = window.innerHeight;
canvas.width = w;
canvas.height = h;

let snowflakes = [];

function createSnowflakes() {
    for (let i = 0; i < 100; i++) {
        snowflakes.push({
            x: Math.random() * w,
            y: Math.random() * h,
            radius: Math.random() * 3 + 2,
            speedY: Math.random() * 1 + 0.5,
            speedX: Math.random() * 0.5 - 0.25
        });
    }
}

function drawSnowflakes() {
    ctx.clearRect(0, 0, w, h);
    ctx.fillStyle = "white";
    ctx.beginPath();
    for (let flake of snowflakes) {
        ctx.moveTo(flake.x, flake.y);
        ctx.arc(flake.x, flake.y, flake.radius, 0, Math.PI * 2);
    }
    ctx.fill();
    updateSnowflakes();
    requestAnimationFrame(drawSnowflakes);
}

function updateSnowflakes() {
    for (let flake of snowflakes) {
        flake.y += flake.speedY;
        flake.x += flake.speedX;
        if (flake.y > h) flake.y = 0;
        if (flake.x > w) flake.x = 0;
        if (flake.x < 0) flake.x = w;
    }
}

window.addEventListener("resize", () => {
    w = window.innerWidth;
    h = window.innerHeight;
    canvas.width = w;
    canvas.height = h;
    snowflakes = [];
    createSnowflakes();
});

createSnowflakes();
drawSnowflakes();
</script>


</body>
</html>