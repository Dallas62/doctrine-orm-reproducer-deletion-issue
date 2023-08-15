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
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'user_rooms')]
#[HasLifecycleCallbacks]
class Room
{
  #[Id]
  #[Column(type: 'ulid', unique: true)]
  #[GeneratedValue(strategy: 'CUSTOM')]
  #[CustomIdGenerator(class: 'Symfony\Bridge\Doctrine\IdGenerator\UlidGenerator')]
  private $id;

  #[ManyToOne(targetEntity: 'App\Entity\User', inversedBy: 'rooms')]
  #[JoinColumn(name: 'user_id', nullable: false)]
  private ?User $user;

  #[OneToMany(mappedBy: 'room', targetEntity: 'App\Entity\Plant')]
  private $plants;

  public function __construct()
  {
    $this->plants = new ArrayCollection();
  }

  public function getId(): ?int
  {
    return $this->id;
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
      $plant->setRoom($this);
    }

    return $this;
  }

  public function removePlant(Plant $plant): self
  {
    if ($this->plants->contains($plant)) {
      $this->plants->removeElement($plant);
      // set the owning side to null (unless already changed)
      if ($plant->getRoom() === $this) {
        $plant->setRoom(null);
      }
    }

    return $this;
  }

  public function __toString()
  {
    return 'room-' . $this->id;
  }
}
