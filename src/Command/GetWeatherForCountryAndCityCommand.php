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
    name: 'GetWeatherForCountryAndCity',
    description: 'Add a short description for your command',
)]
class GetWeatherForCountryAndCityCommand extends Command
{
    private WeatherUtil $weatherUtil;
    private SerializerInterface $serializer;

    protected function configure(): void
    {
        $this->addArgument('country', InputArgument::REQUIRED, 'Country code')
             ->addArgument('city', InputArgument::REQUIRED, 'City name');
    }

    public function __construct(WeatherUtil $weatherUtil, SerializerInterface $serializer, string $name = null)
    {
        $this->weatherUtil = $weatherUtil;
        $this->serializer = $serializer;
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $country = $input->getArgument('country');
        $city = $input->getArgument('city');

        $weathers = $this->weatherUtil->getWeatherForCountryAndCity($country, $city);
        foreach ($weathers as $weather)
        {
            $output->writeln($this->serializer->serialize($weather, 'json'));
        }

        return Command::SUCCESS;
    }
}
