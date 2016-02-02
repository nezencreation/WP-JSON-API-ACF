<?php
/**
 * Plugin Name: Add Advance Custom Fields to WP REST API v2
 * Description: Add Advance Custom Fields to WP REST API v2 - from https://gist.github.com/rileypaulsen/9b4505cdd0ac88d5ef51
 * Author: @PanMan
 * Author: @nzographos
 * Original Author URI: https://github.com/PanManAms/WP-JSON-API-ACF
 * v2 Author URI: https://github.com/nezencreation/WP-JSON-API-ACF
 * Version: 0.2
 * Plugin URI: https://github.com/nezencreation/WP-JSON-API-ACF
 * Copied from https://gist.github.com/rileypaulsen/9b4505cdd0ac88d5ef51 - but a plugin is nicer
 */
function wp_api_encode_acf($data,$post,$context){
    $customMeta = (array) get_fields($post->ID);
    $data->data['meta'] = $customMeta;
    return $data;
}

function wp_api_encode_acf_taxonomy($data,$post){
    $customMeta = (array) get_fields($post->taxonomy."_". $post->term_id );
    $data['meta'] = array_merge($data['meta'], $customMeta );
    return $data;
}

function wp_api_encode_acf_user($data,$post){
    $customMeta = (array) get_fields("user_". $data->data['id']);
    $data->data['meta'] = $customMeta;
    return $data;
}

add_filter('rest_prepare_post', 'wp_api_encode_acf', 10, 3);
add_filter('rest_prepare_page', 'wp_api_encode_acf', 10, 3);
add_filter('rest_prepare_attachment', 'wp_api_encode_acf', 10, 3);
add_filter('rest_prepare_term', 'wp_api_encode_acf_taxonomy', 10, 2);
add_filter('rest_prepare_user', 'wp_api_encode_acf_user', 10, 2);
add_filter('rest_prepare_user', 'wp_api_encode_acf_user', 10, 2);
 // add_filter('rest_prepare_<your custom post type slug>', 'wp_api_encode_acf', 10, 3);
