<?php

/**
 * Get the URL of a local image file
 *
 * @param string $image_url The path to the local image file
 *
 * @return string|false The URL of the local image file or false if the file does not exist
 */
function display_cached_image($image_url) {
    // Generate a unique cache key for the image URL
    $cache_key = 'offers_image_' . md5($image_url);

    // Check if the image is cached
    $cached_image = get_transient($cache_key);

    // If the image is not cached
    if (false === $cached_image) {
        // Fetch the image from the URL
        $response = wp_remote_get($image_url);

        // If there's an error while fetching the image
        if (is_wp_error($response)) {
            // Display the original image URL as a placeholder
            echo '<img src="' . esc_url($image_url) . '" alt="Placeholder"/>';
        } else {
            // Store the fetched image in the cache
            $cached_image = wp_remote_retrieve_body($response);
            set_transient($cache_key, $cached_image, 86400); // Cache time is 86400 seconds (1 day)

            // Display the image with the alt text
            echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr__('Offer image', 'text-domain') . '"/>';
        }
    } else {
        // If the image is cached, display the cached version
        echo $cached_image;
    }
}
