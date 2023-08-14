<?php

namespace App\Command;

use App\Entity\Owner;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('reproducer:delete_data')]
class DeleteDataCommand extends Command
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
    $this->setDescription('Command to reproduce the deletion issue');
  }

  protected function execute(InputInterface $input, OutputInterface $output): int
  {
    $one_owner = $this->entityManager->getRepository(Owner::class)->findOneBy([]);

    if (!$one_owner) {
      $output->writeln('Please create data first');
      return 1;
    }

    $this->entityManager->remove($one_owner);
    $this->entityManager->flush();

    $output->writeln('Data deleted');

    return 0;
  }
}
