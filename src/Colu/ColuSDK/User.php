<?php

namespace Colu\ColuSDK;

use BitWasp\BitcoinLib\BIP32;

/**
 *
 * @author Eyal Alsheich
 *        
 */
class User {
	public $userData, $extendedKey;
	
	/**
	 */
	function __construct($extendedKey) {
		$this->userData = BIP32::import ( $extendedKey );
		$this->extendedKey = $extendedKey;
	}
	public function getId() {
		return $this->extendedKey;
	}
	public function getAddress($index) {
		// creating tuple to derive address
		$tuple = BIP32::get_definition_tuple($this->extendedKey, "0/".$index);
		
		// derive key
		$a = BIP32::CKD($this->extendedKey, $tuple);
		
		// get the address
		$b = BIP32::key_to_address($a[0]);
		
		return $b;
	}
	public function getPublicKey() {
		return $this->userData ["key"];
	}
	public function getChainCoden() {
		return $this->userData ["chain_code"];
	}
}

?>