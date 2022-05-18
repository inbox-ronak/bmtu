<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Permission
{
    private static $_CI;
 
    public function __construct()
    {
        self::$_CI =& get_instance();
        self::$_CI->load->database();
    }
    public static function grant($module,$method)
    {
        $match = false;
        $user_id = $_SESSION['user_id'];
        $user_role = $_SESSION['user_role'];
        if($user_role == 1){
            return true;
        }
        $table = 'user_master';
        $query = self::$_CI->db->get_where($table, array('id' => $user_id));
        $user = $query->result_array();
 
        $module_permission = json_decode($user[0]['module_permission'],true);
        //echo '<pre>';print_r($module_permission);
        if($module_permission){
            foreach ($module_permission as $key=>$value) {
                if(array_key_exists($module,$value)){
                    $methodarr = explode(',',$value[$module]);
                    if($methodarr){
                        if(in_array($method,$methodarr)){
                            //echo $key.'<pre>';print_r($methodarr);
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }
    public function __destruct()
    {
        self::$_CI->db->close();
    }
}