<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 *
 */

/**
 * smarty_function_field
 * This is the constructor for the Smarty plugin.
 *
 * @param $params The runtime Smarty key/value arguments
 * @param $smarty The reference to the Smarty object used in this invocation
 */
function smarty_function_field($params, &$smarty){
    if(!empty($params) && is_array($params) && array_key_exists("defs",$params) && array_key_exists("type",$params["defs"])){
        $field = Field::getField($params["defs"]["type"],$params["defs"]);
        $field->view = array_key_exists("view",$params)?$params["view"]:"detail";
        if(array_key_exists("value",$params)){
            $field->value = $params["value"];
        }
        $field->setup($params["defs"]);
        $field->display();
    }
    return NULL;
}
