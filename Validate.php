<?php 
/** Validate is used to validate empty values, max and min value lengths, US phone numbers, MIME types, and more to come.
 *	A message is returned for each function if an error is found, or else the return is false.
 *
 *	@var string $msg - output message that is returned if an error
 *	@var boolean $error - set to false initially, but used to test if an error message needs to be echoed to the view
 */
class Validate{
	public $msg;
	public $error = false;
	
	/** validate email address
	 *	@param string $email - email to be validated
	 *
	 *	@return string $msg - the error message returned in case of a validation error.
	 */
	public function email($email){
		$this->error = false;
		// for the email prefix
		$pattern = "/^[a-zA-Z0-9][a-zA-Z0-9\._\-&!?=#]*/";
		if(!preg_match($pattern, $email)){
			// $email is invalid because LocalName is bad
			$this->error = true;
			$msg = "<p class='error'>Your email address is invalid</p>";
			return $msg;
		} else {
			// strip out everything but the domain from the email
			$pattern = "/^[a-zA-Z0-9][a-zA-Z0-9\._\-&!?=#]*@/";
			$domain = preg_replace($pattern, '', $email);
			// check to see if $domain is registered
			/** if your code is run on a Windows server, this will not work on its own. you will need
			 *	to call the win_checkdnsrr function instead of: if(!checkdnsrr($domain)) below
			 *
			 *	@example - if(win_checkdnsrr($domain)) - the $recType will default to "MX" and should
			 *	be fine for regular use.
			 */
			if(!checkdnsrr($domain)){
				$this->error = true;
				$msg = "<p class='error'>Your email address is invalid</p>";
				return $msg;
			}
		}
	}

		/**	function used by Windows servers to check the DNS registry for a domain name
		 *	@param string $domain - domain name stripped from email address
		 *	@param string $recType - used to talk to an external program within the Windows server
		 */
		function win_checkdnsrr($domain, $recType=''){
			if(!empty($domain)){
				if($recType == '') $recType = "MX";
				exec("nslookup -type=$recType $domain", $output);
				foreach($output as $line){
					if(preg_match("/^$domain/", $line)){
						return true;
					}
				}
				return false;
			}
			return false;
		}

	/** validate US phone number
	 *	@param string $phone - phone number to be validated
	 *
	 *	@return string $msg - the error message returned in case of a validation error.
	 *	@return string $cleanPhone - the phone number is returned if no validation errors.
	 *	All characters except for numbers are removed from the phone number for input into the database.
	 */
	public function usPhone($phone){
		$this->error = false;
		// check to see if phone number is blank
		if(empty($phone)){
			$this->error = true;
			$msg = "<p class='error'>Your phone number is invalid.</p>";
			return $msg;
		}
		$pattern = "/^\(?[2-9]\d{2}\)?[-\s]\d{3}-\d{4}$/";
		if(!preg_match($pattern, $phone)){
			// phone is not valid
			$this->error = true;
			$msg = "<p class='error'>Your phone number is invalid.</p>";
			return $msg;
		}
		/* the phone is not empty and matches the pattern above, so remove possible parenthesis, dashes
		 * and spaces for database sanitization
		 */
		$pattern = "/[\(\)\-\s]/";
		$cleanPhone = preg_replace($pattern, '', $phone);
		return $cleanPhone;
	}

	/** validate field has min number of characters
	 *	@param string $num - number to use as minimum number of characters
	 *	@param string $value - value to check against  minimum number of characters
	 */
	public function minChar($num, $value){
		$this->error = false;
		if($value < $num){
			$this->error = true;
			$msg = "<p class='error'>The value must contain a minimum of {$num} characters.</p>";
			return $msg;
		}
	}

	/** validate field has max number of characters
	 *	@param string $num - number to use as maximum numbe of characters
	 *
	 *	@return string $msg - the error message returned in case of a validation error.
	 */
	public function maxChar($num, $value){
		$this->error = false;
		if($value > $num){
			$this->error = true;
			$msg = "<p class='error'>The value must contain a maximum of {$num} characters.";
			return $msg;
		}
	}

	/** validate field is correct MIME type
	 *	@param string $val - value to compare against required type
	 *	@param string $type - required MIME type to compare against
	 */
	public function mimeCheck($val, $type){
		
	}

}

?>