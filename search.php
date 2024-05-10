<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iDiscuss - Coding Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
    .container {
        min-height: 100vh;
    }
    </style>

</head>

<body>
    <?php include 'partials/_header.php'; ?>
    <?php include 'partials/_dbconnect.php'; ?>

    <!-- search results starts here -->
    <div class="container my-3">
        <h1>Search Result for <em> "<?php echo $_GET['query']?>"</em></h1>
        <?php
            $noresult = true;
            $QUERY = $_GET['query'];
            $sql = "SELECT * FROM `threads` WHERE MATCH (thread_title,thread_desc) against ('$QUERY')";
            $result = mysqli_query($conn, $sql);
        
            while ($row = mysqli_fetch_assoc($result)) {
                $noresult = false;
                $thread_title = $row['thread_title'];
                $thread_desc = $row['thread_desc'];
                $thread_id = $row['thread_id'];

                // display search result
                echo '
                <div class="result">
                    <h3><a href="/forum/thread.php?threadid='.$thread_id.'" class="text-dark">'. $thread_title .'</a></h3>
                    <p>'. $thread_desc .'</p>
                </div>
                ';
            }

            if ($noresult) {
                echo '
                <div class="h-100 p-5 bg-body-tertiary border rounded-3 my-3">
                    <h2>No results found.</h2>
                    <p>
                        Suggestions:
                        <ul>
                            <li>Make sure that all words are spelled correctly.</li>
                            <li>Try different keywords.</li>
                            <li>Try more general keywords.</li>
                        </ul>
                    </p>
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