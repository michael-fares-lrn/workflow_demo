<?php

require __DIR__.'/vendor/autoload.php';
use LearnositySdk\Request\Init;

$consumer_key = 'yis0TYCu7U9V4o7M';
$consumer_secret = '74c5fd430cf1242a527f6223aebd42d30464be22';

$security = [
    'consumer_key' => $consumer_key,
    'domain'       => 'localhost'
];

$session_id = filter_input(INPUT_GET, 'session_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

echo "session_id: $session_id";

$request = [
    'reports' => [
        [
            'id' => 'session-detail',
            'type' => 'session-detail-by-item',
            'user_id' => '$ANONYMIZED_USER_ID',
            'session_id' => $session_id
        ]   
    ]
];

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Reports API</title>
</head>
<body>
<div>
    <h2>
        Here is a report of the assessment you just took. This is the 'Session detail by item' report, just <em>one</em> of many availabe report types at Learnosity.
    </h2>
    <span>Next stop: 
    <a href="/data.php?session_id=<?=$session_id?>">
           click here
        </a>
        to see much more information on your session with Data API.
    </span>
       
    <div id="session-detail"></div>
</div>
<script type="text/javascript" src="https://reports.learnosity.com"></script>
<script>

    const callbacks = {
        readyListener: function () {
            console.log("Reports API has successfully initialized.");
        },
        errorListener: function (err) {
            console.log(err);
        }
    };

    const reportsApp = LearnosityReports.init(<?=$signedRequest?>, callbacks);
</script>
</body>
</html>