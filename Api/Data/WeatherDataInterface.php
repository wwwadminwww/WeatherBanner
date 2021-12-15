<?php
declare(strict_types=1);

namespace SD\WeatherBanner\Api\Data;

interface WeatherDataInterface
{
    public const ID = 'id';
    public const CITY_NAME = 'city_name';
    public const TEMPERATURE = 'temperature';
    public const HUMIDITY = 'humidity';
    public const PRESSURE = 'pressure';
    public const CREATED_AT = 'created_at';

    /**
     * Get entity id
     *
     * @return mixed
     */
    public function getId();

    /**
     * Set entity id
     *
     * @param mixed $id
     * @return $this
     */
    public function setId($id): self;

    /**
     * Get city name
     *
     * @return string
     */
    public function getCityName(): string;

    /**
     * Set city name
     *
     * @param string $cityName
     * @return $this
     */
    public function setCityName(string $cityName): self;

    /**
     * Get temperature
     *
     * @return float
     */
    public function getTemperature(): float;

    /**
     * Set temperature
     *
     * @param float $temperature
     * @return $this
     */
    public function setTemperature(float $temperature): self;

    /**
     * Get pressure
     *
     * @return int
     */
    public function getPressure(): int;

    /**
     * Set pressure
     *
     * @param int $pressure
     * @return $this
     */
    public function setPressure(int $pressure): self;

    /**
     * Get humidity
     *
     * @return int
     */
    public function getHumidity(): int;

    /**
     * Set humidity
     *
     * @param int $humidity
     * @return $this
     */
    public function setHumidity(int $humidity): self;

    /**
     * Get created at
     *
     * @return string
     */
    public function getCreatedAt(): string;

    /**
     * Set created at
     *
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt(string $createdAt): self;
}
