<?php namespace Rebelpenguin\Events\Components;
use Db;
use App;
use Request;
use Cms\Classes\ComponentBase;
use ApplicationException;
use Rebelpenguin\Events\Classes\template;

class Metadata extends ComponentBase
{
    public function onRun()
    {
        $this->addCss('/plugins/rebelpenguin/events/assets/css/animate.min.css');
        $this->addCss('/plugins/rebelpenguin/events/assets/css/styles_.css');
        $this->addJs('/plugins/rebelpenguin/events/assets/js/components/Metadata.js');
    }
    public function componentDetails()
    {
        return [
            'name' => 'Metadata',
            'description' => 'Plugin to associate metadata to pages .'
        ];
    }
    public function defineProperties()
    {
        return [];
    }
    public function onAddItemFodbold()
    {
        $Sport = $this->property('Sport');
        $id_fb = $this->param('id_fb');
        $taken = explode(':',$id_fb );
        $dataevents = template::metadata($taken[1]);
        $this->page['dataevents'] = $dataevents;


    }
}