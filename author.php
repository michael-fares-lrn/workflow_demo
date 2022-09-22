<?php
require __DIR__.'/vendor/autoload.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;
use LearnositySdk\Request\DataApi;
use LearnositySdk\Request\Remote;

$consumer_key = 'yis0TYCu7U9V4o7M';
$consumer_secret = '74c5fd430cf1242a527f6223aebd42d30464be22';

$security = [
    'consumer_key' => $consumer_key,
    'domain'       => 'localhost'
];


$request = [
    'mode' => 'activity_edit',
    'config' => [
        'dependencies' => [
            'question_editor_api' => [
                'init_options' => [
                    'custom_metadata' => [
                        'level' => [
                            'description' => 'your custom metadata description here',
                            'name' => 'Question Level',
                            'type' => 'string'
                        ],
                        'topic' => [
                            'description' => 'your custom metadata description here',
                            'name' => 'Question Topic',
                            'type' => 'string'
                        ]
                    ]
                ]
            ]
        ],
        'item_edit' => [
            'item' => [
                'reference' => [
                    'show' => true,
                    'edit' => true
                ],
                'actions' => [
                    'show' => true
                ],
                'dynamic_content' => true,
                'shared_passage' => true,
                'enable_audio_recording' => true
            ]
        ],
        'activity_edit' => [
            'back' => false
        ]
    ],
    'user' => [
        'id' => 'demos-site',
        'firstname' => 'Demos',
        'lastname' => 'User',
        'email' => 'demos@learnosity.com'
    ]
];

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Author API</title>
</head>
<body>
<div>
    <h2>
        Author an activity here. When finished, press "save".
    </h2>
    <span>Next stop:  Once saved,
    <a id="link" href="">
            click here 
        </a>
        to take the activity you just created as an assessment via Items API!
    </span>
    <br><br>
        
    <div id="learnosity-author"></div>
  
</div>
<script type="text/javascript" src="https://authorapi.learnosity.com"></script>
<script>

    const callbacks = {
        readyListener: function () {
            console.log("Author API has successfully initialized.");
            authorApp.on('save:activity:success', () => {
                // set reference cookie to activity reference (to be used as activity_template_id in Items request)
                const activityRef = authorApp.getActivityReference();
                const link = document.querySelector('#link');
                
                    link.href = `assessment.php?activityRef=${activityRef}`
                
               
            }) 
                       
        },
        errorListener: function (err) {
            console.log(err);
        }
    };

    const authorApp = LearnosityAuthor.init(<?=$signedRequest?>, callbacks);
</script>
</body>
</html>