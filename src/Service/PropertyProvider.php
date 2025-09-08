<?php
namespace App\Service;

class PropertyProvider
{
    private const PROPERTIES = [
        [
            'id' => 1,
            'title' => 'Charmant appartement T2',
            'description' => 'Bel appartement rénové avec goût...',
            'img' => '/uploads/properties/appartement1.webp',
            'transaction' => 'rent',
            'price' => 750,
            'city' => 'Lyon',
            'propertyTypeId' => 2,
            'userId' => 1,
        ],
        [
            'id' => 2,
            'title' => 'Maison familiale avec jardin',
            'description' => 'Grande maison de 120m²...',
            'img' => '/uploads/properties/maison1.webp',
            'transaction' => 'sale',
            'price' => 325000,
            'city' => 'Grenoble',
            'propertyTypeId' => 1,
            'userId' =>1 ,
        ],
        [
            'id' => 3,
            'title' => 'Studio meublé moderne',
            'description' => 'Studio de 25m² entièrement équipé...',
            'img' => '/uploads/properties/studio1.webp',
            'transaction' => 'rent',
            'price' => 550,
            'city' => 'Chambéry',
            'propertyTypeId' => 2,
            'userId' => 1,
        ]
    ];

    public function getAllProperties(): array
    {
        return self::PROPERTIES;
    }

    public function getPropertiesByType(int $propertyTypeId): array
    {
        return array_filter(self::PROPERTIES, fn($p) => $p['propertyTypeId'] === $propertyTypeId);
    }
}