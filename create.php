<?php
try {
    function randomString($len){
        $str = "12345567890!@#$%^&*()_+abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTVUWXYZ";
        $rand = "";
        for ($i = 0; $i < $len; $i++) {
            $index = rand(0, strlen($str) - 1);
            $rand .= $str[$index];
        }
        return $rand;
    }
    $pdo = new PDO('mysql:host=localhost;port=3306;dbname=product_crud', 'root', '');
    // if there was an error establishing connection 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (!is_dir('images')) {
        mkdir('images');
    }
    $errors = [];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        ['title' => $title, 'description' => $description, 'price' => $price] = $_POST;
        $date = date('Y-m-d H:i:s');
        $image = $_FILES['image'] ?? null;
        $imagePath = '';
        if($image && $image['tmp_name']) {
            $imagePath = './images/'.randomString(8).'/'.$image['name'];
            mkdir(dirname($imagePath));
            move_uploaded_file($image['tmp_name'], $imagePath);
        }
        if (!$title)
            $errors[] = 'Product title is required';
        if (!$price)
            $errors[] = 'Product price is required';

        if (empty($errors)) {
            $statement = $pdo->prepare('INSERT INTO products (title, description, image, price, create_date) VALUES (:title, :description, :image, :price, :date)');
            $statement->bindParam(':title', $title);
            $statement->bindParam(':description', $description
        );
            $statement->bindParam(':image', $imagePath);
            $statement->bindParam(':price', $price);
            $statement->bindParam(':date', $date);
            $statement->execute();
            header('Location:./index.php');
        }
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
<!doctype html>
<html lang = 'eng' >
    <head>
    <!-- Required meta tags -->
    <meta charset = 'utf-8'>
    <meta name = 'viewport' content = 'width=device-width, initial-scale=1'>

    <!-- Bootstrap CSS -->
    <link rel = 'stylesheet' href = 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css' integrity = 'sha384-nU14brUcp6StFntEOOEBvcJm4huWjB0OcIeQ3fltAfSmuZFrkAif0T+UtNGlKKQv' crossorigin = 'anonymous'>
    <link rel = 'stylesheet' href = 'app.css'>
    <title> PhP Prdocut Crud Application </title>
    </head>
    <body>
        <h1> Add Product Details</h1>
        <?php if(!empty($errors)): ?>
            <div class="alert alert-danger">    
                <?php foreach ($errors as $error): ?>
                    <div><?php echo $error; ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
            <form action = "./create.php" method = "post" enctype="multipart/form-data">
                <div class = 'mb-3'>
                    <label class = 'form-label'> Product Image</label>
                    <input type = 'file' class = 'form-control' name = 'image'>
                </div>
                <div class = 'mb-3'>
                    <label class = 'form-label'> Product Title</label>
                    <input type = 'text' class = 'form-control' name = 'title' value = "<?php if(isset($title)) echo $title?>">
                </div>
                <div class = 'mb-3'>
                    <label class = 'form-label'> Product Description</label>
                    <textarea class = 'form-control' name = 'description'> </textarea>
                </div>
                <div class = 'mb-3'>
                    <label class = 'form-label'> Product Price</label>
                    <input type = 'number' step ='.01' class ='form-control' name = 'price' value = "<?php if (isset($title))
                        echo $price ?>">
                    </div>
                    <button type = "submit" class = 'btn btn-success'> Add Product</button>
                </form>
        </body>
    </html>