<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\CustomIdGenerator;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'user_plant_pictures')]
#[HasLifecycleCallbacks]
class PlantPicture
{
  #[Id]
  #[Column(type: 'ulid', unique: true)]
  #[GeneratedValue(strategy: 'CUSTOM')]
  #[CustomIdGenerator(class: 'Symfony\Bridge\Doctrine\IdGenerator\UlidGenerator')]
  private $id;

  #[ManyToOne(targetEntity: 'App\Entity\Plant', inversedBy: 'plant_pictures')]
  #[JoinColumn(name: 'plant_id', nullable: false)]
  private ?Plant $plant;

  public function __construct()
  {
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getPlant(): ?Plant
  {
    return $this->plant;
  }

  public function setPlant(?Plant $plant): self
  {
    $this->plant = $plant;

    return $this;
  }

  public function __toString()
  {
    return 'plant-picture-' . $this->id;
  }
}
