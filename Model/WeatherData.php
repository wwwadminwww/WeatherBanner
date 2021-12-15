<?php
declare(strict_types=1);

namespace SD\WeatherBanner\Model;

use Magento\Framework\Model\AbstractModel;
use SD\WeatherBanner\Api\Data\WeatherDataInterface;

class WeatherData extends AbstractModel implements WeatherDataInterface
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\WeatherData::class);
    }

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->getData(WeatherDataInterface::ID);
    }

    /**
     * @inheritDoc
     */
    public function setId($id): WeatherDataInterface
    {
        return $this->setData(WeatherDataInterface::ID, $id);
    }

    /**
     * @inheritDoc
     */
    public function getCityName(): string
    {
        return $this->getData(WeatherDataInterface::CITY_NAME);
    }

    /**
     * @inheritDoc
     */
    public function setCityName(string $cityName): WeatherDataInterface
    {
        return $this->setData(WeatherDataInterface::CITY_NAME, $cityName);
    }

    /**
     * @inheritDoc
     */
    public function getTemperature(): float
    {
        return (float)$this->getData(WeatherDataInterface::TEMPERATURE);
    }

    /**
     * @inheritDoc
     */
    public function setTemperature(float $temperature): WeatherDataInterface
    {
        return $this->setData(WeatherDataInterface::TEMPERATURE, $temperature);
    }

    /**
     * @inheritDoc
     */
    public function getPressure(): int
    {
        return (int)$this->getData(WeatherDataInterface::PRESSURE);
    }

    /**
     * @inheritDoc
     */
    public function setPressure(int $pressure): WeatherDataInterface
    {
        return $this->setData(WeatherDataInterface::PRESSURE, $pressure);
    }

    /**
     * @inheritDoc
     */
    public function getHumidity(): int
    {
        return (int)$this->getData(WeatherDataInterface::HUMIDITY);
    }

    /**
     * @inheritDoc
     */
    public function setHumidity(int $humidity): WeatherDataInterface
    {
        return $this->setData(WeatherDataInterface::HUMIDITY, $humidity);
    }

    /**
     * @inheritDoc
     */
    public function getCreatedAt(): string
    {
        return $this->getData(WeatherDataInterface::CREATED_AT);
    }

    /**
     * @inheritDoc
     */
    public function setCreatedAt(string $createdAt): WeatherDataInterface
    {
        return $this->setData(WeatherDataInterface::CREATED_AT, $createdAt);
    }
}
