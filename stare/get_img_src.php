<?php
$host = 'https://www.baza-firm.com.pl';
$url = 'https://www.baza-firm.com.pl/szkolenia-kursy/wroclaw/dolnoslaski-zaklad-doskonalenia-zawodowego/pl/79574.html'; // Podaj właściwy adres strony

$dom = new DOMDocument();
@$dom->loadHTMLFile($url); // Załadowanie zawartości strony

$images = $dom->getElementsByTagName('img'); // Pobranie wszystkich obrazków
$imgList = array();
foreach ($images as $image) {
    $src = $image->getAttribute('src'); // Pobranie atrybutu src
    if (strpos($src, 'includes/adem.php') !== false) {
        $imgList[] = $host . $src;
    }
}