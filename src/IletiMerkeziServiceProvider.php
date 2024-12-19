<?php

namespace IletiMerkezi\SMS;

use IletiMerkezi\SMS\IletiMerkezi;
use IletiMerkezi\IletiMerkeziClient;
use Illuminate\Support\ServiceProvider;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;

class IletiMerkeziServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/iletimerkezi.php', 'iletimerkezi');

        $this->app->bind('IletiMerkezi', function($app) {
            return new IletiMerkezi(new IletiMerkeziClient(
                config('iletimerkezi.key'), 
                config('iletimerkezi.hash'), 
                config('iletimerkezi.sender')
            ));
        });
    }

    public function boot()
    {
        Notification::resolved(function (ChannelManager $service) {
            $service->extend('iletimerkezi', function () {
                return new IletiMerkeziChannel(new IletiMerkeziClient(
                    config('iletimerkezi.key'), 
                    config('iletimerkezi.hash'), 
                    config('iletimerkezi.sender')
                ));
            });
        });

        if($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/config/iletimerkezi.php' => config_path('iletimerkezi.php'),
            ], 'config');
        }
    }
}