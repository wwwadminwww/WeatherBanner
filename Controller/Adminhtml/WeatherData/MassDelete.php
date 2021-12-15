<?php
declare(strict_types=1);

namespace SD\WeatherBanner\Controller\Adminhtml\WeatherData;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\NotFoundException;
use Magento\Ui\Component\MassAction\Filter;
use SD\WeatherBanner\Api\WeatherDataRepositoryInterface;
use SD\WeatherBanner\Model\ResourceModel\WeatherData\CollectionFactory;

class MassDelete extends Action implements HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'SD_WeatherBanner::weather_banner_data';

    private Filter $filter;
    private CollectionFactory $collectionFactory;
    private WeatherDataRepositoryInterface $weatherDataRepository;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param WeatherDataRepositoryInterface $weatherDataRepository
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        WeatherDataRepositoryInterface $weatherDataRepository
    ) {
        parent::__construct($context);
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->weatherDataRepository = $weatherDataRepository;
    }

    /**
     * @return Redirect
     * @throws NotFoundException
     * @throws \Magento\Framework\Exception\StateException
     */
    public function execute(): Redirect
    {
        if (!$this->getRequest()->isPost()) {
            throw new NotFoundException(__('Page not found'));
        }

        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $deletedItems = 0;
        foreach ($collection->getItems() as $weatherDataItem) {
            $this->weatherDataRepository->delete($weatherDataItem);
            $deletedItems++;
        }

        if ($deletedItems) {
            $this->messageManager->addSuccessMessage(
                __('A total of %1 record(s) have been deleted.', $deletedItems)
            );
        }
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)
            ->setPath('sd_weather_banner/weatherdata/index');
    }
}
