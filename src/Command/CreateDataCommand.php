<?php

namespace App\Command;

use App\Entity\Car;
use App\Entity\House;
use App\Entity\Owner;
use App\Entity\Seat;
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

  protected function configure()
  {
    $this->setDescription('Command to create data of the reproducer');
  }

  protected function execute(InputInterface $input, OutputInterface $output): int
  {
    $owner = new Owner();
    $house = new House();
    $car = new Car();

    $owner->addHouse($house);
    $owner->addCar($car);

    $house->addCar($car);

    $car->addSeat(new Seat());
    $car->addSeat(new Seat());
    $car->addSeat(new Seat());
    $car->addSeat(new Seat());

    $this->entityManager->persist($owner);
    $this->entityManager->flush();

    $output->writeln('Data created');

    return 0;
  }
}
