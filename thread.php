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
        $threadid = $_GET['threadid'];

        //user_id 
        $name_user_commentedby = $_SESSION['username'];
        $sql2 = "SELECT sno FROM `users` WHERE user_name = '$name_user_commentedby'";
        $result2 = mysqli_query($conn, $sql2);
        $row2= mysqli_fetch_assoc($result2);
        $sno = $row2['sno'];

        $sql = "SELECT * FROM `threads` WHERE thread_id = '$threadid'";
        $result = mysqli_query($conn, $sql);
        
        while ($row = mysqli_fetch_assoc($result)) {
            $thread_title = $row['thread_title'];
            $thread_desc = $row['thread_desc'];
            $user_id = $row['thread_user_id'];

            $sql2 = "SELECT user_name FROM users WHERE sno = '$user_id'";
            $result2 = mysqli_query($conn, $sql2);
            $row2= mysqli_fetch_assoc($result2);
            $user = $row2['user_name'];

        }
    ?>

    <?php
        $method = $_SERVER['REQUEST_METHOD'];
        $showalert = false;

        if ($method == 'POST') {
            // INSERT commebt INTO db
            $threadid = $_GET['threadid'];
            $comment = $_POST['comment'];
          
            
            // $sql2 = "SELECT sno FROM `users` WHERE user_name = '$name_user_commentedby'";
            // $result2 = mysqli_query($conn, $sql2);
            // $row2= mysqli_fetch_assoc($result2);
            // $sno = $row2['sno'];
        

            $sql = "INSERT INTO `comments` (`comment_content`, `comment_by`, `thread_id`, `comment_time`) VALUES ('$comment', '$sno', '$threadid', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            $showalert = true;

            if ($showalert) {
                echo '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> Your Comment has been added.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                ';

                // header("Location: /forum/thread.php?threadid=$threadid");
            }
        }
    ?>


    <!-- category container  -->
    <div class="container my-3">
        <div class="p-5 mb-4 bg-primary-subtle rounded-3">
            <div class="container-fluid py-5">
                <h1 class="display-5 fw-bold"> <?php echo $thread_title; ?></h1>
                <p class="col-md-8 fs-4">
                <h3>Description</h3>
                <?php echo $thread_desc; ?>
                </p>
                <p>Posted by :- <span class="fw-bold"><?php echo $user; ?></span></p>
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

    <?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        echo '
        <div class="container">
            <h2>Post a Comment</h2>
            <!-- form is here  -->.
                <form action="/forum/thread.php?threadid='.$threadid.'" method="post">
                    <div class=" col-md-8 form-floating my-3">
                        <textarea class="form-control" name="comment" placeholder="Comment here..." id="desc"
                            style="height: 100px"></textarea>
                        <label for="floatingTextarea2">Comment</label>
                    </div>
                    <button type="submit" class="btn btn-success">Post Comment</button>
                </form>
        </div>
        ';
    }
    
    else {
        echo '
        <div class="container">
        <h2>Post a Comment</h2>
            <div class="alert alert-danger" role="alert">
                <h5>You need to login to post a comment.</h5>
            </div>
        </div>
        ';
    }
    ?>

    <div class="container">
        <h1 class="py-2">Discussions</h1>

        <?php
            $threadid = $_GET['threadid']; 
            $sql = "SELECT * FROM `comments` WHERE thread_id = $threadid";
            $result = mysqli_query($conn, $sql);
            $noResult = true;
            while ($row = mysqli_fetch_assoc($result)) {
                $noResult = false;
                $userid = $row['comment_by'];
                $content = $row['comment_content'];
                $comment_time = $row['comment_time'];

                $sql2 = "SELECT user_name from `users` where sno = '$userid'";
                $result2 = mysqli_query($conn,$sql2);
                $row2 = mysqli_fetch_assoc($result2);


            echo '
            <div class="d-flex my-3">
                <div class="flex-shrink-0">
                    <img src="images/userDefault.png" class="mr-3" alt="User Image" width="37px">
                </div>
                <div class="flex-grow-1 ms-3">
                <p class="my-0"><b>'. $row2['user_name'] .'</b> <small class="text-muted"> at '. $comment_time .'</small> </p>
                    '. $content .'
                </div>
            </div>';
        }

        if ($noResult) {
            # code...
            echo '
            <div class="my-4">
                <div class="h-100 p-5 bg-body-tertiary border rounded-3">
                <h2>No threads found.</h2>
                <p>Be the first person to answer.</p>
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