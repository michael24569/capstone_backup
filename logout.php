<?php
session_start();
session_unset();
session_destroy();
// Developers: Backend Developer: Michael Enoza, Frontend Developer: Kyle Ambat
header("Location: index.php");
exit();
?>
