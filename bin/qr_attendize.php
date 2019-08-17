<?php

date_default_timezone_set('Europe/London');

// chdir(__DIR__ . '/../');

require_once 'vendor/autoload.php';
use JeroenDesloovere\VCard\VCard;

$attendees = [];
//Read the CSV
if (($handle = fopen("orders.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        $attendees[] = $data;
    }
    fclose($handle);
}

echo "Generating " . count($attendees) . " codes";

foreach ($attendees as $attendee) {

    echo 'Generating QR number for ' . $attendee[0] ." ". $attendee[1] . PHP_EOL;
    $numberFilename = __DIR__ . '/../qr/' . $attendee[3] . '_number.png';
    $numberFilename = strval(str_replace("\0", "", $numberFilename));
    \PHPQRCode\QRcode::png($attendee[3], $numberFilename, 'L', 30, 4);

    // define vcard
    $vcard = new VCard();

    // add personal data
    $firstname = strval(str_replace("\0", "", $attendee[0]));
    $lastname = strval(str_replace("\0", "", $attendee[1]));
    $email = strval(str_replace("\0", "", $attendee[2]));
    $vcard->addName($lastname, $firstname);
    $vcard->addEmail($email);

    echo 'Generating vCard QR for ' . $attendee[0] ."_". $attendee[1] . PHP_EOL;
    $vcardFilename = __DIR__ . '/../qr/' . $attendee[3] . '_vcard.png';
    $vcardFilename = strval(str_replace("\0", "", $vcardFilename));
    \PHPQRCode\QRcode::png($vcard->buildVCard(), $vcardFilename, 'L', 30, 4);
}