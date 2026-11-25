<?php
// Copy to local.php (ignored by Git), or supply the SVL_* environment variables.
return array(
    'env' => 'local',
    'registration_token' => '',
    'passenger_export_token' => '',
    // Required for contact submissions on production; never commit the real secret.
    'recaptcha_secret' => '',
    // Set v3 only for a matching score-based key; v2 keeps the checkbox widget.
    'recaptcha_version' => 'v2',
    'recaptcha_site_key' => '6LeUddUUAAAAAFl8kcpUvMH1QySg_qYAA__8_ukq',
    'databases' => array(
        'web' => array('host' => 'localhost', 'database' => 'svl_local_web',
                       'user' => 'svl_web_local_20261020', 'password' => '', 'socket' => ''),
        'newsletter' => array('host' => 'localhost', 'database' => 'svl_local_newsletter',
                              'user' => 'svl_news_local_20261020', 'password' => '', 'socket' => ''),
    ),
);
