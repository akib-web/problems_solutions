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