<?php
session_start();
session_destroy();
header("Location: jabonescarlatti.php");
exit;
?>