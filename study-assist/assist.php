<?php
session_start();
$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    die("User  not logged in.");
}

$studySchedule = '';
$resources = [];
$topic = '';
$scheduleType = 'daily';

$userId = $_SESSION['user_id'];

$host = 'localhost';
$db   = 'study_assist';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$conn->query("ALTER TABLE schedules MODIFY completed TINYINT(1) NOT NULL DEFAULT 0;");

$timeSlotsOrder = [
    ['start' => '08:00', 'end' => '09:00'],
    ['start' => '12:00', 'end' => '13:00'],
    ['start' => '18:00', 'end' => '19:00']
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (isset($_POST['mark_done'])) {
        $id = (int)$_POST['schedule_id'];
        $stmt = $conn->prepare(
            "UPDATE schedules SET completed = 1 WHERE id = ? AND user_id = ?"
        );
        $stmt->bind_param("ii", $id, $user_id);
        $stmt->execute();
        $stmt->close();
    }

    
    if (isset($_POST['schedule_type'])) {
        $scheduleType = $_POST['schedule_type'];
    }

    
    if (isset($_POST['generate_schedule'])) {
        $courses = explode("\n", trim($_POST['courses']));
        $courses = array_filter(array_map('trim', $courses));
        $studySchedule = "<h3>Your " . ucfirst($scheduleType) . " Study Schedule:</h3>";

        
        $stmt = $conn->prepare("DELETE FROM schedules WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();

        if ($scheduleType === 'weekly') {
            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            $numTimeSlots = count($timeSlotsOrder);

            foreach ($courses as $index => $course) {
                $studySchedule .= "<h4 class='schedule-subject'>{$course} - Weekly Schedule:</h4>";
                foreach ($days as $dayIndex => $day) {
                    $timeSlotIndex = ($index + $dayIndex) % $numTimeSlots;
                    $times = $timeSlotsOrder[$timeSlotIndex];
                    $timeStr = "{$times['start']} - {$times['end']}";

                    
                    $stmt = $conn->prepare("INSERT INTO schedules (user_id, course, schedule_type, day, time_slot) VALUES (?, ?, ?, ?, ?)");
                    $stmt->bind_param("issss", $user_id, $course, $scheduleType, $day, $timeStr);
                    $stmt->execute();
                    $stmt->close();

                    $studySchedule .= "<div class='schedule-day'><h5 class='day-name'>{$day}:</h5><ul class='time-list'><li>{$timeStr}</li></ul></div>";
                }
            }
        } else {
            $slotIndex = 0;
            foreach ($courses as $course) {
                $times = $timeSlotsOrder[$slotIndex % count($timeSlotsOrder)];
                $timeStr = "{$times['start']} - {$times['end']}";

                
                $stmt = $conn->prepare("INSERT INTO schedules (user_id, course, schedule_type, day, time_slot) VALUES (?, ?, ?, NULL, ?)");
                $stmt->bind_param("isss", $user_id, $course, $scheduleType, $timeStr);
                $stmt->execute();
                $stmt->close();

                $studySchedule .= "<h4 class='schedule-course'>{$course} - Daily Schedule:</h4><ul class='time-list'><li>{$timeStr}</li></ul>";
                $slotIndex++;
            }
        }
    }

   

if (isset($_POST['view_schedule'])) {
    $studySchedule = "<h3>Your Saved Schedule:</h3>";

    
    $stmt = $conn->prepare("SELECT id, course, schedule_type, day, time_slot, completed FROM schedules WHERE user_id = ? ORDER BY course, FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'), time_slot");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $scheduleMap = [];
    while ($row = $result->fetch_assoc()) {
        $course = $row['course'];
        $day = $row['day'] ?? 'Daily';
        $time = $row['time_slot'];
        $completed = $row['completed'];
        if (!isset($scheduleMap[$course])) {
            $scheduleMap[$course] = [];
        }
        $scheduleMap[$course][] = ["{$day}: {$time}", $row['id'], $completed];
    }

    foreach ($scheduleMap as $course => $entries) {
        $studySchedule .= "<h4 class='schedule-course'>{$course}</h4><ul class='time-list'>";
        foreach ($entries as $entry) {
            [$entryText, $entryId, $isDone] = $entry;

            $studySchedule .= '<li>';
            if ($isDone) {
                $studySchedule .= "✅ {$entryText}";
            } else {
                $studySchedule .= <<<HTML
                    <form style="display:inline" method="post">
                        <input type="hidden" name="schedule_id" value="{$entryId}">
                        <button type="submit" name="mark_done" title="Mark as completed"
                                style="background:none;border:none;cursor:pointer">☐</button>
                        {$entryText}
                    </form>
                HTML;
            }
            $studySchedule .= '</li>';
        }
        $studySchedule .= "</ul>";
    }
    $stmt->close();
}


  
    if (isset($_POST['get_resources'])) {
        $topic = trim($_POST['topic']);
        $resources = [
            "https://en.wikipedia.org/wiki/" . str_replace(' ', '_', urlencode($topic)),
            "https://www.google.com/search?q=" . urlencode($topic . " tutorials"),
            "https://www.khanacademy.org/search?query=" . urlencode($topic),
            "https://www.coursera.org/courses?query=" . urlencode($topic),
            "https://www.youtube.com/results?search_query=" . urlencode($topic)
        ];
    }
    
    
    if (isset($_POST['delete_schedule'])) {
        $stmt = $conn->prepare("DELETE FROM schedules WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();
        $studySchedule = "<h3>All your schedules have been deleted.</h3>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Hootsworth - Your Academic Helper</title>
<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet" />
<style>
body {
  font-family: 'Roboto', sans-serif;
  background-color: #e0f7e9;
  margin: 0;
  padding: 20px;
  color: #2d3e50;
  position: relative;
  overflow-x: hidden;
}
#owls-container {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  pointer-events: none;
  z-index: 9999;
}
h1 {
  text-align: center;
  color: #2e7d32;
  margin-bottom: 20px;
}
section {
  background-color: #ffffff;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  margin-bottom: 30px;
}
h2 {
  margin-top: 0;
  color: #388e3c;
}
form {
  display: flex;
  flex-direction: column;
}
label {
  margin-bottom: 8px;
  font-weight: 600;
}
textarea, input[type="text"] {
  padding: 10px;
  border: 1px solid #81c784;
  border-radius: 4px;
  resize: vertical;
  font-family: 'Roboto', sans-serif;
}
button {
  margin-top: 10px;
  padding: 12px;
  background-color: #43a047;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-family: 'Roboto', sans-serif;
  font-weight: 600;
  transition: background-color 0.3s;
}
button:hover {
  background-color: #66bb6a;
}
h3 {
  margin-top: 30px;
  color: #2e7d32;
}
.schedule-subject {
  background-color: #aed581;
  padding: 10px;
  border-radius: 6px;
  margin-top: 15px;
}
.schedule-course {
  background-color: #c5e1a5;
  padding: 10px;
  border-radius: 6px;
  margin-top: 15px;
}
.schedule-day {
  margin-left: 20px;
  margin-top: 10px;
}
.day-name {
  margin: 0 0 5px 0;
  font-weight: 600;
}
.time-list {
  list-style: none;
  padding-left: 15px;
  margin: 0;
}
.time-list li {
  background-color: #81c784;
  display: inline-block;
  padding: 8px 12px;
  border-radius: 4px;
  margin-right: 10px;
  color: #fff;
  font-weight: 600;
}
a {
  color: #2e7d32;
  text-decoration: none;
}
a:hover {
  text-decoration: underline;
}
@media (max-width: 768px) {
  body {
    padding: 10px;
  }
}
.owl {
  position: absolute;
  top: -50px;
  width: 40px;
  height: 40px;
  background-image: url('https://i.imgur.com/3lD3H7P.png');
  background-size: contain;
  background-repeat: no-repeat;
  opacity: 0.8;
  animation: fall 10s linear forwards;
}
@keyframes fall {
  to {
    transform: translateY(110vh) rotate(360deg);
    opacity: 0;
  }
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
  transition: background-color 0.3s ease, color 0.3s ease;
}
.back-arrow:hover {
  background: #6a1b9a;
  color: #fff;
}
button[name="mark_done"] {
  font-size: 1rem;
  margin-right: 6px;
}
button[name="mark_done"]:hover {
  opacity: 0.6;
}
</style>
</head>
<body>
<a href="options.php" class="back-arrow" title="Back to options">&#8592; Back</a>
<h1>Hootsworth - Your Academic Helper</h1>
<div id="owls-container"></div>


<section>
  <h2>Select Schedule Type</h2>
  <form method="post">
    <label>
      <input type="radio" name="schedule_type" value="daily" <?php if ($scheduleType==='daily') echo 'checked'; ?> /> Daily Schedule
    </label>
    <label>
      <input type="radio" name="schedule_type" value="weekly" <?php if ($scheduleType==='weekly') echo 'checked'; ?> /> Weekly Schedule
    </label>
    <button type="submit" name="set_schedule_type">Set Schedule Type</button>
  </form>
</section>


<section>
  <h2>Study Schedule Generator</h2>
  <form method="post">
    <input type="hidden" name="schedule_type" value="<?php echo htmlspecialchars($scheduleType); ?>" />
    <label for="courses">Enter your courses (one per line):</label>
    <textarea name="courses" id="courses" rows="4" placeholder="e.g., Math&#10;Science&#10;English"><?php echo isset($_POST['courses']) ? htmlspecialchars($_POST['courses']) : ''; ?></textarea>
    <button type="submit" name="generate_schedule">Generate Schedule</button>
  </form>
</section>


<?php if (!empty($studySchedule)) : ?>
  <div class="schedule-output">
    <?php echo $studySchedule; ?>
  </div>
<?php endif; ?>

<section>
  <h2>View My Schedule</h2>
  <form method="post">
    <button type="submit" name="view_schedule">View My Schedule</button>
  </form>
</section>

<section>
  <h2>Delete My Schedule</h2>
  <form method="post" onsubmit="return confirm('Are you sure you want to delete all your schedules?');">
    <button type="submit" name="delete_schedule">Delete My Schedule</button>
  </form>
</section>


<section>
  <h2>Get Resources for a Topic</h2>
  <form method="post">
    <input type="hidden" name="get_resources" value="1" />
    <label for="topic">Topic:</label>
    <input type="text" name="topic" id="topic" placeholder="e.g., Algebra" value="<?php echo isset($_POST['topic']) ? htmlspecialchars($_POST['topic']) : ''; ?>" />
    <button type="submit">Get Resources</button>
  </form>
  <?php if (!empty($resources)) : ?>
    <h3>Resources:</h3>
    <ul>
      <?php foreach ($resources as $resource): ?>
        <li><a href="<?php echo htmlspecialchars($resource); ?>" target="_blank"><?php echo htmlspecialchars($resource); ?></a></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
</section>

<script>

function createOwl() {
  const container = document.getElementById('owls-container');
  const owl = document.createElement('div');
  owl.className = 'owl';
  owl.style.left = Math.random() * 100 + 'vw';
  const size = Math.random() * 20 + 20;
  owl.style.width = size + 'px';
  owl.style.height = size + 'px';
  container.appendChild(owl);
  owl.addEventListener('animationend', () => {
    container.removeChild(owl);
  });
}
setInterval(createOwl, 300);
</script>

</body>
</html>
