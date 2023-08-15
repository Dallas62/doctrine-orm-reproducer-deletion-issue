<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\CustomIdGenerator;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'users')]
#[HasLifecycleCallbacks]
class User
{
  #[Id]
  #[Column(type: 'ulid', unique: true)]
  #[GeneratedValue(strategy: 'CUSTOM')]
  #[CustomIdGenerator(class: 'Symfony\Bridge\Doctrine\IdGenerator\UlidGenerator')]
  private $id;

  #[OneToOne(targetEntity: 'App\Entity\UserProfile', cascade: ['persist', 'remove'])]
  #[JoinColumn(name: 'profile_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
  private $profile;

  #[OneToMany(mappedBy: 'user', targetEntity: 'App\Entity\Room', cascade: ['persist', 'remove'], orphanRemoval: true)]
  private $rooms;

  #[OneToMany(mappedBy: 'user', targetEntity: 'App\Entity\Plant', cascade: ['persist', 'remove'], orphanRemoval: true)]
  private $plants;

  public function __construct()
  {
    $this->rooms = new ArrayCollection();
    $this->plants = new ArrayCollection();
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getProfile(): ?UserProfile
  {
    return $this->profile;
  }

  public function setProfile(UserProfile $profile): self
  {
    if ($profile->getUser() == null) {
      $profile->setUser($this);
    }

    $this->profile = $profile;

    return $this;
  }

  /**
   * @return Collection|Room[]
   */
  public function getRooms(): Collection
  {
    return $this->rooms;
  }

  public function addRoom(Room $house): self
  {
    if (!$this->rooms->contains($house)) {
      $this->rooms[] = $house;
      $house->setUser($this);
    }

    return $this;
  }

  public function removeRoom(Room $house): self
  {
    if ($this->rooms->contains($house)) {
      $this->rooms->removeElement($house);
      // set the owning side to null (unless already changed)
      if ($house->getUser() === $this) {
        $house->setUser(null);
      }
    }

    return $this;
  }

  /**
   * @return Collection|Plant[]
   */
  public function getPlants(): Collection
  {
    return $this->plants;
  }

  public function addPlant(Plant $plant): self
  {
    if (!$this->plants->contains($plant)) {
      $this->plants[] = $plant;
      $plant->setUser($this);
    }

    return $this;
  }

  public function removePlant(Plant $plant): self
  {
    if ($this->plants->contains($plant)) {
      $this->plants->removeElement($plant);
      // set the owning side to null (unless already changed)
      if ($plant->getUser() === $this) {
        $plant->setUser(null);
      }
    }

    return $this;
  }

  public function __toString()
  {
    return 'user-' . $this->id;
  }
}
