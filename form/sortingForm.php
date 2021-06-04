<?php

include 'config/connect.php';

$sql = "SELECT * FROM mugs WHERE image !=''";
    if ($result = $mysqli->query($sql)) {
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo '<div class="round-box">
              <img src="images/'.$row['image'].'" class="img-fluid" alt="image">
              </br>
              <h4>'.strtoupper($row['title']).'</h4>
              </br>
              <h6 class="text-muted">'.$row['description'].'</h6>
              </br>
              <h6>Prix: '.$row['price'].'€</h6>
              </br>';
            if ($row['qte'] > 0) {
              echo '<h6>Stock: '.$row['qte'].' Pièces</h6>';
            } else {
              echo '<h6>Stock: 0 Pièce</h6>';
            }
            
          }
        }
      }