<?php
declare(strict_types=1);

namespace SD\WeatherBanner\ViewModel;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Psr\Log\LoggerInterface;
use SD\WeatherBanner\Api\Data\WeatherDataInterface;
use SD\WeatherBanner\Api\WeatherDataRepositoryInterface;
use SD\WeatherBanner\Helper\WeatherBannerConfiguration;

class WeatherBannerViewModel implements ArgumentInterface
{
    protected ?WeatherDataInterface $weatherData = null;
    protected WeatherBannerConfiguration $weatherBannerConfiguration;
    private SearchCriteriaBuilder $searchCriteriaBuilder;
    private SortOrderBuilder $sortOrderBuilder;
    private WeatherDataRepositoryInterface $weatherDataRepository;
    private LoggerInterface $logger;

    /**
     * @param WeatherBannerConfiguration $weatherBannerConfiguration
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param SortOrderBuilder $sortOrderBuilder
     * @param WeatherDataRepositoryInterface $weatherDataRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        WeatherBannerConfiguration $weatherBannerConfiguration,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SortOrderBuilder $sortOrderBuilder,
        WeatherDataRepositoryInterface $weatherDataRepository,
        LoggerInterface $logger
    ) {
        $this->weatherBannerConfiguration = $weatherBannerConfiguration;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->weatherDataRepository = $weatherDataRepository;
        $this->logger = $logger;
    }

    /**
     * Get weather data
     *
     * @return WeatherDataInterface|null
     */
    public function getWeatherData(): ?WeatherDataInterface
    {
        if ($this->weatherData === null) {
            $this->weatherData = $this->getLatestWeatherData();
        }

        return $this->weatherData;
    }

    /**
     * Get city name
     *
     * @return string
     */
    public function getCityName(): string
    {
        if ($this->getWeatherData() !== null) {
            return $this->getWeatherData()->getCityName();
        }

        return '';
    }

    /**
     * Get temperature
     *
     * @return string
     */
    public function getTemperature(): string
    {
        if ($this->getWeatherData() !== null) {
            return (string)$this->getWeatherData()->getTemperature();
        }

        return '';
    }

    /**
     * Get pressure
     *
     * @return string
     */
    public function getPressure(): string
    {
        if ($this->getWeatherData() !== null) {
            return (string)$this->getWeatherData()->getPressure();
        }

        return '';
    }

    /**
     * Get humidity
     *
     * @return string
     */
    public function getHumidity(): string
    {
        if ($this->getWeatherData() !== null) {
            return (string)$this->getWeatherData()->getHumidity();
        }

        return '';
    }

    /**
     * Get the latest weather data
     *
     * @return WeatherDataInterface|null
     */
    protected function getLatestWeatherData(): ?WeatherDataInterface
    {
        try {
            $sortOrder = $this->sortOrderBuilder
                ->setField(WeatherDataInterface::ID)
                ->setDirection(SortOrder::SORT_DESC)
                ->create();
            $searchCriteria = $this->searchCriteriaBuilder
                ->setSortOrders([$sortOrder])
                ->setPageSize(1)
                ->setCurrentPage(1)
                ->create();
            $items = $this->weatherDataRepository->getList($searchCriteria)->getItems();
            if (count($items) > 0) {
                return array_shift($items);
            }

            return null;
        } catch (\Exception $exception) {
            $this->logger->debug('WeatherBanner Block can\'t retrieve weather data. ' . $exception->getMessage());
        }

        return null;
    }
}
