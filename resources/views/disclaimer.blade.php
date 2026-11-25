@extends('layouts.site')

@php
    $siteName = config('app.name', 'Laravel');
    $siteDomain = config('app.display_domain');
    $title = __('Disclaimer');
    $description = __('Read the :site disclaimer: our content is educational only and is not medical, financial, or professional advice.', ['site' => $siteName]);

    $lastUpdated = \Carbon\Carbon::parse('2026-11-18');

    $sections = [
        [
            'heading' => __('Educational Purposes Only'),
            'body' => __('The content on :domain is for general informational and educational purposes only and is not medical, financial, legal, or other professional advice. Always consult a qualified professional about your own situation before making health, financial, travel, or technology decisions.', ['domain' => $siteDomain]),
        ],
        [
            'heading' => __('Health and Wellness Information'),
            'body' => __('Articles about skincare, cosmetic treatments, nutrition, exercise, and sleep describe general principles. They do not replace a diagnosis or treatment plan from a doctor, dermatologist, dietitian, or other licensed provider who knows your health history.'),
        ],
        [
            'heading' => __('Financial and Travel Information'),
            'body' => __('Prices, interest rates, fees, visa rules, and insurance terms vary by provider and country and change over time. Check current details with the relevant institution or authority before you act.'),
        ],
        [
            'heading' => __('No Warranties or Liability'),
            'body' => __(':domain makes no representations or warranties as to the accuracy, completeness, or suitability of the information contained herein, and assumes no liability for any losses or damages arising from the use of this content.', ['domain' => $siteDomain]),
        ],
    ];
@endphp

@section('content')
    @include('partials.legal-page', [
        'heading' => __('Disclaimer'),
        'docName' => __('this Disclaimer'),
        'closingNote' => __('This Disclaimer applies to all content published on :site, including articles and guides.', ['site' => $siteName]),
    ])
@endsection
