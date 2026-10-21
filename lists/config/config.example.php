<?php
// Copy to config.php (ignored by Git). Credentials come from private SVL config.
require_once dirname(__DIR__, 2).'/config/database.php';
$svlNewsletter = svl_database_configuration('newsletter');
$language_module = 'spanish.inc';
$database_host = $svlNewsletter['host'];
$database_name = $svlNewsletter['database'];
$database_user = $svlNewsletter['user'];
$database_password = $svlNewsletter['password'];
$pageroot = getenv('SVL_PHPLIST_PAGEROOT') ?: '/lists';
$localPreview = svl_configuration()['env'] === 'local';
define('TEST', $localPreview ? 1 : 0);
define('VERBOSE', 0);
define('PHPMAILERHOST', getenv('SVL_SMTP_HOST') ?: '127.0.0.1');
define('PHPMAILERPORT', (int)(getenv('SVL_SMTP_PORT') ?: 25));
$phpmailer_smtpuser = getenv('SVL_SMTP_USER') ?: '';
$phpmailer_smtppassword = getenv('SVL_SMTP_PASSWORD') ?: '';
$bounce_mailbox_host = getenv('SVL_BOUNCE_HOST') ?: '';
$bounce_mailbox_user = getenv('SVL_BOUNCE_USER') ?: '';
$bounce_mailbox_password = getenv('SVL_BOUNCE_PASSWORD') ?: '';
define('MANUALLY_PROCESS_BOUNCES', 0);
define('CHECK_SESSIONIP', false);
