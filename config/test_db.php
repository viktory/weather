<?php
$db = require(__DIR__ . '/db.php');
$db['dsn'] = 'mysql:host=localhost;dbname=weather_tests';

return $db;
