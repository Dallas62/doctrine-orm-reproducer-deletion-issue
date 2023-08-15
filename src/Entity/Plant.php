<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\CustomIdGenerator;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'user_plants')]
class Plant
{
  #[Id]
  #[Column(type: 'ulid', unique: true)]
  #[GeneratedValue(strategy: 'CUSTOM')]
  #[CustomIdGenerator(class: 'Symfony\Bridge\Doctrine\IdGenerator\UlidGenerator')]
  private $id;

  #[ManyToOne(targetEntity: 'App\Entity\User', inversedBy: 'plants')]
  private ?User $user;

  #[ManyToOne(targetEntity: 'App\Entity\Room', inversedBy: 'plants')]
  #[JoinColumn(name: 'room_id', nullable: true, onDelete: 'SET NULL')]
  private ?Room $room;

  #[OneToMany(mappedBy: 'plant', targetEntity: 'App\Entity\PlantPicture', cascade: ['persist', 'remove'])]
  private $plant_pictures;

  public function __construct()
  {
    $this->plant_pictures = new ArrayCollection();
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  /**
   * @return Collection|PlantPicture[]
   */
  public function getPlant_Pictures(): Collection
  {
    return $this->plant_pictures;
  }

  public function addPlantPicture(PlantPicture $plantPicture): self
  {
    if (!$this->plant_pictures->contains($plantPicture)) {
      $this->plant_pictures[] = $plantPicture;
      $plantPicture->setPlant($this);
    }

    return $this;
  }

  public function removePlantPicture(PlantPicture $plantPicture): self
  {
    if ($this->plant_pictures->contains($plantPicture)) {
      $this->plant_pictures->removeElement($plantPicture);
      // set the owning side to null (unless already changed)
      if ($plantPicture->getPlant() === $this) {
        $plantPicture->setPlant(null);
      }
    }

    return $this;
  }


  public function getUser(): ?User
  {
    return $this->user;
  }

  public function setUser(?User $user): self
  {
    $this->user = $user;

    return $this;
  }

  public function getRoom(): ?Room
  {
    return $this->room;
  }

  public function setRoom(?Room $room): self
  {
    $this->room = $room;

    return $this;
  }

  public function __toString()
  {
    return 'plant-' . $this->id;
  }
}
