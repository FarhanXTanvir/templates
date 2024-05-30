<?php
// Connect to the database
$db = new mysqli('localhost', 'root', '', 'blogs');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $title = $_POST['title'];
  $content = $_POST['content'];
  $image = $_FILES['image']['name'];

  // Handle image upload
  $target_dir = "uploads/";
  $target_file = $target_dir . basename($_FILES["image"]["name"]);

  if ($_FILES["image"]["error"] > 0) {
    echo "Error: " . $_FILES["image"]["error"] . "<br>";
  } else {
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
  }

  // Insert into database
  $stmt = $db->prepare("INSERT INTO posts (title, content, image) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $title, $content, $target_file);
  $stmt->execute();
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Blog Post</title>
  <style>
    @import url("https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap");

    *,
    *::before,
    *::after {
      box-sizing: border-box;
      padding: 0;
      margin: 0;
    }

    body {
      font-family: "Quicksand", sans-serif;
      display: grid;
      place-items: center;
      height: 100vh;
      background: #7f7fd5;
      background: linear-gradient(to right, #91eae4, #86a8e7, #7f7fd5);
    }

    .container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      max-width: 1200px;
      margin-block: 2rem;
      gap: 2rem;
    }

    img {
      max-width: 90%;
      display: block;
      object-fit: cover;
      margin: 0 auto;
    }

    .card {
      display: flex;
      flex-direction: column;
      width: clamp(20rem, calc(20rem + 2vw), 22rem);
      overflow: hidden;
      box-shadow: 0 .1rem 1rem rgba(0, 0, 0, 0.1);
      border-radius: 1em;
      background: #ECE9E6;
      background: linear-gradient(to right, #FFFFFF, #ECE9E6);

    }



    .card__body {
      padding: 1rem;
      display: flex;
      flex-direction: column;
      gap: .5rem;
    }


    .tag {
      align-self: flex-start;
      padding: .25em .75em;
      border-radius: 1em;
      font-size: .75rem;
    }

    .tag+.tag {
      margin-left: .5em;
    }

    .tag-blue {
      background: #56CCF2;
      background: linear-gradient(to bottom, #2F80ED, #56CCF2);
      color: #fafafa;
    }

    .tag-brown {
      background: #D1913C;
      background: linear-gradient(to bottom, #FFD194, #D1913C);
      color: #fafafa;
    }

    .tag-red {
      background: #cb2d3e;
      background: linear-gradient(to bottom, #ef473a, #cb2d3e);
      color: #fafafa;
    }

    .card__body h4 {
      font-size: 1.5rem;
      text-transform: capitalize;
    }

    .card__footer {
      display: flex;
      padding: 1rem;
      margin-top: auto;
    }

    .user {
      display: flex;
      gap: .5rem;
    }

    .user__image {
      border-radius: 50%;
    }

    .user__info>small {
      color: #666;
    }

    .form {
      display: flex;
      flex-direction: column;
      gap: 1rem;
      padding: 1rem;
      border-radius: 1em;
      background: #ECE9E6;
      background: linear-gradient(to right, #FFFFFF, #ECE9E6);
    }

    .form-group {
      display: flex;
      flex-direction: column;
      gap: .5rem;
    }

    .form-control {
      padding: .5rem;
      border-radius: .5em;
      border: 1px solid #ccc;
    }

    .form-control-file {
      padding: .5rem;
    }

    .btn {
      padding: .5rem;
      border-radius: .5em;
      border: none;
      background: #333;
      color: #fafafa;
      cursor: pointer;
    }
  </style>
</head>

<body>
  <div class="form">
    <h1>Create a New Blog Post</h1>
    <form action="blog.php" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" class="form-control">
      </div>
      <div class="form-group">
        <label for="content">Content:</label>
        <textarea id="content" name="content" class="form-control"></textarea>
      </div>
      <div class="form-group">
        <label for="image">Image:</label>
        <input type="file" id="image" name="image" class="form-control-file">
      </div>
      <div class="form-group">
        <input type="submit" name="submit" value="Submit" class="btn btn-primary">
      </div>
    </form>
  </div>
  <div class="container">
    <?php
    // Fetch blog posts from the database
    $result = $db->query("SELECT * FROM posts ORDER BY id DESC");

    while ($row = $result->fetch_assoc()) {
      echo <<<FT
            <div class="card">
      <div class="card__header">
        <img class="card__image"  src="{$row['image']}" alt="{$row['title']}" width="600">
      </div>
      <div class="card__body">
        <span class="tag tag-red">Automobile</span>
        <h4>{$row['title']}</h4>
        <p>{$row['content']}</p>
      </div>
      <div class="card__footer">
        <div class="user">
          <img src="https://i.pravatar.cc/40?img=3" alt="user__image" class="user__image">
          <div class="user__info">
            <h5>Farhan</h5>
            <small>2d ago</small>
          </div>
        </div>
      </div>
    </div>
FT;
    }
    ?>
  </div>
</body>

</html>