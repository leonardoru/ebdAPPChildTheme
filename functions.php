<?php 

# Define some useful vars
$child_theme_root = get_stylesheet_directory_uri();

# Include the ACF Field definition file
include_once "acf-fields.php"; 

# Enque main styles of the child theme
wp_enqueue_style("ebdAPPStyles", $child_theme_root . "/src/css/ebdAPPStyles3.css");


# Woocommerce substitute functions
/**
	 * Add default product tabs to product pages.
	 *
	 * @param array $tabs Array of tabs.
	 * @return array
	 */
	function woocommerce_default_product_tabs( $tabs = array() ) {
		global $product, $post;

		// Description tab - shows product content.
		if ( $post->post_content ) {
			$tabs['description'] = array(
				'title'    => __( 'Descripción', 'woocommerce' ),
				'priority' => 10,
				'callback' => 'woocommerce_product_description_tab',
			);
		}

		// Additional information tab - shows attributes.
		if ( $product && ( $product->has_attributes() || apply_filters( 'wc_product_enable_dimensions_display', $product->has_weight() || $product->has_dimensions() ) ) ) {
			$tabs['additional_information'] = array(
				'title'    => __( 'Servicios Adicionales', 'woocommerce' ),
				'priority' => 20,
				'callback' => 'woocommerce_product_additional_information_tab',
			);
		}

		// Reviews tab - shows comments.
		if ( comments_open() ) {
			$tabs['reviews'] = array(
				/* translators: %s: reviews count */
				'title'    => sprintf( __( 'Reseñas (%d)', 'woocommerce' ), $product->get_review_count() ),
				'priority' => 30,
				'callback' => 'comments_template',
			);
		}

		return $tabs;
	}

    # Extra Tabs:
    
    /**
	 * Output the Servicios Adicionales tab content.
	 */
	function servicios_adicionales_tab() {
		wc_get_template( $child_theme_root . '/single-product/tabs/servicios_adicionales.php' );
	}


    
?>