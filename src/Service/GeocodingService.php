<?php
  namespace App\Service;

  use Symfony\Contracts\HttpClient\HttpClientInterface;

  class GeocodingService {
    private HttpClientInterface $httpClient;
    
    public function __construct(HttpClientInterface $httpClient) {
      $this->httpClient = $httpClient;
    }
    
    public function geocode(string $address): ?array {
      if(!$address) return null;

      $url = 'https://api-adresse.data.gouv.fr/search/?q=' . urlencode($address) . '&limit=1';

      try {
        $res = $this->httpClient->request('GET', $url);
        $data = $res->toArray();

        if (empty($data['features'])) return null;

        $coords = $data['features'][0]['geometry']['coordinates'];
        return [
          'long' => $coords[0],
          'lat' => $coords[1]
        ];
      
      } catch (\Exception $err) {
        return null;
      }
    }
  }