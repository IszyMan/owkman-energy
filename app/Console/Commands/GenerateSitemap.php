<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Product;
use App\Models\Category;

#[Signature('app:generate-sitemap')]
#[Description('Command description')]
class GenerateSitemap extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sitemap = Sitemap::create();

        // Homepage
        $sitemap->add(Url::create('/'));

        $sitemap->add(Url::create('/categories'));

        // Categories
        Category::all()->each(function ($category) use ($sitemap) {
            $sitemap->add(
                Url::create("/category/{$category->slug}")
                    ->setLastModificationDate($category->updated_at)
            );
        });

        // Products
        Product::all()->each(function ($product) use ($sitemap) {
            $sitemap->add(
                Url::create("/product/{$product->slug}")
                    ->setLastModificationDate($product->updated_at)
            );
        });

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated!');
    }
}
