<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];

    $price = $_POST['price'];
    $description = $_POST['description'];

    include($_SERVER['DOCUMENT_ROOT'] . '/lib/guidv4.php');

    include($_SERVER['DOCUMENT_ROOT'] . '/options/connection_database.php');
    $sql = "INSERT INTO `tbl_products` (`name`, `price`, `datecrate`, `description`) VALUES (:name,  :price, NOW(), :description);";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':description', $description);
    $stmt->execute();
    $last_id = $dbh->lastInsertId();
    $isOK = true;
    $bigImageString = "";


    $counter = 1;
    foreach ($_FILES["pictures"]["error"] as $key => $error) {
        if ($error == UPLOAD_ERR_OK) {
            $tmp_name = $_FILES["pictures"]["tmp_name"][$key];
            $image_name =
               guidv4() . '.jpeg';
            $name = basename($_FILES["pictures"]["name"][$key]);

            // basename() may prevent filesystem traversal attacks;
            // further validation/sanitation of the filename may be appropriate
            $sqlImg = 'INSERT INTO `tbl_products_images`
            (`name`, `priority`, `product_id`)
            VALUES (:image,  :priority, :id);';
            $prep = $dbh->prepare($sqlImg);
            $prep->bindParam(':image',$image_name );
            $prep->bindParam(':id',$last_id );
            $prep->bindParam(':priority',$counter );



            move_uploaded_file($tmp_name,  'images/'.$image_name);
            $prep->execute();
            $counter++;
        }
    }




     header("Location: /");
    exit();
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
    <link rel="stylesheet" href="sort-list.css"/>
    <script>
        function slist(target) {
            // (A) SET CSS + GET ALL LIST ITEMS
            target.classList.add("slist");
            let items = target.getElementsByTagName("li"), current = null;

            // (B) MAKE ITEMS DRAGGABLE + SORTABLE
            let j = 1;
            for (let i of items) {
                // (B1) ATTACH DRAGGABLE
                i.draggable = true;
                i.lastChild.id = j++;
                // (B2) DRAG START - YELLOW HIGHLIGHT DROPZONES
                i.ondragstart = (ev) => {
                    current = i;
                    for (let it of items) {
                        if (it != current) {
                            it.classList.add("hint");
                        }
                    }
                };

                // (B3) DRAG ENTER - RED HIGHLIGHT DROPZONE
                i.ondragenter = (ev) => {
                    if (i != current) {
                        i.classList.add("active");
                    }
                };

                // (B4) DRAG LEAVE - REMOVE RED HIGHLIGHT
                i.ondragleave = () => {
                    i.classList.remove("active");
                };

                // (B5) DRAG END - REMOVE ALL HIGHLIGHTS
                i.ondragend = () => {
                    for (let it of items) {
                        it.classList.remove("hint");
                        it.classList.remove("active");
                    }
                };

                // (B6) DRAG OVER - PREVENT THE DEFAULT "DROP", SO WE CAN DO OUR OWN
                i.ondragover = (evt) => {
                    evt.preventDefault();
                };

                // (B7) ON DROP - DO SOMETHING
                i.ondrop = (evt) => {
                    evt.preventDefault();
                    if (i != current) {
                        let currentpos = 0, droppedpos = 0;
                        for (let it = 0; it < items.length; it++) {
                            if (current == items[it]) {
                                currentpos = it;
                            }
                            if (i == items[it]) {
                                droppedpos = it;
                            }
                        }
                        if (currentpos < droppedpos) {
                            i.parentNode.insertBefore(current, i.nextSibling);
                        } else {
                            i.parentNode.insertBefore(current, i);
                        }
                    }
                };
            }
        }
    </script>
    <style>
        /* (A) LIST STYLES */
        .slist {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .slist li {
            margin: 10px;
            padding: 15px;
            border: 1px solid #dfdfdf;
            background: #f5f5f5;
        }

        /* (B) DRAG-AND-DROP HINT */
        .slist li.hint {
            border: 1px solid #ffc49a;
            background: #feffb4;
        }

        .slist li.active {
            border: 1px solid #ffa5a5;
            background: #ffe7e7;
        }
    </style>
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
        <ul id="sortlist">
            <li><input type="file" class="form-control" id="native" name="pictures[]"></li>

        </ul>

        <div class="mb-3">
            <label for="description" class="form-label">Опис</label>
            <input type="text" class="form-control" id="description" name="description">
        </div>

        <button type="submit" class="btn btn-primary"> Додати</button>
    </form>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
<script>
    let list = document.getElementById("sortlist")
    window.addEventListener("DOMContentLoaded", () => {
        slist(list);
    });
    let tmp = document.getElementById('native');

    function CreateNewIMG(e) {
        console.log(e.target.value);
        if (e.target.value != "") {
            let li = document.createElement('li');
            let newInput = document.createElement('input');
            newInput.type = 'file';
            newInput.name = 'pictures[]';
            newInput.className = 'form-control'
            // li.draggable = true;
            li.appendChild(newInput);
            let child = list.appendChild(li);
            child.onchange = CreateNewIMG;
            e.target.onchange = null;

            slist(list)
        }

    }

    tmp.onchange = CreateNewIMG;
</script>
</body>
</html>