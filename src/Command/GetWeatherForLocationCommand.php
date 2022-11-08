<?php

namespace App\Command;

use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[AsCommand(
    name: 'GetWeatherByLocation',
    description: 'Get weather by location ID',
)]
class GetWeatherForLocationCommand extends Command
{
    protected function configure(): void
    {
        $this->addArgument('id', InputArgument::REQUIRED, 'Location ID');;
    }

    public function __construct(WeatherUtil $weatherUtil, SerializerInterface $serializer, string $name = null)
    {
        $this->weatherUtil = $weatherUtil;
        $this->serializer = $serializer;
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $id = $input->getArgument('id');

        $weathers = $this->weatherUtil->GetWeatherByLocationId($id);

        foreach ($weathers as $weather)
        {
            $output->writeln($this->serializer->serialize($weather, 'json'));
        }
        return Command::SUCCESS;
    }
}