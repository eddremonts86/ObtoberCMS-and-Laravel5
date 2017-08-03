<?php namespace Rebelpenguin\Events\Components;

use Db;
use App;
use Request;
use Cms\Classes\ComponentBase;
use ApplicationException;
use Rebelpenguin\Events\Classes\General;
use Rebelpenguin\Events\Classes\template;

class Events extends ComponentBase
{
    public function onRun()
    {
        $this->addCss('/plugins/rebelpenguin/events/assets/css/animate.min.css');
        $this->addCss('/plugins/rebelpenguin/events/assets/css/styles_.css');
        $this->addJs('/plugins/rebelpenguin/events/assets/js/components/Events.js');
    }
    public function componentDetails()
    {
        return [
            'name' => 'Events and Teams',
            'description' => 'Plugin to show the list of events(Day events or Program).'
        ];
    }
    public function defineProperties()
    {
        return [
            'Search' => [
                'title'             => 'Search',
                'description'       => 'Search',
                'type'              => 'checkbox',
                'group' => 'Config',
            ],
            'max' => [
                'description' => 'It refers to the amount of information to show',
                'title' => 'Maximum to show(items)',
                'default' => 10,
                'type' => 'string',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'The Max Items value is required and should be integer.',
                'group' => 'Config',
            ],
            'Layout' => [
                'title' => 'Layout',
                'description' => 'Layouts',
                'default' => '',
                'type' => 'dropdown',
                'group' => 'Config',
            ],

            'Start_Day' => [
                'title'             => 'Start Day',
                'description'       => 'is the day to start the search. Ej (2015-10-25)',
                'type'              => 'string',
                'placeholder'       => '0000-00-00',
                'group'             => 'Config',
            ],
            'Sport' => [
                'title' => 'Sport',
                'description' => 'Specifies whether the embedded Tweet should be left aligned, right aligned, or centered in the page.',
                'type' => 'dropdown',
                'group' => 'Filters',
            ],
            'Head' => [
                'title'             => 'Head',
                'description'       => 'Head of plugin',
                'type'              => 'string',
                'placeholder'       => 'Program – populære kampe',
                'group'             => 'Text-Config',
            ],
            'SubHead' => [
                'title'             => 'SubHead',
                'description'       => 'SubHead of plugin',
                'type'              => 'string',
                'placeholder'       => 'Program – populære kampe',
                'group'             => 'Text-Config',
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
        $contr['Box']= 'Box';
        $contr['Table']= 'Table';
        $contr['TableNew']= 'TableNew';
        $contr['TableProgram']= 'TableProgram';
        $contr['IndexTables']= 'IndexTables';
        return $contr;
    }
    public function getLocaleOptions()
    {
        $contr    = array();
        $contr['es']= 'es';
        $contr['en']= 'en';
        $contr['fr']= 'fr';
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
    public function getStream_providersOptions()
    {
        $contr = array();
        $contr['None']='None';
        $data = Db::select('select * from rebel_penguin_stream_p where active = ?', [1]);
        for($a=0; $a<count($data);$a++){
            $contr[$data[$a]->id_stp]= $data[$a]->name;
        }
        return $contr;
    }
    public function getCountryOptions()
    {
        $result = General::service_fodbold();
        $contr    = array();
        $contr['None']='None';
        for ($i = 0; $i < $result['count']; $i++){
            $name= $result['events'][$i]->recurring_competition->region->name;
            $contr[$result['events'][$i]->recurring_competition->region->id] = $name;
        }
        return $contr;
    }
    public function getTournamentsOptions()
    {
        $result = General::service_fodbold();
        $contr    = array();
        $contr['None']='None';
        for ($i = 0; $i < $result['count']; $i++){
            $name =  $result['events'][$i]->recurring_competition->name;
            $contr[$result['events'][$i]->recurring_competition->id] = $name;
        }
        return $contr;
    }
    public function onAddItem_Fodbold()
    {

        $events = post('events', []);
        $conf = array();
        $alfa2="";
        $countrys = array();
        $end = array();
        $date_events = array();
        $date_eventsm = array();
        $date_eventsend= array();

        $Country = $this->property('Country');
        $date = $this->property('Start_Day');
        $Sport = $this->property('Sport');
        $head = $this->property('Head');
        $SubHead = $this->property('SubHead');
        $stream_providers = $this->property('Stream_providers');
        $cant = $max = $this->property('max');
        $Tournaments = $this->property('Tournaments');
        $Layout = $this->property('Layout');
        $Search = $this->property('Search');

        /* ---------- Plugin Conf ---------- */
        $conf[0]['country']=  $Country;
        $conf[0]['Sport']=  $Sport;
        $conf[0]['stream']=  $stream_providers;
        $conf[0]['max']=  $max;
        $conf[0]['head']=  $head;
        $conf[0]['SubHead']=  $SubHead;
        $conf[0]['Search']=  $Search;
        $conf[0]['Tournaments']=  $Tournaments;
        $conf[0]['Layout']=  $Layout;
        $conf[0]['items']=  0;
        $Link = $this->property('Link');
        $conf[0]['Link']=  $Link;
        /* ---------- end ---------- */
        $result = template::getEventList($Sport,$date,$Layout);
        $data =  template::getSport($Sport);
        if($result=='error'){
            $end[0]['tournament']='No data';
            $events[0]['date_hour']='No data';
            $events[0]['name']='No data';
            $this->page['ends'] = $end;
            $this->page['events'] = $events;
        }
        else{

                $z=0;
                for ($a = 0; $a < count($result) ; $a++) {
                    $mystreams=array();
                    if($cant==0||$cant>count($result[$a])){$cant = count($result[$a]);}
                    $d=0;

                   if(@$result[$a]['error'] != 'true'){

                       for($i = 0; $i < $cant ; $i++){
                       $whitelist = template::whitelist($result[$a][$i]);
                       if($whitelist  == 'true') {
                            $stream =General:: service_fodbold_stramp($result[$a][$i]->id_events);
                            $cantstream = @count($stream['stream_providers']);
                        //-----------------------------------------------------------------------------------//
                        $b=0;
                        if($cantstream>0){
                        for($k=0; $k < $cantstream; $k++){
                            $data_active = Db::table('rebel_penguin_stream_p')
                                ->select('rebel_penguin_stream_p.*')
                                ->where('rebel_penguin_stream_p.id_stp', '=', @$stream['stream_providers'][$k]->id)
                                ->where('rebel_penguin_stream_p.active', '=', 1)
                                ->get();
                            if(@count($data_active)>0) {
                                $mystreams[$b]= $stream['stream_providers'][$k];
                                $b++;
                                break;
                            }
                            }
                        }
                        //-----------------------------------------------------------------------------------//
                        if(1 > 0) {
                                if($Layout=="TableProgram"){$events[$z]['stream']= $mystreams;}
                                $alfa2=$result[$a][$i]->country_alpha2;
                                $events[$z]['start'] = $result[$a][$i]->hour;
                                $events[$z]['Error'] = '0';
                                $events[$z]['Sport'] = $result[$a][$i]->sport;
                                $events[$z]['id_box'] = $i+1;
                                $events[$z]['date_hour']= date("H:i",strtotime($result[$a][$i]->hour));
                                $events[$z]['date']= $result[$a][$i]->hour;
                                $events[$z]['home_team']=$result[$a][$i]->home_team;
                                $events[$z]['away_team']= $result[$a][$i]->away_team;
                                $events[$z]['name']= $result[$a][$i]->home_team .' vs '. $result[$a][$i]->away_team;
                                $events[$z]['country_alpha2'] = $alfa2;
                                $events[$z]['tournament'] = $result[$a][$i]->tournament;
                                $events[$z]['tournament_id'] = $result[$a][$i]->tournament_id;
                                $events[$z]['id']=$result[$a][$i]->id_events;
                                $url_date = date("Y-m-d",strtotime($result[$a][$i]->start));
                                $url_free1=template::Clearfeet($result[$a][$i]->away_team);
                                $url_free2=template::Clearfeet($result[$a][$i]->home_team);
                                $events[$z]['url_free'] =$url_free1.'-vs-'.$url_free2.'-'.$url_date;

                                $id_event_result = Db::table('rebel_penguin_article') ->where('id_evento', $events[$z]['id'] ) ->count();
                                if($id_event_result==0) $events[$z]['id_event_result']=0;else $events[$z]['id_event_result']=1;

                                $events[$z]['away_team_logo']= $result[$a][$i]->away_team_logo;
                                $events[$z]['home_team_logo']= $result[$a][$i]->home_team_logo;

                               /* @$region = gettype($result[$a]['events'][$i]->recurring_competition->region->name);
                                @$name =  $result[$a]['events'][$i]->recurring_competition->region->name;*/
                            $countrys[$z ]['tournament'] = $result[$a][$i]->tournament;
                            $countrys[$z ]['tournament_id'] = $result[$a][$i]->tournament_id;
                            $countrys[$z ]['country_alpha2'] =$alfa2;

                            $events[$z]['date_acc']= template::Day(date("w",strtotime($result[$a][$i]->hour))).' '.date("d.M",strtotime($result[$a][$i]->hour));
                            $countrys[$z ]['date_acc'] = template::Day(date("w",strtotime($result[$a][$i]->hour))).' '.date("d.M",strtotime($result[$a][$i]->hour));
                            $date_events[]['date_acc']= template::Day(date("w",strtotime($result[$a][$i]->hour))).' '.date("d.M",strtotime($result[$a][$i]->hour));
                            $z++;
                            $d++;
                            }
                        }
                   }
                  }
                }
                /*-----------------------------------------------------------------------*/
                for ($i = 0; $i <count($countrys) ; $i++) {$end= array_values(array_unique($countrys,SORT_REGULAR));}
                /*-----------------------------------------------------------------------*/
                   $date_eventsend= array_values(array_unique($date_events,SORT_REGULAR));
                /*-----------------------------------------------------------------------*/
            $conf[0]['items']=  count($events);
            $this->page['ends'] = $end;
            $this->page['date_eventsend'] = $date_eventsend;
            $this->page['events'] = $events;

         }
        $this->page['conf'] = $conf;
     }

}

