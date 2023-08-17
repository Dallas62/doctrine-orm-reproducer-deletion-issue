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
class Room
{
  #[Id]
  #[Column(type: 'integer')]
  #[GeneratedValue]
  private $id;

  #[ManyToOne(targetEntity: 'App\Entity\User', inversedBy: 'rooms')]
  #[JoinColumn(name: 'user_id', nullable: false)]
  private ?User $user;

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

  public function __toString()
  {
    return 'room-' . $this->id;
  }
}
