<?php

namespace App\Controller;

use App\Repository\MeasurementRepository;
use App\Repository\LocationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class WeatherController extends AbstractController
{
    public function cityAction(string $city, string $country, MeasurementRepository $measurementRepository, LocationRepository $locationRepository): Response
    {
        $location = $locationRepository->findByCountryCity($country, $city);
        $measurements = $measurementRepository->findByLocation($location);
        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'measurements' => $measurements,
        ]);
    }
}