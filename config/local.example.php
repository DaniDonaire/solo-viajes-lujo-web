<?php
// Copy to local.php (ignored by Git), or supply the SVL_* environment variables.
return array(
    'env' => 'local',
    'registration_token' => '',
    'passenger_export_token' => '',
    // Required for contact submissions on production; never commit the real secret.
    'recaptcha_secret' => '',
    'databases' => array(
        'web' => array('host' => 'localhost', 'database' => 'svl_local_web',
                       'user' => 'svl_web_local_20261020', 'password' => '', 'socket' => ''),
        'newsletter' => array('host' => 'localhost', 'database' => 'svl_local_newsletter',
                              'user' => 'svl_news_local_20261020', 'password' => '', 'socket' => ''),
    ),
);
