<?php
/*
Plugin Name: Flamix: Bitrix24 and Elementor Forms integration
Plugin URI: https://flamix.solutions/bitrix24/integrations/site/elementor-forms.php
Description: Bitrix24 and WordPress Elementor Forms integration
Author: Roman Shkabko (Flamix)
Version: 1.1.0
Author URI: https://flamix.info
License: GPLv2
*/

defined('ABSPATH') || exit;

use Flamix\Plugin\General\Checker;
use Flamix\Plugin\Init as FlamixPlugin;
use FlamixLocal\Elementor\Settings\Setting;
use FlamixLocal\Elementor\Handlers;

if (version_compare(PHP_VERSION, '7.4.0') < 0) {
    add_action('admin_notices', function () { echo '<div class="error notice"><p><b>Bitrix24 and Elementor Forms integration</b>: Upgrade your PHP version. Minimum version - 7.4+. Your PHP version ' . PHP_VERSION . '! If you don\'t know how to upgrade PHP version, just ask in your hosting provider! If you can\'t upgrade - delete this plugin!</p></div>';});
    return false;
}

include_once __DIR__ . '/includes/vendor/autoload.php';

// Register Flamix base helpers
FlamixPlugin::init(__DIR__, 'FLAMIX_BITRIX24_ELEMENTOR_FORMS')->setLogsPath(WP_CONTENT_DIR . '/uploads/flamix');

// Register Menu and Fields
Setting::init();

// Register handlers
if (Checker::isPluginActive('elementor')) {
    add_action('wp', [Handlers::class, 'trace']); // Save UTMs and Trace
    add_action('elementor_pro/forms/new_record', [Handlers::class, 'forms'], 10, 4); // Forms handle
}