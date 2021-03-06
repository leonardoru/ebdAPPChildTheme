<?php 

# Define some useful vars
$child_theme_root = get_stylesheet_directory_uri();

// Decode Manifest
$stylesManifestPath = $child_theme_root . "/dist/manifest.json";
$stylesManifest = file_get_contents($stylesManifestPath);
$stylesManifest = json_decode($stylesManifest, true);
$styleSheet = $stylesManifest ["ebdAPPStyles.css"];

// var_dump($stylSheet);

# Enque main styles of the child theme
wp_enqueue_style("ebdAPPStyles", $child_theme_root . "/dist/" . $styleSheet, [], null);

# Include the ACF Field definition file
include_once "acf-fields.php"; 

// Custom Taxonomies
// -- Adicionales
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
// -- Categoria de Precios
add_action( 'init', 'custom_taxonomy_Item2' );
function custom_taxonomy_Item2()  {
$labels = array(
    'name'                       => 'Categorias de Precios',
    'singular_name'              => 'Categoria de Precio',
    'menu_name'                  => 'Categorias de Precio',
    'all_items'                  => 'Todos las Categorias de Precio',
    'parent_item'                => 'Servicio Padre',
    'parent_item_colon'          => 'Servicio Padre:',
    'new_item_name'              => 'Nombre de nueva Categoria de Precio',
    'add_new_item'               => 'Agregar nueva Categoria de precio',
    'edit_item'                  => 'Editar Categoria de Precio',
    'update_item'                => 'Actualizar',
    'separate_items_with_commas' => 'Separate Item with commas',
    'search_items'               => 'Buscar Catrgorias de Precio',
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
register_taxonomy( 'cat_precios', 'product', $argsServs );
register_taxonomy_for_object_type( 'cat_precios', 'product' );
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

	$tabs['description']['title'] = __( 'Mas Informaci??n' );		// Rename the description tab

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
	$tabs['caracteristicas'] = array(
		'title' 	=> __( 'Caracteristicas', 'woocommerce' ),
		'priority' 	=> 50,
		'callback' 	=> 'woo_new_product_tab_caracteristicas'
	);

	$tabs['precios_porcategoria'] = array(
		'title' 	=> __( 'Tabla de Precios', 'woocommerce' ),
		'priority' 	=> 4,
		'callback' 	=> 'woo_new_product_tab_precios'
	);

	return $tabs;

}
function woo_new_product_tab_caracteristicas() {
	global $post;
	global $product;

	// The new tab content

	echo '<h2>Caracteristicas Especificas</h2>';
	echo '<p>Algunas de las caracteristicas mas destacada de esta modelo son:</p>';
	echo '<table>';
	$categories_list = $product->get_category_ids();
	foreach( $categories_list as $category){
		$thumbnail_id = get_term_meta( $category, 'thumbnail_id', true );
		$image = wp_get_attachment_url( $thumbnail_id );
		$caracteristica_name = get_term( $category )->name;
		$caracteristica_description = get_term( $category )->description;
		// echo($category);
		// $catName =  get_term( $category )->name ."<br>";

	
		echo("<tr><td><img class='cat_images' src='".$image."'></td><td>". $caracteristica_name ."</td><td>". $caracteristica_description."</div>");
	}  
	echo '</table>';     
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
	echo '<table>';
	// echo '<tr><th></th><th>Servicio</th><th>Precio</th>';
	for( $i = 0; $i<count($term_list); $i++){
		$adicional_id = $term_list[$i]->term_id;
		$adicional_nombre = $term_list[$i]->name;
		$adicional_precio = get_field('field_60d7a24eb2409', 'item_' . $adicional_id);
		$adicional_image = get_field('field_60d7a297b254440a','item_' . $adicional_id);
		$adicional_image = wp_get_attachment_url( $adicional_image );
		echo("<tr><td><img class='adicional_icon' src='". $adicional_image ." '></td><td class='adicional_title'>". $adicional_nombre ."</td> <td class='adicional_precio'> \$COP ". $adicional_precio ."</td></tr>");
	}
	echo '</table>';
}
function woo_new_product_tab_precios() {
	global $post;
	global $product;

	// Returns All Term Items for "my_taxonomy".
	$term_list = wp_get_post_terms( $post->ID, 'cat_precios', array( 'fields' => 'all' ) );
	$cat_precios_id = $term_list[0]->term_id;
	$term_name = get_term( $cat_precios_id )->name;
	$term_desc = get_term( $cat_precios_id )->desc;

	// Get values for current price category
	$fields = get_fields('cat_precios_'.$cat_precios_id);
	// print_r($fields);

	// Get category icon 
	$term_icon = $fields['icono_de_categoria'];
	$term_icon_url = wp_get_attachment_url($term_icon);
	$term_icon_html = "<img src='". $term_icon_url . "' class='cat_icon' >";
	unset($fields['icono_de_categoria']);
	

	// Get category colors
	$term_color_1 = $fields['color_principal'];
	$term_color_2 = $fields['Color Secundario'];
	$term_color_border = $fields['color_borde'];
	$color_texto = $fields['color_texto'];

	unset($fields['color_principal']);
	unset($fields['Color Secundario']);
	unset($fields['color_borde']);
	unset($fields['color_texto']);

	$styles = "style='".
	$styles .= "border : 1px solid " . $term_color_border . ";";
	$styles .= "background: linear-gradient(45deg," . $term_color_1 . ",". $term_color_border . ");";
	$styles .= "color:".$color_texto.";";
	$styles .="'";


	echo '<h2>Tabla de Precios</h2>';
	//echo '<div class="cat_badge" id="categoria_' . $term_name .' "'. $styles . '  > Categoria: '. $term_icon_html . '<span>'. $term_name .'</span></div>' ;
	// echo '<p> A continuacion encontrars los precios para esta modelo: </p>'; 
	echo '<table>';
	echo '<tr><th><div class="cat_badge" id="categoria_' . $term_name .' "'. $styles . '  > '. $term_icon_html . '<span>'. $term_name .'</span></div></th><th>Precio</th>';
	foreach ($fields as $key => $field){

		if ( $field == null){
			continue;
		} else {
			$key = str_replace('_'," ",$key);
			$key = ucwords($key);
			echo("<tr><td>" . $key . "</td><td>\$COP " . $field . "</td></tr>");
		}
	}
	echo '</table>';
}

/**
 * Reorder product data tabs
 */
add_filter( 'woocommerce_product_tabs', 'woo_reorder_tabs', 98 );
function woo_reorder_tabs( $tabs ) {

	$tabs['reviews']['priority'] = 50;			// Reviews last
	// $tabs['description']['priority'] = 1;			// Description first
	$tabs['caracteristicas']['priority'] = 2;	// Additional information third

	return $tabs;
}


    
?>