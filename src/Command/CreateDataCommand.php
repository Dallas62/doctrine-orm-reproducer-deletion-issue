<?php

namespace App\Command;

use App\Entity\Room;
use App\Entity\User;
use App\Entity\UserProfile;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('reproduce')]
class CreateDataCommand extends Command
{
  private EntityManagerInterface $entityManager;

  public function __construct(
    EntityManagerInterface $entityManager
  )
  {
    $this->entityManager = $entityManager;

    parent::__construct();
  }

  protected function configure(): void
  {
    $this->setDescription('Command reproduce issue');
  }

  protected function execute(InputInterface $input, OutputInterface $output): int
  {
    $metaData = $this->entityManager->getMetadataFactory()->getAllMetadata();
    $schemaTool = new SchemaTool($this->entityManager);
    $schemaTool->updateSchema($metaData);

    $user = new User();
    $profile = new UserProfile();
    $room = new Room();

    $user->rooms->add($room);
    $user->profile = $profile;
    $room->user = $user;
    $profile->user = $user;

    $this->entityManager->persist($user);
    $this->entityManager->flush();

    $output->writeln('Data created');

    $this->entityManager->clear();

    $one_user = $this->entityManager->getRepository(User::class)->findOneBy([]);

    $this->entityManager->remove($one_user);
    $this->entityManager->flush();

    $output->writeln('Data deleted');

    return 0;
  }
}
