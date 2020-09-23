<?php

use Premmerce\Wishlist\WishlistPlugin;

/**
 *
 * @wordpress-plugin
 * Plugin Name:       Premmerce Wishlist for WooCommerce
 * Plugin URI:        https://premmerce.com/woocommerce-wishlist/
 * Description:       This plugin provides the possibility for your customers to create wishlists with the further possibility to share them with friends.
 * Version:           1.1.6
 * Author:            Premmerce
 * Author URI:        https://premmerce.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       premmerce-wishlist
 * Domain Path:       /languages
 *
 * WC requires at least: 3.0.0
 * WC tested up to: 3.7
 */

// If this file is called directly, abort.
if ( ! defined('WPINC')) {
    die;
}

call_user_func(function () {

    require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';

    if ( ! get_option('premmerce_version')) {
        require_once plugin_dir_path(__FILE__) . '/freemius.php';
    }

    $main = new WishlistPlugin(__FILE__);

    register_activation_hook(__FILE__, [$main, 'activate']);

    register_deactivation_hook(__FILE__, [$main, 'deactivate']);

    if (function_exists('premmerce_pw_fs')) {
        premmerce_pw_fs()->add_action('after_uninstall', [WishlistPlugin::class, 'uninstall']);
    } else {
        register_uninstall_hook(__FILE__, [WishlistPlugin::class, 'uninstall']);
    }


    $main->run();
});
