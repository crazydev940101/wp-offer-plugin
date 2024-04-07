=== WP Offers Plugin ===
Contributors: Ariel Cruz
Tested up to: 6.4
Requires PHP: 8.2

=== Description ===

This plugin allows users to display offers from an external API using a custom Gutenberg block.

=== Installation ===

1. Download and extract the plugin files.
2. Upload the wp-offers folder to your WordPress plugins directory (/wp-content/plugins/).
3. Activate the plugin through the 'Plugins' menu in WordPress.

=== Usage ===

1.Add a new post or page or edit an existing one.
2.Click the "+" button to add a new block, search for "Offers Block", and add it to your content.
3.Enter the API URL in the "API URL" field in the block settings.
4. Save or publish your post or page.

=== API Consumption ===

The plugin fetches the required data from the following API:
API URL: https://api.jsonbin.io/v3/b/65b7a4281f5677401f27c75b
For images such as logo and deposit icons, the plugin uses the dark version. The plugin handles API responses and errors gracefully, parsing and displaying the offers data on the frontend.

=== Gutenberg Block ===

The plugin includes a custom Gutenberg block, "Offers Block", with a user-editable field for inputting the API URL. The block includes validation to ensure the URL is valid.

=== Style ===

The plugin uses SCSS for styling the Gutenberg block and the frontend display. It demonstrates the use of SCSS features like variables, nesting, and mixins.

=== Caching ===

For optimal performance, the plugin implements caching for API responses and a local caching mechanism for images.
1. API Response Caching:
Create a new method get_cached_api_response() in the API_Handler class to check if a cached version of the API response exists. If it does, return the cached response. If not, fetch the API response, cache it, and then return it.
2. Image Local Caching:
To implement a local caching mechanism for images in WordPress, I can use the Transients API to store the image data in the database with an expiration time. 
