<?php
require_once __DIR__ . '/includes/Constants.php';
require_once __DIR__ . '/includes/Settings.php';

// If uninstall.php is not called by WordPress, exit.
if (!defined('WP_UNINSTALL_PLUGIN')) {
  exit;
}

MobilizonConnector\Settings::deleteAllOptions();
