<link rel="stylesheet" type="text/css" href="minesweeper.css">
<?php
session_start();
  if($_SESSION['boardSet'] != true){
    $_SESSION['mines'] = array();
    $_SESSION['clickOrFlag'] = array();
    setMines(12,14);
  }
  // for($i = 0; $i < 12; $i++){
  //   for($j = 0; $j < 12; $j++){
  //     echo $_SESSION['mines'][$i][$j]." ";
  //     if ($j == 11)
  //       echo "<br>";
  //   }
  // }
  // for($i = 0; $i < 12; $i++){
  //   for($j = 0; $j < 12; $j++){
  //     echo $_SESSION['clickOrFlag'][$i][$j]." ";
  //     if ($j == 11)
  //       echo "<br>";
  //   }
  // }
  if($_SESSION['user'] == null){
    header("Location: http://3750stoor.epizy.com/minesweep/login.php");
  }
?>
<html>
<body>
<h2>Time is running out</h2>
<h3 id='timer'>15</h3>
  <table id = "gameBoard" width=300px height=300px style="border:1px solid #000000;"></table>
  <p id="shobu"></p>

   <form action="logout.php">
     <input type="submit" value="Logout">
   </form>

    <form action="highscore.php">
      <input type="submit" value="To Highscores">
    </form>
  <?php
  $boardSize = 12;
  $numMines = 14;

  ?>

<script>
  //disable context menu
  document.oncontextmenu = function() {
  return false;
}

  // populate the table
  var boardSize = 12
  var numMines = 14
  var tbl = document.getElementById('gameBoard')
  var row
  var cell
  var mines = new Array(boardSize)
  var boardIndex = 0
  var clearedCells = 0
  <?php
    $js_clickOrFlag = json_encode($_SESSION['clickOrFlag']);
    echo "var clickOrFlag = " .$js_clickOrFlag . ";\n";
    ?>
  // rows
  for(var i = 0; i < boardSize; i++) {
    row = tbl.insertRow(i)
    // columns
    for(var j = 0; j < boardSize; j++) {
      cell = row.insertCell(j)
      cell.id = boardIndex++
      cell.clicked = false
      cell.flagged = false
      cell.row = i
      cell.column = j
      //cell.addEventListener("click",function(){clickSquare(cell.id)})
      cell.setAttribute("onclick","leftClickSquare(" + cell.id + ")")
      cell.setAttribute("oncontextmenu","rightClickSquare(" + cell.id + ")")
      if(clickOrFlag[i][j] == 1){
        leftClickSquare(cell.id)
      }
      else if(clickOrFlag[i][j] == 2){
        rightClickSquare(cell.id)
      }
    }
  }

function leftClickSquare(squareID){

  var myRow = document.getElementById(squareID).row
  var myColumn = document.getElementById(squareID).column
  document.getElementById(squareID).clicked = true

  if(document.getElementById(squareID).flagged == true ||
document.getElementById(squareID).clicked == true) {
    // already flagged or clicked
  }
  else {
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById(squareID).innerHTML = this.responseText;
          if (this.responseText == '-1'){
            document.getElementById(squareID).style.backgroundColor = 'black' //mine
            //TODO: Game Over Code
            document.getElementById("shobu").innerHTML = "You Lose!"
          }
          else {
            document.getElementById(squareID).style.backgroundColor = '#f7ebe8' // linen color
            clearedCells++
            if(clearedCells == boardSize*boardSize-numMines){
              //TODO: Win Code
              document.getElementById("shobu").innerHTML = "You Win!"
            }
          }
        }
      };
      xhttp.open("GET", "getcell.php?query=1&x=" + myRow + "&y=" + myColumn, true);
      xhttp.send();
  }

}

function rightClickSquare(squareID) {
  var myRow = document.getElementById(squareID).row
  var myColumn = document.getElementById(squareID).column

  if(document.getElementById(squareID).flagged) {
    document.getElementById(squareID).style.backgroundColor = '#ffa987' // vivid tangerine color
    document.getElementById(squareID).flagged = false
    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", "getcell.php?query=3&x=" + myRow + "&y=" + myColumn, true);
    xhttp.send();
  }
  else if(!document.getElementById(squareID).clicked) {
    document.getElementById(squareID).style.backgroundColor = 'red'
    document.getElementById(squareID).flagged = true
    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", "getcell.php?query=2&x=" + myRow + "&y=" + myColumn, true);
    xhttp.send();
  }
}

</script>
<?php

  function setMines($boardSize, $numMines){
    $mineCount = 0;
    $surroundingBombs = 0;

    for($i = 0; $i < $boardSize; $i++){
      for($j = 0; $j < $boardSize; $j++){
        $_SESSION['mines'][$i][$j] = 0;
          $_SESSION['clickOrFlag'][$i][$j] = 0;
      }
    }

    while($mineCount < $numMines) {
      $randomRow = mt_rand(0, $boardSize - 1);
      $randomColumn = mt_rand(0, $boardSize - 1);
      if ($_SESSION['mines'][$randomRow][$randomColumn] == -1){
        // already set to a mine
      }
      else {
        $_SESSION['mines'][$randomRow][$randomColumn] = -1;
        $mineCount++;
      }
    }

    for($i = 0; $i < $boardSize; $i++){
      for($j = 0; $j < $boardSize; $j++){
        if($_SESSION['mines'][$i][$j] == -1) {
          //Do nothing, it's already set
        }
        else {

          if($i != 0){
            if ($_SESSION['mines'][$i-1][$j-1] == -1)
              $surroundingBombs++;
            if ($_SESSION['mines'][$i-1][$j] == -1)
              $surroundingBombs++;
            if ($_SESSION['mines'][$i-1][$j+1] == -1)
              $surroundingBombs++;
          }

          if ($_SESSION['mines'][$i][$j-1] == -1)
            $surroundingBombs++;
          if ($_SESSION['mines'][$i][$j+1] == -1)
            $surroundingBombs++;

          if($i != $boardSize-1){
            if ($_SESSION['mines'][$i+1][$j-1] == -1)
              $surroundingBombs++;
            if ($_SESSION['mines'][$i+1][$j] == -1)
              $surroundingBombs++;
            if ($_SESSION['mines'][$i+1][$j+1] == -1)
              $surroundingBombs++;
          }

          $_SESSION['mines'][$i][$j] = $surroundingBombs;
          $surroundingBombs = 0;
      }
    }

    $_SESSION['boardSet'] = true;
  }
}

 ?>
</body>
</html>
