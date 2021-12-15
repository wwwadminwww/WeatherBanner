<?php
declare(strict_types=1);

namespace SD\WeatherBanner\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use SD\WeatherBanner\Api\Data\WeatherDataInterface;
use SD\WeatherBanner\Api\Data\WeatherDataSearchResultInterface;

interface WeatherDataRepositoryInterface
{
    /**
     * Get weather data entity by id
     *
     * @param int $id
     * @return WeatherDataInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): WeatherDataInterface;

    /**
     * Save weather data entity
     *
     * @param WeatherDataInterface $weatherData
     * @return WeatherDataInterface
     * @throws CouldNotSaveException
     */
    public function save(WeatherDataInterface $weatherData): WeatherDataInterface;

    /**
     * Delete weather data entity
     *
     * @param WeatherDataInterface $weatherData
     * @return bool
     * @throws StateException
     */
    public function delete(WeatherDataInterface $weatherData): bool;

    /**
     * Delete weather data entity by id
     *
     * @param int $id
     * @return bool
     * @throws NoSuchEntityException
     * @throws StateException
     */
    public function deleteById(int $id): bool;

    /**
     * Get list of weather data entities
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface;
}
