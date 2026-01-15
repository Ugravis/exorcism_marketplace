<?php
namespace App\Twig;

use App\Entity\Service;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class RatingExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'rating_stars',
                [$this, 'renderStars'],
                ['is_safe' => ['html']]
            ),
        ];
    }

    public function renderStars($input): string
    {
        $html = '';

        if ($input instanceof Service) {
            $reviews = $input->getReviews();
            if (count($reviews) === 0) {
                for ($i = 1; $i <= 5; $i++) {
                    $html .= '<i class="star empty">★</i>';
                }
                return $html;
            }

            $sum = 0;
            foreach ($reviews as $review) {
                $sum += $review->getRating();
            }

            $rating = round(($sum / count($reviews)) * 2) / 2;
        } else {
            $rating = round($input * 2) / 2;
        }

        $fullStars = floor($rating);
        $halfStar = ($rating - $fullStars) === 0.5;

        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $fullStars) {
                $html .= '<i class="star full">★</i>';
            } elseif ($halfStar && $i === $fullStars + 1) {
                $html .= '<i class="star half">★</i>';
            } else {
                $html .= '<i class="star empty">★</i>';
            }
        }

        return $html;
    }
}