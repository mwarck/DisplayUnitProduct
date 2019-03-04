<?php
/**
 * @package     Markus
 *
 * @wordpress_plugin
 * Plugin Name:   DisplayUnitProduct
 * Description:   Despliega la unidad de cada producto ejemplo: 100, muestra 100 gr.
 * Version:       1.0.0
 * License:       GPL-2.0+
 *
 */

include_once('DisplayUnitProduct.php');
include_once('UnitproductClass.php');

add_action('plugins_loaded', 'unit_wc_input_start');

function unit_wc_input_start(){
  if(is_admin()){
    $admin = new UnitProduct('unit_txt_field');
    $admin->init();
  } else {
    $plugin = new DisplayUnit('unit_txt_field');
    $plugin->init();
  }
}

 ?>
