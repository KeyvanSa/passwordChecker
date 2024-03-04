<?php

    $url = preg_replace('/\/*$/','',$_SERVER['REQUEST_URI']);

    $path = "../app/api/";

    require_once $path . 'functions.php';
    require_once $path . 'database.php';
    require_once '../app/Core.php';
    $core = new Core();