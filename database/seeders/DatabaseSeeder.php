<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Property;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Models\Content;
use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Dolza',
            'email' => 'dolza@admin.com',
            'password' => Hash::make('Dolza2008!'),
            'is_admin' => true,
        ]);

        $properties = [
            ['id' => 'seed-1', 'name' => 'Prime Plot - Area 47', 'type' => 'land', 'location' => 'Lilongwe', 'price' => 8500000, 'details' => '800 sqm plot in prime location', 'status' => 'approved', 'image' => '/images/property1.jpg', 'featured' => true, 'bedrooms' => '', 'bathrooms' => '', 'area' => '800 sqm'],
            ['id' => 'seed-2', 'name' => 'Farm Land - Salima', 'type' => 'farms', 'location' => 'Salima', 'price' => 25000000, 'details' => '5 acres fertile farmland with water access', 'status' => 'approved', 'image' => '/images/property2.jpg', 'featured' => true, 'bedrooms' => '', 'bathrooms' => '', 'area' => '5 acres'],
            ['id' => 'seed-3', 'name' => '3 Bedroom House', 'type' => 'residential', 'location' => 'Salima', 'price' => 18000000, 'details' => '3 beds · 2 baths - Modern residential house', 'status' => 'approved', 'image' => '/images/property3.jpg', 'featured' => true, 'bedrooms' => '3', 'bathrooms' => '2', 'area' => ''],
            ['id' => 'seed-4', 'name' => 'Commercial Plot', 'type' => 'commercial', 'location' => 'Blantyre', 'price' => 35000000, 'details' => '1200 sqm commercial plot', 'status' => 'approved', 'image' => '/images/property4.jpg', 'featured' => true, 'bedrooms' => '', 'bathrooms' => '', 'area' => '1200 sqm'],
            ['id' => 'seed-5', 'name' => 'Residential Plot - Zomba', 'type' => 'land', 'location' => 'Zomba', 'price' => 6500000, 'details' => '600 sqm residential plot', 'status' => 'approved', 'image' => '/images/property5.jpg', 'featured' => false, 'bedrooms' => '', 'bathrooms' => '', 'area' => '600 sqm'],
            ['id' => 'seed-6', 'name' => 'Agriculture Farm - Kasungu', 'type' => 'farms', 'location' => 'Kasungu', 'price' => 45000000, 'details' => '12 acres agriculture farm', 'status' => 'approved', 'image' => '/images/property6.jpg', 'featured' => true, 'bedrooms' => '', 'bathrooms' => '', 'area' => '12 acres'],
            ['id' => 'seed-7', 'name' => '2 Bedroom House for Rent', 'type' => 'rentals', 'location' => 'Salima', 'price' => 120000, 'details' => '2 beds · 1 bath - Cozy rental house', 'status' => 'approved', 'image' => '/images/two_bed_house.png', 'featured' => false, 'bedrooms' => '2', 'bathrooms' => '1', 'area' => ''],
            ['id' => 'seed-8', 'name' => 'Shop Space - Town Centre', 'type' => 'commercial', 'location' => 'Salima', 'price' => 85000, 'details' => '45 sqm prime shop space', 'status' => 'approved', 'image' => '/images/property2.jpg', 'featured' => false, 'bedrooms' => '', 'bathrooms' => '', 'area' => '45 sqm'],
            ['id' => 'seed-9', 'name' => 'Large Farm - Dowa', 'type' => 'farms', 'location' => 'Dowa', 'price' => 60000000, 'details' => '20 acres with title deed', 'status' => 'approved', 'image' => '/images/large_dowa_farm.png', 'featured' => false, 'bedrooms' => '', 'bathrooms' => '', 'area' => '20 acres'],
        ];

        foreach ($properties as $p) {
            Property::create($p);
        }

        Content::create([
            'section' => 'hero',
            'data' => [
                'title' => 'Your Trusted Partner for Land, Farms & Property in Malawi',
                'subtitle' => "Buy · Build · Invest — Salima's Most Trusted Real Estate Agency",
                'buttonText' => 'View Properties',
                'buttonLink' => '/properties',
                'backgroundImage' => '',
                'badge' => 'Premium Real Estate',
            ],
        ]);

        Content::create([
            'section' => 'about',
            'data' => [
                'heading' => 'Our Story',
                'content' => "Established in 2016, Dolza Real Properties & Estate Agency has grown to become Salima's most trusted real estate partner. Founded by Malawian real estate expert Patrick Weston Kamefu, our agency was born from a vision to provide professional, transparent, and reliable property services across Malawi. Over the past 8+ years, we've helped hundreds of clients buy, sell, and develop properties throughout Salima, Lilongwe, Blantyre, and beyond.",
                'stats' => [
                    ['number' => '8+', 'label' => 'Years Experience'],
                    ['number' => '500+', 'label' => 'Properties Sold'],
                    ['number' => '350+', 'label' => 'Satisfied Clients'],
                    ['number' => '3', 'label' => 'Districts Covered'],
                ],
            ],
        ]);

        Content::create([
            'section' => 'services',
            'data' => [
                ['title' => 'We Sell Properties', 'description' => 'Find your perfect property from our curated selection of premium listings.', 'icon' => 'fa-home'],
                ['title' => 'We Buy Properties', 'description' => 'We offer fair prices for your land and property with quick cash purchases.', 'icon' => 'fa-tag'],
                ['title' => 'Land Surveying', 'description' => 'Professional land surveying and boundary marking services.', 'icon' => 'fa-draw-polygon'],
                ['title' => 'Title Deed Processing', 'description' => 'We handle all title deed and legal documentation for smooth transactions.', 'icon' => 'fa-file-signature'],
                ['title' => 'Business Advertisement', 'description' => 'Advertise your business to thousands of potential clients across Malawi.', 'icon' => 'fa-bullhorn'],
                ['title' => 'Property Development Consultation', 'description' => 'Expert guidance on land suitability and development potential.', 'icon' => 'fa-compass'],
            ],
        ]);

        Content::create([
            'section' => 'footer',
            'data' => [
                'about' => 'Your trusted partner for real estate solutions in Malawi. Buy · Build · Invest with confidence.',
                'email' => 'dolzaestateagency@gmail.com',
                'phone' => '+265 994 369 985',
                'address' => 'Salima Office, Malawi',
            ],
        ]);

        TeamMember::create(['id' => 'team-1', 'name' => 'Patrick Weston Kamefu', 'role' => 'CEO & Founder', 'bio' => 'With over 15 years of experience in the Malawian real estate market, Patrick brings deep local knowledge and an extensive network of contacts.', 'image' => '/images/patrick.jpg', 'email' => 'patrick@dolzaproperties.com', 'phone' => '+265 994 369 985']);
        TeamMember::create(['id' => 'team-2', 'name' => 'Grace Kamangale', 'role' => 'Head Surveyor', 'bio' => 'Grace has been with Dolza since 2018 and brings precision and expertise to every surveying project across Central Malawi.', 'image' => '/images/grace.jpg', 'email' => 'grace@dolzaproperties.com', 'phone' => '+265 882 995 600']);
        TeamMember::create(['id' => 'team-3', 'name' => 'James Chidalo', 'role' => 'Legal Advisor', 'bio' => 'James handles all title deed processing and legal documentation, ensuring every transaction complies with Malawian property law.', 'image' => '/images/james.jpg', 'email' => 'james@dolzaproperties.com', 'phone' => '']);

        Testimonial::create(['id' => 'test-1', 'name' => 'James M.', 'role' => 'Home Buyer', 'content' => "Dolza helped me find my dream farm in Salima. Their team was knowledgeable and professional throughout the process.", 'rating' => 5, 'image' => '']);
        Testimonial::create(['id' => 'test-2', 'name' => 'Grace T.', 'role' => 'Property Seller', 'content' => "I sold my property quickly with Dolza's assistance. They know the Malawian real estate market inside out.", 'rating' => 5, 'image' => '']);
        Testimonial::create(['id' => 'test-3', 'name' => 'Thomas K.', 'role' => 'Client', 'content' => 'Professional service from start to finish. The team guided me through title deed processing with ease.', 'rating' => 4, 'image' => '']);

        $settings = [
            'siteName' => 'Dolza Real Properties & Estate Agency',
            'siteDescription' => 'Premium real estate services in Salima, Malawi',
            'contactEmail' => 'dolzaestateagency@gmail.com',
            'contactPhone' => '+265 994 369 985',
            'address' => 'Salima Office, Malawi',
            'currency' => 'MWK',
            'logo' => '',
        ];
        foreach ($settings as $key => $value) {
            Setting::create(['key' => $key, 'value' => $value]);
        }
    }
}
