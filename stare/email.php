<?php

$pageUrl = 'https://www.baza-firm.com.pl/szkolenia-kursy/jelenia-gora/zaprogramowanicom/pl/376095.html';

function extractEmails($text) {
    $pattern = '/[\w\.-]+@[\w\.-]+/'; // Proste wyrażenie regularne na adresy e-mail
    preg_match_all($pattern, $text, $matches);
    return $matches[0];
}
$emails = extractEmails($pageUrl);

print_r($emails);