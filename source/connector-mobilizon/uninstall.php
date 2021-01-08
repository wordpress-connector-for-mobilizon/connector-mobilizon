<?php
require_once __DIR__ . '/includes/constants.php';
require_once __DIR__ . '/includes/settings.php';

// If uninstall.php is not called by WordPress, exit.
if (!defined('WP_UNINSTALL_PLUGIN')) {
  exit;
}

MobilizonConnector\Settings::deleteAllOptions();
