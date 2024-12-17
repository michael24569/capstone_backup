<?php
session_start();
unset($_SESSION['access_question']);
header("Location: index.php"); // Redirect to index or wherever you want
exit();
?>
<!-- Developers: Backend Developer: Michael Enoza, Frontend Developer: Kyle Ambat -->