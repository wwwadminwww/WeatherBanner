<?php
declare(strict_types=1);

namespace SD\WeatherBanner\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use SD\WeatherBanner\Api\Data\WeatherDataInterface;

class WeatherData extends AbstractDb
{
    /**
     * @inheirtDoc
     */
    protected function _construct()
    {
        $this->_init('sd_weather_data', WeatherDataInterface::ID);
    }
}
