<style>
      body {
        font-family: 'Open Sans', sans-serif;
        margin: 10;
        padding: 0;
        color: #333;
      }

      h1 {
        font-size: 2em;
        margin: 1em 0;
      }

      li {
        font-size: 1.2em;
        margin: 0.5em 0;
      }

      .btn {
        display: inline-block;
        background-color: #0095ff;
        color: #fff;
        padding: 0.8em 1.2em;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        transition: background-color 0.3s;
      }

      .btn:hover {
        background-color: #007acc;
      }
    </style>
  
<?php
  // Include connection file
  include_once('connection.php');
  
  // Check if owner ID is set and not empty
  if (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
  } else {
    die('Owner not found');
  }
  
  // Query to get owner details
  $query = "SELECT * FROM owners WHERE name ='$id'";
  $output = $conn->query($query);
  $data = mysqli_fetch_array($output);
?>

    <h1>Owners Details</h1>
    <li>Name: <?php echo $data['name']; ?></li>
    <li>Email: <?php echo $data['email']; ?></li>
    <li>Phone: <?php echo $data['phone']; ?></li>
    <li>Address: <?php echo $data['address']; ?></li>
  </ul>
  <br>
  <a href='javascript:history.back()' class='btn' > Go Back</a>
</div>
