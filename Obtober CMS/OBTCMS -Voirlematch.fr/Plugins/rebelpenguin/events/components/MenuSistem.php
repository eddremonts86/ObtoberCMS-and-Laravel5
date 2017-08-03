<?php namespace Rebelpenguin\Events\Components;

use Db;
use App;
use Request;
use Cms\Classes\ComponentBase;
use ApplicationException;
use Rebelpenguin\Events\Classes\template;

class MenuSistem extends ComponentBase
{
    public function onRun()
    {
        $this->addCss('/plugins/rebelpenguin/events/assets/css/animate.min.css');
        $this->addCss('/plugins/rebelpenguin/events/assets/css/styles_.css');
        $this->addJs('/plugins/rebelpenguin/events/assets/js/components/MenuSistem.js');
    }
    public function componentDetails()
    {
        return [
            'name'        => 'MenuSistem',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'Layout' => [
                'title' => 'Layout',
                'description' => 'Layouts',
                'default' => '',
                'type' => 'dropdown',
                'group' => 'Config',
            ]

        ];
    }
    public function getLayoutOptions()
    {
        $contr    = array();
        $contr['MENUTOP']= 'MENUTOP';
        $contr['MENUBOTTOM']= 'MENUBOTTOM';
        return $contr;
    }
    public function onMenuSyst()
    {
        $sports = template::sport_name();
        $this->page['sports'] = $sports;

        $Layout = $this->property('Layout');
        $conf[0]['Layout']=  $Layout;
        $this->page['conf'] = $conf;
    }

}