<?php
/*
Plugin Name: Slots Pages
Description: A plugin to create and manage Slots posts.
Version: 1.0
Author: Andre De Carlo
*/
 
if (!defined('ABSPATH')) {
    exit; // Prevent direct access
}

// Register 'Slot' Custom Post Type
function slots_pages_register_post_type() {
    $labels = array(
        'name'          => 'Slots',
        'singular_name' => 'Slot',
        'menu_name'     => 'Slots',
    );
    
    $args = array(
        'labels'        => $labels,
        'public'        => true,
        'has_archive'   => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-tickets',
        'supports'      => array('title', 'editor', 'thumbnail'),
        'show_in_rest'  => true,
    );
    
    register_post_type('slot', $args);
}
add_action('init', 'slots_pages_register_post_type');

// ---------- Add Slot Custom Meta Elements ----------
function slots_pages_add_meta_boxes() {
    add_meta_box('slot_details', 'Slot Details', 'slots_pages_meta_box_callback', 'slot', 'normal', 'high');
}
add_action('add_meta_boxes', 'slots_pages_add_meta_boxes');

function slots_pages_meta_box_callback($post) {
    $star_rating = get_post_meta($post->ID, 'star_rating', true);
    $provider_name = get_post_meta($post->ID, 'provider_name', true);
    $rtp = get_post_meta($post->ID, 'rtp', true);
    $min_wager = get_post_meta($post->ID, 'min_wager', true);
    $max_wager = get_post_meta($post->ID, 'max_wager', true);
    ?>
	<style>
        .sp-meta-container{
            display:flex;
            gap:8px;
            align-items: center;
            margin-bottom: 10px;
        }
        .sp-meta-lbl{
            font-weight:600;
            width: 140px;
        }
        .sp-meta-container input{
            width: 300px;
        }
    </style>
    <div class="sp-meta-container">
        <label class="sp-meta-lbl">Star Rating (1-5):</label>
        <input type="number" name="star_rating" value="<?php echo esc_attr($star_rating); ?>" min="1" max="5" class="widefat" />    
    </div>
    <div class="sp-meta-container">
        <label class="sp-meta-lbl">Provider Name:</label>
        <input type="text" name="provider_name" value="<?php echo esc_attr($provider_name); ?>" class="widefat" />
    </div>
    <div class="sp-meta-container">
        <label class="sp-meta-lbl">RTP (%):</label>
        <input type="text" name="rtp" value="<?php echo esc_attr($rtp); ?>" class="widefat" />
    </div>
    <div class="sp-meta-container">
        <label class="sp-meta-lbl">Minimum Wager:</label>
        <input type="number" name="min_wager" value="<?php echo esc_attr($min_wager); ?>" step="0.01" class="widefat" />
    </div>
    <div class="sp-meta-container">
        <label class="sp-meta-lbl">Maximum Wager:</label>
        <input type="number" name="max_wager" value="<?php echo esc_attr($max_wager); ?>" step="0.01" class="widefat" />
    </div>
    <?php
}

// Save Meta Box Data
function slots_pages_save_meta_data($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!isset($_POST['star_rating'])) return;
    update_post_meta($post_id, 'star_rating', sanitize_text_field($_POST['star_rating']));
    update_post_meta($post_id, 'provider_name', sanitize_text_field($_POST['provider_name']));
    update_post_meta($post_id, 'rtp', sanitize_text_field($_POST['rtp']));
    update_post_meta($post_id, 'min_wager', sanitize_text_field($_POST['min_wager']));
    update_post_meta($post_id, 'max_wager', sanitize_text_field($_POST['max_wager']));
}
add_action('save_post', 'slots_pages_save_meta_data');


// ---------- Display Slots Using Shortcode (For WP Sites not using Gutenberg) ----------
function slots_pages_shortcode() {
    $query = new WP_Query(array('post_type' => 'slot', 'posts_per_page' => -1));
    if ($query->have_posts()) {
        $output = '<div class="slots-list">';
        while ($query->have_posts()) {
            $query->the_post();
            $output .= '<div class="slot-item">';
            $output .= '<h3>' . get_the_title() . '</h3>';
            $output .= '<p>' . get_the_content() . '</p>';
            $output .= '<p>Star Rating: ' . get_post_meta(get_the_ID(), 'star_rating', true) . '</p>';
            $output .= '<p>Provider: ' . get_post_meta(get_the_ID(), 'provider_name', true) . '</p>';
            $output .= '<p>RTP: ' . get_post_meta(get_the_ID(), 'rtp', true) . '%</p>';
            $output .= '<p>Min Wager: ' . get_post_meta(get_the_ID(), 'min_wager', true) . '</p>';
            $output .= '<p>Max Wager: ' . get_post_meta(get_the_ID(), 'max_wager', true) . '</p>';
            if (has_post_thumbnail()) {
                $output .= get_the_post_thumbnail(get_the_ID(), 'medium');
            }
            $output .= '</div>';
        }
        wp_reset_postdata();
        $output .= '</div>';
        return $output;
    } else {
        return '<p>No slots available.</p>';
    }
}
add_shortcode('slots_list', 'slots_pages_shortcode');

// ---------- Gutenberg Slot Details Block ----------
// Register Block
function slots_register_blocks() {
    wp_register_script(
        'slot-details-block',
        plugins_url('blocks/slot-details-block.js', __FILE__),
        array('wp-blocks', 'wp-editor', 'wp-element', 'wp-components', 'wp-api-fetch'),
        filemtime(plugin_dir_path(__FILE__) . 'blocks/slot-details-block.js')
    );

    register_block_type('slots/slot-details', array(
        'editor_script'   => 'slot-details-block',
        'render_callback' => 'slots_render_slot_details',
    ));
}
add_action('init', 'slots_register_blocks');

// Render Callback
function slots_render_slot_details($attributes, $content) {
    global $post;
    if (!$post || get_post_type($post) !== 'slot') return '';

    $star_rating  = get_post_meta($post->ID, 'star_rating', true);
    $provider     = get_post_meta($post->ID, 'provider_name', true);
    $rtp          = get_post_meta($post->ID, 'rtp', true);
    $min_wager    = get_post_meta($post->ID, 'min_wager', true);
    $max_wager    = get_post_meta($post->ID, 'max_wager', true);
    $thumbnail    = get_the_post_thumbnail($post->ID, 'medium');

    ob_start();
    ?>
    <div class="slot-details">
        <h3><?php echo esc_html(get_the_title()); ?></h3>
        <?php echo $thumbnail; ?>
        <p><strong>Star Rating:</strong> <?php echo esc_html($star_rating); ?></p>
        <p><strong>Provider:</strong> <?php echo esc_html($provider); ?></p>
        <p><strong>RTP:</strong> <?php echo esc_html($rtp); ?>%</p>
        <p><strong>Min Wager:</strong> <?php echo esc_html($min_wager); ?></p>
        <p><strong>Max Wager:</strong> <?php echo esc_html($max_wager); ?></p>
    </div>
    <?php
    return ob_get_clean();
}

// ---------- Gutenberg Slot Grid Block ----------
// Register Block
function slots_register_grid_block() {
    wp_register_script(
        'slot-grid-block',
        plugins_url('blocks/slot-grid-block.js', __FILE__),
        array('wp-blocks', 'wp-element'),
        filemtime(plugin_dir_path(__FILE__) . 'blocks/slot-grid-block.js')
    );

    register_block_type('slots/slot-grid', array(
        'editor_script'   => 'slot-grid-block',
        'render_callback' => 'slots_render_grid',
    ));
}
add_action('init', 'slots_register_grid_block');

// Render Callback for Slot Grid
function slots_render_grid($attributes) {
    $default_img = plugin_dir_url(__FILE__) . 'assets/img/default.png';

    // Set default values if missing, matching the block's attributes
    $attributes = wp_parse_args($attributes, [
        'limit' => 9,
        'order_by' => 'recent',
        'showRating' => true,
        'showProvider' => true,
        'showRTP' => true,
        'showMinMaxWager' => true,
        'backgroundColor' => '#e5ebee',
        'borderColor' => '#ddd',
        'borderRadius' => 20,
        'borderWidth' => 0,
        'boxShadowColor' => '#404040',
        'boxShadowBlur' => 20,
        'boxShadowSpread' => -10,
        'titleFontSize' => 20,
        'titleColor' => '#000000',
        'textFontSize' => 15,
        'textColor' => '#333333',
        'buttonBackground' => '#303030',
        'buttonFontColor' => '#FFFFFF',
        'buttonBorderColor' => '#000000',
        'buttonBorderWidth' => 1,
        'buttonBorderRadius' => 5,
        'buttonFontSize' => 14,
        'buttonPadding' => '5px 16px'
    ]);

    // Modify query based on order_by attribute
    $order_args = [];
    switch ($attributes['order_by']) {
        case 'updated':
            $order_args['orderby'] = 'modified';
            break;
        case 'random':
            $order_args['orderby'] = 'rand';
            break;
        default: // 'recent'
            $order_args['orderby'] = 'date';
    }

    $query = new WP_Query(array_merge([
        'post_type' => 'slot',
        'posts_per_page' => intval($attributes['limit'])
    ], $order_args));

    if (!$query->have_posts()) return '<p>No slots found.</p>';

    ob_start();
    // Main grid container styles with dynamic column layout
    echo '<div class="slots-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">';
    
    while ($query->have_posts()) { 
        $query->the_post(); 
        $thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'medium') ?: $default_img; 
        $star_rating = get_post_meta(get_the_ID(), 'star_rating', true); 
        $provider = get_post_meta(get_the_ID(), 'provider_name', true); 
        $rtp = get_post_meta(get_the_ID(), 'rtp', true); 
        $min_wager = get_post_meta(get_the_ID(), 'min_wager', true); 
        $max_wager = get_post_meta(get_the_ID(), 'max_wager', true);

        echo "<div class='slot-item' style='
            background: {$attributes['backgroundColor']}; 
            border: {$attributes['borderWidth']}px solid {$attributes['borderColor']}; 
            border-radius: {$attributes['borderRadius']}px; 
            box-shadow: 0px 4px {$attributes['boxShadowBlur']}px {$attributes['boxShadowSpread']}px {$attributes['boxShadowColor']}; 
            padding: 15px; 
            text-align: center;
        '>";

        echo "<img src='$thumbnail' style='width: 100%; border-radius: {$attributes['borderRadius']}px;' />";
        
        echo "<h4 style='
            font-size: {$attributes['titleFontSize']}px; 
            color: {$attributes['titleColor']};
        '>" . get_the_title() . "</h4>";

        if ($attributes['showRating']) echo "<p style='
            font-size: {$attributes['textFontSize']}px; 
            color: {$attributes['textColor']};
        '>⭐ $star_rating/5</p>";

        if ($attributes['showProvider']) echo "<p style='
            font-size: {$attributes['textFontSize']}px; 
            color: {$attributes['textColor']};
        '>Provider: $provider</p>";

        if ($attributes['showRTP']) echo "<p style='
            font-size: {$attributes['textFontSize']}px; 
            color: {$attributes['textColor']};
        '>RTP: $rtp%</p>";

        if ($attributes['showMinMaxWager']) echo "<p style='
            font-size: {$attributes['textFontSize']}px; 
            color: {$attributes['textColor']};
        '>Min-Max Wager: $$min_wager - $$max_wager</p>";

        echo "<a href='" . get_permalink() . "' class='more-info' style='
            display: inline-block; 
            margin-top: 10px; 
            padding: {$attributes['buttonPadding']}; 
            background: {$attributes['buttonBackground']}; 
            color: {$attributes['buttonFontColor']}; 
            text-decoration: none; 
            border: {$attributes['buttonBorderWidth']}px solid {$attributes['buttonBorderColor']}; 
            border-radius: {$attributes['buttonBorderRadius']}px; 
            font-size: {$attributes['buttonFontSize']}px;
        '>More Info</a>";

        echo "</div>"; 
    }
    echo '</div>'; 
    wp_reset_postdata();
    return ob_get_clean(); 
}

?>