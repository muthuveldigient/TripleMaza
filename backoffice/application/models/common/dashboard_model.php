<?php
/*
  Class Name	: Dashboard_model
  Package Name  : Casino
  Purpose       : Handle all the database services related to Casino -> Games
  Auther 	: Arun
  Date of create: Oct 09 2013

*/

class Game_model extends CI_Model
{

        public function getLastThreeMonths(){
            $month = date('m-Y',strtotime("-3 Months"));
            $month1 = date('m-Y',strtotime("-2 Months"));
            $month2= date('m-Y',strtotime("-1 Months"));
            $months = array($month,$month1,$month2);
            return $months;
        }

}