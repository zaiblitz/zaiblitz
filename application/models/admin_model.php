<?php
/**
 * Created by PhpStorm.
 * User: Merwin Domingo
 * Date: 4/5/2015
 * Time: 6:28 PM
 */

class Admin_Model extends CI_Model {


    public function admin_list() {
        $data['recordsTotal'] = 10;
        $data['iTotalRecords'] = 10;
        $data['iTotalDisplayRecords'] = 10;


        $data['aaData'] = array(
            array( 'id' => 1, 'firstName' => 'Merwin', 'lastName' => 'Domingo', 'flag' => 1 ),
            array( 'id' => 2, 'firstName' => 'Jhae', 'lastName' => 'Batioco', 'flag' => 0 ),
            array( 'id' => 3, 'firstName' => 'Kath', 'lastName' => 'Batioco', 'flag' => 1 ),
            array( 'id' => 4, 'firstName' => 'Angel', 'lastName' => 'Batioco', 'flag' => 0 )
        );

        return json_encode($data);
    }
}
?>