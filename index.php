
<?php
try {
  $pdo = new PDO('mysql:host=localhost;port=3306;dbname=product_crud', 'root', '');
  // if there was an error establishing connection 
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $query = $pdo->prepare('SELECT * FROM products ORDER BY title ');
  $query->execute();
  $products = $query->fetchAll(PDO::FETCH_ASSOC);
  // echo '<pre>';
  // var_dump($products);
  // echo '</pre>';
} catch (PDOException $e) {
  echo $e->getMessage();
}
?>
<!doctype html>
<html lang="eng" >
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" integrity="sha384-nU14brUcp6StFntEOOEBvcJm4huWjB0OcIeQ3fltAfSmuZFrkAif0T+UtNGlKKQv" crossorigin="anonymous">
    <link rel="stylesheet" href="app.css">
    <title> PhP Prdocut Crud Application </title>
  </head>
  <body>
    <h1> Product Details</h1>
    <a href = "./create.php" class="btn btn-success"> Add Product</a>
    <table class="table">
  <thead>
    <tr>
      <th scope = "col" > # </th> 
      <th scope="col">Image</th>
      <th scope="col">Title</th>
      <th scope="col">Description</th>
      <th scope="col">Price</th>
      <th scope="col">Create Date</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    
    <?php foreach ($products as $i => $product): ?>
                      <tr>
                    <th scope="row"> <?php echo $i + 1; ?> </th>
                    <td><img src="<?php echo $product["image"]; ?>" alt = "image" width=80px height= 80px /></td>
                    <td> <?php echo $product["title"]; ?></td>
                    <td><?php echo $product["description"]; ?></td>
                    <td><?php echo $product["price"]; ?></td>
                    <td><?php echo $product["create_date"]; ?></td>
                    <td>
                      <button type="button" class="btn btn-sm btn-outline-success">Edit</button>
                      <button type="button" class="btn btn-sm btn-outline-danger">Danger</button>
                   </td>
                  </tr>
    
    <?php endforeach; ?>
    
  </tbody>
</table>
  </body>
</html> 