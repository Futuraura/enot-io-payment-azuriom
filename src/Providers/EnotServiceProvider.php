<?php

namespace Azuriom\Plugin\Enot\Providers;

use Azuriom\Extensions\Plugin\BasePluginServiceProvider;
use Azuriom\Plugin\Enot\EnotMethod;

class EnotServiceProvider extends BasePluginServiceProvider
{
    /**
     * Register any plugin services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any plugin services.
     *
     * @return void
     */
    public function boot()
    {
        if (! plugins()->isEnabled('shop')) {
            logger()->warning('Enot нужен плагин Shop для работы !');

            return;
        }

        $this->loadViews();

        $this->loadTranslations();

        payment_manager()->registerPaymentMethod('enot', EnotMethod::class);
    }
}
