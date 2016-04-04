<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Learnings extends CI_Controller {


    public function __construct() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->model('person_model');
        $this->load->library('PHPExcel');
    }


    public function index()
    {
        $this->load->view('learnings/index');
    }

    public function export_excel()
    {
        $data = $this->person_model->get_all_person();


        $phpExcel = new PHPExcel();

        $phpExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $phpExcel->getActiveSheet()->getCell('A1')->setValue('Created by:');
        $phpExcel->getActiveSheet()->getCell('B1')->setValue('Merwin Dale');

        $filename = 'MerwinExcel'.'.xls';

        $rowCount = 3;
        foreach( $data as $key => $val ) {
            $name = $val['pr_fname'];
            $email = $val['pr_email'];
            $phpExcel->getActiveSheet()->setCellValue('A'.$rowCount, $name);
            $phpExcel->getActiveSheet()->setCellValue('B'.$rowCount, $email);
            $rowCount++;
        }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        PHPExcel_IOFactory::createWriter($phpExcel, 'Excel5')->save('php://output');
    }

    public function file_upload() {
       echo $this->input->post('action');
    }

    public function html5_file_upload() {

        $file = $_FILES['image']['tmp_name'];
        $file_name = $_FILES['image']['name'];

        //print_r($_FILES['image']);

        $directory =  'media/images/uploads';

        if(file_exists($directory.'/'.$file_name)) {
            echo json_encode( array('error' => 'File name already exist'));
        } else {
            move_uploaded_file($file, $directory.'/'.$file_name);
        }
    }

    public function json() {
        $this->load->view('learnings/json');
    }

    public function layouts() {
        $this->load->view('learnings/layouts');

         switch($this->input->post('id')) {
             case  'layout1';
                 echo 'ok';
                 //$this->load->view('learnings/layouts/layout1');
                 break;
         }
    }
}
