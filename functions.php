<?php 

# Define some useful vars
$child_theme_root = get_stylesheet_directory_uri();

# Include the ACF Field definition file
include_once "acf-fields.php"; 

# Enque main styles of the child theme
wp_enqueue_style("ebdAPPStyles", $child_theme_root . "/src/css/ebdAPPStyles5.css");

// Custom Taxonomies
add_action( 'init', 'custom_taxonomy_Item' );
function custom_taxonomy_Item()  {
$labels = array(
    'name'                       => 'adicionales',
    'singular_name'              => 'Servicio Adicional',
    'menu_name'                  => 'Servicios Adicionales',
    'all_items'                  => 'Todos los servicios',
    'parent_item'                => 'Servicio Padre',
    'parent_item_colon'          => 'Servicio Padre:',
    'new_item_name'              => 'Nombre de nuevo servicio',
    'add_new_item'               => 'Agregar nuevo servicio',
    'edit_item'                  => 'Editar Servicio',
    'update_item'                => 'Actualizar',
    'separate_items_with_commas' => 'Separate Item with commas',
    'search_items'               => 'Buscar Servicios',
    'add_or_remove_items'        => 'Agregar o remover Items',
    'choose_from_most_used'      => 'Choose from the most used Items',
);
$argsServs = array(
    'labels'                     => $labels,
    'hierarchical'               => true,
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
);
register_taxonomy( 'item', 'product', $argsServs );
register_taxonomy_for_object_type( 'item', 'product' );
}

# Woocommerce substitute functions
/**
 * Remove product data tabs:
 * From: https://docs.woocommerce.com/document/editing-product-data-tabs/
 */
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

function woo_remove_product_tabs( $tabs ) {

    unset( $tabs['additional_information'] );  	// Remove the additional information tab

    return $tabs;
}

/**
 * Rename product data tabs
 */
add_filter( 'woocommerce_product_tabs', 'woo_rename_tabs', 98 );
function woo_rename_tabs( $tabs ) {

	$tabs['description']['title'] = __( 'Mas Información' );		// Rename the description tab

	return $tabs;

}

/**
 * Custom Tabs
 */
/* ---- Caracteristicas Tab -----*/
add_filter( 'woocommerce_product_tabs', 'woo_childtheme_custom_tabs' );
function woo_childtheme_custom_tabs( $tabs ) {
	
	// Adds the new tab
	
	$tabs['caracteristicas'] = array(
		'title' 	=> __( 'Caracteristicas', 'woocommerce' ),
		'priority' 	=> 50,
		'callback' 	=> 'woo_new_product_tab_caracteristicas'
	);

	$tabs['adicionales'] = array(
		'title' 	=> __( 'Servicios Adicionales', 'woocommerce' ),
		'priority' 	=> 4,
		'callback' 	=> 'woo_new_product_tab_adicionales'
	);

	return $tabs;

}
function woo_new_product_tab_caracteristicas() {
	global $post;
	global $product;

	// The new tab content

	echo '<h2>Caracteristicas Especificas</h2>';
	echo '<p>Algunas de las caracteristicas mas destacada de esta modelo son:</p>';

	$categories_list = $product->get_category_ids();
	foreach( $categories_list as $category){
		$thumbnail_id = get_term_meta( $category, 'thumbnail_id', true );
		$image = wp_get_attachment_url( $thumbnail_id );
		// echo($category);
		// $catName =  get_term( $category )->name ."<br>";

	
		echo("<div class='cat_element'><img class='cat_images' src='".$image."'><span class='cat_images_title'>". get_term( $category )->name ."</span></div>");
	}       
}
function woo_new_product_tab_adicionales() {
	global $post;
	global $product;

	// The new tab content

	echo '<h2>Servicios Adicionales</h2>';
	echo '<p>A continuacion encontrars los servicios adicionales que brinda esta modelo:</p>'; 
	//Returns All Term Items for "my_taxonomy".
	$term_list = wp_get_post_terms( $post->ID, 'item', array( 'fields' => 'all' ) );
	//print_r( $term_list );

	for( $i = 0; $i<count($term_list); $i++){
		$adicional_id = $term_list[$i]->term_id;
		$fields = get_fields($adicional_id);
		print_r($fields);



		$adicional_nombre = $term_list[$i]->name;
		$adicional_precio = get_field('field_60d7a24eb2409', 'item_' . $adicional_id);
		$adicional_image = get_field('field_60d7a297b254440a','item_' . $adicional_id);
		$adicional_image = wp_get_attachment_url( $adicional_image );
		echo("<div class='adicional_element'><img class='adicional_icon' src='". $adicional_image ." '><span class='adicional_title'>". $adicional_nombre ."</span> <span class='adicional_precio'> ... \$COP ". $adicional_precio ."</span></div>");
	}
}


/**
 * Reorder product data tabs
 */
add_filter( 'woocommerce_product_tabs', 'woo_reorder_tabs', 98 );
function woo_reorder_tabs( $tabs ) {

	$tabs['reviews']['priority'] = 50;			// Reviews last
	$tabs['description']['priority'] = 1;			// Description first
	$tabs['caracteristicas']['priority'] = 2;	// Additional information third

	return $tabs;
}


    
?>