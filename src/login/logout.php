<?php

session_start();
session_destroy();

header("Location: /v1/login");


?>
