<?php
// Tworzenie obiektu DOMDocument
$dom = new DOMDocument();

// Pobieranie zawartości strony internetowej
$htmlContent = file_get_contents('https://www.bazafirm.net/index.php?cnt=company.search&searchkey=&district_id=-1&cpg=1'); // Podmień to na właściwy adres URL

// Ładowanie zawartości HTML do obiektu DOMDocument
$dom->loadHTML($htmlContent);

// Znalezienie wszystkich linków w elemencie <a>
$linkElements = $dom->getElementsByTagName('a');

// Przechodzenie przez znalezione linki i zapisywanie tych zawierających "index.php?cnt" do tablicy
$linksToSave = array();
foreach ($linkElements as $linkElement) {
    $href = $linkElement->getAttribute('href');
    if (strpos($href, 'index.php?cnt') !== false) {
        $linksToSave[] = $href;
    }
}

// Zapisywanie linków do pliku CSV
$csvFileName = 'links.csv';
$csvFile = fopen($csvFileName, 'w');
foreach ($linksToSave as $link) {
    fputcsv($csvFile, array($link));
}
fclose($csvFile);

echo "Linki zostały zapisane do pliku $csvFileName.";
?>
