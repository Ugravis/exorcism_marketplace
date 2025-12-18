<?php
  namespace App\EventListener;

  use App\Entity\Booking;
  use App\Service\GeocodingService;
  use Doctrine\Persistence\Event\LifecycleEventArgs;

  class BookingListener {
    private GeocodingService $geocoder;
    
    public function __construct(GeocodingService $geocoder) {
      $this->geocoder = $geocoder;
    }

    public function prePersist(LifecycleEventArgs $args): void {
      $this->geocodeBooking($args);
    }

    public function preUpdate(LifecycleEventArgs $args): void {
      $this->geocodeBooking($args);
    }

    private function geocodeBooking(LifecycleEventArgs $args): void {
      $entity = $args->getObject();
      if (!$entity instanceof Booking) return;

      $address = $entity->getAddress();
      $city = $entity->getCity();
      $postal_code = $entity->getPostalCode();

      $fullAddress = "$address, $city, $postal_code";

      $coords = $this->geocoder->geocode($fullAddress);

      $entity->setLatitude($coords['lat'] ?? null);
      $entity->setLongitude($coords['long'] ?? null);
    }
  }