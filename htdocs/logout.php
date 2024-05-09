<?php

session_start();
$_SESSION['loggedin'] = null;


header("Location: index.html");
exit;
?>