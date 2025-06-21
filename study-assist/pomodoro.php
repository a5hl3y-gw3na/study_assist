<?php

$conn = new mysqli('localhost', 'root', '', 'study_assist');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


session_start();
$user_id = $_SESSION['user_id'] ?? 1; 


$today = date('Y-m-d');

$stmt = $conn->prepare("SELECT hours_completed, days_streak FROM daily_progress WHERE user_id = ? AND date = ?");
$stmt->bind_param("is", $user_id, $today);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $hours_completed = $row['hours_completed'];
    $days_streak = $row['days_streak'];
} else {
    
    $hours_completed = 0;
    $days_streak = 0;
  
    $stmt_insert = $conn->prepare("INSERT INTO daily_progress (user_id, date) VALUES (?, ?)");
    $stmt_insert->bind_param("is", $user_id, $today);
    $stmt_insert->execute();
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Pomodoro Timer - Prof. Hootsworth</title>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Orbitron:wght@500&display=swap" rel="stylesheet" />
<style>

body {
    font-family: 'Roboto', sans-serif;
    margin: 0;
    padding: 0;
    background: linear-gradient(135deg, #ffe0b2, #fffde7);
    color: #333;
    display: flex;
    flex-direction: column; 
    align-items: center;
    justify-content: flex-start;
    min-height: 100vh;
    box-sizing: border-box;
    padding: 20px;
}


.back-arrow {
    position: fixed;
    top: 15px;
    left: 15px;
    font-size: 1.3rem;
    text-decoration: none;
    color: #6a1b9a;
    background: #d1c4e9;
    padding: 8px 14px;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    z-index: 1100;
    font-weight: 600;
    transition: background-color 0.3s ease, color 0.3s ease, transform 0.2s;
}
.back-arrow:hover {
    background: #6a1b9a;
    color: #fff;
    transform: scale(1.05);
}


h1 {
    font-size: 2.5em;
    margin-top: 20px;
    color: #6a1b9a;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
    text-align: center;
}


.timer-container {
    margin-top: 30px;
    display: flex;
    flex-direction: column;
    align-items: center;
    background: #fff8e1;
    padding: 25px;
    border-radius: 20px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    max-width: 380px;
    width: 100%;
    transition: box-shadow 0.3s, transform 0.3s;
}
.timer-container:hover {
    box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    transform: translateY(-2px);
}


#clock {
    font-family: 'Orbitron', sans-serif;
    font-size: 4.5em;
    color: #d84315;
    margin-bottom: 20px;
    letter-spacing: 3px;
    padding: 10px 20px;
    border-radius: 12px;
    background: linear-gradient(135deg, #ffe0b2, #ffcc80);
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
    transition: transform 0.2s, box-shadow 0.2s;
}
#clock:hover {
    transform: scale(1.05);
    box-shadow: inset 0 4px 8px rgba(0,0,0,0.2);
}


button {
    font-family: 'Roboto', sans-serif;
    margin: 10px 8px;
    padding: 12px 24px;
    font-size: 1.1em;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    background-color: #ff7043;
    color: #fff;
    box-shadow: 0 3px 6px rgba(0,0,0,0.2);
    transition: background-color 0.3s, transform 0.2s;
}
button:hover {
    background-color: #ef6c00;
    transform: translateY(-2px);
}


.owl-section {
    margin-top: 50px;
    text-align: center;
    max-width: 400px;
}
.owl {
    font-size: 150px;
    cursor: pointer;
    display: inline-block;
    transition: transform 0.3s, filter 0.3s;
}
.owl:hover {
    transform: rotate(5deg) scale(1.1);
    filter: brightness(1.2);
}
.owl-hint {
    font-style: italic;
    margin-top: 12px;
    color: #555;
    font-size: 1.1em;
}


.description {
    margin-top: 30px;
    max-width: 750px;
    padding: 20px;
    background: #fff3e0;
    border-radius: 15px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    font-size: 1.2em;
    line-height: 1.6;
    text-align: justify;
    color: #333;
    transition: box-shadow 0.3s, transform 0.3s;
}
.description:hover {
    box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    transform: translateY(-2px);
}

.progress-container {
    background: #ffffff;
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    margin-top: 20px;
    max-width: 300px;
    width: 100%;
    box-sizing: border-box;
}

.progress-item {
    text-align: center;
    margin-bottom: 15px;
}

.progress-item h2 {
    font-size: 1.5em;
    color: #6a1b9a;
}

.progress-value {
    font-size: 2.5em;
    font-weight: bold;
    color: #d84315;
}

@keyframes hoot {
    0% { transform: rotate(0deg); }
    10% { transform: rotate(10deg); }
    20% { transform: rotate(-10deg); }
    30% { transform: rotate(10deg); }
    40% { transform: rotate(-10deg); }
    50% { transform: rotate(0deg); }
    100% { transform: rotate(0deg); }
}


@keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(216, 67, 53, 0.4); }
    70% { box-shadow: 0 0 0 10px rgba(216, 67, 53, 0); }
    100% { box-shadow: 0 0 0 0 rgba(216, 67, 53, 0); }
}
#clock.active {
    animation: pulse 2s infinite;
}


.spotify-container {
    margin-top: 30px;
    text-align: center;
    width: 90vw;
    max-width: 900px;
}

.spotify-container iframe {
    width: 100% !important;
    height: 380px; 
    border-radius: 12px;
    border: none;
}
</style>
</head>
<body>
<a href="options.php" class="back-arrow" title="Back to options">← Back</a>

<h1>Prof. Hootsworth's Pomodoro Timer</h1>
<div class="timer-container">
    <div id="clock">25:00</div>
    <div>
        <button id="startBtn">Start</button>
        <button id="pauseBtn">Pause</button>
        <button id="resetBtn">Reset</button>
    </div>
</div>

<div class="progress-container">
    <div class="progress-item">
        <h2>Today's Study Time</h2>
        <p class="progress-value" id="study-hours"><?php echo number_format($hours_completed, 1); ?> hours</p>
    </div>
    <div class="progress-item">
        <h2>Current Streak</h2>
        <p class="progress-value" id="study-streak"><?php echo $days_streak; ?> days</p>
    </div>
</div>

<div class="owl-section">
    <div class="owl" id="hoot-owl" title="Click me!">🦉</div>
    <div class="owl-hint" id="hoot-hint">Hoot! Hoot! Time's up!</div>
</div>

<div class="description">
    The Pomodoro Technique is a game-changer for productivity — it turns time into your ally. By breaking work into focused 25-minute sprints followed by short breaks, it trains your brain to stay sharp and avoid burnout. This rhythm not only helps you get more done in less time but also keeps procrastination at bay by making daunting tasks feel manageable. It's simple, effective, and backed by psychology—because your brain works best when it knows rest is just around the corner.
</div>

<div class="spotify-container">
    <h2>Take a cerebral memory boost, play this in your background</h2>
    <iframe src="https://open.spotify.com/embed/playlist/569ASLkAaigoLJKsXl17US" 
        allowtransparency="true" allow="encrypted-media" allowfullscreen></iframe>
</div>

<script>


let timerDuration = 25 * 60; // 25 minutes
let currentTime = timerDuration;
let timerInterval = null;
let isRunning = false;

const clockDisplay = document.getElementById('clock');
const startBtn = document.getElementById('startBtn');
const pauseBtn = document.getElementById('pauseBtn');
const resetBtn = document.getElementById('resetBtn');
const hootHint = document.getElementById('hoot-hint');
const owl = document.getElementById('hoot-owl');

function updateClock() {
    let minutes = Math.floor(currentTime / 60);
    let seconds = currentTime % 60;
    clockDisplay.textContent = 
        `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    if (currentTime === 0) {
        clockDisplay.classList.add('active');
    } else {
        clockDisplay.classList.remove('active');
    }
}

function startTimer() {
    if (isRunning) return;
    if (currentTime <= 0) {
        currentTime = timerDuration;
        updateClock();
    }
    isRunning = true;
    timerInterval = setInterval(() => {
        if (currentTime > 0) {
            currentTime--;
            updateClock();
        } else {
            clearInterval(timerInterval);
            isRunning = false;
            sessionOver();
        }
    }, 1000);
}

function pauseTimer() {
    clearInterval(timerInterval);
    isRunning = false;
}

function resetTimer() {
    clearInterval(timerInterval);
    isRunning = false;
    currentTime = timerDuration;
    updateClock();
}

function sessionOver() {
    hootHint.textContent = "Hoot! Hoot! Session is over!";
    owl.style.animation = 'hoot 1s ease-in-out';
    
    const hootSound = new Audio('https://freesound.org/data/previews/512/512073_10236562-lq.mp3');
    hootSound.play();

    
    fetch('update_progress.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            sessionMinutes: Math.floor(timerDuration / 60),
        }),
    })
    .then(response => response.json())
    .then(data => {
        
        hootHint.textContent = data.message;
    });

    setTimeout(() => {
        hootHint.textContent = "Hoot! Hoot! Time's up!";
        owl.style.animation = '';
    }, 3000);
}

startBtn.addEventListener('click', startTimer);
pauseBtn.addEventListener('click', pauseTimer);
resetBtn.addEventListener('click', resetTimer);


owl.addEventListener('click', () => {
    sessionOver();
});

updateClock();
</script>
</body>
</html>

