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
    <?php
        $id = $_GET['catid'];
        $sql = "SELECT * FROM `category` WHERE category_id = $id";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $catname = $row['category_name'];
            $catdesc = $row['category_description'];
        }
    ?>

    <?php
        $method = $_SERVER['REQUEST_METHOD'];
        $showalert = false;

        if ($method == 'POST') {
            // INSERT thread INTO DATABASE
            $th_title = $_POST['title'];
            $th_desc = $_POST['description'];

            //for xss attack prevention
            $th_title = str_replace("<", "&lt;", $th_title);
            $th_title = str_replace(">", "&gt;", $th_title);

            $th_desc = str_replace("<", "&lt;", $th_desc);
            $th_desc = str_replace(">", "&gt;", $th_desc);

            $name_user_commentedby = $_SESSION['username'];
            $sql2 = "SELECT sno FROM `users` WHERE user_name = '$name_user_commentedby'";
            $result2 = mysqli_query($conn, $sql2);
            $row2= mysqli_fetch_assoc($result2);
            $th_user_id = $row2['sno'];

            $sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$id', '$th_user_id', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            $showalert = true;

            if ($showalert) {
                # code...
                echo '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> Your thread has been added. Please wait for the community to respond.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                ';
            }
        }
    ?>

    <!-- category container  -->
    <div class="container my-3">
        <div class="p-5 mb-4 bg-primary-subtle rounded-3">
            <div class="container-fluid py-5">
                <h1 class="display-5 fw-bold">Welcome to <?php echo $catname; ?> forum</h1>
                <p class="col-md-8 fs-4">
                    <?php echo $catdesc; ?>
                </p>
                <a href="/forum/about.php" class="btn btn-success btn-lg">
                About iDiscuss
                </a>                   
            </div>

            <hr class="my-4">
            <p>
            <h5>Forum Rules</h5>
            <ul>
                <li>Be civil. Don’t post anything that a reasonable person would consider offensive, abusive, or hate
                    speech.</li>
                <li> Keep it clean. Don’t post anything obscene or sexually explicit.
                </li>
                <li> Respect each other. Don’t harass or grief anyone, impersonate people, or expose their private
                    information.
                </li>
                <li> Respect our forum. Don’t post spam or otherwise vandalize the forum.
                </li>
            </ul>
            </p>

        </div>
    </div>

    <!-- start discussion container  -->
    <?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        $id = $_GET['catid'];
        echo '
        <div class="container">
            <h2>Start a Discussion</h2>
            <!-- form is here  -->
            <form class="my-4" action="/forum/threadlist.php?catid='.$id.'" method="post">
            <!-- action="$_SERVER["REQUEST_URI"] WILL GIVE SAME RESULT" -->

        <div class="col-md-8 mb-3">
            <label for="exampleInputEmail1" class="form-label">Problem title </label>
            <input type="text" class="form-control" name="title" id="title" aria-describedby="emailHelp">
            <div id="title" class="form-text">Keep title as small as possible.</div>
        </div>

        <div class=" col-md-8 form-floating my-3">
            <textarea class="form-control" name="description" placeholder="Comment here..." id="desc"
                style="height: 100px"></textarea>
            <label for="floatingTextarea2">Elaborate your concern</label>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        </div>
    ';
    }
    else {
    echo '
        <div class="container">
            <h2>Start a Discussion</h2>
            <div class="alert alert-danger" role="alert">
                <h5>You need to login to join a conversation.</h5>
            </div>
        </div>
    ';
    }

    ?>

    <!-- display discussion -->
    <div class="container mb-5">
        <h1 class="py-2">Browse Questions</h1>
        <!-- Loop for questions here  -->
        <?php
            // $id = $_GET['catid'];
            $sql = "SELECT * FROM `threads` WHERE thread_cat_id = $id";
            $result = mysqli_query($conn, $sql);
            $noResult = true;

            while ($row = mysqli_fetch_assoc($result)) {
                $noResult = false;

                $thread_title = $row['thread_title'];
                $thread_desc = $row['thread_desc'];
                $thread_id = $row['thread_id'];
                $thread_user_id = $row['thread_user_id'];
                $thread_time = $row['timestamp'];

                $sql2 = "SELECT user_name FROM users WHERE sno = '$thread_user_id'";
                $result2 = mysqli_query($conn, $sql2);
                $row2= mysqli_fetch_assoc($result2);

                echo '
                    <div class="d-flex my-4">
                        <div class="flex-shrink-0">
                            <img src="images/userDefault.png" class="mr-3" alt="User Image" width="37px">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5><a class="text-dark" href="thread.php?threadid='. $thread_id .'">'. $thread_title .'</a></h5>
                            '. $thread_desc .'
                            <p class="font-weight-bold my-0"><strong>ASKED BY - '. $row2['user_name'] .'</strong> at <small class="text-muted"><em>'. $thread_time .'</em></small></p>
                        </div>
                    </div>';
            }

            // displays message only if forum threads is empty 
            if ($noResult) {
                # code...
                echo '
                <div class="my-4">
                    <div class="h-100 p-5 bg-body-tertiary border rounded-3">
                    <h2>No threads found.</h2>
                    <p>Be the first person to ask a question.</p>
                    </div>
                </div>
              ';
            }
        ?>
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