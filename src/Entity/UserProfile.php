<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\CustomIdGenerator;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'user_profiles')]
#[HasLifecycleCallbacks]
class UserProfile
{
  #[Id]
  #[Column(type: 'ulid', unique: true)]
  #[GeneratedValue(strategy: 'CUSTOM')]
  #[CustomIdGenerator(class: 'Symfony\Bridge\Doctrine\IdGenerator\UlidGenerator')]
  private $id;

  #[OneToOne(targetEntity: 'App\Entity\User')]
  #[JoinColumn(name: 'user_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
  private $user;


  public function __construct()
  {
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getUser(): ?User
  {
    return $this->user;
  }

  public function setUser(User $user): self
  {
    $this->user = $user;

    return $this;
  }

  public function __toString()
  {
    return 'profile-' . $this->id;
  }
}
