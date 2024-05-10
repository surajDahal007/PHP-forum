<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iDiscuss - Coding Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php include 'partials/_header.php'; ?>
    <?php include 'partials/_dbconnect.php'; ?>

    <!-- slider here  -->
    <div id="carouselExampleIndicators" class="carousel slide">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="images/img1.jpg" height="500" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="images/img2.jpg" height="500" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="images/img3.jpg" height="500" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- category container  -->
    <div class="container my-3">
        <h2 class="text-center">iDiscuss - Browse Categories</h2>
        <div class="row">

            <!-- fetch categories from database  -->
            <?php
                $sql = 'SELECT * FROM `category`';
                $result = mysqli_query($conn, $sql);
                
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['category_id'];

                    echo ' <div class="col-md-4 my-2">
                                <div class="card" style="width: 18rem;">
                                    <img src="images/'. $id .'.jpeg" class="card-img-top" height="180" alt="image for this category">
                                    <div class="card-body">
                                        <h5 class="card-title"><a href="threadlist.php?catid='.$id.'">'. $row['category_name'] .'</a></h5>
                                        <p class="card-text">'. substr($row['category_description'],0,100) .'...</p>
                                        <a href="threadlist.php?catid='.$id.'" class="btn btn-primary">View Thread</a>
                                    </div>
                                </div>
                            </div>';  
                }
            ?>

        </div>
    </div>

    <?php include 'partials/_footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
</body>

</html>