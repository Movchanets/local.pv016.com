<?php
include($_SERVER['DOCUMENT_ROOT'] . '/options/connection_database.php');
$id = $_GET['id'];
$name = '';
$price = '';
$description = '';
$sql = 'SELECT p.id, p.name, p.price, p.description 
        from tbl_products p
        where p.id=:id;';

$sth = $dbh->prepare($sql);
$sth->execute([':id' => $id]);
if ($row = $sth->fetch()) {
    $name = $row['name'];
    $price = $row['price'];
    $description = $row['description'];
}
$sql = "SELECT pi.name, pi.priority 
        FROM tbl_products_images pi
        WHERE pi.product_id=:id
        ORDER BY pi.priority;";
$sth = $dbh->prepare($sql);
$sth->execute([':id' => $id]);
$images = $sth->fetchAll();
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
    <h1 class="text-center">Змініти продукт</h1>
    <form method="post" enctype="multipart/form-data" class="col-md-6 offset-md-3">
        <div class="mb-3">
            <label for="name" class="form-label">Назва</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo  $name ?>">
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Ціна</label>
            <input type="text" class="form-control" id="price" value="<?php echo  $price ?>" name="price">
        </div>
        <ul id="sortlist">
            <?php
            foreach ($images as $image)
            {
                echo '<li>
<label  >
<img src="images/'.$image["name"].'" class="img">
<input type="file" class="form-control" id="$image" name="pictures[]"  value='.$image["name"].' style="display: none;">
</label>
</li>' ;
            }
            ?>
            <li>
                <label >
                <img id = 'img1' alt='add' src="https://placehold.jp/3d4070/ffffff/500x500.png?text=Placeholder" class="img">
                <input type="file" class="form-control" id="native" name="pictures[]" style="display: none;">
                </label>
            </li>

        </ul>

        <div class="mb-3">
            <label for="description" class="form-label">Опис</label>
            <input type="text" class="form-control" id="description"  value="<?php echo  $description ?>"name="description">
        </div>

        <button type="submit" class="btn btn-primary"> Додати</button>
    </form>
</div>
</body>
<script src="js/bootstrap.bundle.min.js"></script>
<script>
    let list = document.getElementById("sortlist")
    window.addEventListener("DOMContentLoaded", () => {
        slist(list);
    });
    let tmp = document.getElementById('native');
    let counter = 1;

    function CreateNewIMG(e) {

        console.log(e.target.value);
        if (e.target.value != "") {

            let li = document.createElement('li');
            let label = document.createElement('label')
            let img = document.createElement('img');
            img.src = "https://placehold.jp/3d4070/ffffff/500x500.png?text=Placeholder";
            img.id  = 'img' + ++counter;
            let newInput = document.createElement('input');
            newInput.type = 'file';
            newInput.name = 'pictures[]';
            newInput.className = 'form-control'
            newInput.style = "display: none;";
            label.appendChild(img);
            label.appendChild(newInput);
            li.appendChild(label);
            let child = list.appendChild(li);
            child.onchange = (e) => {
                CreateNewIMG(e);
                document.getElementById('img'+ counter).src = window.URL.createObjectURL(e.target.files[0])
            };
            e.target.onchange = null;

            slist(list)
        }

    }

    tmp.onchange =  (e) => {
        CreateNewIMG(e);
        document.getElementById('img'+ 1).src = window.URL.createObjectURL(e.target.files[0])
    };;
</script>