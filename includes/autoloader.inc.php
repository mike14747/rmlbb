<?php

spl_autoload_register(function ($class) {
    include 'models/' . $class . '.class.php';
});
