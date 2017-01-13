<?php
/**
 * Template Name: Set Data
 */
?>
<?php
//session_start();

$properties_horizontal = hydra_form_filter('properties_horizontal');
if ($properties_horizontal->getFormRecord()) {

    $query_args1 = $properties_horizontal->getQueryArray();

    $query_args = $properties_horizontal->getQueryArray();
	
	//echo "<pre>";
	//print_r($query_args1);
	
	//setcookie("name", "John Watkin");

    if (isset($query_args1["meta_query"][1]["value"]["items"][0]["location"]) && !empty($query_args1["meta_query"][1]["value"]["items"][0]["location"])) {
        $query_args['meta_query'][1] = array(
            'key' => '_%_location',
            'compare' => '=',
            'value' => $query_args1["meta_query"][1]["value"]["items"][0]["location"]
        );
        $selloc =	get_term_by( 'id',      $query_args1["meta_query"][1]["value"]["items"][0]["location"], 'locations');
        $_SESSION["selected_city"] = $selloc->name;
        $_SESSION["selected_city_id"] = $query_args1["meta_query"][1]["value"]["items"][0]["location"];
		
		
		
    }

    if (isset($query_args1["meta_query"][1]["value"]["items"][0]["country"]) && !empty($query_args1["meta_query"][1]["value"]["items"][0]["country"]))
    {

        $query_args['meta_query'][2] = array(
            'key' => '_%_country',
            'compare' => '=',
            'value' => $query_args1["meta_query"][1]["value"]["items"][0]["country"]
        );
        $selcou =	get_term_by( 'id',$query_args1["meta_query"][1]["value"]["items"][0]["country"], 'locations');
        $_SESSION["selected_cou"] = $selcou->name;
        $_SESSION["selected_cou_id"] = $query_args1["meta_query"][1]["value"]["items"][0]["country"];
    }


    if(isset($query_args1["meta_query"][1]["value"]["items"][0]["sublocation"]) && !empty($query_args1["meta_query"][1]["value"]["items"][0]["sublocation"])) {
        $query_args['meta_query'][3] = array(
            'key' => '_%_sublocation',
            'compare' => '=',
            'value' => $query_args1["meta_query"][1]["value"]["items"][0]["sublocation"]
        );
        $selsubloc =	get_term_by( 'id',  $query_args1["meta_query"][1]["value"]["items"][0]["sublocation"], 'locations');
        $_SESSION["selected_subloc"] = $selsubloc->name;
        $_SESSION["selected_subloc_id"] = $query_args1["meta_query"][1]["value"]["items"][0]["sublocation"];
    }

    // echo "<pre>";
    //  print_r($query_args);
    // die;

}

//echo  $_COOKIE["name"];

//echo "<pre>";
//print_r($_SESSION);

wp_redirect(home_url());
exit;

?>