<?php

namespace Combindma\Gallery;

use Combindma\Gallery\Http\Controllers\GalleryCategoryController;
use Illuminate\Support\Facades\Route;

class Gallery
{
    public static function routes(string $prefix = 'dash')
    {
        Route::group(['prefix' => $prefix, 'as' => 'gallery::'], function () {
            Route::get('/gallery/index', [GalleryCategoryController::class, 'index'])->name('gallery.index');
            Route::post('/gallery/store', [GalleryCategoryController::class, 'store'])->name('gallery.store');
            Route::delete('/gallery/{gallery}/destroy', [GalleryCategoryController::class, 'destroy'])->name('gallery.destroy');
        });
    }
}
