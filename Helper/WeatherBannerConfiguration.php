<?php
declare(strict_types=1);

namespace SD\WeatherBanner\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class WeatherBannerConfiguration extends AbstractHelper
{
    protected const ENABLED_CONFIG_PATH = 'weather_banner/general/enable_weather_banner';
    protected const API_BASE_URL_CONFIG_PATH = 'weather_banner/api_configuration/base_url';
    protected const API_KEY_CONFIG_PATH = 'weather_banner/api_configuration/api_key';
    protected const CITY_NAME_CONFIG_PATH = 'weather_banner/api_configuration/city_name';
    protected const UNITS_OF_MEASUREMENT_CONFIG_PATH = 'weather_banner/api_configuration/units_of_measurement';

    /**
     * Checking if module is enabled
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return (bool)$this->scopeConfig->getValue(
            self::ENABLED_CONFIG_PATH,
            ScopeInterface::SCOPE_WEBSITE
        );
    }

    /**
     * Get API base URL
     *
     * @return mixed
     */
    public function getApiBaseUrl()
    {
        return $this->scopeConfig->getValue(self::API_BASE_URL_CONFIG_PATH);
    }

    /**
     * Get API key
     *
     * @return mixed
     */
    public function getApiKey()
    {
        return $this->scopeConfig->getValue(self::API_KEY_CONFIG_PATH);
    }

    /**
     * Get city name
     *
     * @return mixed
     */
    public function getCityName()
    {
        return $this->scopeConfig->getValue(
            self::CITY_NAME_CONFIG_PATH,
            ScopeInterface::SCOPE_WEBSITE
        );
    }

    /**
     * Get units of measurement
     *
     * @return mixed
     */
    public function getUnitsOfMeasurement()
    {
        return $this->scopeConfig->getValue(self::UNITS_OF_MEASUREMENT_CONFIG_PATH);
    }
}
