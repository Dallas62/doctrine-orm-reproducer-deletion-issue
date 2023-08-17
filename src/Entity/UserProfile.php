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
class UserProfile
{
  #[Id]
  #[Column(type: 'integer')]
  #[GeneratedValue]
  public $id;

  #[OneToOne(targetEntity: 'App\Entity\User')]
  #[JoinColumn(onDelete: 'CASCADE')]
  public $user;
}
