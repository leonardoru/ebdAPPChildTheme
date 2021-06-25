<?php
/**
 * Servicios Adicionales  tab
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

global $post;
global $product;
?>
<span>Categorias</span>
        <?php 
            $categories_list = $product->get_category_ids();
            foreach( $categories_list as $category){
                $thumbnail_id = get_term_meta( $category, 'thumbnail_id', true );
                $image = wp_get_attachment_url( $thumbnail_id );
                // echo($category);
                // $catName =  get_term( $category )->name ."<br>";

            
                echo("<div class='cat_element'><img class='cat_images' src='".$image."'><span class='cat_images_title'>". get_term( $category )->name ."</span></div>");
            }
        
        ?>
