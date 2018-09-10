<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Checklogin extends CI_Controller
{
        
        public function check_isvalidated(){
            echo "Partner".$this->session->userdata['partnerid'];
            if(!$this->session->userdata['partnerid']){
                redirect('login');
            }
        }
        
}