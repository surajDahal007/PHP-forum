<?php
  session_start();

    echo '<nav class="navbar navbar-expand-lg bg-dark bg-body-tertiary" data-bs-theme="dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="/forum">iDiscuss</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/forum">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="about.php">About</a>
          </li>
          
          <li class="nav-item">
            <a href="contact.php" class="nav-link">Contact</a>
          </li>
        </ul>';

        if (isset($_SESSION['loggedin']) && isset($_SESSION['loggedin']) ) {
          echo '
          <form class="d-flex" role="search" method="get" action="/search.php">           
            <input class="form-control me-2" name="query" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-success" "type="submit">Search</button>
            <p class="text-light my-2 mx-3">'. $_SESSION['username'] .'</p>
            <a href="partials/_logout.php" class="btn btn-outline-primary">Logout</a>
          </form>
          ';
          
// /forum/partials
        }else {
          echo '
          <form class="d-flex" role="search" method="get" action="/search.php">
            <input class="form-control me-2" name="query" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-success" type="submit">Search</button>
          </form>
          <div class="mx-2">
              <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
              <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#signupModal">SignUp</button>
          </div>
          ';
        }
        echo'
      </div>
    </div>
  </nav>';

  include 'partials/_loginModal.php';
  include 'partials/_signupModal.php';

  if (isset($_GET['signupsuccess'])) {
    echo '
      <div class="alert alert-success alert-dismissible fade show my-0" role="alert">
        <strong>Congratulations!</strong> You have signed up in iDiscuss. You can now Login.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    ';
  }

  if (isset($_GET['signupfailure'])) {
    $err = $_GET['error'];
    echo '
    <div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
      <strong>Error! </strong>'. $err .'
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    ';
  }

  if (isset($_GET['loginSuccess'])) {
    echo '
    <div class="alert alert-success alert-dismissible fade show my-0" role="alert">
      <strong>Welcome! </strong> LoggedIn Successfully.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    ';
  }

  if (isset($_GET['loginFailure'])) {
    echo '
    <div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
      <strong>Oops! </strong> Password didn\'t match.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    ';
  }

  if (isset($_GET['error'])) {
    $err = $_GET['error'];
    echo '
    <div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
      <strong>Error! </strong>'. $err .'
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    ';
  }

?>
