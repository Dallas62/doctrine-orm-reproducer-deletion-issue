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
#[Table(name: 'cars')]
class Car
{
  #[Id]
  #[Column(type: 'integer', unique: true)]
  #[GeneratedValue]
  private $id;

  #[ManyToOne(targetEntity: 'App\Entity\Owner', inversedBy: 'cars')]
  private $owner;

  #[ManyToOne(targetEntity: 'App\Entity\House', inversedBy: 'cars')]
  #[JoinColumn(name: 'house_id', nullable: true, onDelete: 'SET NULL')]
  private $house;

  #[OneToMany(targetEntity: 'App\Entity\Seat', mappedBy: 'seats', cascade: ['persist', 'remove'])]
  private $seats;

  public function __construct()
  {
    $this->seats = new ArrayCollection();
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  /**
   * @return Collection|Seat[]
   */
  public function getSeats(): Collection
  {
    return $this->seats;
  }

  public function addSeat(Seat $seat): self
  {
    if (!$this->seats->contains($seat)) {
      $this->seats[] = $seat;
      $seat->setCar($this);
    }

    return $this;
  }

  public function removeSeat(Seat $seat): self
  {
    if ($this->seats->contains($seat)) {
      $this->seats->removeElement($seat);
      // set the owning side to null (unless already changed)
      if ($seat->getCar() === $this) {
        $seat->setCar(null);
      }
    }

    return $this;
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

  public function getHouse(): ?House
  {
    return $this->house;
  }

  public function setHouse(?House $house): self
  {
    $this->house = $house;

    return $this;
  }

  public function __toString()
  {
    return 'car-' . $this->id;
  }
}
