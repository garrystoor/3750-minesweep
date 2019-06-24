<link rel="stylesheet" type="text/css" href="minesweeper.css">
<?php
  session_start();
  if($_SESSION['boardSet'] != true){
    $_SESSION['mines'] = array();
    $_SESSION['clickedValues'] = array();
    setMines(12,14);
    $_SESSION['currTime'] = 0;
  }

  if($_SESSION['user'] == null){
    header("Location: http://3750stoor.epizy.com/minesweep/login.php");
  }

  function setMines($boardSize, $numMines){
    $mineCount = 0;
    $surroundingBombs = 0;

    for($i = 0; $i < $boardSize; $i++){
      for($j = 0; $j < $boardSize; $j++){
          $_SESSION['mines'][$i][$j] = 0;
          $_SESSION['clickedValues'][$i][$j] = 0;
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


<html>
<body>
<h2>Minesweeper</h2>
<h3 id='timer'>Time: </h3>
  <table id = "gameBoard" width=300px height=300px style="border:1px solid #000000;"></table>
  <p id="shobu"></p>



  <form action="newGame.php">
    <input type="submit" value="New Game">
  </form>

   <form action="logout.php">
     <input type="submit" value="Logout">
   </form>



    <form action="highscore.php">
      <input type="submit" value="Highscores">
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

  // initalize time
  var currTime = <?php echo $_SESSION['currTime']?>

  // populate the table
  var win
  var lose
  var boardSize = 12
  var numMines = 14
  var tbl = document.getElementById('gameBoard')
  var row
  var cell
  var mines = new Array(boardSize)
  var boardIndex = 0
  var clearedCells = 0
    <?php
      $js_clickedValues = json_encode($_SESSION['clickedValues']);
      echo "var clickedValues = " .$js_clickedValues . ";\n";
      ?>
  //tbl.style.display = "none"
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
      if(clickedValues[i][j] != 0 && clickedValues[i][j] != -3 && clickedValues[i][j] != -1){
        cell.clicked = true
        cell.style.backgroundColor = '#f7ebe8'
        if(clickedValues[i][j] != -2)
          cell.innerHTML = clickedValues[i][j];

        clearedCells++
        if(clearedCells == boardSize*boardSize-numMines){
          wonGame()
        }
      }
      else if(clickedValues[i][j] == -3){
        cell.flagged = true
        cell.style.backgroundColor = 'red'
      }
    }
  }
  //setTimeout(function(){ tbl.style.display = "table" }, 3000);

setInterval(updateTime, 1000)
function updateTime() {
    if(win || lose){}
    else{
      var xhttp = new XMLHttpRequest()
      xhttp.open("GET", "getcell.php?query=5&currTime=" + currTime, true)
      xhttp.send()
      document.getElementById('timer').innerHTML = "Time: " + currTime++
    }
}

function leftClickSquare(squareID){

  var myRow = document.getElementById(squareID).row
  var myColumn = document.getElementById(squareID).column

  if(document.getElementById(squareID).flagged ||
document.getElementById(squareID).clicked || win) {
    // already flagged, clicked, or won
  }
  else {
      document.getElementById(squareID).clicked = true
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {

          if (this.responseText == '-1'){
            document.getElementById(squareID).style.backgroundColor = 'black' //mine
            lostGame()
          }
          else {
            if(this.responseText == 0){
              if(myRow != 0){
                leftClickSquare(squareID-boardSize)
                if(myColumn!= boardSize-1)
                  leftClickSquare(squareID-boardSize+1)
                if(myColumn!= 0)
                  leftClickSquare(squareID-boardSize-1)
              }

              if(myColumn != 0)
                leftClickSquare(squareID-1)
              if(myColumn!= boardSize-1)
                leftClickSquare(squareID+1)

              if(myRow != boardSize-1){
                leftClickSquare(squareID+boardSize)
                if(myColumn!= boardSize-1)
                  leftClickSquare(squareID+boardSize+1)
                if(myColumn!= 0)
                  leftClickSquare(squareID+boardSize-1)
              }
            }
            if(this.responseText != 0)
              document.getElementById(squareID).innerHTML = this.responseText;
            document.getElementById(squareID).style.backgroundColor = '#f7ebe8' // linen color
            clearedCells++
            if(clearedCells == boardSize*boardSize-numMines){
              wonGame()
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
  if(win||lose){
    return
  }

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

function lostGame(){
  var squareID = 0
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function(){
    if (this.readyState == 4 && this.status == 200) {
      mines = JSON.parse(this.responseText)
      for(var i = 0; i < boardSize; i++) {
        for(var j = 0; j < boardSize; j++) {
          document.getElementById(squareID).clicked = true
          if (mines[i][j] == -1 && !(document.getElementById(squareID).flagged))
            document.getElementById(squareID).style.backgroundColor = 'black'
          squareID++
        }
      }
    }
  }
  xhttp.open("GET", "getcell.php?query=7", true);
  xhttp.send();

    document.getElementById("shobu").innerHTML = "You Lose!"


    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", "getcell.php?query=6", true);
    xhttp.send();
    lose = true
}

function wonGame(){
  //TODO: Win Code
  document.getElementById("shobu").innerHTML = "You Win!"
  win = true
  var finalScore = currTime - 1
  var xhttp = new XMLHttpRequest()
  xhttp.open("GET", "getcell.php?query=4&finalScore=" + finalScore, true)
  xhttp.send()

}

</script>
</body>
</html>
