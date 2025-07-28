<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Application\Handler\ImportListRequestHandlerInterface::class,
            \App\Application\Handler\ImportListRequestHandler::class
        );

        $this->app->bind(
            \App\Application\Validator\FileUploadValidatorInterface::class,
            \App\Application\Validator\FileUploadValidator::class
        );

        $this->app->bind(
            \App\Application\Handler\CsvFileUploadHandlerInterface::class,
            \App\Application\Handler\CsvFileUploadHandler::class
        );

        $this->app->bind(
            \App\Application\Handler\ErrorFileDownloadHandlerInterface::class,
            \App\Application\Handler\ErrorFileDownloadHandler::class
        );

        $this->app->bind(
            \App\Application\Dispatcher\ImportJobDispatcherInterface::class,
            \App\Application\Dispatcher\ImportJobDispatcher::class
        );
    }
}
