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
  var mines = [[],[]]
  var boardIndex = 0
  // rows
  for(var i = 0; i < boardSize; i++) {
    row = tbl.insertRow(i)
    // columns
    for(var j = 0; j < boardSize; j++) {
      cell = row.insertCell(j)
      cell.id = boardIndex++
      //cell.addEventListener("click",function(){clickSquare(cell.id)})
      cell.setAttribute("onclick","leftClickSquare(" + cell.id + ")")
      cell.setAttribute("oncontextmenu","rightClickSquare(" + cell.id + ")")
    }
  }


setMines()


function leftClickSquare(squareID){
  var myRow = document.getElementById(squareID).rowIndex
  var myCell = document.getElementById(squareID).cellIndex
  if(document.getElementById(squareID).style.backgroundColor == 'red') {
    // already flagged
  }
  else if(mines[myRow][myCell] == -1) {
    document.getElementById(squareID).style.backgroundColor = 'black'
  }

  else {
    document.getElementById(squareID).style.backgroundColor = 'green'
  }

}

function rightClickSquare(squareID) {
  if(document.getElementById(squareID).style.backgroundColor != 'red') {
    document.getElementById(squareID).style.backgroundColor = 'red'
  }
  else {
    document.getElementById(squareID).style.backgroundColor = 'blue'
  }
}

function adjacentSquares(squareID){

}

function setMines(){
  for(var i = 0; i < boardSize; i++){
    for(var j = 0; j < boardSize; j++)
      mines[i][j] = 0
  }
  var mineCount = 0
  while(mineCount < boardSize) {
    var randomRow = Math.floor(Math.random() * boardSize);
    var randomCell = Math.floor(Math.random() * boardSize)
    if (mines[randomRow][randomCell] == -1){
      // already set to a mine
    }
    else {
      mines[randomRow][randomCell] = -1
      mineCount++
    }
  }

}



</script>
</html>
