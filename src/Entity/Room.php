<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

#[Entity]
class Room
{
  #[Id]
  #[Column(type: 'integer')]
  #[GeneratedValue]
  public $id;

  #[ManyToOne(targetEntity: 'App\Entity\User', inversedBy: 'rooms')]
  #[JoinColumn(nullable: false)]
  public ?User $user;
}
