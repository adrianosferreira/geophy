<?php

namespace App\Models;

class Sale {

	public $transType;
	public $amount;
	public $document;
	public $pricePerSizeUnit;
	public $pricePerBed;

	public function getTransType(): string {
		return $this->transType;
	}

	public function setTransType( string $transType ): Sale {
		$this->transType = $transType;

		return $this;
	}

	public function getAmount(): float {
		return $this->amount;
	}

	public function setAmount( float $amount ): Sale {
		$this->amount = $amount;

		return $this;
	}

	public function getDocument(): string {
		return $this->document;
	}

	public function setDocument( string $document ): Sale {
		$this->document = $document;

		return $this;
	}

	public function getPricePerSizeUnit(): float {
		return $this->pricePerSizeUnit;
	}

	public function setPricePerSizeUnit( float $pricePerSizeUnit ): Sale {
		$this->pricePerSizeUnit = $pricePerSizeUnit;

		return $this;
	}

	public function getPricePerBed(): float {
		return $this->pricePerBed;
	}

	public function setPricePerBed( float $pricePerBed ): Sale {
		$this->pricePerBed = $pricePerBed;

		return $this;
	}
}