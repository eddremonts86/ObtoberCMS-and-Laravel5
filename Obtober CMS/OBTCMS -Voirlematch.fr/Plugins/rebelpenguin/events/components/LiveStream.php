<?php namespace Rebelpenguin\Events\Components;

use Db;
use App;
use Request;
use Cms\Classes\ComponentBase;
use ApplicationException;
use Rebelpenguin\Events\Classes\General;
use Rebelpenguin\Events\Classes\template;

class LiveStream extends ComponentBase
{

    public function onRun()
    {
        $this->addCss('/plugins/rebelpenguin/events/assets/css/animate.min.css');
        $this->addCss('/plugins/rebelpenguin/events/assets/css/styles_.css');
        $this->addJs('/plugins/rebelpenguin/events/assets/js/components/Live.js');
    }

    public function componentDetails()
    {
        return [
            'name' => 'Live Stream',
            'description' => 'Plugin to associate various sporting events .'
        ];
    }

    public function defineProperties()
    {
        return [

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
                'default' => 'TABLE',
                'type' => 'dropdown',
                'group' => 'Config',
            ]
        ];
    }

    public function getLayoutOptions()
    {
        $contr = array();
        $contr['TABLE'] = 'TABLE';
        $contr['NEW'] = 'NEW';
        return $contr;
    }

    public function onAddItem_Fodbold()
    {

        $param = $_POST['newItem'];
        $events = post('events', []);
        $conf = array();
        $streamresult = array();
        $countrys = array();
        $end = array();
        $cant = $max = $this->property('max');
        $Layout = $this->property('Layout');
        /* ---------- Plugin Conf ---------- */
        $conf[0]['max'] = $max;
        $conf[1]['Layout'] = $Layout;
        $index=0;
        /* ---------- end ---------- */
        /* ---------- SPORT DATA ---------- */
        $data = template::sport_name();
        $sports = array();

        if (count($data) >= 1) {
            for ($a = 0; $a < count($data); $a++) {
                $sports[$a] = [
                    'id' => $data[$a]['id'],
                    'id_sport' => template::Clearspace_end($data[$a]['id_sport']),
                    'name' => $data[$a]['name'],
                    'active' => $data[$a]['active'],
                    'color' => $data[$a]['color']
                ];
                /* ---------- EVENTS DATA ---------- */
                $date = date( 'Y-m-d' );
                $result = template::getEventList($data[$a]['id_sport'],$date,null);
                //var_dump($result);
                if(@$result[0]['error']!='true'){
                    if ($cant == 0 || $cant >count($result[0])) {$cant = count($result[0]);}
                    for ($i = 0; $i < $cant; $i++) {
                        $stream = template::whitelist($result[0][$i]);
                        if($stream == 'true') {
                             //-----------------------------------------------------------------------------------//
                             $stream = General::service_fodbold_stramp($result[0][$i]->id_events);
                             $cantstreamtotal = @count($stream['stream_providers']);
                             $b = 0;
                             for ($z = 0; $z < $cantstreamtotal; $z++) {
                                 $data_active = Db::table('rebel_penguin_stream_p')->select('rebel_penguin_stream_p.*')
                                     ->where('rebel_penguin_stream_p.id_stp', '=', @$stream['stream_providers'][$z]->id)
                                     ->where('rebel_penguin_stream_p.active', '=', 1)->get();
                                 if (@count($data_active) > 0) {$b++;break;}
                             }
                                

                             if ($b > 0) {
                                 $events[$index]['stream'] = $stream['stream_providers'];
                                 $alfa2=$result[0][$i]->country_alpha2;
                                 $events[$index]['start'] = $result[0][$i]->hour;
                                 $events[$index]['Error'] = '0';
                                 $events[$index]['sport'] = $result[0][$i]->sport;
                                 $events[$index]['sport_id'] = $result[0][$i]->sportid;
                                 $events[$index]['id_box'] = $i+1;
                                 $events[$index]['date_hour']= date("H:i",strtotime($result[0][$i]->hour));
                                 $events[$index]['date_acc']= date("D d.M",strtotime($result[0][$i]->hour));
                                 $events[$index]['date']= $result[0][$i]->hour;
                                 $events[$index]['home_team']=$result[0][$i]->home_team;
                                 $events[$index]['away_team']= $result[0][$i]->away_team;
                                 $events[$index]['name']= $result[0][$i]->home_team .' vs '. $result[0][$i]->away_team;
                                 $events[$index]['country_alpha2'] = $alfa2;
                                 $events[$index]['tournament'] = $result[0][$i]->tournament;
                                 $events[$index]['tournament_id'] = $result[0][$i]->tournament_id;
                                 $events[$index]['id']=$result[0][$i]->id_events;
                                 $url_date = date("Y-m-d",strtotime($result[0][$i]->start));
                                 $url_free1=template::Clearfeet($result[0][$i]->away_team);
                                 $url_free2=template::Clearfeet($result[0][$i]->home_team);
                                 $events[$index]['url_free'] =$url_free1.'-vs-'.$url_free2.'-'.$url_date;
                                 $events[$index]['away_team_logo']= $result[0][$i]->away_team_logo;
                                 $events[$index]['home_team_logo']= $result[0][$i]->home_team_logo;
                                 $id_event_result = Db::table('rebel_penguin_article') ->where('id_evento', $events[$index]['id'] ) ->count();
                                 if($id_event_result==0) $events[$index]['id_event_result']=0;else $events[$index]['id_event_result']=1;
                                 $index++;
                             }
                         }
                    }
                }
                else{
                    $events[0]['sport_id'] = template::Clearspace_end($data[0]['id_sport']);
                    $events[0]['home_team']='No data';
                }
            }
            $conf[2]['data'] = "data";
        } else {
            $conf[2]['data'] = "nodata";
            $sports[0] = ['id' => '0', 'name' => 'No sports in data base', 'url_api_server' => 'Url'];
        }

        $this->page['events'] = $events;
        $this->page['conf'] = $conf;
        $this->page['sports'] = $sports;


    }














    public function onAddItem_Fodboldold()
    {

        $param = $_POST['newItem'];
        $events = post('events', []);
        $conf = array();
        $streamresult = array();
        $countrys = array();
        $end = array();
        $cant = $max = $this->property('max');
        $Layout = $this->property('Layout');
        /* ---------- Plugin Conf ---------- */
        $conf[0]['max'] = $max;
        $conf[1]['Layout'] = $Layout;
        $index=0;
        /* ---------- end ---------- */
        /* ---------- SPORT DATA ---------- */
        $data = Db::select('select * from rebel_penguin_sports  where active = ?', [1]);
        $sports = array();
        if (count($data) >= 1) {
            for ($a = 0; $a < count($data); $a++) {
                $sports[$a] = [
                    'id' => $data[$a]->id,
                    'id_sport' => template::Clearspace_end($data[$a]->id_sport),
                    'name' => $data[$a]->name,
                    'active' => $data[$a]->active,
                    'color' => $data[$a]->color,
                    'url_api_server' => $data[$a]->url_api_server,
                ];
                /* ---------- EVENTS DATA ---------- */
                $result = General::service_fodbold_update(null,$data[$a]->id_sport);
                if ($cant == 0 || $cant > $result['count']) {$cant = $result['count'];}
                for ($i = 0; $i < $cant; $i++) {
                    $stream = template::whitelist($result['events'][$i]);
                    if($stream == 'true') {
                        //-----------------------------------------------------------------------------------//
                        $stream = General::service_fodbold_stramp($result['events'][$i]->id);
                        $cantstreamtotal = @count($stream['stream_providers']);
                        $b = 0;
                        for ($z = 0; $z < $cantstreamtotal; $z++) {
                            $data_active = Db::table('rebel_penguin_stream_p')
                                ->select('rebel_penguin_stream_p.*')
                                ->where('rebel_penguin_stream_p.id_stp', '=', @$stream['stream_providers'][$z]->id)
                                ->where('rebel_penguin_stream_p.active', '=', 1)
                                ->get();
                            if (@count($data_active) > 0) {
                                $b++;
                                break;
                            }
                        }

                        if ($b > 0) {
                            $events[$index]['id'] = $result['events'][$i]->id;
                            $events[$index]['sport'] = $data[$a]->name;
                            $events[$index]['sport_id'] = template::Clearspace_end($data[$a]->id);
                            $events[$index]['start'] = $result['events'][$i]->start_date;
                            $events[$index]['Error'] = '0';
                            $events[$index]['id_box'] = $i + 1;
                            $events[$index]['date_hour'] = date("h:i", strtotime($result['events'][$i]->start_date));
                            $events[$index]['name'] = $result['events'][$i]->home->name . ' vs ' . $result['events'][$i]->away->name;
                            $events[$index]['tournament'] = $result['events'][$i]->recurring_competition->name;
                            $events[$index]['tournament_id'] = $result['events'][$i]->recurring_competition->id;
                            $events[$index]['date'] = $result['events'][$i]->start_date;
                            $events[$index]['home_team'] = $result['events'][$i]->home->name;
                            $events[$index]['away_team'] = $result['events'][$i]->away->name;
                            $events[$index]['stream'] = $stream['stream_providers'];
                            if (!isset($result['events'][$i]->recurring_competition->name)) {
                                $events[$i]['country'] = 'International';
                            } else {
                                // $events[$i]['country'] = $result['events'][$i]->recurring_competition->region->name;
                            }
                            if (!isset($result['events'][$i]->away->logo)) {
                                $events[$i]['away_team_logo'] = "storage/app/media/General/people.png";
                            } else {
                                $events[$i]['away_team_logo'] = $result['events'][$i]->away->logo;
                            }
                            if (!isset($result['events'][$i]->home->logo)) {
                                $events[$i]['home_team_logo'] = "storage/app/media/General/people.png";
                            } else {
                                $events[$i]['home_team_logo'] = $result['events'][$i]->home->logo;
                            }
                            $url_date = date("Y-m-d",strtotime($result['events'][$i]->start_date));
                            $url_free1=template::Clearfeet($result['events'][$i]->home->name);
                            $url_free2=template::Clearfeet($result['events'][$i]->away->name);
                            $events[$index]['url_free'] =$url_free1.'-vs-'.$url_free2.'-'.$url_date;
                            $countrys[$i]['tournament'] = $result['events'][$i]->recurring_competition->name;
                            $countrys[$i]['tournament_id'] = $result['events'][$i]->recurring_competition->id;
                            $index++;
                        }
                    }
                }
            }
            $conf[2]['data'] = "data";
        } else {
            $conf[2]['data'] = "nodata";
            $sports[0] = ['id' => '0', 'name' => 'No sports in data base', 'url_api_server' => 'Url'];
        }
        $this->page['events'] = $events;
        $this->page['conf'] = $conf;
        $this->page['sports'] = $sports;


    }
}