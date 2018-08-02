<?php

require './vendor/autoload.php';

$db = new App\DB();

$db->prepare();
//$db->show();

echo '================================================' . "\n";

// Массив класса точек
$nodes = $db->getNodes();

$tree = new \App\Tree();
$tree->growAll($nodes);
$tree->show();

$db->clear();
