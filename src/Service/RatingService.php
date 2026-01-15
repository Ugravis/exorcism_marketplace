<?php
    namespace App\Service;

    use App\Entity\Service;

    class RatingService
    {
        public function getAverageRating(Service $service): float
        {
            $reviews = $service->getReviews();

            if (count($reviews) === 0) {
                return 0;
            }

            $sum = 0;
            foreach ($reviews as $review) {
                $sum += $review->getRating();
            }

            return round(($sum / count($reviews)) * 2) / 2;
        }
    }