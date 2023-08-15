<?php

namespace App\Command;

use App\Entity\Plant;
use App\Entity\PlantPicture;
use App\Entity\Room;
use App\Entity\User;
use App\Entity\UserProfile;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('reproducer:create_data')]
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
    $this->setDescription('Command to create data of the reproducer');
  }

  protected function execute(InputInterface $input, OutputInterface $output): int
  {
    $user = new User();
    $profile = new UserProfile();

    $user->setProfile($profile);

    $nb_rooms = random_int(1, 5);

    for ($i = 1; $i < $nb_rooms; $i++) {
      $room = new Room();

      $nb_plants = random_int(0, 3);

      for ($j = 0; $j < $nb_plants; $j++) {
        $plant = new Plant();

        $nb_plant_pictures = random_int(0, 3);

        for ($k = 0; $k < $nb_plant_pictures; $k++) {
          $plant->addPlantPicture(new PlantPicture());
        }

        $user->addPlant($plant);
        $room->addPlant($plant);
      }

      $user->addRoom($room);
    }

    $this->entityManager->persist($user);
    $this->entityManager->flush();

    $output->writeln('Data created');

    return 0;
  }
}
