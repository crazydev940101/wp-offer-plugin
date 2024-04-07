<?php
class API_Handler {
    /**
     * Fetch offers from the API
     *
     * @param string $api_url The URL of the API endpoint
     *
     * @return array|bool The decoded JSON data or false on error
     */
    public function fetch_offers($api_url) {
        // Make a GET request to the API endpoint
        $response = wp_remote_get($api_url);

        // Check for errors and return false if there was an error
        if (is_wp_error($response)) {
            return false;
        }

        // Retrieve the response body
        $body = wp_remote_retrieve_body($response);

        // Decode the JSON response into an associative array
        $data = json_decode($body, true);

        // Return the decoded data or false if there was an error
        return $data;
    }
}
