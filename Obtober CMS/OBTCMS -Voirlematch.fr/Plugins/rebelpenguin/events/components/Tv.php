<?php namespace Rebelpenguin\Events\Components;

use Db;
use App;
use Request;
use Cms\Classes\ComponentBase;
use ApplicationException;
use Rebelpenguin\Events\Classes\General;

class Tv extends ComponentBase
{

    public function onRun()
    {
        $this->addCss('/plugins/rebelpinguin/events/assets/css/animate.min.css');
        $this->addCss('/plugins/rebelpinguin/events/assets/css/styles_.css');
        $this->addJs('/plugins/rebelpinguin/events/assets/js/components/Tv.js');
    }
    public function componentDetails()
    {
        return [
            'name' => 'Tv Guide',
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
        $contr    = array();
        $contr['TABLE'][]= 'TABLE';
        return $contr;
    }
    public function onAddItem_Fodbold()
    {

        $param = $_POST['newItem'];
        $events = post('events', []);
        $conf = array();
        $countrys = array();
        $end = array();
        $cant = $max = $this->property('max');
        $Layout = $this->property('Layout');
        /* ---------- Plugin Conf ---------- */
        $conf[3]['max']=  $max;
        $conf[6]['Layout']=  $Layout;
        $this->page['conf'] = $conf;
        /* ---------- end ---------- */

        /* ---------- SPORT DATA ---------- */
        $data = Db::select('select * from rebel_penguin_sports');
        $sports = array();
        if (count($data) >= 1) {
            for ($i = 0; $i < count($data); $i++)
            {$sports[$i] = ['id' => $data[$i]->id, 'name' => $data[$i]->name, 'active' => $data[$i]->active, 'url_api_server' => $data[$i]->url_api_server,];}
            /* ---------- EVENTS DATA ---------- */
            $result = General::service_fodbold();
            if($cant==0||$cant>$result['count'])
            {$cant = $result['count'];}

            for ($i = 0; $i <$cant ; $i++) {
                $stream = General::service_fodbold_stramp($result['events'][$i]->id);
                $cantstream = @count($stream['stream_providers']);
                if($cantstream> 0) {
                    $events[$i]['start'] = $result['events'][$i]->start_date;
                    $events[$i]['Error'] = '0';
                    $events[$i]['id_box'] = $i + 1;
                    $events[$i]['date_hour'] = date("h:i", strtotime($result['events'][$i]->start_date));
                    $events[$i]['name'] = $result['events'][$i]->home->name . ' vs ' . $result['events'][$i]->away->name;
                    $events[$i]['country'] = $result['events'][$i]->recurring_competition->region->name;
                    $events[$i]['country_alpha2'] = $result['events'][$i]->recurring_competition->region->alpha2;
                    $events[$i]['country_alpha3'] = $result['events'][$i]->recurring_competition->region->alpha3;
                    $events[$i]['tournament'] = $result['events'][$i]->recurring_competition->name;
                    $events[$i]['tournament_id'] = $result['events'][$i]->recurring_competition->id;

                    $countrys[$i]['tournament'] = $result['events'][$i]->recurring_competition->name;
                    $countrys[$i]['tournament_id'] = $result['events'][$i]->recurring_competition->id;
                    $countrys[$i]['country_alpha2'] = $result['events'][$i]->recurring_competition->region->alpha2;

                    $events[$i]['id'] = $result['events'][$i]->id;
                    $events[$i]['sport'] = $result['sport']->name;
                    $events[$i]['sport_id'] = $result['sport']->id;
                    $events[$i]['date'] = $result['events'][$i]->start_date;
                    $events[$i]['home_team'] = $result['events'][$i]->home->name;
                    $events[$i]['home_team_logo'] = $result['events'][$i]->home->logo;
                    $events[$i]['away_team'] = $result['events'][$i]->away->name;
                    $events[$i]['away_team_logo'] = $result['events'][$i]->away->logo;
                    $id_event_result = Db::table('rebel_penguin_article')->where('id_evento', $events[$i]['id'])->count();
                    if ($id_event_result == 0) $events[$i]['id_event_result'] = 0;
                    else $events[$i]['id_event_result'] = 1;
                    $url_free1 = str_replace(' ', '', $result['events'][$i]->away->name);
                    $url_free2 = str_replace(' ', '', $result['events'][$i]->home->name);
                    $events[$i]['url_free'] =$url_free1.'-vs-'.$url_free2;
                }



            }
            /*$countrys = array_unique($countrys,SORT_REGULAR );
            for ($i = 0; $i <count($countrys) ; $i++) {
                if(isset($countrys[$i]))
                $end[$i]['tournament']= $countrys[$i];

            }*/
            $this->page['ends'] = $countrys;
            $this->page['sports'] = $sports;
            $this->page['events'] = $events;


        }
        else { $sports[0] = ['id' => '0', 'name' => 'No sports in data base', 'url_api_server' => 'Url']; }





    }

}