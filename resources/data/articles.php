<?php

/**
 * Site content data: sections, authors, and main guides (programs).
 *
 * Main guides: settings here, text in resources/data/programs/{slug}.md
 *   (front matter: title, intro), translations in programs/{es,fr}/. None yet.
 *   A line with just [[CTA]] in the body becomes a button to cta_url.
 *
 * There is no database; this file and the Markdown files next to it are the
 * single source of truth, read through App\Support\SiteContent.
 *
 * Articles live in resources/data/articles/{slug}.md: a front-matter block
 * (title, section, author, date, optional image/excerpt) followed by the
 * Markdown body. Images are picked up automatically from
 * public/images/articles/{slug}.{webp,jpg,jpeg,png} (or the front-matter
 * "image" path); without one, generated artwork is shown.
 *
 * Sections: 'title', 'order', optional 'icon' (Heroicon name) and
 *   'description' (shown on topic cards and the section header).
 * Authors: 'name', 'role', 'bio' (short, shown under articles), 'bio_long'
 *   (the author's own page at /author/{key}), optional 'photo' (file in
 *   public/images/team/). Without 'photo', public/images/team/{key}.{webp,jpg,
 *   jpeg,png} is used when present, otherwise the author's initials.
 */

return [

    'sections' => [
        'wellness-beauty' => [
            'title' => 'Wellness & Beauty',
            'order' => 1,
            'icon' => 'sparkles',
            'description' => 'Spa and skincare treatments, hair and nail care, cosmetic procedures, sleep, and everyday stress relief.',
        ],
        'fitness-food' => [
            'title' => 'Fitness & Food',
            'order' => 2,
            'icon' => 'heart',
            'description' => 'Nutrition basics, meal planning, protein and calories, strength and cardio training, mobility, and hydration.',
        ],
        'travel-lifestyle' => [
            'title' => 'Travel & Lifestyle',
            'order' => 3,
            'icon' => 'globe-alt',
            'description' => 'Trip planning, flights and stays, travel insurance and visas, packing, safety, minimalism, and daily routines.',
        ],
        'personal-finance' => [
            'title' => 'Personal Finance',
            'order' => 4,
            'icon' => 'banknotes',
            'description' => 'Budgeting, credit scores and cards, emergency funds, debt, mortgages, investing, inflation, and retirement.',
        ],
        'digital-life' => [
            'title' => 'Digital Life',
            'order' => 5,
            'icon' => 'device-phone-mobile',
            'description' => 'Online privacy and security, passwords and VPNs, AI, cloud storage, devices, social media, and screen time.',
        ],
    ],

    'authors' => [
        'clara-whitmore' => [
            'name' => 'Clara Whitmore',
            'role' => 'Wellness & Beauty Editor',
            'bio' => 'Clara Whitmore is a wellness writer who covers skincare science, spa and salon treatments, and evidence-based habits for rest and stress relief.',
            'bio_long' => 'Clara Whitmore is a wellness writer who covers skincare science, spa and salon treatments, and evidence-based habits for rest and stress relief. Clara spent several years working alongside licensed estheticians and dermatology clinics, translating treatment protocols and ingredient research into clear guides for everyday readers. Her articles focus on how treatments actually work, what results to expect, and which questions to ask a professional before booking. Away from her desk, Clara enjoys long coastal walks and ceramics.',
        ],
        'marcus-bell' => [
            'name' => 'Marcus Bell',
            'role' => 'Fitness & Nutrition Writer',
            'bio' => 'Marcus Bell writes about nutrition fundamentals, meal planning, and practical training for people building healthier routines.',
            'bio_long' => 'Marcus Bell writes about nutrition fundamentals, meal planning, and practical training for people building healthier routines. With a background in exercise science and years of coaching beginners, Marcus focuses on the basics that make the biggest difference: balanced meals, adequate protein, steady movement, and recovery. He breaks down research into simple steps readers can apply in their own kitchens and gyms. In his free time, Marcus trains for trail runs and experiments with batch-cooking recipes.',
        ],
        'sofia-laurent' => [
            'name' => 'Sofia Laurent',
            'role' => 'Travel & Lifestyle Editor',
            'bio' => 'Sofia Laurent is a travel editor who covers trip planning, travel documents and insurance, and simple ways to live and work with more intention.',
            'bio_long' => 'Sofia Laurent is a travel editor who covers trip planning, travel documents and insurance, and simple ways to live and work with more intention. Having lived in four countries and worked remotely for much of her career, Sofia writes the kind of guides she wished she had on her first trips abroad: realistic budgets, clear checklists, and honest notes on trade-offs. She also explores minimalism, sustainable habits, and routines that make busy days calmer. Sofia collects paper maps and loves slow train journeys.',
        ],
        'daniel-hart' => [
            'name' => 'Daniel Hart',
            'role' => 'Personal Finance Writer',
            'bio' => 'Daniel Hart explains budgeting, credit, borrowing, and investing basics in plain language for readers taking charge of their money.',
            'bio_long' => 'Daniel Hart explains budgeting, credit, borrowing, and investing basics in plain language for readers taking charge of their money. With experience in consumer banking and financial education, Daniel has helped hundreds of people understand statements, interest rates, and loan terms before signing anything. His articles walk through how financial products work, what they really cost, and which habits build long-term stability. Daniel volunteers with community financial literacy programs and is an avid chess player.',
        ],
        'nora-kim' => [
            'name' => 'Nora Kim',
            'role' => 'Technology & Digital Life Editor',
            'bio' => 'Nora Kim covers online privacy, cybersecurity basics, consumer devices, and how everyday technology like AI and social media works.',
            'bio_long' => 'Nora Kim covers online privacy, cybersecurity basics, consumer devices, and how everyday technology like AI and social media works. Nora previously worked in IT support and digital safety training, where she learned that most people simply need clear explanations and a few reliable habits. Her guides demystify specifications, security settings, and algorithms so readers can choose devices confidently and protect their personal information. Outside of work, Nora builds small home automation projects and enjoys film photography.',
        ],
    ],

    'programs' => [],

];
