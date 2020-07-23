<?php 

  require_once 'pdo.php';
  session_start();

  if(!isset($_GET['profile_id'])) {
    $_SESSION['status'] = "Missing profile_id";
    $_SESSION['color'] = "red";
    header("Location: index.php");
    return;
  }

  $profile_id = htmlentities($_GET['profile_id']);

  $sql = "SELECT * FROM profile WHERE profile_id=:pid";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([':pid' => $profile_id]);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  $sql = "SELECT * FROM position WHERE profile_id=:pid";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([':pid' => $profile_id]);
  $positions = array();

  while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $positions[] = $result;
  }

  if($row == false) {
    $_SESSION['status'] = "Could not load profile";
    $_SESSION['color'] = "red";
    header("Location: index.php");
    return;
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <title>Nilesh D</title>
</head>
<body>
  <div class="container">
    <h1>Profile information</h1>
    <p>First Name: <?= htmlentities($row['first_name']); ?></p>
    <p>Last Name: <?= htmlentities($row['last_name']); ?></p>
    <p>Email: <?= htmlentities($row['email']); ?></p>
    <p>Headline: </p>
    <p><?= htmlentities($row['headline']); ?></p>
    <p>Summary: </p>
    <p><?= htmlentities($row['summary']); ?></p>
    <p>Position</p>
    <ul>
      <?php foreach($positions as $position) : ?>
        <li><?= $position['year']; ?>: <?= $position['description']; ?></li>
      <?php endforeach; ?>
    </ul>
    <p><a href="index.php">Done</a></p>
  </div>
</body>
</html>
