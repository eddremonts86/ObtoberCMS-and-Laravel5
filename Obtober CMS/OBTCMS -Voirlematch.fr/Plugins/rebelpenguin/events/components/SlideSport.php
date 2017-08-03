<?php namespace Rebelpenguin\Events\Components;
use Db;
use App;
use Request;
use Cms\Classes\ComponentBase;
use ApplicationException;
use Rebelpenguin\Events\Classes\template;
class SlideSport extends ComponentBase
{
    public function onRun()
    {
        $this->addCss('/plugins/rebelpenguin/events/assets/css/animate.min.css');
        $this->addCss('/plugins/rebelpenguin/events/assets/css/styles_.css');
        $this->addJs('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js');
        $this->addJs('/plugins/rebelpenguin/events/assets/js/components/SlideSport.js');
    }
    public function componentDetails()
    {
        return [
            'name'        => 'SlideSport Component',
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
            ],
            'Stream' => [
                'title' => 'Stream',
                'description' => 'Specifies whether the embedded Tweet should be left aligned, right aligned, or centered in the page.',
                'type' => 'dropdown',
                'group' => 'Config',
            ],
            'Head0' => [
                'description' => 'It refers to the amount of information to show',
                'type' => 'string',
                'group' => 'Config',
            ],
            'Head1' => [
                'description' => 'It refers to the amount of information to show',
                'type' => 'string',
                'group' => 'Config',
            ],
            'Head2' => [
                'description' => 'It refers to the amount of information to show',
                'type' => 'string',
                'group' => 'Config',
            ],
            'Head3' => [
                'description' => 'It refers to the amount of information to show',
                'type' => 'string',
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
    public function getStreamOptions()
    {
        $contr = array();
        $contr['None']='None';
        $data = Db::select('select * from rebel_penguin_stream_p where active = ?', [1]);
        for($a=0; $a<count($data);$a++){
            $contr[$data[$a]->id_stp]= $data[$a]->name;
        }
        return $contr;
    }
    public function onSlideSport()
    {
        $Sport = $this->property('Sport');
        $Stream = $this->property('Stream');
        $conf=array();
        $conf[0]['Head0'] = $this->property('Head0');
        $conf[0]['Head1']= $this->property('Head1');
        $conf[0]['Head2']= $this->property('Head2');
        $conf[0]['Head3']= $this->property('Head3');
        $conf[0]['Stream']= $this->property('Stream');

        $namesport=template::getSport($Sport);
        $conf[0]['color'] = $namesport[0]['color'];
        $conf[0]['sport'] = $namesport[0]['name'];



        $art = template::liveheader($Sport,$Stream);
        if(@$art['error']=='true')
        {$conf[0]['count']= 0;}
        else
        {$conf[0]['count']= count($art);}
        $this->page['header'] = $conf;
        $this->page['art'] = $art;
    }
}