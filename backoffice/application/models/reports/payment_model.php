<?php
//error_reporting(E_ALL);
/*
  Class Name	: Account_model
  Package Name  : User
  Purpose       : Handle all the database services related to Agent -> Agent
  Auther 	    : Azeem
  Date of create: Aug 02 2013
*/
class payment_Model extends CI_Model
{

	public function getProviderNameById($id){
	    $query  = $this->db2->query("select PROVIDER_NAME from payment_provider where PAYMENT_PROVIDER_ID = '$id'");
		$result = $query->row();
		return $result->PROVIDER_NAME;
	}

	public function getAllPaymentProviders(){
		$querycnt=$this->db2->query("select * from payment_provider");
		$rowcnt=$querycnt->result();
		return $rowcnt;
	}

	public function getAllPaymentStatus(){
		$querycnt=$this->db2->query("select * from transaction_status");
		$rowcnt=$querycnt->result();
		return $rowcnt;
	}

	public function getAllTransactionTypes(){
		$querycnt=$this->db2->query("select * from transaction_type");
		$rowcnt=$querycnt->result();
		return $rowcnt;
	}

	public function getChipValue($amount){
				$formatable_price = $amount.'0000';
			//echo "SELECT chips FROM nu_jshopping_products WHERE product_price = '".$formatable_price."'";
				$selQry2 = $this->db2->query("SELECT chips FROM nu_jshopping_products WHERE product_price = '".$formatable_price."'");
				$row2 = $selQry2->row();
				return $product_chips = $row2->chips;
	}




/*	public function getPaymentTransNameById($id){
	    $query  = $this->db->query("select TRANSACTION_STATUS_NAME from transaction_status where TRANSACTION_STATUS_ID = '$id'");
		$result = $query->row();
		$trans_name = $result->TRANSACTION_STATUS_NAME;

		switch ($trans_name) {
			case 'TRANS_PAYPAL_INITIATED':
				$product_status_val = 'Pending';
				break;
			case 'TRANS_START':
				$product_status_val = 'Started';
				break;
			case 'TRANS_FAILED':
				$product_status_val = 'Failed';
				break;
			case 'TRANS_SUCCESS':
				$product_status_val = 'Success';
				break;
			case 'TRANS_SUCCESS_WITH_WARNING':
				$product_status_val = 'Success';
				break;
			case 'PROMO_OK':
				$product_status_val = 'Promo Success';
				break;
			case 'BET_OK':
				$product_status_val = 'Bet Success';
				break;
			case 'WIN_OK':
				$product_status_val = 'Win Success';
				break;

			default:
			    $product_status_val	 = $trans_name;
				break;
		}

		return $product_status_val;

	} */

	public function getPaymentTransNameById($id){
	    $query  = $this->db2->query("select TRANSACTION_STATUS_DESCRIPTION from transaction_status where TRANSACTION_STATUS_ID = '$id'");
		$result = $query->row();
		$trans_name = $result->TRANSACTION_STATUS_DESCRIPTION;

/*		switch ($trans_name) {

			case 'PROMO_OK':
				$product_status_val = 'Success';
				break;
			case 'BET_OK':
				$product_status_val = 'Success';
				break;
			case 'WIN_OK':
				$product_status_val = 'Success';
				break;
            case 'XP_POINTS_OK':
                $product_status_val = 'Success';
				break;
            case 'DEPOSIT_OK':
                $product_status_val = 'Success';
				break;
            case 'DEPOSIT_PENDING':
                $product_status_val = 'Pending';
				break;
            case 'DEPOSIT_REJECTED':
                $product_status_val = 'Rejected';
				break;
            case 'DEPOSIT_CANCEL':
                $product_status_val = 'Cancel';
				break;
            case 'VIP_OK':
                $product_status_val = 'Success';
				break;
            case 'VIP_PENDING':
                $product_status_val = 'Pending';
				break;
            case 'VIP_REJECTED':
                $product_status_val = 'Rejected';
				break;
            case 'VIP_CANCEL':
                $product_status_val = 'Cancel';
				break;

			case 'REFUND_OK':
				$product_status_val = 'Success';
				break;
			case 'WITHDRAW_PENDING':
				$product_status_val = 'Pending';
				break;
			case 'WITHDRAW_CANCEL':
				$product_status_val = 'Cancel';
				break;
			case 'WITHDRAW_OK':
				$product_status_val = 'Success';
				break;
			case 'WITHDRAW_APPROVED':
				$product_status_val = 'Approved';
				break;
			case 'WITHDRAW_REJECTED':
				$product_status_val = 'Rejected';
				break;

			case 'TRANS_PAYPAL_INITIATED':
				$product_status_val = 'Pending';
				break;
			case 'TRANS_START':
				$product_status_val = 'Progress';
				break;
			case 'TRANS_FAILED':
				$product_status_val = 'Failed';
				break;
			case 'TRANS_SUCCESS':
				$product_status_val = 'Success';
				break;
			case 'TRANS_SUCCESS_WITH_WARNING':
				$product_status_val = 'Success';
				break;
			case 'TRANSACTION_SATUS_DUMMY_AMOUNT_OK':
				$product_status_val = 'Success';
				break;
			case 'TOPUP_AMOUNT_OK':
				$product_status_val = 'Success';
				break;
			case 'AMOUNT_MISMATCHED':
				$product_status_val = 'Pending';
				break;
			case 'ENTRYFEE_OK':
				$product_status_val = 'Success';
				break;

			default:
			    $product_status_val	 = $trans_name;
				break;

		}*/

		return $trans_name;

	}

	public function getTransactionTypeById($id){
		$query  = $this->db2->query("select * from transaction_type where TRANSACTION_TYPE_ID = '$id'");
		$result = $query->row();
		$trans_desc = $result->TRANSACTION_DESCRIPTION;
		switch ($trans_desc) {
/*			case 'Adjustment_Promo':
				$product_status_val = 'NU Giveaway';
				break;
			case 'Promo':
				$product_status_val = 'NU Giveaway';
				break;
			case 'Bet':
			   $product_status_val = 'NU House Loses';
				break;
			case 'Win':
			   $product_status_val = 'NU House Wins';
				break;	*/
			default:
			    $product_type_desc	 = $trans_desc;
				break;
		}

		return $product_type_desc;

	}

	public function getAdjustedByName($patnerID) {
		$this->db2->select('PARTNER_ID,PARTNER_NAME')->from('partner');
		$this->db2->where('PARTNER_ID',$patnerID);
		$browseSQL = $this->db2->get();
		return $browseSQL->row();
	}

}
