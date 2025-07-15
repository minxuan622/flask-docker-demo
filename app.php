<?php
// 儲存留言用的檔案
$filename = "messages.txt";

// 如果使用者送出留言
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name = htmlspecialchars($_POST["name"]);
  $message = htmlspecialchars($_POST["message"]);
  $timestamp = date("Y-m-d H:i:s");
  $entry = "$timestamp | $name: $message\n";
  file_put_contents($filename, $entry, FILE_APPEND);
}
?>
<!DOCTYPE html>
<html lang="zh-Hant">

<head>
  <meta charset="UTF-8">
  <title>櫻花留言板</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background: #fef6f9;
      font-family: 'Segoe UI', sans-serif;
      text-align: center;
    }

    h1 {
      margin-top: 30px;
      color: #c94f7c;
    }

    form {
      margin: 20px auto;
      width: 300px;
    }

    input,
    textarea {
      width: 100%;
      margin: 8px 0;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 1em;
    }

    button {
      background-color: #c94f7c;
      color: white;
      padding: 10px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .messages {
      margin-top: 30px;
      background: #fff;
      padding: 20px;
      width: 500px;
      max-width: 90%;
      margin-left: auto;
      margin-right: auto;
      border-radius: 10px;
      box-shadow: 0 0 10px #ccc;
      text-align: left;
    }

    .message {
      border-bottom: 1px solid #eee;
      padding: 8px 0;
    }

    canvas {
      position: fixed;
      top: 0;
      left: 0;
      z-index: -1;
      pointer-events: none;
    }
  </style>
</head>

<body>
  <h1>🌸 櫻花留言板 🌸</h1>

  <form method="POST" action="">
    <input type="text" name="name" placeholder="你的名字" required>
    <textarea name="message" placeholder="寫點什麼吧..." rows="4" required></textarea>
    <button type="submit">送出留言</button>
  </form>

  <div class="messages">
    <h3>留言區：</h3>
    <?php
    if (file_exists($filename)) {
      $lines = file($filename, FILE_IGNORE_NEW_LINES);
      foreach (array_reverse($lines) as $line) {
        echo "<div class='message'>" . htmlspecialchars($line) . "</div>";
      }
    } else {
      echo "<p>目前還沒有留言。</p>";
    }
    ?>
  </div>

  <canvas id="sakuraCanvas"></canvas>
  <script>
    // Sakura falling animation
    const canvas = document.getElementById('sakuraCanvas');
    const ctx = canvas.getContext('2d');
    let width = window.innerWidth;
    let height = window.innerHeight;
    canvas.width = width;
    canvas.height = height;

    window.addEventListener('resize', () => {
      width = window.innerWidth;
      height = window.innerHeight;
      canvas.width = width;
      canvas.height = height;
    });

    const sakuraImage = new Image();
    sakuraImage.src = "https://png.pngtree.com/png-clipart/20220108/ourmid/pngtree-pink-cherry-blossom-dai-pink-petals-spring-cherry-blossom-sea-png-image_4099494.png";

    const sakuraCount = 30;
    const sakuras = [];

    for (let i = 0; i < sakuraCount; i++) {
      sakuras.push({
        x: Math.random() * width,
        y: Math.random() * height,
        r: Math.random() * 20 + 20,
        d: Math.random() * 1 + 0.5
      });
    }

    function drawSakura() {
      ctx.clearRect(0, 0, width, height);
      for (let i = 0; i < sakuraCount; i++) {
        const p = sakuras[i];
        ctx.save();
        ctx.globalAlpha = 0.8;
        ctx.drawImage(sakuraImage, p.x, p.y, p.size, p.size);
        ctx.restore();
      }

      updateSakura();
    }

    function updateSakura() {
      for (let i = 0; i < sakuraCount; i++) {
        const p = sakuras[i];
        p.y += p.speed;
        p.x += Math.sin(p.y * 0.01) * 1;

        if (p.y > height) {
          p.y = 0;
          p.x = Math.random() * width;
        }
      }
    }

    sakuraImage.onload = () => {
      setInterval(drawSakura, 30);
    };
  </script>
</body>

</html>