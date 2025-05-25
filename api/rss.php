<?php
define('SLASH', DIRECTORY_SEPARATOR);
header("Content-Type: application/rss+xml; charset=UTF-8");
require_once 'C:\xampp\htdocs\WebInfoAn2SpilevoiAnton' . SLASH . 'util' . SLASH . 'database.php';

$doc = new DOMDocument('1.0', 'UTF-8');
$doc->formatOutput = true;

$rss = $doc->createElement('rss');
$rss->setAttribute('version', '2.0');
$doc->appendChild($rss);

$channel = $doc->createElement('channel');
$rss->appendChild($channel);

$channel->appendChild($doc->createElement('title', 'Catalog Cărți - Cel mai recent Top 10 + Ultimele Recenzii'));
$channel->appendChild($doc->createElement('link', 'https://localhost/WebInfoAn2SpilevoiAnton'));
$channel->appendChild($doc->createElement('description', 'Top 10 cărți și ultimele 25 recenzii'));
$channel->appendChild($doc->createElement('language', 'ro'));
$channel->appendChild($doc->createElement('pubDate', date(DATE_RSS)));

$db = Database::getInstance()->getConnection();

$topSeparator = $doc->createElement('item');
$topSeparator->appendChild($doc->createElement('title', '--- TOP 10 CĂRȚI ---'));
$topSeparator->appendChild($doc->createElement('description', 'Cele mai bune 10 cărți.'));
$channel->appendChild($topSeparator);

$stmt = $db->query("
    SELECT b.id, b.title, b.description, b.link, MAX(r.created_at) as created_at, AVG(r.rating) as avg_rating
    FROM books b
    JOIN reviews r ON b.id = r.book_id
    GROUP BY b.id
    ORDER BY avg_rating DESC
    LIMIT 10
");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $title = "";
    $description = "";
    if (!empty($row['link'])) {
        $bookUrl = 'localhost/WebInfoAn2SpilevoiAnton/book/viewExternal/'.urlencode(base64_encode($row['link']));
        $data = getExternalBookData($row['link']);
        $title = $data['volumeInfo']['title'] ?? "";
        $description =  $data['volumeInfo']['description'] ?? "";
        
    } else {
        $bookUrl = 'localhost/WebInfoAn2SpilevoiAnton/book/view/'.$row['id'];
    }
    
    $item = $doc->createElement('item');
    $item->appendChild($doc->createElement('title', "TOP: " . ($row['title'] ?? $title)));
    $item->appendChild($doc->createElement('link', $bookUrl));
    $item->appendChild($doc->createElement('description', "Rating mediu: " . round($row['avg_rating'],1) . ". " . ($row['description'] ?? $description)));
    $item->appendChild($doc->createElement('pubDate', date(DATE_RSS, strtotime($row['created_at']))));
    $channel->appendChild($item);
}

$reviewsSeparator = $doc->createElement('item');
$reviewsSeparator->appendChild($doc->createElement('title', '--- ULTIMELE 25 RECENZII ---'));
$reviewsSeparator->appendChild($doc->createElement('description', 'Cele mai recente recenzii.'));
$channel->appendChild($reviewsSeparator);

$stmt = $db->query("
    SELECT r.id, r.text, r.username, r.created_at, r.rating, b.title AS book_title, b.id AS book_id
    FROM reviews r
    JOIN books b ON r.book_id = b.id
    ORDER BY r.created_at DESC
    LIMIT 25
");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $title = "";
    if (!empty($row['link'])) {
        $bookUrl = 'localhost/WebInfoAn2SpilevoiAnton/book/viewExternal/'.urlencode(base64_encode($row['link']));
        $data = getExternalBookData($row['link']);
        $title = $data['volumeInfo']['title'] ?? "";
    } else {
        $bookUrl = 'localhost/WebInfoAn2SpilevoiAnton/book/view/'.$row['id'];
    }
    
    $item = $doc->createElement('item');
    $item->appendChild($doc->createElement('title', "Review: " .( $row['book_title'] ?? $title)));
    $item->appendChild($doc->createElement('link', $bookUrl));
    $item->appendChild($doc->createElement('description', $row['username'] . ' a scris: ' . $row['text'] . ' (Rating: ' . $row['rating'] . '/5)'));
    $item->appendChild($doc->createElement('pubDate', date(DATE_RSS, strtotime($row['created_at']))));
    $channel->appendChild($item);
}

echo $doc->saveXML();

function getExternalBookData($link)
{
    $response = file_get_contents($link);
    $data = json_decode($response, true);
    return $data;
}
?>
