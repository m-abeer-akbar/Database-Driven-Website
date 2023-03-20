<?php
  require_once('connection.php');

  // Query for the total number of owners, dogs, and events
  $query1 = "SELECT COUNT(id) FROM owners";
  $ownerCountResult = $conn->query($query1);
  $ownerCount = $ownerCountResult->fetch_row()[0];

  $query2 = "SELECT COUNT(id) FROM dogs";
  $dogCountResult = $conn->query($query2);
  $dogCount = $dogCountResult->fetch_row()[0];

  $query3 = "SELECT COUNT(*) FROM events";
  $eventCountResult = $conn->query($query3);
  $eventCount = $eventCountResult->fetch_row()[0];

  // Creating the welcome message
  $welcomeMessage = "<br>Welcome to Poppleton Dogs Show!</br> This year $ownerCount owners entered $dogCount dogs in $eventCount events!";
?>

<html>
  <head>
    <title>Poppleton Dogs Show</title>
    <style type="text/css">
      
      body {
  font-family: Arial, sans-serif;
  background-color: #f0f0f0;
  color: #333;
}

h1 {
  color: #555;
  text-align: center;
  margin: 20px;
}

table {
  width: 80%;
  margin: 20px auto;
  border-collapse: collapse;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
}

th, td {
  border: 1px solid #ddd;
  padding: 10px;
}

th {
  background-color: #555;
  color: white;
  font-weight: bold;
}

td {
  text-align: center;
}

tr:nth-child(even) {
  background-color: #f8f8f8;
}

tr:hover {
  background-color: #f0e68c;
}

    </style>
  </head>
  <body>
    <h1><?php echo $welcomeMessage; ?></h1>
    <table>
    <tr>
      <th>Number</th>
      <th>Dog's Name</th>
      <th>Breed</th>
      <th>Average Score</th>
      <th>Owner's Name</th>
      <th>Owner's Email</th>
    </tr>
    <?php
      // This query helps retrieve information about top 10 dogs with highrest average scores.
      $query4 = "SELECT d.id AS dog_id, AVG(e.score) AS avg_score, d.name AS dogs_name FROM dogs d
                 INNER JOIN entries e ON d.id = e.dog_id
                 GROUP BY d.id
                 HAVING COUNT(e.competition_id) > 1
                 ORDER BY avg_score DESC
                 LIMIT 10";
      $topDogsResult = $conn->query($query4);

      // We only need to display details about the top 10 dogs
      $number = 1;
      while ($row = $topDogsResult->fetch_assoc()) {
        $dogId = $row['dog_id'];
        $dogName = $row['dogs_name'];
        $avgScore = $row['avg_score'];

        // Get the dog's breed name
        $query5 = "SELECT b.name AS breed_name FROM breeds b
                   INNER JOIN dogs d ON b.id = d.breed_id
                   WHERE d.id = $dogId";
        $breedResult = $conn->query($query5);
        $breedName = $breedResult->fetch_assoc()['breed_name'];

        // Get the dog's owner's name and email
        $query6 = "SELECT o.name AS owner_name, o.email AS owner_email FROM owners o
                   INNER JOIN dogs d ON o.id = d.owner_id
                   WHERE d.id = $dogId";
        $ownerResult = $conn->query($query6);
        $ownerInfo = $ownerResult->fetch_assoc();
        
        // Print the information for this dog in a row of the table
        echo "<tr>";
        echo "<td>$number</td>";
        echo "<td>$dogName</td>";
        echo "<td>$breedName</td>";
        echo "<td>$avgScore</td>";?>
        <td><a href="ownerprofile.php?id=<?php echo $ownerInfo[owner_name]?>"><?php echo $ownerInfo[owner_name]?></a></td>
        <td><a href="mailto: <?php echo $ownerInfo[owner_email]?>"><?php echo $ownerInfo[owner_email]?></a></td>
        </tr>
        <?php
        $number++; 
      }
    ?>
  </table>

      