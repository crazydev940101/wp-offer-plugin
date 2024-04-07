<?php
class Cached_API_Handler extends API_Handler {
    /**
     * Fetch or get cached API response
     *
     * @param string $api_url The URL of the API endpoint
     *
     * @return array|bool The decoded JSON data or false on error
     */
    public function get_cached_api_response($api_url) {
        // Generate a unique cache key for the API URL
        $cache_key = 'api_response_' . md5($api_url);

        // Check if a cached response exists
        $cached_response = get_transient($cache_key);

        if ($cached_response) {
            // Return the cached response
            return $cached_response;
        }

        // Fetch the API response
        $api_response = $this->fetch_offers($api_url);

        if ($api_response) {
            // Cache the API response for 1 day
            set_transient($cache_key, $api_response, 86400);
        }

        // Return the API response
        return $api_response;
    }
}
