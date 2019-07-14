<?php

namespace App\Models;

class School {

	public $Id;
	public $name;
	public $gradeLevel;
	public $distance;

	public function getId(): int {
		return $this->Id;
	}

	public function setId( int $Id ): School {
		$this->Id = $Id;

		return $this;
	}

	public function getName(): string {
		return $this->name;
	}

	public function setName( string $name ): School {
		$this->name = $name;

		return $this;
	}

	public function getGradeLevel(): string {
		return $this->gradeLevel;
	}

	public function setGradeLevel( string $gradeLevel ): School {
		$this->gradeLevel = $gradeLevel;

		return $this;
	}

	public function getDistance(): float {
		return $this->distance;
	}

	public function setDistance( float $distance ): School {
		$this->distance = $distance;

		return $this;
	}
}