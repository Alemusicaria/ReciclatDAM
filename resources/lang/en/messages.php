<?php
return [
    // Global texts
    'welcome' => 'Welcome to Reciclat DAM Dashboard',
    'partner' => 'Your partner in sustainable recycling solutions',
    'language' => 'EN',
    'catalan' => 'Catalan',
    'english' => 'English',
    'spanish' => 'Spanish',

    // Hero section
    'hero' => [
        'title' => 'Help to Recycle',
        'subtitle' => 'Earn Rewards',
        'description' => 'Transform your recycling into benefits for the community.',
        'search_placeholder' => 'Search for a collection point...',
        'apple_store' => 'Download on the Apple Store',
        'google_play' => 'Download on Google Play',
        'no_results' => 'No collection points found.',
        'search_error' => 'Search error. Please try again.',
        'fraction' => 'Fraction:',
        'hero_image_alt' => 'Hero Image',
        'static_map_alt' => 'Static Map',
        'city' => 'City',
        'no_city' => 'No city found',
        'address' => 'Address',
        'avilable' => 'Available',
        'not_available' => 'Not Available',
    ],

    // How it works section
    'how_it_works' => [
        'title' => 'How does it work?',
        'download_app' => 'Download the App',
        'download_app_desc' => 'Install the app on your device to get started.',
        'recycle' => 'Recycle',
        'recycle_desc' => 'Follow the instructions to recycle correctly.',
        'coins' => 'Accumulate <b>ECODAMS</b>',
        'coins_desc' => 'Earn <b>ECODAMS</b> for every recycling action.',
        'rewards' => 'Claim Rewards',
        'rewards_desc' => 'Use your <b>ECODAMS</b> to get exclusive rewards.'
    ],

    // Sponsors section
    'sponsors' => [
        'title' => 'Our Partners',
    ],

    // About us section
    'about_us' => [
        'title' => 'What is Reciclat DAM?',
        'description_1' => 'ReciclatDAM is an innovative application that allows you to recycle easily and in a fun way. Earn points called <strong>ECODAMS</strong> for each recycling action and use them to get exclusive rewards. Join our community and help make the world a more sustainable place!',
        'description_2' => 'With Reciclat DAM and your <strong>ECODAMS</strong>, you win and the environment wins.',
        'image_alt' => 'Recycling related photo'
    ],

    // Awards section
    'awards' => [
        'title' => 'Awards and Recognitions',
        'collection_title' => 'Awards Collection',
        'collection_description' => 'Browse through our collection of awards and recognitions.',
        'detail_title' => 'Award Detail',
        'selected_award_alt' => 'Selected award',
        'no_awards_found' => 'No awards found.',
        'no_awards_available' => 'No awards available',
        'no_award_to_show' => 'No award found to display.',
        'error_loading' => 'Error loading awards.'
    ],

    // Opinions section
    'opinions' => [
        'title' => 'Testimonials',
        'loading' => 'Loading testimonials...',
        'no_opinions' => 'No testimonials available.',
        'error_loading' => 'Error loading testimonials.'
    ],

    // Recycling section
    'recycling' => [
        'title' => 'Search for a product or select a fraction',
        'search_placeholder' => 'Search for a product...',
        'fractions_title' => 'Fractions',
        'no_products' => 'No products found in this fraction.',
        'products_title' => 'Products in this fraction',
        'what_is' => 'What it is:',
        'how_to' => 'How to recycle it:',
        'benefits' => 'Benefits:',
        'tips' => 'Tips:',
        'recycling_info' => 'Recycling information',
        'product_description' => 'Product description',
        'close' => 'Close',
        'back_to_list' => 'Back to list',
        'clear_filter' => 'Clear Filter',
        'fraction_search' => 'Search by fraction',
        'all_fractions' => 'All fractions',
        'map_title' => 'Collection Points Map',
        'no_collection_points' => 'No collection points found for this fraction.',
        'available' => 'Available',
        'yes' => 'Yes',
        'no' => 'No'
    ],

    // Categories
    'categories' => [
        'slug' => [
            'paper' => 'Paper',
            'packaging' => 'Packaging',
            'organic' => 'Organic',
            'glass' => 'Glass',
            'rest' => 'Rest',
            'waste_collection' => 'Waste Collection',
            'medication' => 'Medication',
            'batteries' => 'Batteries',
            'special' => 'Special Waste',
            'raee' => 'RAEE'
        ],
        'nom' => [
            'paper' => 'Paper and Cardboard',
            'packaging' => 'Light Packaging',
            'organic' => 'Organic Waste',
            'glass' => 'Glass Container',
            'rest' => 'General Waste',
            'waste_collection' => 'Recycling Center',
            'medication' => 'Medications',
            'batteries' => 'Batteries and Accumulators',
            'special' => 'Special Waste',
            'raee' => 'WEEE',
            'raee_tooltip' => 'Waste Electrical and Electronic Equipment'
        ],
    ],

    // Fractions specific information
    'fractions' => [
        'paper' => [
            'name' => 'Paper and Cardboard',
            'description' => 'Paper and cardboard are biodegradable materials that come from a renewable source and can be recycled up to 6 times.',
            'instructions' => 'Fold cardboard boxes to reduce their volume. Make sure the paper is clean and dry. Do not mix paper soiled with oil, food or other liquids.',
            'benefits' => 'Recycling one ton of paper saves 17 trees and up to 26,000 liters of water.',
            'tips' => 'Filmed, waxed or laminated papers cannot be recycled in the blue bin. Used kitchen paper and napkins go in the organic waste bin.'
        ],
        'packaging' => [
            'name' => 'Light Packaging',
            'description' => 'Light packaging includes plastic bottles, cans, tetra briks, styrofoam trays and plastic wrapping.',
            'instructions' => 'Empty containers completely and crush them if possible to reduce volume. You don\'t need to wash them, but do remove food residue.',
            'benefits' => 'Recycling plastic saves 80% of the energy needed to manufacture new products and reduces environmental pollution.',
            'tips' => 'Reuse plastic bags or use cloth bags. Remember that single-use plastic utensils are not packaging and go in the gray bin.'
        ],
        'organic' => [
            'name' => 'Organic Waste',
            'description' => 'Organic waste includes food scraps, small plant residues and other compostable materials.',
            'instructions' => 'Use compostable bags and make sure there are no improper materials such as plastics or metals. Avoid disposing liquids.',
            'benefits' => 'Properly sorted organic waste is turned into high-quality compost for agriculture and gardening.',
            'tips' => 'Cork stoppers, wooden toothpicks and used paper napkins also go in the brown bin. Avoid throwing large bones or shellfish shells.'
        ],
        'glass' => [
            'name' => 'Glass Container',
            'description' => 'Glass is 100% recyclable and can be reused infinitely without losing quality.',
            'instructions' => 'Empty containers completely and remove caps and lids. No need to wash them. Do not mix flat glass, ceramics or tableware.',
            'benefits' => 'Recycling glass saves 30% of energy compared to manufacturing new glass and reduces CO₂ emissions.',
            'tips' => 'Mirrors, windows, drinking glasses, glass or ceramic plates do not go in the green bin, but to the recycling center or gray bin.'
        ],
        'rest' => [
            'name' => 'General Waste',
            'description' => 'General waste includes all those residues that cannot be recycled or that do not have a specific collection system.',
            'instructions' => 'Use the gray bin only when the waste cannot be disposed of in any other specific container.',
            'benefits' => 'Proper separation reduces the amount of waste that ends up in landfills, extending their useful life.',
            'tips' => 'Before throwing an object in the gray bin, ask yourself if it could be recycled in any of the other containers or at the recycling center.'
        ],
        'waste_collection' => [
            'name' => 'Recycling Center',
            'description' => 'Recycling centers are facilities where waste that does not have a specific container on the street is collected selectively.',
            'instructions' => 'Bring the waste separated by type and follow the staff instructions. Check the schedules and rules of the recycling center in your municipality.',
            'benefits' => 'The use of recycling centers allows valuable materials to be recovered and prevents hazardous substances from contaminating the environment.',
            'tips' => 'Many municipalities offer mobile recycling centers that regularly visit neighborhoods. Some special waste such as paints or solvents should never be thrown down the drain.'
        ],
        'medicines' => [
            'name' => 'Medications',
            'description' => 'Expired or unused medications contain substances that can be harmful to the environment if not managed properly.',
            'instructions' => 'Take expired medications, medication residues and their packaging to the SIGRE containers found in pharmacies.',
            'benefits' => 'Proper medication management prevents aquifer contamination and protects public health.',
            'tips' => 'Never flush medications down the toilet or sink. Also return the leaflets and cardboard boxes along with the medications.'
        ],
        'batteries' => [
            'name' => 'Batteries and Accumulators',
            'description' => 'Batteries and accumulators contain heavy metals and toxic substances that can seriously contaminate water and soil.',
            'instructions' => 'Deposit used batteries in specific containers found in shops, shopping centers, schools and public buildings.',
            'benefits' => 'Recycling batteries allows valuable metals to be recovered and prevents contamination by toxic substances such as mercury, cadmium or lead.',
            'tips' => 'Consider using rechargeable batteries to reduce the amount of waste. Button batteries are particularly polluting and should always be recycled.'
        ],
        'special' => [
            'name' => 'Special Waste',
            'description' => 'Special waste includes products that contain hazardous or toxic substances that require specific management.',
            'instructions' => 'Take these wastes to the recycling center in your municipality. Never mix them with other household waste or throw them in conventional containers.',
            'benefits' => 'Proper management of special waste prevents environmental contamination and allows some valuable materials to be recovered.',
            'tips' => 'Products such as paints, solvents, oils, fluorescent lamps, batteries, X-rays and thermometers are special waste. Store them safely until you can take them to the recycling center.'
        ],
        'raee' => [
            'name' => 'Waste Electrical and Electronic Equipment',
            'description' => 'Waste Electrical and Electronic Equipment (WEEE) includes any device that works with electricity or batteries that has reached the end of its useful life.',
            'instructions' => 'Take WEEE to the recycling center, mobile recycling points or electronics stores that offer collection service. Establishments that sell new devices are obliged to collect old ones.',
            'benefits' => 'WEEE contains valuable materials that can be recovered, such as precious metals, copper and aluminum, and also toxic components that must be properly treated.',
            'tips' => 'Delete personal data from electronic devices before recycling them. From small appliances to large refrigerators, all electronic devices must be properly recycled.'
        ]
    ],

    // Products and search
    'products' => [
        'search_title' => 'Search Results',
        'no_results' => 'No products found for your search.',
        'error_search' => 'Error in search. Please try again.'
    ],

    // Footer section
    'footer' => [
        'contact' => 'Contact',
        'address' => 'Main Square 1, 25200 Cervera',
        'phone' => '(+34) 123 45 67 89',
        'email' => 'reciclatdam@gmail.com',
        'follow_us' => 'Follow Us',
        'quick_links' => 'Quick Links',
        'home' => 'Home',
        'how_it_works' => 'How It Works',
        'about_us' => 'About Us',
        'recycling' => 'Recycling',
        'rewards' => 'Rewards',
        'opinions' => 'Testimonials',
        'location' => 'Our Location',
        'copyright' => '© 2025 ReciclatDAM. All rights reserved.',
        'privacy_policy' => 'Privacy Policy',
        'terms' => 'Terms & Conditions',
        'legal_notice' => 'Legal Notice'
    ],
];