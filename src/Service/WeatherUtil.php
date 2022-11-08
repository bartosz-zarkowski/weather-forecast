<?php
namespace App\Service;

use App\Entity\Location;
use App\Repository\MeasurementRepository;
use App\Repository\LocationRepository;

class WeatherUtil
{
    private MeasurementRepository $measurementRepository;
    private LocationRepository $locationRepository;

    public function __construct(LocationRepository $locationRepository, MeasurementRepository $measurementRepository)
    {
        $this->measurementRepository = $measurementRepository;
        $this->locationRepository = $locationRepository;
    }

    public function  getLocationForCountryCity($countryCode, $cityName): Location
    {
        return $this->locationRepository->findByCountryCity($countryCode, $cityName);
    }

    public function getWeatherForLocation($location): Array
    {
        return $this->measurementRepository->findByLocation($location);
    }

    public function getWeatherForCountryAndCity($countryCode, $cityName): Array
    {
        $location = $this->getLocationForCountryCity($countryCode, $cityName);
        return $this->getWeatherForLocation($location);
    }

    public function GetWeatherByLocationId($id): Array
    {
        $location = $this->locationRepository->findById($id);
        return $this->getWeatherForLocation($location);
    }
}