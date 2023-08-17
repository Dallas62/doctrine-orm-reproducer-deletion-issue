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
class User
{
  #[Id]
  #[Column(type: 'integer')]
  #[GeneratedValue]
  public $id;

  #[OneToOne(targetEntity: 'App\Entity\UserProfile', cascade: ['persist', 'remove'])]
  #[JoinColumn(onDelete: 'CASCADE')]
  public $profile;

  #[OneToMany(mappedBy: 'user', targetEntity: 'App\Entity\Room', cascade: ['persist', 'remove'], orphanRemoval: true)]
  public $rooms;

  public function __construct()
  {
    $this->rooms = new ArrayCollection();
  }
}
