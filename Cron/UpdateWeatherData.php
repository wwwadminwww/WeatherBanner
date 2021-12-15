<?php
declare(strict_types=1);

namespace SD\WeatherBanner\Cron;

use Psr\Log\LoggerInterface;
use SD\WeatherBanner\Api\WeatherDataRepositoryInterface;
use SD\WeatherBanner\Helper\WeatherBannerConfiguration;
use SD\WeatherBanner\Model\WeatherData;
use SD\WeatherBanner\Model\WeatherDataFactory;
use SD\WeatherBanner\Service\OpenWeatherService;

class UpdateWeatherData
{
    private OpenWeatherService $openWeatherService;
    private WeatherDataFactory $weatherDataFactory;
    private WeatherDataRepositoryInterface $weatherDataRepository;
    private WeatherBannerConfiguration $weatherBannerConfiguration;
    private LoggerInterface $logger;

    /**
     * @param OpenWeatherService $openWeatherService
     * @param WeatherDataFactory $weatherDataFactory
     * @param WeatherDataRepositoryInterface $weatherDataRepository
     * @param WeatherBannerConfiguration $weatherBannerConfiguration
     * @param LoggerInterface $logger
     */
    public function __construct(
        OpenWeatherService $openWeatherService,
        WeatherDataFactory $weatherDataFactory,
        WeatherDataRepositoryInterface $weatherDataRepository,
        WeatherBannerConfiguration $weatherBannerConfiguration,
        LoggerInterface $logger
    ) {
        $this->openWeatherService = $openWeatherService;
        $this->weatherDataFactory = $weatherDataFactory;
        $this->weatherDataRepository = $weatherDataRepository;
        $this->weatherBannerConfiguration = $weatherBannerConfiguration;
        $this->logger = $logger;
    }

    /**
     * Get new weather data and save in DB
     *
     * @return void
     */
    public function execute(): void
    {
        if ($this->weatherBannerConfiguration->isEnabled()) {
            try {
                $weatherData = $this->openWeatherService->getWeatherData();
                if ($weatherData === null) {
                    $this->logger->debug('UpdateWeatherData got empty data.');
                    return;
                }
                /** @var WeatherData $weatherDataModel */
                $weatherDataModel = $this->weatherDataFactory->create();
                $weatherDataModel->setCityName($this->weatherBannerConfiguration->getCityName());
                $weatherDataModel->setTemperature((float)$weatherData['temp']);
                $weatherDataModel->setPressure((int)$weatherData['pressure']);
                $weatherDataModel->setHumidity((int)$weatherData['humidity']);
                $this->weatherDataRepository->save($weatherDataModel);
            } catch (\Exception $exception) {
                $this->logger->warning('UpdateWeatherData error: ' . $exception->getMessage());
            }
        }
    }
}
