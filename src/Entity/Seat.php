<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'seats')]
class Seat
{
  #[Id]
  #[Column(type: 'integer', unique: true)]
  #[GeneratedValue]
  private $id;

  #[ManyToOne(targetEntity: 'App\Entity\Car', inversedBy: 'seats')]
  #[JoinColumn(name: 'car_id', nullable: false)]
  private $car;

  public function __construct()
  {
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getCar(): ?Car
  {
    return $this->car;
  }

  public function setCar(?Car $car): self
  {
    $this->car = $car;

    return $this;
  }

  public function __toString()
  {
    return 'seat-' . $this->id;
  }
}
