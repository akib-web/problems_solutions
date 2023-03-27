<?php
/* Sort products in cost of goods in descending order. */
function bitbirds_admin_product_order( $query ){

    global $typenow;

    if( is_admin() && $query->is_main_query() && $typenow == 'product' ){
			$query->set( 'meta_key', 'yith_cog_cost' );
        	$query->set( 'orderby', 'meta_value_num' );
			$query->set('order', 'DESC');
    }
}
add_action( 'parse_query', 'bitbirds_admin_product_order' );


// === update _merchshark_bitBirds_highest_margin meta_key for each product. this key is used to filter & sorting for highest_margin
function merchshark_bitBirds_highest_margin() {
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1
    );

    $products = new WP_Query( $args );

    if ( $products->have_posts() ) {
        while ( $products->have_posts() ) {
            $products->the_post();

            $regular_price = get_post_meta( get_the_ID(), '_regular_price', true );
            
            $sale_price = get_post_meta( get_the_ID(), '_price', true );
			
            if ( $regular_price && $sale_price ) {
				$margin = ( $regular_price - $sale_price ) / $regular_price * 100;
                update_post_meta( get_the_ID(), '_merchshark_highest_profit_margin', $margin );
            }
        }
    }

    wp_reset_postdata();
}

add_action( 'init', 'merchshark_bitBirds_highest_margin' );


// ==== add a new filter highest_margin. 
function bitBirds_catalog_orderby_options( $options ) {
    if ( is_product_category() ) {
        $options['highest_margin'] = __( 'Highest Margins', 'woocommerce' );
	}
    return $options;
}
add_filter( 'woocommerce_catalog_orderby', 'bitBirds_catalog_orderby_options', 20, 1 );
	
// === make queries for highest_margin
function bitBirds_catalog_orderby( $args ) {
    $orderby_value = isset( $_GET['orderby'] ) ? wc_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
    if ( 'highest_margin' == $orderby_value ) {
        $args['orderby'] = 'meta_value_num';
        $args['order'] = 'DESC';
        $args['meta_key'] = '_merchshark_highest_profit_margin';
    }
    return $args;
}
add_filter( 'woocommerce_get_catalog_ordering_args', 'bitBirds_catalog_orderby' );
	
// ==== set default filter as highest_margin.
function bitBirds_default_catalog_orderby( $orderby ) {
    if ( ! is_admin() && is_product_category() ) {
        $orderby = 'highest_margin';
    }
    return $orderby;
}

add_filter( 'woocommerce_default_catalog_orderby', 'bitBirds_default_catalog_orderby', 20, 1 );

