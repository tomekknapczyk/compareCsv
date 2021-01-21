<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/Comparator.php';
require_once __DIR__ . '/Downloader.php';

$loader = new \Twig\Loader\FilesystemLoader('/');
$twig = new \Twig\Environment($loader, [
    'cache' => false,
]);

if (isset($_POST['refresh']) && $_POST['refresh'] == 1) {
    $download = new Downloader('http://sklep.tuning-tec.pl/_integracje/_export/_items_val.php', 'file1.csv', 'file2.csv');
}

$comparator = new Comparator('file1.csv', 'file2.csv');

echo $twig->render('results.html.twig', [
    'new_items' => $comparator->new_items,
    'old_items' => $comparator->old_items,
    'added_items' => $comparator->getNewProducts(),
    'missed_items' => $comparator->getMissedProducts(),
    'differences' => $comparator->getDifferences(),
    'file1' => $comparator->file1,
    'file2' => $comparator->file2,
]);
