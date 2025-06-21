<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: CHATBOT.php');
    exit();
}

header('Content-Type: text/html; charset=UTF-8');
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Chatbot with Wikipedia Search</title>
<style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    background: linear-gradient(135deg, #e0f7fa, #fffde7);
    color: #333;
  }

  #floating-owl {
    position: fixed;
    top: 15px;
    left: 50%;
    transform-origin: 50% 100%;
    font-size: 64px;
    animation: swing 3s ease-in-out infinite;
    z-index: 9999;
    user-select: none;
    pointer-events: none;
    transform: translateX(-50%);
  }

  @keyframes swing {
    0% { transform: translateX(-50%) rotate(10deg); }
    50% { transform: translateX(-50%) rotate(-10deg); }
    100% { transform: translateX(-50%) rotate(10deg); }
  }

  #chat-container {
    max-width: 850px;
    margin: 90px auto 20px auto; /* add top margin so chat is below owl */
    padding: 25px;
    background: #ffffff;
    border-radius: 20px;
    height: 60vh;
    overflow-y: auto;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
  }

  .message {
    padding: 14px;
    margin: 10px;
    border-radius: 15px;
    max-width: 75%;
    white-space: pre-wrap;
    line-height: 1.4;
    font-size: 15px;
  }

  .user {
    background: #c8e6c9;
    align-self: flex-end;
    box-shadow: 2px 2px 8px rgba(76, 175, 80, 0.2);
  }

  .bot {
    background: #f1f8e9;
    align-self: flex-start;
    box-shadow: 2px 2px 8px rgba(139, 195, 74, 0.2);
  }

  #input-area {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 15px;
    gap: 10px;
    background: #ffffff;
    box-shadow: inset 0 1px 5px rgba(0, 0, 0, 0.05);
  }

  #userInput {
    flex: 1;
    padding: 12px 15px;
    font-size: 16px;
    border-radius: 25px;
    border: 1px solid #ccc;
    outline: none;
    transition: box-shadow 0.2s ease;
  }

  #userInput:focus {
    box-shadow: 0 0 8px #4dd0e1;
    border-color: #4dd0e1;
  }

  button {
    padding: 12px 20px;
    font-size: 15px;
    border-radius: 25px;
    border: none;
    cursor: pointer;
    transition: background 0.3s ease;
    font-weight: bold;
  }

  button:hover {
    opacity: 0.9;
  }

  button:active {
    transform: scale(0.98);
  }

  button:first-of-type {
    background-color: #4dd0e1;
    color: white;
  }

  #clearBtn {
    background-color: #ef5350;
    color: white;
  }

  #clearBtn:hover {
    background-color: #e53935;
  }

  #loader {
    display: none;
    margin: 10px 0;
    text-align: center;
  }

  .spinner {
    border: 4px solid #f3f3f3;
    border-top: 4px solid #26c6da;
    border-radius: 50%;
    width: 28px;
    height: 28px;
    animation: spin 1s linear infinite;
    display: inline-block;
  }

  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
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
</style>
</head>
<body>
<a href="../options.php" class="back-arrow" title="Back to options">← Back</a>

<div id="floating-owl">🦉</div>

<div id="chat-container"></div>

<div id="input-area">
  <input type="text" id="userInput" placeholder="Ask A Wise question..." />
  <button onclick="sendMessage()">Send</button>
  <button id="clearBtn" onclick="clearChat()">Clear</button>
  <button onclick="viewHistory()">View History</button>
<button onclick="deleteHistory()">Delete History</button>

</div>

<div id="loader">
  <div class="spinner"></div> <span>Loading...</span>
</div>

<script>
  const userId = "<?php echo $_SESSION['user_id']; ?>";
  const chatbox = document.getElementById("chat-container");
  const userInput = document.getElementById("userInput");
  const loader = document.getElementById("loader");

  window.onload = () => {
    addMessage("Bonjour my pupil, I'm Prof Hootsworth, the oldest owl in the world. Ask me anything!", 'bot');
  };

  function addMessage(text, sender) {
    const msg = document.createElement("div");
    msg.className = "message " + sender;
    msg.innerHTML = text;
    chatbox.appendChild(msg);
    chatbox.scrollTop = chatbox.scrollHeight;
  }

  function clearChat() {
    chatbox.innerHTML = '';
  }

  function showLoader() { loader.style.display = 'block'; }
  function hideLoader() { loader.style.display = 'none'; }

  async function sendMessage() {
  const message = userInput.value.trim();
  if (!message) return;

  addMessage(message, 'user');
  userInput.value = '';
  showLoader();

  const info = await getWikipediaInfo(message);
  hideLoader();

  const reply = (!info || info.trim().toLowerCase().includes("sorry") || info.trim() === "")
      ? "Hoot! I couldn't find anything. Try rephrasing or asking something else."
      : info;

  addMessage(reply, 'bot');

  // Save to history
  fetch('save_history.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ user_message: message, bot_response: reply })
  });
}


  userInput.addEventListener("keypress", function (e) {
    if (e.key === "Enter") {
      e.preventDefault();
      sendMessage();
    }
  });

  async function searchWikipedia(query) {
    const searchUrl = `https://en.wikipedia.org/w/api.php?origin=*&action=query&format=json&list=search&srsearch=${encodeURIComponent(query)}`;
    try {
      const res = await fetch(searchUrl);
      const data = await res.json();
      if (data.query.search.length > 0) {
        return data.query.search[0].title;
      } else {
        return null;
      }
    } catch (err) {
      return null;
    }
  }
function viewHistory() {
  clearChat();
  showLoader();
  fetch('get_history.php')
    .then(res => res.json())
    .then(data => {
      hideLoader();
      if (data.length === 0) {
        addMessage("No history found.", 'bot');
      } else {
        data.forEach(entry => {
          addMessage(entry.user_message, 'user');
          addMessage(entry.bot_response, 'bot');
        });
      }
    })
    .catch(() => {
      hideLoader();
      addMessage("Could not load history.", 'bot');
    });
}

function deleteHistory() {
  if (!confirm("Are you sure you want to delete your chat history?")) return;
  fetch('delete_history.php')
    .then(() => {
      clearChat();
      addMessage("All history has been deleted.", 'bot');
    });
}

  async function fetchWikipediaExtract(title) {
    const url = `https://en.wikipedia.org/w/api.php?origin=*&action=query&format=json&prop=extracts&exintro&explaintext&redirects=1&titles=${encodeURIComponent(title)}`;
    try {
      const res = await fetch(url);
      const data = await res.json();
      const pages = data.query.pages;
      const page = Object.values(pages)[0];
      if (page && !page.missing && page.extract && page.extract.trim() !== "") {
        const pageUrl = `https://en.wikipedia.org/wiki/${encodeURIComponent(page.title)}`;
        return `<strong>${page.title}</strong>:<br/>${page.extract}<br/><a href="${pageUrl}" target="_blank" style="color:blue;">Read more on Wikipedia</a>`;
      } else {
        return "";
      }
    } catch (err) {
      return "";
    }
  }

  async function getWikipediaInfo(query) {
    const title = await searchWikipedia(query);
    if (title) {
      const extract = await fetchWikipediaExtract(title);
      if (extract && extract.trim() !== "") {
        return extract;
      }
    }
    return "Hoot! I couldn't reach Wikipedia just now. Try again in a bit.";
  }
</script>

</body>
</html>
