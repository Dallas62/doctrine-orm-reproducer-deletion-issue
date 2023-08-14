<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'owners')]
class Owner
{
  #[Id]
  #[Column(type: 'integer', unique: true)]
  #[GeneratedValue]
  private $id;

  #[OneToMany(mappedBy: 'owner', targetEntity: 'App\Entity\House', cascade: ['persist', 'remove'], orphanRemoval: true)]
  private $houses;

  #[OneToMany(mappedBy: 'owner', targetEntity: 'App\Entity\Car', cascade: ['persist', 'remove'], orphanRemoval: true)]
  private $cars;

  public function __construct()
  {
    $this->houses = new ArrayCollection();
    $this->cars = new ArrayCollection();
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  /**
   * @return Collection|House[]
   */
  public function getHouses(): Collection
  {
    return $this->houses;
  }

  public function addHouse(House $house): self
  {
    if (!$this->houses->contains($house)) {
      $this->houses[] = $house;
      $house->setOwner($this);
    }

    return $this;
  }

  public function removeHouse(House $house): self
  {
    if ($this->houses->contains($house)) {
      $this->houses->removeElement($house);
      // set the owning side to null (unless already changed)
      if ($house->getOwner() === $this) {
        $house->setOwner(null);
      }
    }

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
      $car->setOwner($this);
    }

    return $this;
  }

  public function removeCar(Car $car): self
  {
    if ($this->cars->contains($car)) {
      $this->cars->removeElement($car);
      // set the owning side to null (unless already changed)
      if ($car->getOwner() === $this) {
        $car->setOwner(null);
      }
    }

    return $this;
  }

  public function __toString()
  {
    return 'owner-' . $this->id;
  }
}
