<?php
declare(strict_types=1);

namespace SD\WeatherBanner\Api\Data;

interface WeatherDataSearchResultInterface
{
    /**
     * Get items
     *
     * @return WeatherDataInterface[]
     */
    public function getItems();

    /**
     * Set items
     *
     * @param WeatherDataInterface[] $items
     * @return mixed
     */
    public function setItems($items);
}
