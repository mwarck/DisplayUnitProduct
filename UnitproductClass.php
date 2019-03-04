<?php
/**
 * Buscar woocommerce_product_options_grouping
 * woocommerce_process_product_meta
 */
class UnitProduct{
  private $textfield_id;
  public function __construct(){
    $this->textfield_id = 'unit_txt_field';
  }
  public function init() {

            add_action(
                'woocommerce_product_options_general_product_data',
                array( $this, 'product_options_general_product_data' )
            );
            add_action(
              'woocommerce_process_product_meta',
    array( $this, 'add_custom_linked_field_save' )
            );
    }

    public function product_options_general_product_data() {
      $description = sanitize_text_field('Ingresa la cantidad base del producto en gr, sin la palabra gr');
      $placeholder = sanitize_text_field('Cantidad inicial ej. 250');
      $args = array(
                'id'            => $this->textfield_id,
                'label'         => sanitize_text_field( 'Cantidad en gr:' ),
                'placeholder'   => $placeholder,
                'desc_tip'      => true,
                'type'          =>'number',
                'description'   => $description,
            );
            woocommerce_wp_text_input( $args );

    }
    public function add_custom_linked_field_save( $post_id ) {

        if ( ! ( isset( $_POST['woocommerce_meta_nonce'], $_POST[ $this->textfield_id ] ) || wp_verify_nonce( sanitize_key( $_POST['woocommerce_meta_nonce'] ), 'woocommerce_save_data' ) ) ) {
        return false;
    }

    $product_teaser = sanitize_text_field(
        wp_unslash( $_POST[ $this->textfield_id ] )
    );

    update_post_meta(
        $post_id,
        $this->textfield_id,
        esc_attr( $product_teaser )
    );
}
}

?>
