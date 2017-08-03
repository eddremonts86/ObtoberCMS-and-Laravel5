<?php namespace Rebelpenguin\Events\Components;


use Db;
use App;
use Request;
use Cms\Classes\ComponentBase;
use ApplicationException;
use Rebelpenguin\Events\Classes\template;
class LandingPage extends ComponentBase
{
    public function onRun()
    {
        $this->addCss('/plugins/rebelpenguin/events/assets/css/animate.min.css');
        $this->addCss('/plugins/rebelpenguin/events/assets/css/styles_.css');
        $this->addJs('/plugins/rebelpenguin/events/assets/js/components/LandingPage.js');
    }
    public function componentDetails()
    {
        return [
            'name'  => 'LandingPage',
            'description' => 'No description provided yet...'
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
            ]
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
    public function onLandingPages()
    {
        $id_fb = $this->param('id_fb');
        $Sport = "Fodbold";
        $id_fb = explode(':',$id_fb );
        $article= template::landinPagesGobal($id_fb[1]);
        $this->page['articles'] = $article;
        $streams= template::landinPagesstream($id_fb[1],$Sport);
        if(empty($streams)==true){
            return Redirect::to('/');
        }
        else{
            $this->page['stream'] = $streams;

        }

    }
}