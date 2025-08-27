<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../Messages/message.css">
  <link rel="stylesheet" href="../Navbar/navbar.css">
  <title>Chat UI</title>
</head>
<body>
  <div class="container">
    <?php include '../Navbar/navbar.php'; ?>
    <div class="chat-main">
      <div class="chat-sidebar">
        <div class="chat-search">
          <input type="text" placeholder="Search">
        </div>
        <div class="chat-list">
          <div class="chat-list-item active">
            <img src="../Images/undraw_male-avatar_zkzx.svg"alt="Avatar">
            <div class="chat-list-info">
              <div class="chat-list-namee">Mark Aldrin Mendoza</div>
              <div class="chat-list-msgg">I lost an Item</div>
            </div>
            <div class="chat-list-time">05:40pm</div>
            <span class="chat-list-label">CHAT</span>
          </div>
          <div class="chat-list-item">
            <img src="../Images/undraw_male-avatar_zkzx.svg" alt="Avatar">
            <div class="chat-list-info">
              <div class="chat-list-name">JOHN SMITH</div>
              <div class="chat-list-msg">I paid last month contribution...</div>
            </div>
            <div class="chat-list-time">12:08pm</div>
          </div>
          <div class="chat-list-item">
            <img src="../Images/undraw_female-avatar_7t6k.svg" alt="Avatar">
            <div class="chat-list-info">
              <div class="chat-list-name">CHRISTINO MO</div>
              <div class="chat-list-msg">How are you doing Christino?</div>
            </div>
            <div class="chat-list-time">11:00am</div>
          </div>
          <div class="chat-list-item">
            <img src="../Images/undraw_avatar-traveler_ljy2.svg" alt="Avatar">
            <div class="chat-list-info">
              <div class="chat-list-name">GENEVIEVE</div>
              <div class="chat-list-msg">What about last night? Had fun Beach?</div>
            </div>
            <div class="chat-list-time">05:40pm</div>
          </div>
          <div class="chat-list-item">
            <img src="../Images/undraw_female-avatar_7t6k.svg" alt="Avatar">
            <div class="chat-list-info">
              <div class="chat-list-name">CHRISTINO MO</div>
              <div class="chat-list-msg">I paid last month contribution...</div>
            </div>
            <div class="chat-list-time">04:00pm</div>
          </div>
          <div class="chat-list-item">
            <img src="../Images/undraw_avatar-traveler_ljy2.svg" alt="Avatar">
            <div class="chat-list-info">
              <div class="chat-list-name">GENEVIEVE</div>
              <div class="chat-list-msg">I paid last month contribution...</div>
            </div>
            <div class="chat-list-time">11:00pm</div>
          </div>
        </div>
      </div>
      <div class="chat-content">
        <div class="chat-header">
          <img src="../Images/undraw_male-avatar_zkzx.svg"alt="Avatar">
          <div>
            <div class="chat-header-name">Mark Aldrin Mendoza</div>
            <div class="chat-header-status">Active now</div>
          </div>
        </div>
        <div class="chat-messages">
          <div class="chat-message chat-message-received">
            <img src="../Images/undraw_female-avatar_7t6k.svg" alt="Avatar">
            <div class="chat-message-bubble">I lost an Item</div>
            <div class="chat-message-time">05:40pm</div>
          </div>
          <div class="chat-message chat-message-sent">
            <img src="../Images/undraw_male-avatar_zkzx.svg" alt="Avatar">
            <div class="chat-message-bubble">Hi Dear. I'll be there by 7:30pm, btw where are u?</div>
            <div class="chat-message-time">06:30pm</div>
          </div>
          <div class="chat-message chat-message-received">
            <img src="../Images/undraw_female-avatar_7t6k.svg" alt="Avatar">
            <div class="chat-message-bubble">Destiboy Pub</div>
            <div class="chat-message-time">06:35pm</div>
          </div>
          <div class="chat-message chat-message-sent">
            <img src="../Images/undraw_male-avatar_zkzx.svg" alt="Avatar">
            <div class="chat-message-bubble">Coming.</div>
            <div class="chat-message-time">06:50pm</div>
          </div>
        </div>
        <div class="chat-input">
          <input type="text" placeholder="Type here...">
          <button type="button">Send</button>
        </div>
      </div>
      <div class="chat-profile">
        <img src="../Images/undraw_male-avatar_zkzx.svg" alt="Avatar" class="chat-profile-avatar">
        <div class="chat-profile-name">Mark Aldrin Mendoza</div>
        <div class="chat-profile-status">Active now</div>
        <div class="chat-profile-info">
          <div><strong>EMAIL:</strong> markaldrin@gmail.com</div>
          <div><strong>PHONE:</strong> +93762384752</div>
          <div><strong>GRADE & SECTION:</strong> 10 - GRACE </div>
          <div><strong>REGISTER:</strong> JANUARY 12 2025</div>
        </div>
        <button class="chat-profile-block">BLOCK</button>
      </div>
    </div>
  </div>
</body>
</html>
