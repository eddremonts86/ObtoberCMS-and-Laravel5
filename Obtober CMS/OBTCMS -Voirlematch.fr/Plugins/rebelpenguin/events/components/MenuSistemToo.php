<?php namespace Rebelpenguin\Events\Components;
use Db;
use App;
use Request;
use Cms\Classes\ComponentBase;
use ApplicationException;
use Rebelpenguin\Events\Classes\template;
class MenuSistemToo extends  ComponentBase
{
    public function onRun()
{
    $this->addCss('/plugins/rebelpenguin/events/assets/css/animate.min.css');
    $this->addCss('/plugins/rebelpenguin/events/assets/css/styles_.css');
    $this->addJs('/plugins/rebelpenguin/events/assets/js/components/MenuSistemToo.js');
}
    public function componentDetails()
{
    return [
        'name'        => 'MenuSistemToo',
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
    $contr['TOPMENU']= 'TOPMENU';
    $contr['BOTTOMMENU']= 'BOTTOMMENU';
    return $contr;
}
    public function onMenuSystToo()
{
    $sports = template::sport_name();
    $this->page['sports'] = $sports;

    $Layout = $this->property('Layout');
    $conf[0]['Layout']=  $Layout;
    $this->page['conf'] = $conf;
}

}