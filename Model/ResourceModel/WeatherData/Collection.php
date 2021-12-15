<?php
declare(strict_types=1);

namespace SD\WeatherBanner\Model\ResourceModel\WeatherData;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use SD\WeatherBanner\Api\Data\WeatherDataInterface;
use SD\WeatherBanner\Model\ResourceModel\WeatherData as WeatherDataResource;
use SD\WeatherBanner\Model\WeatherData;

class Collection extends AbstractCollection
{
    /**
     * @inheritDoc
     */
    protected $_idFieldName = WeatherDataInterface::ID;

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(WeatherData::class, WeatherDataResource::class);
    }
}
