<?php

require __DIR__.'/vendor/autoload.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;
use LearnositySdk\Request\DataApi;
use LearnositySdk\Request\Remote;

$session_id = filter_input(INPUT_GET, 'session_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$consumer_key = 'yis0TYCu7U9V4o7M';
$consumer_secret = '74c5fd430cf1242a527f6223aebd42d30464be22';

$security = [
    'consumer_key' => $consumer_key,
    'domain'       => 'localhost'
];


$data_api = new DataApi();
$data_request = [
    'session_id' => [$session_id],
];

$response = $data_api->request(
    "https://data.learnosity.com/v1/sessions/responses",
    $security,
    $consumer_secret,
    $data_request,
    'get'
)->json()['data'];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Data API</title>
</head>
<body>
    <h2>Access raw session, itembank, and other data for more powerful analytics using our Data API.
        Here is an example of the data for your assessment session availabe via the sessions/responses endpoint,
        just <em>one</em> of many endpoints available to you via Data API.
    </h2>
    <br><br>
    <span>Next stop: 
    <a href="./index.php">
           click here
        </a>
        to start again.
    </span>
    <pre>
        <?= json_encode($response, JSON_PRETTY_PRINT)?>
    </pre>
</body>
</html>