<link rel="stylesheet" type="text/css" href="minesweeper.css">
<?php
  // initialize the game board

  // set mines


?>
<html>
<h2>Time is running out</h2>
<h3>15</h3>
  <table id = "gameBoard" width=300px height=300px style="border:1px solid #000000;"></table>
<script>
  // populate the table
  var boardSize = 9
  var tbl = document.getElementById('gameBoard')
  var row
  var boardIndex = 0
  // rows
  for(var i = 0; i < boardSize; i++) {
    row = tbl.insertRow(i)
    // columns
    for(var j = 0; j < boardSize; j++) {
      row.insertCell(j)
      tbl.rows[i].cells[j].id = boardIndex++
      tbl.rows[i].cells[j].onclick = clickSquare("click", tbl.rows[i].cells[j].id)
    }
  }





function clickSquare(event, squareID){
  document.getElementById('squareID').style.backgroundColor = 'black'
}

function adjacentSquares(squareID){

}

function setMines(){

}



</script>
</html>
