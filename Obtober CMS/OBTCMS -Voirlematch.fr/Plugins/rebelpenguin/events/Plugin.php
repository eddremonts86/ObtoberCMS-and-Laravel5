<?php namespace Rebelpenguin\Events;

use Backend;
use System\Classes\PluginBase;
use Rebelpenguin\Events\Classes\General;
use Rebelpenguin\Events\Classes\template;


/**
 * Events Plugin Information File
 */
class Plugin extends PluginBase
{

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name' => 'Events',
            'description' => 'No description provided yet...',
            'author' => 'rebelpenguin',
            'icon' => 'icon-leaf'
        ];
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {

        return [
            'Rebelpenguin\Events\Components\Events' => 'Events',
            'Rebelpenguin\Events\Components\FrontPagePartners' => 'FrontPagePartners',
            'Rebelpenguin\Events\Components\GeneralStream' => 'GeneralStream',
            'Rebelpenguin\Events\Components\LiveStream' => 'LiveStream',
            'Rebelpenguin\Events\Components\SportEvents' => 'SportEvents',
            'Rebelpenguin\Events\Components\StreamProviders' => 'StreamProviders',
            'Rebelpenguin\Events\Components\StreamUdbyder' => 'StreamUdbyder',
            'Rebelpenguin\Events\Components\Metadata' => 'Metadata',
            'Rebelpenguin\Events\Components\GamePage' => 'GamePage',
            'Rebelpenguin\Events\Components\LandingPage' => 'LandingPage',
            'Rebelpenguin\Events\Components\StreamPageDinamic' => 'StreamPageDinamic',
            'Rebelpenguin\Events\Components\StreamPage' => 'StreamPage',
            'Rebelpenguin\Events\Components\SlideSport' => 'SlideSport',
            'Rebelpenguin\Events\Components\MenuSistem' => 'MenuSistem',
            'Rebelpenguin\Events\Components\MenuSistemToo' => 'MenuSistemToo',
            'Rebelpenguin\Events\Components\Tv' => 'Tv',
            'Rebelpenguin\Events\Components\ArticleAPI' => 'ArticleAPI',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'rebelpenguin.events.some_permission' => [
                'tab' => 'Events',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return [
            'events' => [
                'label' => 'Rebel Penguin.(Admin)',
                'url' => Backend::url('rebelpenguin/events/Events'),
                'icon' => 'icon-leaf',
                'permissions' => ['rebelpenguin.events.*'],
                'order' => 500,
            ],
        ];
    }

    public function registerSchedule($schedule)
    {
        $schedule->call(function () {
            General::SyncEvents();
        })->everyFiveMinutes();
    }

}
