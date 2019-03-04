<?php
/**
 *
 */
class DisplayUnit{
  private $textfield_id;


  function __construct()
  {
    global $woocommerce;
    global $product;
    $this->textfield_id = 'unit_txt_field';
  }
  public function init(){
    add_action(
      'woocommerce_before_add_to_cart_form',
      array($this, 'product_value')
    );
    $meta_unit = get_post_meta( get_the_ID(), $this->textfield_id,true);
    $arrive= array(
      'mytextfiel'  =>$meta_unit
    );
    wp_localize_script('operational_wc_calculate','meta_unit',$arrive);

    add_action( 'woocommerce_single_product_summary','woocommerce_template_single_price',10);
    add_action( 'woocommerce_after_shop_loop_item_title', array( $this, 'product_value' ), 10, 0);
    add_action('init',array($this,'operational_wc_calculate') );

  }
  public function product_value(){
    $product = new WC_Product(get_the_ID());
    $teaser = get_post_meta( get_the_ID(), $this->textfield_id,true);
    $price =  woocommerce_price($product->get_price());
    if( empty($teaser)){
      return;
    }
      $unida = $teaser;
    echo("<div class='weight' id='weight'><a> $unida gr x $price </a></div>");
  }
  public function operational_wc_calculate(){
    wc_enqueue_js('$(document).ready(function($){
      $("form.cart").on("change","input.qty", function(e){
        var formid = e.delegateTarget.id;
        var nameBase = "calculus_" + formid;
        var idDisplay = "base_" + formid;
        var valor   = $(this).val();
        var base    = $("input[name = " + nameBase + "] ").val();
        var multi   = valor*base;
        $("input[id = " + idDisplay + "]").val(multi);
      });
    });');
  }
}
 ?>
