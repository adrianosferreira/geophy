<?php

namespace App\Models;

class Property {

	public $id;
	public $country;
	public $address;
	public $zip;

	public function getId(): int {
		return $this->id;
	}

	public function setId( int $id ): Property {
		$this->id = $id;

		return $this;
	}

	public function getZip(): int {
		return $this->zip;
	}

	public function setZip( int $zip ): Property {
		$this->zip = $zip;

		return $this;
	}

	public function getCountry(): string {
		return $this->country;
	}

	public function setCountry( string $country ): Property {
		$this->country = $country;

		return $this;
	}

	public function getAddress(): string {
		return $this->address;
	}

	public function setAddress( string $address ): Property {
		$this->address = $address;

		return $this;
	}
}