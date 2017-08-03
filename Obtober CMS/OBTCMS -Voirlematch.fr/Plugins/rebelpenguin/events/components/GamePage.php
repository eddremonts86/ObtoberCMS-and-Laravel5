<?php namespace Rebelpenguin\Events\Components;


use Db;
use App;
use Request;
use Cms\Classes\ComponentBase;
use ApplicationException;
use Rebelpenguin\Events\Classes\template;

class GamePage extends ComponentBase
{
    public function onRun()
    {
        $this->addCss('/plugins/rebelpenguin/events/assets/css/animate.min.css');
        $this->addCss('/plugins/rebelpenguin/events/assets/css/styles_.css');
        $this->addJs('/plugins/rebelpenguin/events/assets/js/components/GamePage.js');
    }
    public function componentDetails()
    {
        return [
            'name' => 'Game Page',
            'description' => 'Plugin to associate metadata to pages .'
        ];
    }
    public function defineProperties()
    {
        return [
            'Sport' => [
                'title' => 'Sport',
                'description' => 'Specifies whether the embedded Tweet should be left aligned, right aligned, or centered in the page.',
                'default' => 'Fodbold',
                'type' => 'dropdown',
                'group' => 'Config',
            ],
        'Link' => [
        'title'             => 'Link of review',
        'description'       => 'Link of review',
        'type'              => 'string',
        'placeholder'       => '/revue-streaming',
        'group'             => 'Template Live',
    ],
        ];
    }
    public function getLayoutOptions()
    {
        $contr    = array();
        $contr['TABLE']= 'TABLE';
        return $contr;
    }
    public function getSportOptions()
    {
        $contr = array();
        $contr['None']='None';
        $data = Db::select('select * from rebel_penguin_sports where active = ?', [1]);
        for($a=0; $a<count($data);$a++){
            $contr[$data[$a]->id_sport]= $data[$a]->name;
        }
        return $contr;
    }
    public function onGamepage()
    {
        $conf = array();
        $Link = $this->property('Link');
        $conf[0]['Link']=  $Link;
        $Sport = $this->property('Sport');
        $id_fb = $this->param('id_fb');
        $taken = explode(':',$id_fb );
        $dataevents = template::fb_se_live($taken[1]);
        $sportarray = template::getSportbyId($Sport);
        $stream_prov = template::StraempPerEvent($taken[1],$Sport);
        $this->page['conf'] = $conf;
        $this->page['dataevents'] = $dataevents;
        $this->page['sport'] = $sportarray;
        $this->page['eventS'] = $stream_prov;
        $this->page['stream'] = $stream_prov;

    }
}