<?php
    session_start();
    echo 'loggin you out. Please Wait...';

    session_destroy();
    header("Location: /forum");
?>