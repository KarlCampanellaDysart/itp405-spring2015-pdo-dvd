<?php 

if (!isset($_GET['dvd_title'])) {
  header('Location: index.php');
}

$host = 'itp460.usc.edu';
$dbname = 'dvd';
$user = 'student';
$pass = 'ttrojan';

$title = $_GET['dvd_title']; // $_REQUEST['artist']
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);

$sql = "
  SELECT title, genre_name, format_name, rating_name
  FROM dvds
  INNER JOIN genres
  ON dvds.genre_id = genres.id
  INNER JOIN formats
  ON dvds.format_id = genres.id
  INNER JOIN ratings
  ON dvds.rating_id = ratings.id
  WHERE title LIKE ?
";

$statement = $pdo->prepare($sql);
$like = '%'.$title.'%';
$statement->bindParam(1, $like);


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
      </h3>
      <p>Genre: <?php echo $dvd->genre_name ?></p>
      <p>Format: <?php echo $dvd->format_name ?></p>
      <p>Rating: <a href="ratings.php?rating=<?php echo $dvd->rating_name ?>"><?php echo $dvd->rating_name ?></a></p>
      </div>
    </div>
  <?php endforeach; ?>
  
</body>
</html>