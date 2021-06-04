<?php

include 'config/connect.php';

$sql = "SELECT * FROM mugs WHERE image !=''";
    if ($result = $mysqli->query($sql)) {
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            
          }
        }
      }