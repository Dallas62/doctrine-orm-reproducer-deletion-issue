<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'houses')]
class House
{
  #[Id]
  #[Column(type: 'integer', unique: true)]
  #[GeneratedValue]
  private $id;

  #[ManyToOne(targetEntity: 'App\Entity\Owner', inversedBy: 'houses')]
  #[JoinColumn(name: 'owner_id', nullable: false)]
  private $owner;

  #[OneToMany(mappedBy: 'house', targetEntity: 'App\Entity\Car', cascade: ['persist', 'remove'])]
  private $cars;

  public function __construct()
  {
    $this->cars = new ArrayCollection();
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getOwner(): ?Owner
  {
    return $this->owner;
  }

  public function setOwner(?Owner $owner): self
  {
    $this->owner = $owner;

    return $this;
  }

  /**
   * @return Collection|Car[]
   */
  public function getCars(): Collection
  {
    return $this->cars;
  }

  public function addCar(Car $car): self
  {
    if (!$this->cars->contains($car)) {
      $this->cars[] = $car;
      $car->setHouse($this);
    }

    return $this;
  }

  public function removeCar(Car $car): self
  {
    if ($this->cars->contains($car)) {
      $this->cars->removeElement($car);
      // set the owning side to null (unless already changed)
      if ($car->getHouse() === $this) {
        $car->setHouse(null);
      }
    }

    return $this;
  }

  public function __toString()
  {
    return 'house-' . $this->id;
  }
}
