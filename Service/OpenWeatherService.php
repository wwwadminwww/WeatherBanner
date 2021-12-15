<?php
declare(strict_types=1);

namespace SD\WeatherBanner\Service;

use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\Serialize\Serializer\Json as JsonSerializer;
use Psr\Log\LoggerInterface;
use SD\WeatherBanner\Helper\WeatherBannerConfiguration;

class OpenWeatherService
{
    private Curl $curl;
    private WeatherBannerConfiguration $weatherBannerConfiguration;
    private JsonSerializer $jsonSerializer;
    private LoggerInterface $logger;

    /**
     * @param Curl $curl
     * @param WeatherBannerConfiguration $weatherBannerConfiguration
     * @param JsonSerializer $jsonSerializer
     * @param LoggerInterface $logger
     */
    public function __construct(
        Curl $curl,
        WeatherBannerConfiguration $weatherBannerConfiguration,
        JsonSerializer $jsonSerializer,
        LoggerInterface $logger
    ) {
        $this->curl = $curl;
        $this->weatherBannerConfiguration = $weatherBannerConfiguration;
        $this->jsonSerializer = $jsonSerializer;
        $this->logger = $logger;
    }

    /**
     * Get weather data
     *
     * @return array|null
     */
    public function getWeatherData(): ?array
    {
        $baseUrl = $this->weatherBannerConfiguration->getApiBaseUrl();
        $params = http_build_query($this->getParams());
        $requestUrl = $baseUrl . '?' . $params;

        $this->curl->get($requestUrl);
        if ($this->curl->getStatus() !== 200) {
            $response = $this->curl->getBody();
            $this->logger->debug('OpenWeather bad request: ' . $response);
            return null;
        }

        $response = $this->jsonSerializer->unserialize($this->curl->getBody());
        if (!isset($response['main'])) {
            $this->logger->debug('OpenWeatherService got incorrect data from the API service.');
            return null;
        }

        return $response['main'];
    }

    /**
     * Get request params
     *
     * @return array
     */
    protected function getParams(): array
    {
        return [
            'q' => $this->weatherBannerConfiguration->getCityName(),
            'appid' => $this->weatherBannerConfiguration->getApiKey(),
            'units' => $this->weatherBannerConfiguration->getUnitsOfMeasurement()
        ];
    }
}
