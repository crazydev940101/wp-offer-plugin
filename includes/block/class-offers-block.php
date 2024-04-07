<?php

include_once("functions-cached-image.php");

class Offers_Block {
    public function __construct() {
        // Register the block on initialization
        add_action('init', array($this, 'register_block'));
    }

    // Register the block with its editor script, editor style, and render callback
    public function register_block() {
        register_block_type('wp-offers/offers-block', array(
            'editor_script' => 'offers-block',
            'editor_style' => 'wp-offers-style',
            'render_callback' => array($this, 'render_block')
        ));
    }

    // Render the block content based on the API response
    public function render_block($block_content, $content = '') {
        $pattern = '/data-api-url="([^"]+)"/';
        preg_match($pattern, $content, $matches);
        $api_url = isset($matches[1]) ? $matches[1] : '';
    
        if (!empty($api_url)) {
           // Now you can create an instance of Cached_API_Handler and use the get_cached_api_response method
            $cached_api_handler = new Cached_API_Handler();
            $data = $cached_api_handler->get_cached_api_response($api_url);

            if ($data && isset($data['record'])) {
                $content = $data['record'];
                ob_start();
                ?>
                <div class="block-container">
                    <?php foreach ($content['offers'] as $offer) : ?>
                        <!-- Display individual offer details -->
                        <div class="block-row">
                             <!-- Offer logo and preview button -->
                            <div class="block-col">
                                <div class="block-item">
                                    <div>
                                        <?php echo !empty($offer['ribbon']) ? '<span class="badge">' . $offer['ribbon'] . '</span>': '<span class="badge" style="background-color:#fafafa !important">' . $offer['ribbon'] . '</span>'; ?>
                                    </div>
                                    <div class="cache-block-logo">
                                        <!-- Display cached images -->
                                        <?php display_cached_image($offer['logo']['dark']); ?>
                                    </div>
                                    <div>
                                        <a href="<?php echo isset($offer['preview_image']['large_url']) ? $offer['preview_image']['large_url'] : ''; ?>" class="preview-btn"><i class="fa fa-picture-o" aria-hidden="true"></i>Preview</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Offer headlines -->
                            <div class="block-col">
                                <div class="block-item">
                                    <p class="block_headline_1"><?php echo isset($offer['headlines']['one']['title']) ? $offer['headlines']['one']['title'] : ''; ?></p>
                                    <p class="block_headline_2"><?php echo isset($offer['headlines']['two']['title']) ? $offer['headlines']['two']['title'] : ''; ?></p>
                                    <p class="block_headline_3"><?php echo isset($offer['headlines']['three']['title']) ? $offer['headlines']['three']['title'] : ''; ?></p>
                                </div>
                            </div>
                             <!-- Offer ratings and slider -->
                            <div class="block-col">
                                <div class="block-item">
                                    <div class="rating">
                                        <?php 
                                            $rating = $offer['stars'];
                                            $full_stars = floor($rating);
                                            $half_star = ($rating - $full_stars) > 0 ? 1 : 0;
                                            $empty_stars = 5 - $full_stars - $half_star;
                                        ?>
                                        <?php for ($i = 0; $i < $full_stars; $i++): ?>
                                            <i class="fa fa-star"></i>
                                        <?php endfor; ?>
                                        <?php if ($half_star == 1): ?>
                                            <i class="fa fa-star-half-o"></i>
                                        <?php endif; ?>
                                        <?php for ($i = 0; $i < $empty_stars; $i++): ?>
                                            <i class="fa fa-star-o"></i>
                                        <?php endfor; ?>
                                    </div>
                                    <div class="slider">
                                        <div class="slides">
                                            <?php foreach ($offer['deposits'] as $deposit) : ?>
                                                <div class="slide-item">
                                                    <img src="<?php echo esc_url($deposit['dark_url']) ?>" alt="<?php echo ($deposit['name']) ?>">
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <div class="dots">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Offer bullet points -->
                            <div class="block-col">
                                <div class="block-item">
                                    <ul class="bullet_points">
                                        <li>
                                            <p><?php echo isset($offer['bullet_points']['one']['title']) ? $offer['bullet_points']['one']['title'] : ''; ?></p>
                                        </li>
                                        <li>
                                            <p><?php echo isset($offer['bullet_points']['two']['title']) ? $offer['bullet_points']['two']['title'] : ''; ?></p>
                                        </li>
                                        <li>
                                            <p><?php echo isset($offer['bullet_points']['three']['title']) ? $offer['bullet_points']['three']['title'] : ''; ?></p>
                                        </li>
                                        <li>
                                            <p><?php echo isset($offer['bullet_points']['four']['title']) ? $offer['bullet_points']['four']['title'] : ''; ?></p>
                                        </li>
                                    </ul>
                                    
                                </div>
                            </div>
                             <!-- Offer CTA and terms -->
                            <div class="block-col">
                                <div class="block-item">
                                    <div>
                                        <a href="<?php echo isset($offer['links']['offer']) ? $offer['links']['offer'] : ''; ?>" class="cta-btn"><?php echo isset($offer['cta']['one']) ? $offer['cta']['one'] : ''; ?></a>
                                    </div>
                                    <div class="cta-text">
                                        <span>
                                            <a href="<?php echo isset($offer['links']['terms']) ? $offer['links']['terms'] : ''; ?>" ><?php echo isset($offer['terms']) ? $offer['terms'] : ''; ?></a> 
                                            <span>|</span>
                                            <a href="<?php echo isset($offer['links']['review']) ? $offer['links']['review'] : ''; ?>" ><?php echo isset($offer['review']) ? $offer['review'] : ''; ?></a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <!-- Offer footer -->
                        <div class="footer">
                            <hr />
                            <span><?php echo $offer['fine_print'] . '&nbsp;&nbsp;|&nbsp;&nbsp;' . $offer['disclaimer'] ?> </span>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php
                return ob_get_clean();
            } else {
                return 'Failed to fetch offers. Please check the API URL.';
            }
        } else {
            return 'Please enter a valid API URL to fetch offers.';
        }
    }
}

// Instantiate the Offers_Block class
new Offers_Block();


