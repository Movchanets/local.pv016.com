<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    include($_SERVER['DOCUMENT_ROOT'] . '/lib/guidv4.php');

    $dir_save = "images/";


    $isOK = true;
    $bigImageString = "";


    foreach ($_FILES["pictures"]["error"] as $key => $error) {
        if ($error == UPLOAD_ERR_OK) {
            $tmp_name = $_FILES["pictures"]["tmp_name"][$key];
            $image_name = guidv4() . '.jpeg';
            $uploadfile = $dir_save . $image_name;
            $bigImageString .= $uploadfile . ';';
            // basename() may prevent filesystem traversal attacks;
            // further validation/sanitation of the filename may be appropriate
            $name = basename($_FILES["pictures"]["name"][$key]);
            move_uploaded_file($tmp_name, $uploadfile);
        }
    }
    print_r($bigImageString);
    if ($isOK) {
        include($_SERVER['DOCUMENT_ROOT'] . '/options/connection_database.php');
        $sql = "INSERT INTO `tbl_products` (`name`, `image`, `price`, `datecrate`, `description`) VALUES (:name, :image, :price, NOW(), :description);";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image', $image_name);
        // $stmt->execute();
        // header("Location: /");
        exit();
    } else {
        echo "Error save file";
        exit();
    }

}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Головна сторінка</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/_header.php'); ?>

<div class="container">
    <h1 class="text-center">Додати продукт</h1>
    <form method="post" enctype="multipart/form-data" class="col-md-6 offset-md-3">
        <div class="mb-3">
            <label for="name" class="form-label">Назва</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Ціна</label>
            <input type="text" class="form-control" id="price" name="price">
        </div>
        <div class="mb-3" id="images">
            <label for="pictures[]" class="form-label col-12">Фото</label>
            <input type="file" class="col-12" name="pictures[]"/>
        </div>
        <div class="mb-3 ">
            <label for="description" class="form-label ">Опис</label>

            <input type="text" class="form-control " id="description" name="description">
        </div>

        <button type="submit" class="btn btn-primary"> Додати</button>
    </form>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
<script>
    var ImgDiv = document.getElementById('images');

    var input = ImgDiv.children.item(1);

    function CreateNewInput() {
        let newInput = document.createElement('input');
        newInput.type = 'file';
        newInput.name = 'pictures[]';
        newInput.className = 'col-12'
        let child = ImgDiv.appendChild(newInput);
        child.onchange = CreateNewInput;

    }

    input.onchange = CreateNewInput;
</script>
</body>
</html>