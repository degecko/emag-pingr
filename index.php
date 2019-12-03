<?php

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\FileCookieJar;
use GuzzleHttp\Exception\ClientException;

require_once 'vendor/autoload.php';

$urlsPath = __DIR__ . '/urls.txt';
$prevPricesFile = __DIR__ . '/prev-prices.json';

if (! file_exists($urlsPath)) {
    echo 'You need to create the urls.txt file and add the products that you are interested in.';
}

if (! file_exists($prevPricesFile)) {
    file_put_contents($prevPricesFile, '{}');

    $prevPrices = new stdClass;
}

$urls = explode(PHP_EOL, file_get_contents($urlsPath));
isset($prevPrices) or $prevPrices = json_decode(file_get_contents($prevPricesFile));
$jar = new FileCookieJar('/tmp/emag-pingr.cookie');
$client = new Client([
    'cookies' => $jar,
    'headers' => [
        'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36',
    ]
]);

foreach ($urls as $i => $url) {
    $hash = md5($url);

    if (filter_var($url, FILTER_VALIDATE_URL)) {
        try {
            $html = $client->get($url)->getBody()->getContents();

            if (preg_match('#price: {"current":([\d.]+)#si', $html, $res)) {
                $currentPrice = $res[1];

                if (isset($prevPrices->$hash) && $currentPrice < $prevPrices->$hash) {
                    $alerts[$hash] = $currentPrice . ' < ' . $prevPrices->$hash . ' - ' . $url;
                }

                $prevPrices->$hash = $currentPrice;

                file_put_contents($prevPricesFile, json_encode($prevPrices));
            } else {
                $alerts[$hash] = "Can't find the fakken price, chief. ($i)";
            }
        } catch (ClientException $e) {
            continue;
        }
    } else {
        $alerts[$hash] = "Invalid URL: $url";
    }
}

$alertsFile = '/Users/gecko/Desktop/oi';
$currentAlerts = file_exists($alertsFile) ? json_decode(file_get_contents($alertsFile)) : new stdClass;

if (isset($alerts)) {
    foreach ($alerts as $hash => $details) {
        $currentAlerts->$hash = $details;
    }

    file_put_contents($alertsFile, json_encode($currentAlerts));
}
