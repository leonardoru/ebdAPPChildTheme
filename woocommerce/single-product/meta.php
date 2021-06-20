<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
?>
<div class="product_meta">

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

    <span class="edad_wrapper"><?php esc_html_e( 'Edad:', 'woocommerce' ); ?> <span class="edad"><?php echo get_field('field_60cd23ff4ebb5',$product->get_id()) ?></span></span><br>
    <span class="edad_wrapper"><?php esc_html_e( 'Estatura:', 'woocommerce' ); ?> <span class="estatura"><?php echo get_field('field_60cd24274ebb6',$product->get_id()) ?></span></span><br>
    <span class="edad_wrapper"><?php esc_html_e( 'Busto:', 'woocommerce' ); ?> <span class="busto"><?php echo get_field('field_60cd193772e4a',$product->get_id()) ?></span></span><br>
    <span class="pantalon_wrapper"><?php esc_html_e( 'Pantalon:', 'woocommerce' ); ?> <span class="pantalon"><?php echo get_field('field_60cd25d3bead3',$product->get_id()) ?></span></span><br>
    <span class="medidas_wrapper"><?php esc_html_e( 'Medidas:', 'woocommerce' ); ?> <span class="medidas"><?php echo get_field('field_60cd24ffbeacf',$product->get_id()) ?></span></span><br>
    <span class="ojos_wrapper"><?php esc_html_e( 'Color de Ojos:', 'woocommerce' ); ?> <span class="ojos"><?php echo get_field('field_60cd257abead1',$product->get_id()) ?></span></span><br>
    <span class="piel_wrapper"><?php esc_html_e( 'Piel:', 'woocommerce' ); ?> <span class="piel"><?php echo get_field('color_de_piel',$product->get_id()) ?></span></span><br>
    <span class="experiencia_wrapper"><?php esc_html_e( 'Experiencia:', 'woocommerce' ); ?> <span class="experiencia"><?php echo get_field('experiencia',$product->get_id()) ?></span></span><br>
    <span class="nacionalidad_wrapper"><?php esc_html_e( 'Nacionalidad:', 'woocommerce' ); ?> <span class="nacionalidad"><?php echo get_field('nacionalidad',$product->get_id()) ?></span></span><br>
    <span class="ciudad_origen_wrapper"><?php esc_html_e( 'Ciudad de Origen:', 'woocommerce' ); ?> <span class="ciudad_origen"><?php echo get_field('ciudad_de_origen',$product->get_id()) ?></span></span><br>


    <?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( 'Categoria:', 'Categorias:', count( $product->get_category_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?>

	<?php echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>
