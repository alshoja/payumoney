<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('string', 'url'));
		$this->load->library('session');
	}

	public function index()
	{
		$this->load->view('Home');
	}
	


	//Method that handle when the payment was successful
	public function success(){
		if(empty($_POST)){
			redirect('HomeController');
		}

		$status=$_POST["status"];
		$firstname=$_POST["firstname"];
		$amount=$_POST["amount"];
		$txnid=$_POST["txnid"];
		$posted_hash=$_POST["hash"];
		$key=$_POST["key"];
		$productinfo=$_POST["productinfo"];
		$email=$_POST["email"];
		$salt = "oCaLAZlKi5";
		$sno = $_POST["udf1"];

		$retHashSeq = $salt.'|'.$status.'||||||||||'.$sno.'|'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;

		$hash = strtolower(hash("sha512", $retHashSeq));

		if ($hash != $posted_hash) {
	       $this->session->set_flashdata('msg_error', "An Error occured while processing your payment. Try again..");
		}

		else{
			$this->session->set_flashdata('msg_success', "Payment was successful..");
		}
		unset($_POST);
		redirect();
	}

	//Method that handles when payment was failed
	public function failure(){
		unset($_POST);
		$this->session->set_flashdata('msg_error', "Your payment was failed. Try again..");
		redirect();
	}

	//Method that handles when payment was cancelled.
	public function cancel(){
		unset($_POST);
		$this->session->set_flashdata('msg_error', "Your payment was cancelled. Try again..");
		redirect();
	}

	


}
