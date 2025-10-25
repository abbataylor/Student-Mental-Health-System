<?php
session_start();
if (!isset($_SESSION['student_id'])) {
  header("Location: login.php");
  exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>KIU Mental Health Chat Support</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
  background: #0b0f1a;
  color: #e6e6e6;
  font-family: Arial, sans-serif;
}
.chat-container {
  max-width: 700px;
  margin: auto;
  background: #111827;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 0 10px #00eaff55;
}
.message-box {
  height: 420px;
  overflow-y: auto;
  background: #0d1627;
  padding: 15px;
  border-radius: 8px;
}
.user-msg {
  text-align: right;
  color: #36ff88;
  margin-top: 8px;
}
.bot-msg {
  text-align: left;
  color: #00eaff;
  margin-top: 8px;
}
input {
  background: #0b1220;
  border: 1px solid #00eaff55;
  color: #e6e6e6;
}
</style>
</head>

<body>

<div class="container py-4">
  <h2 class="text-center" style="color:#00eaff;">🧠 KIU Mental Health Support Chat</h2>

  <div class="chat-container">
    <div class="message-box" id="chatBox"></div>

    <form id="chatForm" class="mt-3">
      <input type="text" id="messageInput" class="form-control" placeholder="Type your message..." required>
      <button class="btn btn-info w-100 mt-2" type="submit">Send</button>
    </form>

  </div>
</div>

<script>
document.getElementById("chatForm").onsubmit = function(e){
  e.preventDefault();
  
  let msg = document.getElementById("messageInput").value;
  document.getElementById("chatBox").innerHTML += `<p class='user-msg'>${msg}</p>`;
  document.getElementById("messageInput").value = "";

  fetch("http://127.0.0.1:5002/chat", {  // We will replace this link with cloud URL when we deploy
    method:"POST",
    headers: {"Content-Type":"application/json"},
    body: JSON.stringify({message: msg})
  })
  .then(res => res.json())
  .then(data => {
    document.getElementById("chatBox").innerHTML += `<p class='bot-msg'>${data.reply}</p>`;
  });
};
</script>

</body>
</html>
