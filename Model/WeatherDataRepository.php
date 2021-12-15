<?php
declare(strict_types=1);

namespace SD\WeatherBanner\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResults;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use SD\WeatherBanner\Api\Data\WeatherDataInterface;
use SD\WeatherBanner\Api\Data\WeatherDataSearchResultInterfaceFactory;
use SD\WeatherBanner\Api\WeatherDataRepositoryInterface;
use SD\WeatherBanner\Model\WeatherDataFactory;
use SD\WeatherBanner\Model\ResourceModel\WeatherData as WeatherDataResource;
use SD\WeatherBanner\Model\ResourceModel\WeatherData\CollectionFactory as WeatherDataCollectionFactory;

class WeatherDataRepository implements WeatherDataRepositoryInterface
{
    private WeatherDataFactory $weatherDataFactory;
    private WeatherDataResource $weatherDataResource;
    private WeatherDataCollectionFactory $weatherDataCollectionFactory;
    private CollectionProcessorInterface $collectionProcessor;
    private WeatherDataSearchResultInterfaceFactory $weatherDataSearchResultFactory;

    /**
     * @param WeatherDataFactory $weatherDataFactory
     * @param WeatherDataResource $weatherDataResource
     * @param WeatherDataCollectionFactory $weatherDataCollectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param WeatherDataSearchResultInterfaceFactory $weatherDataSearchResultFactory
     */
    public function __construct(
        WeatherDataFactory $weatherDataFactory,
        WeatherDataResource $weatherDataResource,
        WeatherDataCollectionFactory $weatherDataCollectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        WeatherDataSearchResultInterfaceFactory $weatherDataSearchResultFactory
    ) {
        $this->weatherDataFactory = $weatherDataFactory;
        $this->weatherDataResource = $weatherDataResource;
        $this->weatherDataCollectionFactory = $weatherDataCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->weatherDataSearchResultFactory = $weatherDataSearchResultFactory;
    }

    /**
     * @param int $id
     * @return WeatherDataInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): WeatherDataInterface
    {
        $model = $this->weatherDataFactory->create();
        $this->weatherDataResource->load($model, $id);
        if (!$model->getId()) {
            throw new NoSuchEntityException(__('Weather data entity with id `%1` does not exist.', $id));
        }

        return $model;
    }

    /**
     * @param WeatherDataInterface $weatherData
     * @return WeatherDataInterface
     * @throws CouldNotSaveException
     */
    public function save(WeatherDataInterface $weatherData): WeatherDataInterface
    {
        try {
            $this->weatherDataResource->save($weatherData);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __(
                    'Could not save weather data entity: %1',
                    $weatherData->getId()
                ),
                $exception
            );
        }

        return $weatherData;
    }

    /**
     * @param WeatherDataInterface $weatherData
     * @return bool
     * @throws StateException
     */
    public function delete(WeatherDataInterface $weatherData): bool
    {
        try {
            $this->weatherDataResource->delete($weatherData);
        } catch (\Exception $exception) {
            throw new StateException(
                __(
                    'Cannot delete weather data entity with id %1',
                    $weatherData->getId()
                ),
                $exception
            );
        }

        return true;
    }

    /**
     * @param int $id
     * @return bool
     * @throws NoSuchEntityException
     * @throws StateException
     */
    public function deleteById(int $id): bool
    {
        return $this->delete($this->getById($id));
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface
    {
        $collection = $this->weatherDataCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);

        /**
         * @var SearchResults $searchResults
         */
        $searchResults = $this->weatherDataSearchResultFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}
