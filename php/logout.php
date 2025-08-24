<?php // cierre de la sesión y redirección a login.php
session_start();
session_destroy();
header("Location: login.php");
exit();
