<?php

namespace WintechLaravel\Excel;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;
use WintechLaravel\Excel\Cache\CacheManager;
use WintechLaravel\Excel\Console\ExportMakeCommand;
use WintechLaravel\Excel\Console\ImportMakeCommand;
use WintechLaravel\Excel\Files\Filesystem;
use WintechLaravel\Excel\Files\TemporaryFileFactory;
use WintechLaravel\Excel\Mixins\DownloadCollectionMixin;
use WintechLaravel\Excel\Mixins\DownloadQueryMacro;
use WintechLaravel\Excel\Mixins\ImportAsMacro;
use WintechLaravel\Excel\Mixins\ImportMacro;
use WintechLaravel\Excel\Mixins\StoreCollectionMixin;
use WintechLaravel\Excel\Mixins\StoreQueryMacro;
use WintechLaravel\Excel\Transactions\TransactionHandler;
use WintechLaravel\Excel\Transactions\TransactionManager;

class ExcelServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/Console/stubs/export.model.stub'       => base_path('stubs/export.model.stub'),
                __DIR__ . '/Console/stubs/export.plain.stub'       => base_path('stubs/export.plain.stub'),
                __DIR__ . '/Console/stubs/export.query.stub'       => base_path('stubs/export.query.stub'),
                __DIR__ . '/Console/stubs/export.query-model.stub' => base_path('stubs/export.query-model.stub'),
                __DIR__ . '/Console/stubs/import.collection.stub'  => base_path('stubs/import.collection.stub'),
                __DIR__ . '/Console/stubs/import.model.stub'       => base_path('stubs/import.model.stub'),
            ], 'stubs');

            if ($this->app instanceof LumenApplication) {
                $this->app->configure('excel');
            } else {
                $this->publishes([
                    $this->getConfigFile() => config_path('excel.php'),
                ], 'config');
            }
        }

        if ($this->app instanceof \Illuminate\Foundation\Application) {
            // Laravel
            $this->app->booted(function ($app) {
                $app->make(SettingsProvider::class)->provide();
            });
        } else {
            // Lumen
            $this->app->make(SettingsProvider::class)->provide();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->mergeConfigFrom(
            $this->getConfigFile(),
            'excel'
        );

        $this->app->bind(CacheManager::class, function ($app) {
            return new CacheManager($app);
        });

        $this->app->singleton(TransactionManager::class, function ($app) {
            return new TransactionManager($app);
        });

        $this->app->bind(TransactionHandler::class, function ($app) {
            return $app->make(TransactionManager::class)->driver();
        });

        $this->app->bind(TemporaryFileFactory::class, function () {
            return new TemporaryFileFactory(
                config('excel.temporary_files.local_path', config('excel.exports.temp_path', storage_path('framework/laravel-excel'))),
                config('excel.temporary_files.remote_disk')
            );
        });

        $this->app->bind(Filesystem::class, function ($app) {
            return new Filesystem($app->make('filesystem'));
        });

        $this->app->bind('excel', function ($app) {
            return new Excel(
                $app->make(Writer::class),
                $app->make(QueuedWriter::class),
                $app->make(Reader::class),
                $app->make(Filesystem::class)
            );
        });

        $this->app->alias('excel', Excel::class);
        $this->app->alias('excel', Exporter::class);
        $this->app->alias('excel', Importer::class);

        Collection::mixin(new DownloadCollectionMixin);
        Collection::mixin(new StoreCollectionMixin);
        Builder::macro('downloadExcel', (new DownloadQueryMacro)());
        Builder::macro('storeExcel', (new StoreQueryMacro())());
        Builder::macro('import', (new ImportMacro())());
        Builder::macro('importAs', (new ImportAsMacro())());

        $this->commands([
            ExportMakeCommand::class,
            ImportMakeCommand::class,
        ]);
    }

    /**
     * @return string
     */
    protected function getConfigFile(): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'excel.php';
    }
}
