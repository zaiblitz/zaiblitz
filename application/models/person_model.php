<?php
/**
 * Created by PhpStorm.
 * User: Merwin Domingo
 * Date: 4/5/2015
 * Time: 6:28 PM
 */

class Person_Model extends CI_Model {

    // table name
    private $tbl_person= 'person_tbl';

    public function __construct()
    {
        parent::__construct(); // Call the Model constructor
    }

    public function person_list() {
        $data['recordsTotal'] = 10;
        $data['iTotalRecords'] = 10;
        $data['iTotalDisplayRecords'] = 10;

        $query = $this->db->query('SELECT * FROM person_tbl');
        // print_r($query->result_array());  // return array
        $data['aaData'] = $query->result(); // return object
        return json_encode($data);
    }

    public function get_person_name() {
        $query = $this->db->query('SELECT * FROM person_tbl');

        $res_array = $query->result_array();
        foreach( $res_array as $key => $val ) {
            $name[] = $val['pr_fname'];
        }
        return json_encode($name);
    }

    public function save_person( $person_id = NULL, $data ) {
        if( $person_id) {
            $this->db->where('pr_id', $person_id );
            $this->db->update('person_tbl', $data);
            $message = 'Successfully Updated.';
        } else {
            $this->db->insert('person_tbl', $data);
            $message = 'Successfully Registered';
        }
        echo json_encode( array($message));
    }

    public function save_person_lists( $list ) {
        if( $list ) {
             foreach( $list as $key => $val ) {
                 $data = array(
                     'pr_fname' => $val['pr_fname'],
                     'pr_lname' => $val['pr_lname'],
                     'pr_email' => $val['pr_email'],
                     'pr_gender' => $val['pr_gender'],
                     'pr_login_id' => $val['pr_login_id']
                 );
                 $this->db->insert('person_tbl', $data );
             }
             echo json_encode( array('Successfully registered'));
        }
    }

    public function delete_person( $person_id ) {
        foreach( $person_id as $id ) {
            $this->db->where('pr_id', $id);
            $this->db->delete('person_tbl');
        }
    }

    public function check_username( $username ) {
        $query = $this->db->query("SELECT * FROM person_tbl where pr_login_id='".$username."'");
        $result =  $query->result_array();
        $data = !empty($result) ? true : false;
        echo json_encode(array(  'username' => $data ) );
    }

    public function get_all_person() {
        $query = $this->db->query('SELECT * FROM person_tbl');
        $response = $query->result_array();
        return $response;
    }
}
?>