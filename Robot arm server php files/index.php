<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Robot Arm Control Panel</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f9f9f9;
      text-align: center;
      padding: 40px;
    }

    h2 {
      margin-bottom: 30px;
    }

    .slider-container {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 20px;
      margin-bottom: 30px;
    }

    .slider {
      background: #fff;
      padding: 15px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      width: 220px;
    }

    input[type=range] {
      width: 100%;
    }

    .buttons {
      margin-bottom: 30px;
    }

    button {
      padding: 10px 20px;
      margin: 5px;
      border: none;
      border-radius: 6px;
      background-color: #007BFF;
      color: white;
      font-weight: bold;
      cursor: pointer;
    }

    button:hover {
      background-color: #0056b3;
    }

    table {
      width: 90%;
      margin: auto;
      border-collapse: collapse;
      background: white;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    th, td {
      border: 1px solid #ccc;
      padding: 10px;
    }

    th {
      background-color: #007BFF;
      color: white;
    }

    td form {
      display: inline;
    }

    .remove-btn {
      background: #dc3545;
    }

    .load-btn {
      background: #17a2b8;
    }
  </style>
</head>
<body>

<h2>Robot Arm Control Panel</h2>

<form method="post" action="save_pose.php">
  <div class="slider-container">
    <?php for ($i = 1; $i <= 6; $i++): ?>
      <div class="slider">
        <label for="servo<?= $i ?>">Motor <?= $i ?>: <span id="val<?= $i ?>">90</span>°</label><br>
        <input type="range" name="servo<?= $i ?>" id="servo<?= $i ?>" min="0" max="180" value="90"
               oninput="document.getElementById('val<?= $i ?>').innerText = this.value;">
      </div>
    <?php endfor; ?>
  </div>

  <div class="buttons">
    <button type="reset" style="background: #6c757d;">Reset</button>
    <button type="submit">Save Pose</button>
    <button type="button" onclick="runCurrentPose()">Run</button>
  </div>
</form>

<!-- Table -->
<table>
  <tr>
    <th>#</th>
    <?php for ($i = 1; $i <= 6; $i++): ?>
      <th>Motor <?= $i ?></th>
    <?php endfor; ?>
    <th>Actions</th>
  </tr>
  <?php
  $poses = $conn->query("SELECT * FROM pose ORDER BY id DESC");
  while ($row = $poses->fetch_assoc()):
  ?>
    <tr>
      <td><?= $row['id'] ?></td>
      <?php for ($i = 1; $i <= 6; $i++): ?>
        <td><?= $row['servo' . $i] ?></td>
      <?php endfor; ?>
      <td>
        <button class="load-btn" onclick='loadPose(<?= json_encode($row) ?>)'>Load</button>
        <form action="delete_pose.php" method="post" style="display:inline;">
          <input type="hidden" name="id" value="<?= $row['id'] ?>">
          <button class="remove-btn" type="submit">Remove</button>
        </form>
      </td>
    </tr>
  <?php endwhile; ?>
</table>

<!-- JS to Load + Run -->
<script>
function loadPose(pose) {
  for (let i = 1; i <= 6; i++) {
    document.getElementById(`servo${i}`).value = pose[`servo${i}`];
    document.getElementById(`val${i}`).innerText = pose[`servo${i}`];
  }
}

function runCurrentPose() {
  const form = document.createElement('form');
  form.method = 'POST';
  form.action = 'run_pose_direct.php';

  for (let i = 1; i <= 6; i++) {
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = `servo${i}`;
    input.value = document.getElementById(`servo${i}`).value;
    form.appendChild(input);
  }

  document.body.appendChild(form);
  form.submit();
}
</script>

</body>
</html>
