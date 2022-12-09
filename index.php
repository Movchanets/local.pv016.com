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
<?php

try {
    $user = "root";
    $pass = "";
    $dbh = new PDO('mysql:host=localhost;dbname=pv016', $user, $pass);

} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}


?>



<?php include "_header.php" ?>

<div class="container">
    <h1 class="text-center">Список продуктів</h1>
    <section style="background-color: #eee;">
        <div class="container py-5">
              <div class="row justify-content-center">
                <?php foreach ($dbh->query('SELECT * FROM tbl_products') as $row) : ?>


                    <div class="col-md-8 col-lg-6 p-2 col-xl-4">
                        <div class="card" style="border-radius: 15px;">
                            <div class="bg-image hover-overlay ripple ripple-surface ripple-surface-light"
                                 data-mdb-ripple-color="light">
                                <img src="<?php echo $row['image']; ?>"
                                     style="border-top-left-radius: 15px; border-top-right-radius: 15px;"
                                     class="img-fluid"
                                     alt="<?php echo $row['name']; ?>"/>
                                <a href="#!">
                                    <div class="mask"></div>
                                </a>
                            </div>
                            <hr class="my-0"/>
                            <div class="card-body pb-0">

                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p><a href="#!" class="text-dark"><?php echo $row['name']; ?></a></p>

                                    </div>
                                    <div>
                                        <div class="d-flex justify-content-between">
                                            <p><a href="#!" class="text-dark">$<?php echo $row['price']; ?></a></p>

                                        </div>
                                        <div class="d-flex justify-content-between align-items-center pb-2 mb-1">

                                            <button type="button" id ='delete' onclick="Delete(<?php echo $row['id']; ?>);" class="btn btn-danger">Delete</button>
                                            <button type="button" class="btn btn-primary">Buy now</button>
                                        </div>
                                    </div>
                                </div>


                            </div>

                        </div>

                    </div>
                <?php endforeach;
                $dbh = null; ?>

            </div>
    </section>

</div>


<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/axios.min.js"></script>
<script src="js/index.js"></script>

</body>
</html>