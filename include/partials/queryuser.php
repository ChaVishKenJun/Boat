<!DOCTYPE html>
<html>
  <head>
    <style>
      table {
        width: 100%;
        border-collapse: collapse;
      }

      table, td, th {
        border: 1px solid black;
        padding: 5px;
      }

      th {text-align: left;}
    </style>
  </head>
  <body>

  <?php
  

  $query = intval($_GET['query']);

  $result = $db->single_dynamic_query("SELECT * FROM user WHERE firstname LIKE '%$query%' OR lastname LIKE '%$query%' OR email LIKE '%$query%'");
  $fields = $result[1]['con'][0];

  echo "<table>";
  foreach ($result[0] as $row) {
    $count = 0;
    echo "<tr>";
    while($count <= $fields - 1) {
      echo "<td>" . $row[$count] . "</td>";
      $count++;
    }
    echo "</tr>";
  }
  echo "</table>";
  ?>

  </body>
</html>