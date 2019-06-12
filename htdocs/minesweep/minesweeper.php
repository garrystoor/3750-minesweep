<link rel="stylesheet" type="text/css" href="minesweeper.css">
<?php
session_start();
session_destroy();
  // initialize the game board

  // set mines
  /*
  $minesArray = array[81];
  for(var i = 0; i < 81; i++) {
    array[i] = 0;
  }
  $_Session['mines'];
*/
?>
<html>
<h2>Time is running out</h2>
<h3>15</h3>
  <table id = "gameBoard" width=300px height=300px style="border:1px solid #000000;"></table>
<script>
  //disable context menu
  document.oncontextmenu = function() {
  return false;
}

  // populate the table
  var boardSize = 9
  var tbl = document.getElementById('gameBoard')
  var row
  var cell
  var mines = new Array(boardSize)
  var boardIndex = 0
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
    }
  }


setMines()


function leftClickSquare(squareID){
  var myRow = document.getElementById(squareID).row
  var myColumn = document.getElementById(squareID).column
  if(document.getElementById(squareID).style.backgroundColor == 'red') {
    // already flagged
  }
  else if(mines[myRow][myColumn] == -1) {
    document.getElementById(squareID).style.backgroundColor = 'black'
    document.getElementById(squareID).clicked = true;
    //TODO: IMPLEMENT GAME OVER CODE
  }

  else {
    document.getElementById(squareID).style.backgroundColor = 'green'
    adjacentSquares(squareID)
    document.getElementById(squareID).clicked = true;
  }

}

function rightClickSquare(squareID) {
  if(document.getElementById(squareID).flagged) {
    document.getElementById(squareID).style.backgroundColor = 'blue'
    document.getElementById(squareID).flagged = false
  }
  else if(!document.getElementById(squareID).clicked) {
    document.getElementById(squareID).style.backgroundColor = 'red'
    document.getElementById(squareID).flagged = true
  }
}

function adjacentSquares(squareID){
  var myRow = document.getElementById(squareID).row
  var myColumn = document.getElementById(squareID).column
  var surroundingBombs = 0
  if(mines[myRow][myColumn] == -1) {
    //Game Over, adjacentSquares shouldn't be called here
  }
  else {

    if(myRow != 0){
      if (mines[myRow-1][myColumn-1] == -1)
        surroundingBombs++
      if (mines[myRow-1][myColumn] == -1)
        surroundingBombs++
      if (mines[myRow-1][myColumn+1] == -1)
        surroundingBombs++
    }

    if (mines[myRow][myColumn-1] == -1)
      surroundingBombs++
    if (mines[myRow][myColumn+1] == -1)
      surroundingBombs++

    if(myRow != boardSize-1){
      if (mines[myRow+1][myColumn-1] == -1)
        surroundingBombs++
      if (mines[myRow+1][myColumn] == -1)
        surroundingBombs++
      if (mines[myRow+1][myColumn+1] == -1)
        surroundingBombs++
    }

    mines[myRow][myColumn] = surroundingBombs
    document.getElementById(squareID).innerHTML = surroundingBombs
  }
}

function setMines(){
  for (var i = 0; i < mines.length; i++) {
    mines[i] = new Array(boardSize);
}

  for(var i = 0; i < boardSize; i++){
    for(var j = 0; j < boardSize; j++)
      mines[i][j] = 0
  }
  var mineCount = 0
  while(mineCount < boardSize) {
    var randomRow = Math.floor(Math.random() * boardSize);
    var randomColumn = Math.floor(Math.random() * boardSize)
    if (mines[randomRow][randomColumn] == -1){
      // already set to a mine
    }
    else {
      mines[randomRow][randomColumn] = -1
      mineCount++
    }
  }

}



</script>
</html>
