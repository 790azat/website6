<?php

use App\Support\SiteContent;

test('returns a successful response', function () {
    $response = $this->get(route('home'));

    $response->assertOk();
});

test('homepage links every category', function () {
    $response = $this->get(route('home'))
        ->assertOk()
        ->assertSee('Categories');

    foreach (SiteContent::categories() as $category) {
        $response->assertSee(route('section', $category['id']), false);
    }
});

test('homepage has an article search', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Search articles...');
});

test('disclaimer page is linked from the footer', function () {
    $this->get(route('disclaimer'))
        ->assertOk()
        ->assertSee(config('app.display_domain').' makes no representations');

    $this->get(route('home'))
        ->assertOk()
        ->assertSee(route('disclaimer'), false);
});

test('homepage lists the latest articles', function () {
    if (SiteContent::articles()->isEmpty()) {
        $this->markTestSkipped('No articles yet.');
    }

    $response = $this->get(route('home'))->assertOk()->assertSee('Latest Articles');

    foreach (SiteContent::articles()->take(4) as $article) {
        $response->assertSee(route('article', $article['slug']), false);
    }
});
