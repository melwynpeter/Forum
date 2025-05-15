<?php
session_start();
echo "logging out, please wait... <br>"; 
session_unset();
session_destroy();
header("Location: /forum");

?>