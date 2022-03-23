// Target _blank on external woocommerce products (product lists/categories)
function wc_extenal_in_new_tab($args, $product) 
{
    if( $product->is_type('external') ) {
        // Inject target="_blank" into the attributes array
        $args['attributes']['target'] = '_blank';
    }    

    return $args;
}
add_filter( 'woocommerce_loop_add_to_cart_args', 'wc_extenal_in_new_tab', 10, 2 );

// Target _blank on external woocommerce products (individual)
function wc_extenal_individual_in_new_tab() {
    global $product;
    if ( ! $product->add_to_cart_url() ) {
    return;
    }
    $product_url = $product->add_to_cart_url();
    $button_text = $product->single_add_to_cart_text();
    //The code below outputs the edited button with target="_blank" added to the html markup.
    do_action( 'woocommerce_before_add_to_cart_button' ); ?>
    <p class="cart">
    <a href="<?php echo esc_url( $product_url ); ?>" rel="nofollow" class="single_add_to_cart_button                                                           button alt" target="_blank">  
    <?php echo esc_html($button_text ); ?></a>
    </p>
    <?php do_action( 'woocommerce_after_add_to_cart_button' );
}
// Remove the default WooCommerce external product Buy Product button on the individual Product page.
remove_action( 'woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30 );
// Add the open in a new browser tab WooCommerce external product Buy Product button.
add_action( 'woocommerce_external_add_to_cart', 'wc_extenal_individual_in_new_tab', 30 );

// Target _blank on external woocommerce products (gutenberg blocks)
function wc_external_product_block_in_new_tab( $html, $data, $product ) {
	$html = str_replace('rel="nofollow"', '', $html);
	$html = str_replace('target="_blank"', '', $html);
	$html = str_replace('<a', '<a target="_blank" rel="nofollow"', $html);
    return $html;
}
add_filter( 'woocommerce_blocks_product_grid_item_html', 'wc_external_product_block_in_new_tab', 10, 3 );
