<?php

namespace Combindma\Gallery;

use Combindma\Gallery\Http\Controllers\GalleryCategoryController;
use Illuminate\Support\Facades\Route;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class GalleryServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('gallery')
            ->hasViews()
            ->hasMigration('create_gallery_table');
    }

    public function packageRegistered()
    {
        Route::macro('gallery', function (string $baseUrl = 'admin') {
            Route::group(['prefix' => $baseUrl, 'as' => 'gallery::'], function () {
                Route::get('/gallery/index', [GalleryCategoryController::class, 'index'])->name('gallery.index');
                Route::post('/gallery/store', [GalleryCategoryController::class, 'store'])->name('gallery.store');
                Route::delete('/gallery/{gallery}/destroy', [GalleryCategoryController::class, 'destroy'])->name('gallery.destroy');
            });
        });
    }
}
