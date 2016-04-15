<?php

function do_hydra_render_form( $params, $content = null ) {	
	extract(shortcode_atts(array(
		'form_name' => '',
	), $params));

	return force_balance_tags( hydra_render_form($form_name) );
}
add_shortcode( 'hydra_render_form', 'do_hydra_render_form' );