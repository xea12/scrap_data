<?php

use voku\helper\HtmlDomParser;
use thiagoalessio\TesseractOCR\TesseractOCR;
require_once 'vendor/autoload.php';
$host = 'https://www.baza-firm.com.pl/';
// HTML do analizy
$htmlContent = '<div id="emlAddrBox">
    <div class="displayInlineBlock txtLeft">
        <span class="fontSize14 grayColor mainLabFnt displayBlock clearBoth  marginBottom3 txtLeft">email:</span><img src="/includes/adem.php?usr=a29udGFrdA==&amp;dmn=emFwcm9ncmFtb3dhbmkuY29t&amp;mobEml=0" alt="główny adres kontaktowy e-mail do firmy" class="emlImg" width="4" height="3" style="/* width:100%; height:100%; */"></div>
</div>';

// Utwórz parser HTML
$dom = HtmlDomParser::str_get_html($htmlContent);

// Znajdź element <div> o odpowiednim ID
$divId = 'emlAddrBox';
$targetDiv = $dom->getElementById($divId);

if ($targetDiv) {
    // Znajdź element <img> wewnątrz znalezionego <div>
    $imgElement = $targetDiv->find('img', 0);

    if ($imgElement) {
        // Pobierz atrybut 'src' obrazka
        $imgSrc = $imgElement->getAttribute('src');

        // Wyświetl adres obrazka
        $img = $host . $imgSrc;
        echo $img;
        $localImagePath = 'images/obrazka.jpg';
        $imageContent = file_get_contents($img);
        if ($imageContent !== false) {
            file_put_contents($localImagePath, $imageContent);
        }



        $tesseract = new TesseractOCR($localImagePath);

        $detectedText = $tesseract->run();
        echo $detectedText;

    } else {
        echo "Nie znaleziono elementu <img> wewnątrz <div>";
    }
} else {
    echo "Nie znaleziono elementu <div> o podanym ID";
}

// Zwolnij zasoby
$dom->clear();

