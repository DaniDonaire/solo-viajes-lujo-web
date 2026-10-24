<?php
// Save a completed copy outside www, then point SVL_CONFIG_FILE at that PHP file.
// The MySQL user must have privileges ONLY on these two dedicated staging databases.
// The whole staging directory must be protected with HTTP Basic Auth and noindex.
return array(
    'env' => 'staging',
    'base_path' => '/preproduccion',
    'mail_capture_dir' => '/home/soloviajesdelujo/svl-private/preprod-mail',
    'registration_token' => '',
    'passenger_export_token' => '',
    'recaptcha_secret' => '',
    'databases' => array(
        'web' => array('host' => 'localhost', 'database' => 'solov_preprod_web',
            'user' => '', 'password' => '', 'socket' => ''),
        'newsletter' => array('host' => 'localhost', 'database' => 'solov_preprod_newsletter',
            'user' => '', 'password' => '', 'socket' => ''),
    ),
);
