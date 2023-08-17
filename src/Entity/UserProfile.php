<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'user_profiles')]
class UserProfile
{
  #[Id]
  #[Column(type: 'integer')]
  #[GeneratedValue]
  private $id;

  #[OneToOne(targetEntity: 'App\Entity\User')]
  #[JoinColumn(onDelete: 'CASCADE')]
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
