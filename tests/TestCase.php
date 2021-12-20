<?php

namespace Combindma\Gallery\Tests;

use Combindma\Gallery\GalleryServiceProvider;
use Combindma\Gallery\Http\Controllers\GalleryCategoryController;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Route;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Spatie\\Gallery\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            GalleryServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        //Schema::dropAllTables(); //run MYSQL server by this command: brew services start mysql

        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $migration = include __DIR__ . '/../database/migrations/create_gallery_table.php.stub';
        $migration->up();
    }

    protected function defineRoutes($router)
    {
        Route::group(['as' => 'gallery::', 'middleware' => ['bindings']], function () {
            Route::get('/gallery/index', [GalleryCategoryController::class, 'index'])->name('gallery.index');
            Route::post('/gallery/store', [GalleryCategoryController::class, 'store'])->name('gallery.store');
            Route::delete('/gallery/{gallery}/destroy', [GalleryCategoryController::class, 'destroy'])->name('gallery.destroy');
        });
    }
}
