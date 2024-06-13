<?php 
session_start();

function data($cell, $i){
  if($cell[$i] == 0){
    echo ('<button name="index" value="' . $i . '"></button>');
  } else {
    echo '<h1>' . $cell[$i] . '</h1>';
  }
}

if(!(
  isset($_SESSION["gameboard"]) and
  isset($_SESSION["score_x"]) and
  isset($_SESSION["score_o"]) and
  isset($_SESSION["move_counter"]) and
  isset($_SESSION["first_to_play"])
)){
  $_SESSION["gameboard"] = array(0, 0, 0, 0, 0, 0, 0, 0, 0);
  $_SESSION["score_x"] = 0;
  $_SESSION["score_o"] = 0;
  $_SESSION["move_counter"] = 0;
  $_SESSION["first_to_play"] = rand(1, 2);
}


$winner = "none";

if($_GET and $_SESSION["move_counter"] <= 9){
  
  $i = $_GET["index"];

  if($_SESSION["gameboard"][$i] == 0){

    if($_SESSION["first_to_play"] == 1){
      
      if($_SESSION["move_counter"] % 2 == 0){
        $_SESSION["gameboard"][$i] = "X";
        $_SESSION["move_counter"] += 1;
      } else {
        $_SESSION["gameboard"][$i] = "O";
        $_SESSION["move_counter"] += 1;
      }
    } else {
      
      if($_SESSION["move_counter"] % 2 == 0){
        $_SESSION["gameboard"][$i] = "O";
        $_SESSION["move_counter"] += 1;
      } else {
        $_SESSION["gameboard"][$i] = "X";
        $_SESSION["move_counter"] += 1;
      }
    }

  } else {
    echo '<p class="warning-message">Mossa non valida!</p>';
  }
}

if($_SESSION["move_counter"] >= 5){
  if (
      $_SESSION["gameboard"][0] == $_SESSION["gameboard"][1] and
      $_SESSION["gameboard"][1] == $_SESSION["gameboard"][2]
  ) {
      $winner = $_SESSION["gameboard"][0];
  } elseif (
      $_SESSION["gameboard"][3] == $_SESSION["gameboard"][4] and
      $_SESSION["gameboard"][4] == $_SESSION["gameboard"][5]
  ) {
      $winner = $_SESSION["gameboard"][3];
  } elseif (
      $_SESSION["gameboard"][6] == $_SESSION["gameboard"][7] and
      $_SESSION["gameboard"][7] == $_SESSION["gameboard"][8]
  ) {
      $winner = $_SESSION["gameboard"][6];
  } elseif (
      $_SESSION["gameboard"][0] == $_SESSION["gameboard"][3] and
      $_SESSION["gameboard"][3] == $_SESSION["gameboard"][6]
  ) {
      $winner = $_SESSION["gameboard"][0];
  } elseif (
      $_SESSION["gameboard"][1] == $_SESSION["gameboard"][4] and
      $_SESSION["gameboard"][4] == $_SESSION["gameboard"][7]
  ) {
      $winner = $_SESSION["gameboard"][1];
  } elseif (
      $_SESSION["gameboard"][2] == $_SESSION["gameboard"][5] and
      $_SESSION["gameboard"][5] == $_SESSION["gameboard"][8]
  ) {
      $winner = $_SESSION["gameboard"][2];
  } elseif (
      $_SESSION["gameboard"][0] == $_SESSION["gameboard"][4] and
      $_SESSION["gameboard"][4] == $_SESSION["gameboard"][8]
  ) {
      $winner = $_SESSION["gameboard"][0];
  } elseif (
      $_SESSION["gameboard"][2] == $_SESSION["gameboard"][4] and
      $_SESSION["gameboard"][4] == $_SESSION["gameboard"][6]
  ) {
      $winner = $_SESSION["gameboard"][2];
  } elseif (
      $_SESSION["move_counter"] == 9 and (
        !($_SESSION["gameboard"][0] == $_SESSION["gameboard"][1] and $_SESSION["gameboard"][1] == $_SESSION["gameboard"][2]) and
        !($_SESSION["gameboard"][3] == $_SESSION["gameboard"][4] and $_SESSION["gameboard"][4] == $_SESSION["gameboard"][5]) and
        !($_SESSION["gameboard"][6] == $_SESSION["gameboard"][7] and $_SESSION["gameboard"][7] == $_SESSION["gameboard"][8]) and
        !($_SESSION["gameboard"][0] == $_SESSION["gameboard"][3] and $_SESSION["gameboard"][3] == $_SESSION["gameboard"][6]) and
        !($_SESSION["gameboard"][1] == $_SESSION["gameboard"][4] and $_SESSION["gameboard"][4] == $_SESSION["gameboard"][7]) and
        !($_SESSION["gameboard"][2] == $_SESSION["gameboard"][5] and $_SESSION["gameboard"][5] == $_SESSION["gameboard"][8]) and
        !($_SESSION["gameboard"][0] == $_SESSION["gameboard"][4] and $_SESSION["gameboard"][4] == $_SESSION["gameboard"][8]) and
        !($_SESSION["gameboard"][2] == $_SESSION["gameboard"][4] and $_SESSION["gameboard"][4] == $_SESSION["gameboard"][6])
      )
  ) {
      $winner = "pareggio";
  }

  if ($winner == "X") {
      $_SESSION["score_x"] += 1;
      $_SESSION["gameboard"] = array(0, 0, 0, 0, 0, 0, 0, 0, 0);
      $_SESSION["move_counter"] = 0;
      $_SESSION["first_to_play"] = rand(1, 2);
  } elseif ($winner == "O") {
      $_SESSION["score_o"] += 1;
      $_SESSION["gameboard"] = array(0, 0, 0, 0, 0, 0, 0, 0, 0);
      $_SESSION["move_counter"] = 0;
      $_SESSION["first_to_play"] = rand(1, 2);
  } elseif ($winner == "pareggio") {
      $_SESSION["gameboard"] = array(0, 0, 0, 0, 0, 0, 0, 0, 0);
      $_SESSION["move_counter"] = 0;
      $_SESSION["first_to_play"] = rand(1, 2);
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tic Tac Toe</title>
  <link rel="stylesheet" href="style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
  <div class="info">
    <p class="scores"><span class="red">X</span> <span><?php echo $_SESSION["score_x"]; ?></span> - <span><?php echo $_SESSION["score_o"]; ?></span> <span class="blue">O</span></p>
    <p class="first-to-play">Primo a giocare: <span>
      <?php 
      if($_SESSION["first_to_play"] == 1){
        echo "<span class='player red'>X</span>";
      } else {
        echo "<span class='player blue'>O</span>";
      }
      ?></span></p>
  </div>
  <form class="gameboard" action="index.php" method="get">
    <div class="area area1"><?php data($_SESSION["gameboard"], 0) ?></div>
    <div class="area area2"><?php data($_SESSION["gameboard"], 1) ?></div>
    <div class="area area3"><?php data($_SESSION["gameboard"], 2) ?></div>
    <div class="area area4"><?php data($_SESSION["gameboard"], 3) ?></div>
    <div class="area area5"><?php data($_SESSION["gameboard"], 4) ?></div>
    <div class="area area6"><?php data($_SESSION["gameboard"], 5) ?></div>
    <div class="area area7"><?php data($_SESSION["gameboard"], 6) ?></div>
    <div class="area area8"><?php data($_SESSION["gameboard"], 7) ?></div>
    <div class="area area9"><?php data($_SESSION["gameboard"], 8) ?></div>
  </form>


</body>
</html>
