<?php 

$host = 'itp460.usc.edu';
$dbname = 'dvd';
$user = 'student';
$pass = 'ttrojan';

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);

$rating = $_GET['rating'];

//echo $rating;

$sql = "
  SELECT title, genre_name, format_name, rating_name
  FROM dvds
  INNER JOIN genres
  ON dvds.genre_id = genres.id
  INNER JOIN formats
  ON dvds.format_id = formats.id
  INNER JOIN ratings
  ON dvds.rating_id = ratings.id
  WHERE ratings.rating_name = ?
";

$statement = $pdo->prepare($sql);
$statement->bindParam(1, $rating);
$statement->execute();
$dvds = $statement->fetchAll(PDO::FETCH_OBJ);

?>

<html>
<head>
  <title>DVD Search</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/css/bootstrap.css">
</head>
<body class="container" style="padding: 10px 10px 10px 10px">

  <div class="row">  
    <div class="jumbotron"><h2>ITP405: DVD Search</h2></div>
  </div>
    
    <?php foreach($dvds as $dvd) : ?>
      <div class="row">
        <div class="col-sm-12">
        <h3>
          <?php echo $dvd->title ?>
          <?php echo $dvd->genre_name ?>
        </h3>
        <p>Format: <?php echo $dvd->format_name ?></p>
        <p>Rating: <?php echo $dvd->rating_name ?></p>
        </div>
      </div>
    <?php endforeach; ?>
</body>
</html>