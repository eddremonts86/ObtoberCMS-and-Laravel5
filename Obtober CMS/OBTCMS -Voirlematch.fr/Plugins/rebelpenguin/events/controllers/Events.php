<?php
namespace rebelpenguin\Events\Controllers;

use DB;
use Model;
use Backend\Classes\BackendController;
use Rebelpenguin\Events\Classes\General;
use Rebelpenguin\Events\Classes\template;

class Events extends \Backend\Classes\Controller
{

    public $formConfig = 'config_form.yaml';

    /*-------------- Default  Data-------------------*/
    public function index()
    {
        $this->addCss('/plugins/rebelpenguin/events/assets/css/editor.css');
        $this->addCss('/plugins/rebelpenguin/events/assets/css/controlercss.css');
        $this->addCss('/plugins/rebelpenguin/events/assets/css/bootstrap-datepicker.css');
        $this->addCss('/plugins/rebelpenguin/events/assets/css/font-awesome/css/font-awesome.min.css');
        $this->addCss('/plugins/rebelpenguin/events/assets/css/library/jquery.dataTables.min.css');

        $this->addJs('/plugins/rebelpenguin/events/assets/js/library/editor.js');
        $this->addJs('/plugins/rebelpenguin/events/assets/js/controller/events_controllers.js');
        $this->addJs('/plugins/rebelpenguin/events/assets/js/library/jquery.tablesorter.min.js');
        $this->addJs('/plugins/rebelpenguin/events/assets/js/library/bootstrap-datepicker.min.js');
        $this->addJs('/plugins/rebelpenguin/events/assets/js/library/bootstrap-datepicker.en-GB.min.js');
        $this->addJs('/plugins/rebelpenguin/events/assets/js/library/jquery.dataTables.min.js');



        $sports = $this->onLoadSports();
        $this->vars['sports'] = $sports;

        /*------------  Load sport Articles ----------------*/
        $fb_result = $this->onLoadArticle_fb_Data();
        $this->vars['fb_result'] = $fb_result;

        /*------------  Load Stream Providers ----------------*/
        $result = $this->generldata();
        $this->vars['stream'] = $result;

        /*------------  Load sport Events  ----------------*/
        $events = $this->onAddItem_Fodbold();
       /* print_r('<pre>');
        print_r($events);*/
        $this->vars['events'] = $events;

        /*------------  Load sport Events  ----------------*/
        $id = '';
        $countrys = $this->onGetCountrys($id);
        $this->vars['countrys'] = $countrys;
    }
    public function full_copy($source, $target, $name)
    {
        if (is_dir($source)) {
            @mkdir($target);
            $d = dir($source);
            while (FALSE !== ($entry = $d->read())) {
                if ($entry == '.' || $entry == '..') {
                    continue;
                }
                $Entry = $source . '/' . $entry;
                if (is_dir($Entry)) {
                    full_copy($Entry, $target . '/' . $entry);
                    continue;
                }
                copy($Entry, $target . '/' . $entry);
                $file = $target . '/' . $entry;
                $actual = file_get_contents($file);

                $str = str_replace("fodbold", $name, $actual, $count);
                $strend = str_replace("Fodbold", $name, $str, $count);
                $fp = fopen($file, "w");
                fputs($fp, $strend);
                fclose($fp);
            }
            $d->close();
            return true;
        } else {
            copy($source, $target);
        }
    }

    /*-------------- Main Data-------------------*/
    public function generldata()
    {
        //$data = Db::select('select * from rebel_penguin_stream_p order by active desc, name asc');

        $data = Db::table('rebel_penguin_stream_p')
            ->select('rebel_penguin_stream_p.*')
            ->orderby('active','desc')
            ->orderby('name','asc')

            ->get();

        $result = array();
        for ($a = 0; $a < count($data); $a++) {
            $result[$a]['name'] = $data[$a]->name;
            $result[$a]['id'] = $data[$a]->id_stp;
            $result[$a]['url'] = $data[$a]->url;
            $result[$a]['active'] = $data[$a]->active;
        }
        return $result;
    }
    public function onAddItem_Fodbold()
    {
        $events = post('events', []);
        $eventsfalse = post('events', []);
        $date = date('Y-m-d');
        $sport = template::sport_name();
        $result = General::sportservice($date, $sport[0]['id_sport']);

        if ($result == 'error') {
            $events[0]['name'] = 'Do not have information for this day';
            $events[0]['date'] = $date;
            $events[0]['error'] = 1;
            return $events;
        } else {
            $a=0;
            $b=0;
            for ($i = 0; $i < $result['count']; $i++) {
                if(template::ImExit($result['events'][$i]->id)=='true') {
                    $events[$a]['mine'] = 'true';
                    $events[$a]['error'] = 0;
                    $events[$a]['start'] = date("d.m.y", strtotime($result['events'][$i]->start_date));
                    $events[$a]['sport_name'] = $result['sport']->name;
                    $events[$a]['sport_id'] = $result['sport']->id;
                    $events[$a]['Error'] = '0';
                    $events[$a]['Error'] = '0';
                    $events[$a]['id_box'] = $i + 1;
                    $events[$a]['date_hour'] = date("Y-m-d H:s", strtotime($result['events'][$i]->start_date));
                    $events[$a]['name'] = $result['events'][$i]->home->name . ' vs ' . $result['events'][$i]->away->name;
                    $events[$a]['country'] = $result['events'][$i]->recurring_competition->region->name;
                    $events[$a]['tournament'] = $result['events'][$i]->recurring_competition->name;
                    $events[$a]['id'] = $result['events'][$i]->id;
                    $events[$a]['date'] = $newDate = date("Y-m-d", strtotime($result['events'][$i]->start_date));
                    $events[$a]['home_team'] = template::Clearspace_end($result['events'][$i]->home->name);
                    $events[$a]['home_team_logo'] = $result['events'][$i]->home->logo;
                    $events[$a]['away_team'] = template::Clearspace_end($result['events'][$i]->away->name);
                    $events[$a]['away_team_logo'] = $result['events'][$i]->away->logo;
                    $url_date = date("Y-m-d", strtotime($result['events'][$i]->start_date));
                    $url_free1 = template::Clearfeet($result['events'][$i]->home->name);
                    $url_free2 = template::Clearfeet($result['events'][$i]->away->name);
                    $events[$a]['url_free'] = $url_free1 . '-vs-' . $url_free2 . '-' . $url_date;
                    $id_event_result = Db::table('rebel_penguin_article')
                        ->where('id_evento', '=', $events[$a]['id'])
                        ->count();
                    if ($id_event_result == 0) $events[$a]['id_event_result'] = 0;
                    else $events[$a]['id_event_result'] = 1;
                    $showcase = Db::table('rebel_penguin_landingpage_showcase')
                        ->where('id_event', '=', $events[$a]['id'])
                        ->where('active', '=', 1)
                        ->count();
                    if ($showcase == 0) $events[$a]['showcase'] = 0;
                    else $events[$a]['showcase'] = 1;
                    $streamsact = Db::table('rebel_penguin_restrictions_events')
                        ->select('rebel_penguin_restrictions_events.*')
                        ->where('rebel_penguin_restrictions_events.active', '=', 1)
                        ->where('rebel_penguin_restrictions_events.id_event', '=', $result['events'][$i]->id)
                        ->get();
                    if (count($streamsact) > 0) {
                        $events[$a]['active_rest'] = $streamsact[0]->active;
                    } else {
                        $events[$a]['active_rest'] = 0;
                    }
                    $blockevent = Db::table('rebel_penguin_listevent')
                        ->select('rebel_penguin_listevent.*')
                        ->where('rebel_penguin_listevent.active', '=', 1)
                        ->where('rebel_penguin_listevent.id_event', '=', $result['events'][$i]->id)
                        ->get();
                    if (count($blockevent) > 0) {
                        $events[$a]['blockevent'] = $blockevent[0]->active;
                    } else {
                        $events[$a]['blockevent'] = 0;
                    }
                    $a++;
                }
                else{
                    $eventsfalse[$b]['mine'] = 'false';
                    $eventsfalse[$b]['error'] = 0;
                    $eventsfalse[$b]['start'] = date("d.m.y", strtotime($result['events'][$i]->start_date));
                    $eventsfalse[$b]['sport_name'] = $result['sport']->name;
                    $eventsfalse[$b]['sport_id'] = $result['sport']->id;
                    $eventsfalse[$b]['Error'] = '0';
                    $eventsfalse[$b]['Error'] = '0';
                    $eventsfalse[$b]['id_box'] = $i + 1;
                    $eventsfalse[$b]['date_hour'] = date("Y-m-d H:s", strtotime($result['events'][$i]->start_date));
                    $eventsfalse[$b]['name'] = $result['events'][$i]->home->name . ' vs ' . $result['events'][$i]->away->name;
                    $eventsfalse[$b]['country'] = @$result['events'][$i]->recurring_competition->region->name;
                    $eventsfalse[$b]['tournament'] = $result['events'][$i]->recurring_competition->name;
                    $eventsfalse[$b]['id'] = $result['events'][$i]->id;
                    $eventsfalse[$b]['date'] = $newDate = date("Y-m-d", strtotime($result['events'][$i]->start_date));
                    $eventsfalse[$b]['home_team'] = template::Clearspace_end($result['events'][$i]->home->name);
                    $eventsfalse[$b]['home_team_logo'] = $result['events'][$i]->home->logo;
                    $eventsfalse[$b]['away_team'] = template::Clearspace_end($result['events'][$i]->away->name);
                    $eventsfalse[$b]['away_team_logo'] = $result['events'][$i]->away->logo;
                    $url_date = date("Y-m-d", strtotime($result['events'][$i]->start_date));
                    $url_free1 = template::Clearfeet($result['events'][$i]->home->name);
                    $url_free2 = template::Clearfeet($result['events'][$i]->away->name);
                    $eventsfalse[$b]['url_free'] = $url_free1 . '-vs-' . $url_free2 . '-' . $url_date;
                    $id_event_result = Db::table('rebel_penguin_article')
                        ->where('id_evento', '=', $eventsfalse[$b]['id'])
                        ->count();
                    if ($id_event_result == 0) $eventsfalse[$b]['id_event_result'] = 0;
                    else $eventsfalse[$b]['id_event_result'] = 1;
                    $showcase = Db::table('rebel_penguin_landingpage_showcase')
                        ->where('id_event', '=', $eventsfalse[$b]['id'])
                        ->where('active', '=', 1)
                        ->count();
                    if ($showcase == 0) $eventsfalse[$b]['showcase'] = 0;
                    else $eventsfalse[$b]['showcase'] = 1;
                    $streamsact = Db::table('rebel_penguin_restrictions_events')
                        ->select('rebel_penguin_restrictions_events.*')
                        ->where('rebel_penguin_restrictions_events.active', '=', 1)
                        ->where('rebel_penguin_restrictions_events.id_event', '=', $result['events'][$i]->id)
                        ->get();
                    if (count($streamsact) > 0) {
                        $eventsfalse[$b]['active_rest'] = $streamsact[0]->active;
                    } else {
                        $eventsfalse[$b]['active_rest'] = 0;
                    }
                    $blockevent = Db::table('rebel_penguin_listevent')
                        ->select('rebel_penguin_listevent.*')
                        ->where('rebel_penguin_listevent.active', '=', 1)
                        ->where('rebel_penguin_listevent.id_event', '=', $result['events'][$i]->id)
                        ->get();
                    if (count($blockevent) > 0) {
                        $eventsfalse[$b]['blockevent'] = $blockevent[0]->active;
                    } else {
                        $eventsfalse[$b]['blockevent'] = 0;
                    }
                    $b++;
                }
            }
            while(!empty($eventsfalse))
            {
                $events[count($events)]=array_pop($eventsfalse);
            }
            return $events;
        }


    }

    /*--------------General System--------------------*/
    public function onUpdateSTP()
    {
        $STP = General::Service_STP();
        for ($i = 0; $i < count($STP['stream_providers']); $i++) {
            $id = $STP['stream_providers'][$i]->id;
            $name = $STP['stream_providers'][$i]->name;
            $url = $STP['stream_providers'][$i]->url;
            $isread = template::getStream($id);
            if(0 == $isread) {
                Db::insert('insert into rebel_penguin_stream_p (id_stp,name,url,active) values (?, ?, ?,?)', [$id, $name, $url, false]);
                Db::insert('insert into rebel_penguin_stream_data (id_stp,gnr_label) values (?, ?)', [$id, $name]);
            }

        }
    }
    public function onSportEdit()
    {
        $id = $_POST['id'];
        $id = explode('Edtsport_', $id);
        $id = $id[1];
        $data = Db::select('select * from rebel_penguin_sports where id_sport = ?', [$id]);
        if (count($data) >= 1) {
            return [
                'id' => $data[0]->id,
                'id_sport' => $data[0]->id_sport,
                'name' => $data[0]->name,
                'color' => $data[0]->color,
                'result' => true,
            ];
        } else {
            return ['result' => false];
        }
    }
    public function onLoadSports()
    {
        $result = array();
        $sport = General::Service_Sport();
        for ($i = 0; $i < count($sport['sports']); $i++) {
            $id = $sport['sports'][$i]->id;
            $data = Db::select('select * from rebel_penguin_sports where id_sport = ?', [$id]);
            if ($data) {
                $result[$i] = [
                    'id' => $sport['sports'][$i]->id,
                    'name' => $sport['sports'][$i]->name,
                    'active' => $data[0]->active,
                    'url_api_server' => $data[0]->url_api_server
                ];

            } else {
                $result[$i] = [
                    'id' => $sport['sports'][$i]->id,
                    'name' => $sport['sports'][$i]->name,
                    'active' => "0",
                    'url_api_server' => "http://web1.livegoals.dk:9255/api/v1.1/schedule/?sport=" . $id
                ];
            }
        }

        return $result;


    }
    public function onUpdateSports()
    {
        $id = $_POST['id'];
        $color = $_POST['color'];
        $affected = Db::table('rebel_penguin_sports')
            ->where('id_sport', $id)
            ->update(['color' => $color]
            );


        if ($affected)
            return true;
        else
            return false;

    }
    public function onSaveSports($name)
    {
        $source_pg = '/home/eduardo/agis/cms/themes/Footballstream/pages/pg_foodbold';
        $source_ly = '/home/eduardo/agis/cms/themes/Footballstream/layouts/ly_fodbold';

        $destination_pg = '/home/eduardo/agis/cms/themes/Footballstream/pages/pg_'.$name;
        $destination_ly = '/home/eduardo/agis/cms/themes/Footballstream/layouts/ly_'.$name;

        $pades = $this->full_copy($source_pg, $destination_pg, $name);
        $layaut = $this->full_copy($source_ly, $destination_ly, $name);
        if ($pades == true and $layaut == true) {
            return true;
        } else return false;

    }
    public function onSyncEvents()
    {
       $sync=General::SyncEvents();
       return $sync;
    }
    /*--------------General Stream P System--------------------*/
    public function onInitDataStream()
    {
        $id = $_POST['id'];
        $id = explode('edit_', $id);
        $id = $id[1];
        $data = Db::select('select * from rebel_penguin_stream_data where id_stp = ?', [$id]);

        if (count($data) >= 1) {
            return [
                'id' => $data[0]->id,
                'id_stp' => $data[0]->id_stp,
                'gnr_label' => $data[0]->gnr_label,
                'gnr_affi' => $data[0]->gnr_affi,
                'gnr_false' => $data[0]->gnr_false,
                'gnr_review_butt' => $data[0]->gnr_review_butt,
                'gnr_live_butt' => $data[0]->gnr_live_butt,
                'gnr_sort' => $data[0]->gnr_sort,
                'gnr_rating' => $data[0]->gnr_rating,
                'gnr_coment' => html_entity_decode($data[0]->gnr_coment),
                'gnr_active' => $data[0]->gnr_active,

                'img_cont' => html_entity_decode($data[0]->img_cont),
                'img_genr' => html_entity_decode($data[0]->img_genr),

                'meta_title' => $data[0]->meta_title,
                'meta_desc' => $data[0]->meta_desc,
                'meta_keywords' => $data[0]->meta_keywords,

                'cont_pros' => html_entity_decode($data[0]->cont_pros),
                'cont_introduction' => html_entity_decode($data[0]->cont_introduction),
                'cont_bonus' => $data[0]->cont_bonus,
                'cont_topbutton' => $data[0]->cont_topbutton,
                'cont_botbutton' => $data[0]->cont_botbutton,
                'cont_affiliate' => $data[0]->cont_affiliate,
                'cont_false_affiliate' => $data[0]->cont_false_affiliate,
                'cont_active' => $data[0]->cont_active,

                'udv_heading' => $data[0]->udv_heading,
                'udv_ratin' => $data[0]->udv_ratin,
                'udv_content' => html_entity_decode($data[0]->udv_content),

                'prod_heading' => $data[0]->prod_heading,
                'prod_ratin' => $data[0]->prod_ratin,
                'prod_content' => html_entity_decode($data[0]->prod_content),

                'lives_heading' => $data[0]->lives_heading,
                'lives_ratin' => $data[0]->lives_ratin,
                'lives_content' => html_entity_decode($data[0]->lives_content),

                'odds_heading' => $data[0]->odds_heading,
                'odds_ratin' => $data[0]->odds_ratin,
                'odds_content' => html_entity_decode($data[0]->odds_content),

                'supp_heading' => $data[0]->supp_heading,
                'supp_ratin' => $data[0]->supp_ratin,
                'supp_content' => html_entity_decode($data[0]->supp_content),

                'bonusser_heading' => $data[0]->bonusser_heading,
                'bonusser_ratin' => $data[0]->bonusser_ratin,
                'bonusser_content' => html_entity_decode($data[0]->bonusser_content),

                'bruger_heading' => $data[0]->bruger_heading,
                'bruger_ratin' => $data[0]->bruger_ratin,
                'bruger_content' => html_entity_decode($data[0]->bruger_content),

                'ind_og_heading' => $data[0]->ind_og_heading,
                'ind_og_ratin' => $data[0]->ind_og_ratin,
                'ind_og_content' => html_entity_decode($data[0]->ind_og_content),

                'vores_heading' => $data[0]->vores_heading,
                'vores_ratin' => $data[0]->vores_ratin,
                'vores_content' => html_entity_decode($data[0]->vores_content),

                'liveb_heading' => $data[0]->liveb_heading,
                'liveb_ratin' => $data[0]->liveb_ratin,
                'liveb_content' => html_entity_decode($data[0]->liveb_content),

                'indsat_heading' => $data[0]->indsat_heading,
                'indsat_ratin' => $data[0]->indsat_ratin,
                'indsat_content' => html_entity_decode($data[0]->indsat_content),

                'konk_heading' => $data[0]->konk_heading,
                'konk_ratin' => $data[0]->konk_ratin,
                'konk_content' => html_entity_decode($data[0]->konk_content),
                'result' => true,
            ];
        } else {
            return ['result' => false];
        }

    }
    public function onFetchDataFromServer()
    {
        $value = $_POST['result'];
        $id = $_POST['id'];
        $id = explode('ok_', $id);
        $id = $id[1];
        $gnr_active = $value[0];
        
        $gnr_label = $value[1];
        $gnr_affi = $value[2];
        $gnr_review_butt = $value[3];
        $gnr_live_butt = $value[4];
        $gnr_sort = $value[5];
        $gnr_rating = $value[6];

        $gnr_coment = htmlentities(addslashes(trim($value[7],"\t\n\r\0\x0B")));
        $meta_title = $value[8];
        $meta_desc = $value[9];
        $meta_keywords = $value[10];
        $cont_pros = htmlspecialchars(addslashes(trim($value[11],"\t\n\r\0\x0B")));
        $cont_introduction = htmlspecialchars(addslashes(trim($value[12],"\t\n\r\0\x0B")));
        $cont_bonus = $value[13];
        $cont_topbutton = $value[14];
        $cont_botbutton = $value[15];
        $cont_affiliate = $value[16];
        $cont_active = $value[17];
        $udv_heading = $value[18];
        $udv_ratin = $value[19];
        $udv_content = htmlentities(addslashes(trim($value[20],"\t\n\r\0\x0B")));
        $prod_heading = $value[21];
        $prod_ratin = $value[22];
        $prod_content = htmlentities(addslashes(trim($value[23],"\t\n\r\0\x0B")));
        $lives_heading = $value[24];
        $lives_ratin = $value[25];
        $lives_content = htmlentities(addslashes(trim($value[26],"\t\n\r\0\x0B")));
        $odds_heading = $value[27];
        $odds_ratin = $value[28];
        $odds_content = htmlentities(addslashes(trim($value[29],"\t\n\r\0\x0B")));
        $supp_heading = $value[30];
        $supp_ratin = $value[31];
        $supp_content = htmlentities(addslashes(trim($value[32],"\t\n\r\0\x0B")));
        $bonusser_heading = $value[33];
        $bonusser_ratin = $value[34];
        $bonusser_content = htmlentities(addslashes(trim($value[35],"\t\n\r\0\x0B")));
        $bruger_heading = $value[36];
        $bruger_ratin = $value[37];
        $bruger_content = htmlentities(addslashes(trim($value[38],"\t\n\r\0\x0B")));
        $ind_og_heading = $value[39];
        $ind_og_ratin = $value[40];
        $ind_og_content = htmlentities(addslashes(trim($value[41],"\t\n\r\0\x0B")));
        $vores_heading = $value[42];
        $vores_ratin = $value[43];
        $vores_content = htmlentities(addslashes(trim($value[44],"\t\n\r\0\x0B")));
        $liveb_heading = $value[45];
        $liveb_ratin = $value[46];
        $liveb_content = htmlentities(addslashes(trim($value[47],"\t\n\r\0\x0B")));
        $indsat_heading = $value[48];
        $indsat_ratin = $value[49];
        $indsat_content = htmlentities(addslashes(trim($value[50],"\t\n\r\0\x0B")));
        $konk_heading = $value[51];
        $konk_ratin = $value[52];
        $gnr_false = $value[56];
        $cont_false_affiliate = $value[57];
        $konk_content = htmlentities(addslashes(trim($value[53],"\t\n\r\0\x0B")));
        $img_cont = htmlentities(addslashes("storage/app/media/Stream%20Provider/live-stream-reviews/" . $gnr_label . ".png"));
        $img_genr = htmlentities(addslashes("storage/app/media/Stream%20Provider/live-stream-reviews/" . $gnr_label . ".png"));

        $affected = Db::update('update
                                   rebel_penguin_stream_data
                                   set
                                      gnr_active = "' . $gnr_active . '",
                                      gnr_label =  "' . $gnr_label . '",
                                      gnr_affi = "' . $gnr_affi . '",
                                      gnr_false = "' . $gnr_false . '",
                                      gnr_review_butt = "' . $gnr_review_butt . '",
                                      gnr_live_butt = "' . $gnr_live_butt . '",
                                      gnr_sort = "' . $gnr_sort . '",
                                      gnr_rating = "' . $gnr_rating . '",
                                      gnr_coment = "' . $gnr_coment . '",

                                      meta_title = "' . $meta_title . '",
                                      meta_desc = "' . $meta_desc . '",
                                      meta_keywords = "' . $meta_keywords . '",

                                      cont_pros = "' . $cont_pros . '",
                                      cont_introduction = "' . $cont_introduction . '",
                                      cont_bonus = "' . $cont_bonus . '",
                                      cont_topbutton = "' . $cont_topbutton . '",
                                      cont_botbutton = "' . $cont_botbutton . '",
                                      cont_affiliate = "' . $cont_affiliate . '",
                                      cont_false_affiliate = "' . $cont_false_affiliate . '",
                                      cont_active = "' . $cont_active . '",

                                      udv_heading = "' . $udv_heading . '",
                                      udv_ratin ="' . $udv_ratin . '",
                                      udv_content = "' . $udv_content . '",

                                      prod_heading = "' . $prod_heading . '",
                                      prod_ratin = "' . $prod_ratin . '",
                                      prod_content = "' . $prod_content . '",

                                      lives_heading = "' . $lives_heading . '",
                                      lives_ratin = "' . $lives_ratin . '",
                                      lives_content = "' . $lives_content . '",

                                      odds_heading = "' . $odds_heading . '",
                                      odds_ratin ="' . $odds_ratin . '",
                                      odds_content = "' . $odds_content . '",

                                      supp_heading = "' . $supp_heading . '",
                                      supp_ratin = "' . $supp_ratin . '",
                                      supp_content = "' . $supp_content . '",

                                      bonusser_heading ="' . $bonusser_heading . '",
                                      bonusser_ratin = "' . $bonusser_ratin . '",
                                      bonusser_content ="' . $bonusser_content . '",

                                      bruger_heading = "' . $bruger_heading . '",
                                      bruger_ratin = "' . $bruger_ratin . '",
                                      bruger_content = "' . $bruger_content . '",

                                      ind_og_heading = "' . $ind_og_heading . '",
                                      ind_og_ratin = "' . $ind_og_ratin . '",
                                      ind_og_content = "' . $ind_og_content . '",

                                      vores_heading = "' . $vores_heading . '",
                                      vores_ratin = "' . $vores_ratin . '",
                                      vores_content = "' . $vores_content . '",

                                      liveb_heading = "' . $liveb_heading . '",
                                      liveb_ratin = "' . $liveb_ratin . '",
                                      liveb_content = "' . $liveb_content . '",

                                      indsat_heading = "' . $indsat_heading . '",
                                      indsat_ratin = "' . $indsat_ratin . '",
                                      indsat_content = "' . $indsat_content . '",

                                      konk_heading = "' . $konk_heading . '",
                                      konk_ratin = "' . $konk_ratin . '",
                                      konk_content ="' . $konk_content . '",

                                      img_cont ="' . $img_cont . '",
                                      img_genr ="' . $img_genr . '"
                                      where id_stp = ?', [$id ]);
        return ['result' => true];


    }
    public function onChangeStatus()
    {
        $id = $_POST['id'];
        $active = $_POST['active'];
        $id = explode('active_', $id);
        $id = $id[1];
        $affected = Db::update('update rebel_penguin_stream_p set active = ' . $active . ' where id_stp = ?', [$id]);
        $result = $this->index();
    }

    public function onChangeStatusSport()
    {
        $id = $_POST['id'];
        $realname= $_POST['name'];
        $name = template::Clearfeet_sport($_POST['name']);
        $active = $_POST['active'];
        if ($active == 'true') {
            $active = 1;
        } else {
            $active = 0;
        }
        $id = explode('sport_', $id);
        $id = $id[1];
        $color = substr(md5(time()), 0, 6);
        //$url = "http://web1.livegoals.dk:9255/api/v1.1/schedule/?sport=" . $id;
        $affected = Db::update('update rebel_penguin_sports set active = ' . $active . ' where id_sport = ?', [$id]);
        if (!$affected) {
            $copy = $this->onSaveSports($name);
            if ($copy == true) {
                Db::table('rebel_penguin_sports')
                    ->insert([
                        'name'      =>  $name,
                        'url_api_server' =>  '',
                        'active'    =>  $active,
                        'color'     =>  $color,
                        'id_sport'  =>  trim($id, "\t\n\r\0\x0B"),
                        'realname'  =>  $realname
                    ]);
            } else
                return 'Hay algun error';
        }

        return true;
    }

    public function onLandingPagesh()
    {
        $id = $_POST['id'];
        $data_array = $_POST['array_'];
        $id = explode('landing_', $id);
        $id = $id[1];
        $genral = Db::table('rebel_penguin_landingpage_showcase')
            ->select('rebel_penguin_landingpage_showcase.*')
            ->where('rebel_penguin_landingpage_showcase.id_event', '=', $id)
            ->where('rebel_penguin_landingpage_showcase.id_sport', '=', $data_array[11])
            ->get();

        if (count($genral) <= 0) {
            Db::table('rebel_penguin_landingpage_showcase')->insert(
                [
                    'id_event' => template::Clearspace_end($id),
                    'id_sport' => template::Clearspace_end($data_array[11]),
                    'home_team' => template::Clearspace_end($data_array[7]),
                    'away_team' => template::Clearspace_end($data_array[8]),
                    'eventdate' => $data_array[1],
                    'eventhour' => $data_array[1],
                    'home_team_logo' => $data_array[9],
                    'away_team_logo' => $data_array[10],
                    'active' => 1,
                ]

            );
        } else {
            if ($genral[0]->active == 1) {
                Db::table('rebel_penguin_landingpage_showcase')
                    ->where('id', $genral[0]->id)
                    ->update(
                        [
                            'active' => 0,
                        ]
                    );
            } else {
                Db::table('rebel_penguin_landingpage_showcase')
                    ->where('id', $genral[0]->id)
                    ->update(
                        [
                            'active' => 1,
                        ]
                    );
            }
        }
        return true;
    }
    public function onLandingPagesave()
    {
        $data_array = $_POST['data_array'];
        $artid = $_POST['id'];
        $gnr_checkbox_use = $_POST['gnr_checkbox_use'];
        $Sponsoreret = $_POST['Sponsoreret'];
        $gnr_checkbox = $_POST['gnr_checkbox'];
        $id = explode('landpage_', $artid);
        $id = $id[1];
        $Stream_id = 0;
        $article = Db::select('select * from rebel_penguin_landing_article where id_artc = ? ', [$id]);
        if (count($article) <= 0) {
            Db::table('rebel_penguin_landing_article')->insert(
                [
                    'id_artc' =>template::Clearfeet($id),
                    'pagetitle' => $data_array['pagtitle'],
                    'urltoken' => $data_array['Token'],
                    'metadescrip' => $data_array['Description'],
                    'metakeyb' => $data_array['Keywords'],
                    'prombox_head' => $data_array['Heading'],
                    'prombox_affil' => $data_array['Affiliate'],
                    'prombox_banner_head' => $data_array['Heading1'],
                    'prombox_aff_tv' => $data_array['OnTV'],
                    'prombox_banner_subH' => $data_array['OnTV'],
                    'Sponsoreret' => $Sponsoreret,
                    'promobox_link' => $gnr_checkbox,
                    'usedarticle' => $gnr_checkbox_use
                ]
            );
        } else {
            Db::table('rebel_penguin_landing_article')
                ->where('id_artc', '=', $id)
                ->update(
                    [
                        'pagetitle' => $data_array['pagtitle'],
                        'urltoken' => $data_array['Token'],
                        'metadescrip' => $data_array['Description'],
                        'metakeyb' => $data_array['Keywords'],
                        'prombox_head' => $data_array['Heading'],
                        'prombox_affil' => $data_array['Affiliate'],
                        'prombox_banner_head' => $data_array['Heading1'],
                        'prombox_aff_tv' => $data_array['OnTV'],
                        'prombox_banner_subH' => $data_array['OnTV'],
                        'Sponsoreret' => $Sponsoreret,
                        'promobox_link' => $gnr_checkbox,
                        'usedarticle' => $gnr_checkbox_use
                    ]
                );
        }

        $stream = Db::select('select * from rebel_penguin_stream_p where active = ? ', [1]);
        if (count($stream) > 0) {
            for ($i = 0; $i < count($stream); $i++) {
                $idSTR = $stream[$i]->id_stp;
                $stream_article = Db::select('select * from rebel_penguin_landing_Stream where id_stream = ? and id_artc = ?', [$idSTR, $id]);
                $Stream_Heading = 'Stream_Heading_' . $idSTR;
                $Stream_Aff_ = 'Stream_Aff_' . $idSTR;
                $Stream_Content_ = 'Stream_Content_' . $idSTR;
                $Stream_Sort_ = 'Stream_Sort_' . $idSTR;
                $Stream_Icon1_ = 'Stream_Icon1_' . $idSTR;
                $Stream_Icon2_ = 'Stream_Icon2_' . $idSTR;
                $Stream_Icon3_ = 'Stream_Icon3_' . $idSTR;
                $Stream_Phrase_ = 'Stream_Phrase_' . $idSTR;
                $Stream_ButtonText_ = 'Stream_ButtonText_' . $idSTR;
                $promobox_ = 'promobox_' . $idSTR;
                $Price_ = 'Price_' . $idSTR;
                $Quality_ = 'Quality_' . $idSTR;
                $Rating_ = 'Rating_' . $idSTR;
                $Disclaimer_ = 'Disclaimer_' . $idSTR;
                $Showsponsored = 'Showsponsored_' . $idSTR;

                if (count($stream_article) <= 0) {
                    Db::table('rebel_penguin_landing_Stream')->insert(
                        [
                            'id_artc' => trim($id, "\t\n\r\0\x0B"),
                            'id_stream' => $idSTR,
                            'stream_head' => $data_array[$Stream_Heading],
                            'stream_aff' => $data_array[$Stream_Aff_],
                            'stream_content' => $data_array[$Stream_Content_],
                            'stream_sort' => $data_array[$Stream_Sort_],
                            'stream_icon_one' => $data_array[$Stream_Icon1_],
                            'stream_icon_two' => $data_array[$Stream_Icon2_],
                            'stream_icon_tree' => $data_array[$Stream_Icon3_],
                            'stream_buttons_phrase' => $data_array[$Stream_Phrase_],
                            'stream_buttons_butt' => $data_array[$Stream_ButtonText_],
                            'promobox' => $data_array[$promobox_],
                            'Price' => $data_array[$Price_],
                            'Quality' => $data_array[$Quality_],
                            'Rating' => $data_array[$Rating_],
                            'sponsored' => $data_array[$Showsponsored],
                            'Disclaimer' => $data_array[$Disclaimer_],
                            'active' => 1
                        ]

                    );
                } else {
                    Db::table('rebel_penguin_landing_Stream')
                        ->where('id_artc', '=', $id)
                        ->where('id_stream', '=', $idSTR)
                        ->update(
                            [
                                'id_artc' => $id,
                                'id_stream' => $idSTR,
                                'stream_head' => $data_array[$Stream_Heading],
                                'stream_aff' => $data_array[$Stream_Aff_],
                                'stream_content' => $data_array[$Stream_Content_],
                                'stream_sort' => $data_array[$Stream_Sort_],
                                'stream_icon_one' => $data_array[$Stream_Icon1_],
                                'stream_icon_two' => $data_array[$Stream_Icon2_],
                                'stream_icon_tree' => $data_array[$Stream_Icon3_],
                                'stream_buttons_phrase' => $data_array[$Stream_Phrase_],
                                'stream_buttons_butt' => $data_array[$Stream_ButtonText_],
                                'promobox' => $data_array[$promobox_],
                                'Price' => $data_array[$Price_],
                                'Quality' => $data_array[$Quality_],
                                'Rating' => $data_array[$Rating_],
                                'sponsored' => $data_array[$Showsponsored],
                                'Disclaimer' => $data_array[$Disclaimer_],
                                'active' => 1
                            ]
                        );
                }

            }
        }


    }
    public function onLandingPage()
    {
        $id = $_POST['id'];
        $id = explode('landpage_', $id);
        $id = $id[1];
        $error = [];
        $genral = Db::table('landainPagesData')
            ->select('landainPagesData.*')
            ->where('landainPagesData.article_id', '=', $id)
            ->get();
        if (count($genral) > 0) {
            return $genral;
        } else {
            $error[0]['error'] = 'error';
            return $error;
        }


    }
    public function onStreamDataSports()
    {
        $data_array = $_POST['_array'];
        $stram_prov_id = $_POST['stram_prov_id'];
        $stram_prov_id = explode('sportconf_', $stram_prov_id);
        $stram_prov_id = $stram_prov_id[1];
        //var_dump($data_array['gpp_button_aff']);
        $genral = Db::select('select * from rebel_penguin_stream_general where id_sport = ? and id_stream = ?', [$data_array['Id_Sport'], $stram_prov_id]);
        $GM = Db::select('select * from rebel_penguin_stream_general_manager where id_sport = ? and id_stream = ?', [$data_array['Id_Sport'], $stram_prov_id]);
        $GD = Db::select('select * from rebel_penguin_stream_page_details where id_sport = ? and id_stream = ?', [$data_array['Id_Sport'], $stram_prov_id]);
        $GPD = Db::select('select * from rebel_penguin_stream_provider_page where id_sport = ? and id_stream = ?', [$data_array['Id_Sport'], $stram_prov_id]);

        if (count($genral) <= 0) {
            Db::table('rebel_penguin_stream_general')->insert(
                [
                    'id_sport' => $data_array['Id_Sport'],
                    'id_stream' => $stram_prov_id,
                    'gnr_label' => $data_array['gnr_label'],
                    'gnr_rating' => $data_array['gnr_rating'],
                    'gnr_afflink' => $data_array['gnr_afflink'],
                    'gnr_false_aff' => $data_array['gnr_false_aff_'],
                    'gnr_quality' => $data_array['gnr_quality'],
                    'gnr_sort' => $data_array['gnr_sort'],
                    'gnr_size' => $data_array['gnr_size'],
                    'gnr_price' => $data_array['gnr_price']
                ]

            );
        } else {
            Db::table('rebel_penguin_stream_general')
                ->where('id', $genral[0]->id)
                ->update(
                    [
                        'id_sport' => $data_array['Id_Sport'],
                        'id_stream' => $stram_prov_id,
                        'gnr_label' => $data_array['gnr_label'],
                        'gnr_rating' => $data_array['gnr_rating'],
                        'gnr_afflink' => $data_array['gnr_afflink'],
                        'gnr_false_aff' => $data_array['gnr_false_aff_'],
                        'gnr_quality' => $data_array['gnr_quality'],
                        'gnr_sort' => $data_array['gnr_sort'],
                        'gnr_size' => $data_array['gnr_size'],
                        'gnr_price' => $data_array['gnr_price']
                    ]
                );
        }

        if (count($GM) <= 0) {
            Db::table('rebel_penguin_stream_general_manager')->insert(
                [
                    'id_sport' => $data_array['Id_Sport'],
                    'id_stream' => $stram_prov_id,
                    'gpm_head' => htmlentities(addslashes(template::Clearstream($data_array['gpm_head']))),
                    'gpm_quality_head' => htmlentities(addslashes(template::Clearstream($data_array['gpm_quality_head']))),
                    'gpm_quality_content' => $data_array['gpm_quality_content'],
                    'gpm_udv_head' => htmlentities(addslashes(template::Clearstream($data_array['gpm_udv_head']))),
                    'gpm_udv_content' => $data_array['gpm_udv_content'],
                    'gpm_price_head' => htmlentities(addslashes(template::Clearstream($data_array['gpm_price_head']))),
                    'gpm_price_content' =>$data_array['gpm_price_content'],
                    'gpm_icon_H_one' => htmlentities(addslashes(template::Clearstream($data_array['gpm_icon_H_one']))),
                    'gpm_icon_S_one' => htmlentities(addslashes(template::Clearstream($data_array['gpm_icon_S_one']))),
                    'gpm_icon_H_two' => htmlentities(addslashes(template::Clearstream($data_array['gpm_icon_H_two']))),
                    'gpm_icon_S_two' => htmlentities(addslashes(template::Clearstream($data_array['gpm_icon_S_two']))),
                    'gpm_icon_H_three' => htmlentities(addslashes(template::Clearstream($data_array['gpm_icon_H_three']))),
                    'gpm_icon_S_three' => htmlentities(addslashes(template::Clearstream($data_array['gpm_icon_S_three']))),
                    'gpm_icon_N_three' => htmlentities(addslashes(template::Clearstream($data_array['gpm_icon_N_three']))),
                    'gpm_button_rew' => htmlentities(addslashes(template::Clearstream($data_array['gpm_button_rew']))),
                    'gpm_button_wlive' => htmlentities(addslashes(template::Clearstream($data_array['gpm_button_wlive']))),
                    'gpm_button_aff' => $data_array['gpm_button_aff'],
                    'gpm_false_button_aff' => htmlentities(addslashes(template::Clearstream($data_array['gpm_false_button_aff_'])))
                ]

            );
        } else {
            Db::table('rebel_penguin_stream_general_manager')
                ->where('id', $GM[0]->id)
                ->update(
                    [
                        'id_sport' => $data_array['Id_Sport'],
                        'id_stream' => template::Clearfeet($stram_prov_id),
                        'gpm_head' => $data_array['gpm_head'],
                        'gpm_quality_head' => htmlentities(addslashes(template::Clearstream($data_array['gpm_quality_head']))),
                        'gpm_quality_content' => $data_array['gpm_quality_content'],
                        'gpm_udv_head' => htmlentities(addslashes(template::Clearstream($data_array['gpm_udv_head']))),
                        'gpm_udv_content' =>$data_array['gpm_udv_content'],
                        'gpm_price_head' => htmlentities(addslashes(template::Clearstream($data_array['gpm_price_head']))),
                        'gpm_price_content' =>$data_array['gpm_price_content'],
                        'gpm_icon_H_one' => htmlentities(addslashes(template::Clearstream($data_array['gpm_icon_H_one']))),
                        'gpm_icon_S_one' => htmlentities(addslashes(template::Clearstream($data_array['gpm_icon_S_one']))),
                        'gpm_icon_H_two' => htmlentities(addslashes(template::Clearstream($data_array['gpm_icon_H_two']))),
                        'gpm_icon_S_two' => htmlentities(addslashes(template::Clearstream($data_array['gpm_icon_S_two']))),
                        'gpm_icon_H_three' => htmlentities(addslashes(template::Clearstream($data_array['gpm_icon_H_three']))),
                        'gpm_icon_S_three' => htmlentities(addslashes(template::Clearstream($data_array['gpm_icon_S_three']))),
                        'gpm_icon_N_three' => htmlentities(addslashes(template::Clearstream($data_array['gpm_icon_N_three']))),
                        'gpm_button_rew' => htmlentities(addslashes(template::Clearstream($data_array['gpm_button_rew']))),
                        'gpm_button_wlive' => htmlentities(addslashes(template::Clearstream($data_array['gpm_button_wlive']))),
                        'gpm_button_aff' => $data_array['gpm_button_aff'],
                        'gpm_false_button_aff' => htmlentities(addslashes(template::Clearstream($data_array['gpm_false_button_aff_'])))
                    ]
                );
        }

        if (count($GD) <= 0) {
            Db::table('rebel_penguin_stream_page_details')->insert(
                [
                    'id_sport' => template::Clearfeet($data_array['Id_Sport']),
                    'id_stream' => template::Clearfeet($stram_prov_id),
                    'gpd_head' => htmlentities(addslashes(template::Clearstream($data_array['gpd_head']))),
                    'gpd_icon_note' => htmlentities(addslashes(template::Clearstream($data_array['gpd_icon_note']))),
                    'gpd_icon_H_one' => htmlentities(addslashes(template::Clearstream($data_array['gpd_icon_H_one']))),
                    'gpd_icon_S_one' => htmlentities(addslashes(template::Clearstream($data_array['gpd_icon_S_one']))),
                    'gpd_icon_H_two' => htmlentities(addslashes(template::Clearstream($data_array['gpd_icon_H_two']))),
                    'gpd_icon_S_two' => htmlentities(addslashes(template::Clearstream($data_array['gpd_icon_S_two']))),
                    'gpd_icon_H_three' => htmlentities(addslashes(template::Clearstream($data_array['gpd_icon_H_three']))),
                    'gpd_icon_S_three' => htmlentities(addslashes(template::Clearstream($data_array['gpd_icon_S_three']))),
                    'gpd_button_head' => htmlentities(addslashes(template::Clearstream($data_array['gpd_button_head']))),
                    'gpd_button_subhead' => htmlentities(addslashes(template::Clearstream($data_array['gpd_button_subhead']))),
                    'gpd_button_aff' => $data_array['gpd_button_aff'],
                    'gpd_false_button_aff' => htmlentities(addslashes(template::Clearstream($data_array['gpd_false_button_aff_']))),
                    'gpd_button_disclaimer' => htmlentities(addslashes(template::Clearstream($data_array['gpd_button_disclaimer'])))

                ]

            );
        } else {
            Db::table('rebel_penguin_stream_page_details')
                ->where('id', $GD[0]->id)
                ->update(
                    [
                        'id_sport' => template::Clearfeet($data_array['Id_Sport']),
                        'id_stream' => template::Clearfeet($stram_prov_id),
                        'gpd_head' => htmlentities(addslashes(template::Clearstream($data_array['gpd_head']))),
                        'gpd_icon_note' => htmlentities(addslashes(template::Clearstream($data_array['gpd_icon_note']))),
                        'gpd_icon_H_one' => htmlentities(addslashes(template::Clearstream($data_array['gpd_icon_H_one']))),
                        'gpd_icon_S_one' => htmlentities(addslashes(template::Clearstream($data_array['gpd_icon_S_one']))),
                        'gpd_icon_H_two' => htmlentities(addslashes(template::Clearstream($data_array['gpd_icon_H_two']))),
                        'gpd_icon_S_two' => htmlentities(addslashes(template::Clearstream($data_array['gpd_icon_S_two']))),
                        'gpd_icon_H_three' => htmlentities(addslashes(template::Clearstream($data_array['gpd_icon_H_three']))),
                        'gpd_icon_S_three' => htmlentities(addslashes(template::Clearstream($data_array['gpd_icon_S_three']))),
                        'gpd_button_head' => htmlentities(addslashes(template::Clearstream($data_array['gpd_button_head']))),
                        'gpd_button_subhead' => htmlentities(addslashes(template::Clearstream($data_array['gpd_button_subhead']))),
                        'gpd_button_aff' => $data_array['gpd_button_aff'],
                        'gpd_false_button_aff' => htmlentities(addslashes(template::Clearstream($data_array['gpd_false_button_aff_']))),
                        'gpd_button_disclaimer' => htmlentities(addslashes(template::Clearstream($data_array['gpd_button_disclaimer'])))

                    ]
                );

        }

        if (count($GPD) <= 0) {
            Db::table('rebel_penguin_stream_provider_page')->insert(
                [
                    'id_sport' => template::Clearfeet($data_array['Id_Sport']),
                    'id_stream' => template::Clearfeet($stram_prov_id),
                    'gpp_head' => htmlentities(addslashes(template::Clearstream($data_array['gpp_head']))),
                    'gpp_quality_head' => htmlentities(addslashes(template::Clearstream($data_array['gpp_quality_head']))),
                    'gpp_quality_content' => $data_array['gpp_quality_content'],
                    'gpp_udv_head' => htmlentities(addslashes(template::Clearstream($data_array['gpp_udv_head']))),
                    'gpp_udv_content' =>$data_array['gpp_udv_content'],
                    'gpp_price_head' => htmlentities(addslashes(template::Clearstream($data_array['gpp_price_head']))),
                    'gpp_price_content' => $data_array['gpp_price_content'],
                    'gpp_icon_H_one' => htmlentities(addslashes(template::Clearstream($data_array['gpp_icon_H_one']))),
                    'gpp_icon_S_one' => htmlentities(addslashes(template::Clearstream($data_array['gpp_icon_S_one']))),
                    'gpp_icon_H_two' => htmlentities(addslashes(template::Clearstream($data_array['gpp_icon_H_two']))),
                    'gpp_icon_S_two' => htmlentities(addslashes(template::Clearstream($data_array['gpp_icon_S_two']))),
                    'gpp_icon_H_three' => htmlentities(addslashes(template::Clearstream($data_array['gpp_icon_H_three']))),
                    'gpp_icon_S_three' => htmlentities(addslashes(template::Clearstream($data_array['gpp_icon_S_three']))),
                    'gpp_icon_note' => htmlentities(addslashes(template::Clearstream($data_array['gpp_icon_note']))),
                    'gpp_button_rew' => htmlentities(addslashes(template::Clearstream($data_array['gpp_button_rew']))),
                    'gpp_button_wlive' => htmlentities(addslashes(template::Clearstream($data_array['gpp_button_wlive']))),
                    'gpp_button_aff' => $data_array['gpp_button_aff'],
                    'gpp_false_button_aff' => htmlentities(addslashes(template::Clearstream($data_array['gpp_false_button_aff_']))),
                    'gpp_button_disclaimer' => htmlentities(addslashes(template::Clearstream($data_array['gpp_button_disclaimer']))),
                    'gpd_points_head_' => htmlentities(addslashes(template::Clearstream($data_array['gpd_points_head_']))),
                    'gpd_points_pointOne_' => htmlentities(addslashes(template::Clearstream($data_array['gpd_points_pointOne_']))),
                    'gpd_points_pointTwo_' => htmlentities(addslashes(template::Clearstream($data_array['gpd_points_pointTwo_']))),
                    'gpd_points_pointTree_' => htmlentities(addslashes(template::Clearstream($data_array['gpd_points_pointTree_'])))

                ]

            );
        } else {
            Db::table('rebel_penguin_stream_provider_page')
                ->where('id', $GPD[0]->id)
                ->update(
                    [
                        'id_sport' => template::Clearfeet($data_array['Id_Sport']),
                        'id_stream' => template::Clearfeet($stram_prov_id),
                        'gpp_head' => htmlentities(addslashes(template::Clearstream($data_array['gpp_head']))),
                        'gpp_quality_head' => htmlentities(addslashes(template::Clearstream($data_array['gpp_quality_head']))),
                        'gpp_quality_content' =>$data_array['gpp_quality_content'],
                        'gpp_udv_head' => htmlentities(addslashes(template::Clearstream($data_array['gpp_udv_head']))),
                        'gpp_udv_content' => $data_array['gpp_udv_content'],
                        'gpp_price_head' => htmlentities(addslashes(template::Clearstream($data_array['gpp_price_head']))),
                        'gpp_price_content' => $data_array['gpp_price_content'],
                        'gpp_icon_H_one' => htmlentities(addslashes(template::Clearstream($data_array['gpp_icon_H_one']))),
                        'gpp_icon_S_one' => htmlentities(addslashes(template::Clearstream($data_array['gpp_icon_S_one']))),
                        'gpp_icon_H_two' => htmlentities(addslashes(template::Clearstream($data_array['gpp_icon_H_two']))),
                        'gpp_icon_S_two' => htmlentities(addslashes(template::Clearstream($data_array['gpp_icon_S_two']))),
                        'gpp_icon_H_three' => htmlentities(addslashes(template::Clearstream($data_array['gpp_icon_H_three']))),
                        'gpp_icon_S_three' => htmlentities(addslashes(template::Clearstream($data_array['gpp_icon_S_three']))),
                        'gpp_icon_note' => htmlentities(addslashes(template::Clearstream($data_array['gpp_icon_note']))),
                        'gpp_button_rew' => htmlentities(addslashes(template::Clearstream($data_array['gpp_button_rew']))),
                        'gpp_button_wlive' => htmlentities(addslashes(template::Clearstream($data_array['gpp_button_wlive']))),
                        'gpp_button_aff' => $data_array['gpp_button_aff'],
                        'gpp_false_button_aff' => htmlentities(addslashes(template::Clearstream($data_array['gpp_false_button_aff_']))),
                        'gpp_button_disclaimer' => htmlentities(addslashes(template::Clearstream($data_array['gpp_button_disclaimer']))),
                        'gpd_points_head_' => htmlentities(addslashes(template::Clearstream($data_array['gpd_points_head_']))),
                        'gpd_points_pointOne_' => htmlentities(addslashes(template::Clearstream($data_array['gpd_points_pointOne_']))),
                        'gpd_points_pointTwo_' => htmlentities(addslashes(template::Clearstream($data_array['gpd_points_pointTwo_']))),
                        'gpd_points_pointTree_' => htmlentities(addslashes(template::Clearstream($data_array['gpd_points_pointTree_'])))
                    ]
                );
        }

        return true;
    }
    public function onUpdateStreamPerSport()
    {
        $id_stream = $_POST['id'];
        $id_stream = explode('sportconf_', $id_stream);
        $id_stream = $id_stream[1];
        $data = array();
        $result = Db::select('select * from streampersport where id_stp = ?', [$id_stream]);
        for ($i = 0; $i < count($result); $i++) {
            $data[$result[$i]->name]['name'] = $result[$i]->name;
            $data[$result[$i]->name]['id_sport'] = template::Clearfeet($result[$i]->id_sport);
            $data[$result[$i]->name]['id_stream'] = template::Clearfeet($result[$i]->id_stp);

            /* -------------- Genera Info ---------------- */
            $data[$result[$i]->name]['gnr_label'] = $result[$i]->gnr_label;
            $data[$result[$i]->name]['gnr_afflink'] = $result[$i]->gnr_afflink;
            $data[$result[$i]->name]['gnr_false_aff'] = $result[$i]->gnr_false_aff;
            $data[$result[$i]->name]['gnr_quality'] = $result[$i]->gnr_quality;
            $data[$result[$i]->name]['gnr_sort'] = $result[$i]->gnr_sort;
            $data[$result[$i]->name]['gnr_size'] = $result[$i]->gnr_size;
            $data[$result[$i]->name]['gnr_price'] = $result[$i]->gnr_price;
            $data[$result[$i]->name]['gnr_active'] = $result[$i]->gnr_active;
            $data[$result[$i]->name]['gnr_rating'] = $result[$i]->gnr_rating;

            /* --------------Stream_general_manager ---------------- */
            $data[$result[$i]->name]['gpm_head'] = html_entity_decode($result[$i]->gpm_head);
            $data[$result[$i]->name]['gpm_active'] = html_entity_decode($result[$i]->gpm_active);
            $data[$result[$i]->name]['gpm_quality_head'] = html_entity_decode($result[$i]->gpm_quality_head);
            $data[$result[$i]->name]['gpm_quality_content'] = html_entity_decode($result[$i]->gpm_quality_content);
            $data[$result[$i]->name]['gpm_udv_head'] = html_entity_decode($result[$i]->gpm_udv_head);
            $data[$result[$i]->name]['gpm_udv_content'] = html_entity_decode($result[$i]->gpm_udv_content);
            $data[$result[$i]->name]['gpm_price_head'] = html_entity_decode($result[$i]->gpm_price_head);
            $data[$result[$i]->name]['gpm_price_content'] = html_entity_decode($result[$i]->gpm_price_content);
            $data[$result[$i]->name]['gpm_icon_H_one'] = html_entity_decode($result[$i]->gpm_icon_H_one);
            $data[$result[$i]->name]['gpm_icon_S_one'] = html_entity_decode($result[$i]->gpm_icon_S_one);
            $data[$result[$i]->name]['gpm_icon_H_two'] = html_entity_decode($result[$i]->gpm_icon_H_two);
            $data[$result[$i]->name]['gpm_icon_S_two'] = html_entity_decode($result[$i]->gpm_icon_S_two);
            $data[$result[$i]->name]['gpm_icon_H_three'] = html_entity_decode($result[$i]->gpm_icon_H_three);
            $data[$result[$i]->name]['gpm_icon_S_three'] = html_entity_decode($result[$i]->gpm_icon_S_three);
            $data[$result[$i]->name]['gpm_icon_N_three'] = html_entity_decode($result[$i]->gpm_icon_N_three);
            $data[$result[$i]->name]['gpm_button_rew'] = html_entity_decode($result[$i]->gpm_button_rew);
            $data[$result[$i]->name]['gpm_button_wlive'] = html_entity_decode($result[$i]->gpm_button_wlive);
            $data[$result[$i]->name]['gpm_button_aff'] = html_entity_decode($result[$i]->gpm_button_aff);
            $data[$result[$i]->name]['gpm_false_button_aff'] = html_entity_decode($result[$i]->gpm_false_button_aff);

            /* -------------- Stream_page_details ---------------- */
            $data[$result[$i]->name]['gpd_head'] = html_entity_decode($result[$i]->gpd_head);
            $data[$result[$i]->name]['gpd_icon_note'] = html_entity_decode($result[$i]->gpd_icon_note);
            $data[$result[$i]->name]['gpd_icon_H_one'] = html_entity_decode($result[$i]->gpd_icon_H_one);
            $data[$result[$i]->name]['gpd_icon_S_one'] = html_entity_decode($result[$i]->gpd_icon_S_one);
            $data[$result[$i]->name]['gpd_icon_H_two'] = html_entity_decode($result[$i]->gpd_icon_H_two);
            $data[$result[$i]->name]['gpd_icon_S_two'] = html_entity_decode($result[$i]->gpd_icon_S_two);
            $data[$result[$i]->name]['gpd_icon_H_three'] = html_entity_decode($result[$i]->gpd_icon_H_three);
            $data[$result[$i]->name]['gpd_icon_S_three'] = html_entity_decode($result[$i]->gpd_icon_S_three);
            $data[$result[$i]->name]['gpd_button_head'] = html_entity_decode($result[$i]->gpd_button_head);
            $data[$result[$i]->name]['gpd_button_subhead'] = html_entity_decode($result[$i]->gpd_button_subhead);
            $data[$result[$i]->name]['gpd_button_aff'] = html_entity_decode($result[$i]->gpd_button_aff);
            $data[$result[$i]->name]['gpd_false_button_aff'] = html_entity_decode($result[$i]->gpd_false_button_aff);
            $data[$result[$i]->name]['gpd_button_disclaimer'] = html_entity_decode($result[$i]->gpd_button_disclaimer);
            $data[$result[$i]->name]['gpd_points_head_'] = html_entity_decode($result[$i]->gpd_points_head_);
            $data[$result[$i]->name]['gpd_points_pointOne_'] = html_entity_decode($result[$i]->gpd_points_pointOne_);
            $data[$result[$i]->name]['gpd_points_pointTwo_'] = html_entity_decode($result[$i]->gpd_points_pointTwo_);
            $data[$result[$i]->name]['gpd_points_pointTree_'] = html_entity_decode($result[$i]->gpd_points_pointTree_);

            /* -------------- Stream_provider_page ---------------- */
            $data[$result[$i]->name]['gpp_head'] = html_entity_decode($result[$i]->gpp_head);
            $data[$result[$i]->name]['gpp_quality_head'] = html_entity_decode($result[$i]->gpp_quality_head);
            $data[$result[$i]->name]['gpp_quality_content'] = html_entity_decode($result[$i]->gpp_quality_content);
            $data[$result[$i]->name]['gpp_udv_head'] = html_entity_decode($result[$i]->gpp_udv_head);
            $data[$result[$i]->name]['gpp_udv_content'] = html_entity_decode($result[$i]->gpp_udv_content);
            $data[$result[$i]->name]['gpp_price_head'] = html_entity_decode($result[$i]->gpp_price_head);
            $data[$result[$i]->name]['gpp_price_content'] = html_entity_decode($result[$i]->gpp_price_content);
            $data[$result[$i]->name]['gpp_icon_H_one'] = html_entity_decode($result[$i]->gpp_icon_H_one);
            $data[$result[$i]->name]['gpp_icon_S_one'] = html_entity_decode($result[$i]->gpp_icon_S_one);
            $data[$result[$i]->name]['gpp_icon_H_two'] = html_entity_decode($result[$i]->gpp_icon_H_two);
            $data[$result[$i]->name]['gpp_icon_S_two'] = html_entity_decode($result[$i]->gpp_icon_S_two);
            $data[$result[$i]->name]['gpp_icon_H_three'] = html_entity_decode($result[$i]->gpp_icon_H_three);
            $data[$result[$i]->name]['gpp_icon_S_three'] = html_entity_decode($result[$i]->gpp_icon_S_three);
            $data[$result[$i]->name]['gpp_icon_note'] = html_entity_decode($result[$i]->gpp_icon_note);
            $data[$result[$i]->name]['gpp_button_rew'] = html_entity_decode($result[$i]->gpp_button_rew);
            $data[$result[$i]->name]['gpp_button_wlive'] = html_entity_decode($result[$i]->gpp_button_wlive);
            $data[$result[$i]->name]['gpp_button_aff'] = html_entity_decode($result[$i]->gpp_button_aff);
            $data[$result[$i]->name]['gpp_false_button_aff'] = html_entity_decode($result[$i]->gpp_false_button_aff);
            $data[$result[$i]->name]['gpp_button_disclaimer'] = html_entity_decode($result[$i]->gpp_button_disclaimer);
            /* -------------- End ---------------- */

        }

        return $data;
    }

    /*--------------Article System--------------------*/
    public function onLoadArticleData()
    {
        $id = $_POST['id'];
        $id = explode('art_', $id);
        $id = $id[1];
        $data = Db::select('select * from rebel_penguin_article where id_evento = ?', [$id]);
        $result = array();
        $a = 0;
        if (count($data) != 0) {
            $result = [
                'id' => template::Clearfeet($data[$a]->id),
                'id_event' => template::Clearfeet($data[$a]->id_evento),
                'name' => $data[$a]->artic_name,
                'date' => $data[$a]->date,
                'date_h' => $data[$a]->date_h,
                'match_' => $data[$a]->match_,
                'date_h' => $data[$a]->date_h,
                'country' => $data[$a]->country,
                'liga' => $data[$a]->liga,
                'caption' => html_entity_decode($data[$a]->caption),
                'autor' => $data[$a]->autor,
                'artic_name' => html_entity_decode($data[$a]->artic_name),
                'article_body' => html_entity_decode($data[$a]->article_body),
                'show_front' => $data[$a]->show_front,
                'permanet_front' => $data[$a]->permanet_front,
                'date_create' => $data[$a]->date_create,
                'vip_article' => $data[$a]->vip_article,
                'date_update' => $data[$a]->date_update];
            return $result;
        } else {
            $result = ['error' => 'This match no have information yet, be the first at writter',];
            return $result;
        }


    }
    public function onSaveDataArticle()
    {
        $value = $_POST['result'];
        $hora =  date("Y-m-d H:s", strtotime($value[1]));
        $event = $value[2];
        $country = $value[3];
        $id_sport = template::Clearspace($value[18]);
        $liga = $value[4];
        $id_event = template::Clearspace(htmlentities(addslashes($value[5])));
        $article_body = htmlentities(addslashes($value[6]));
        $article_caption = htmlentities(addslashes($value[7]));
        $article_frontpage = $value[8];
        $article_prioritize = $value[9];
        $vip_article = $value[15];
        $article_name = htmlentities(addslashes($value[10]));
        $article_autor = htmlentities(addslashes($value[11]));
        $home_team = template::Clearspace_end(htmlentities(addslashes($value[13])));
        $away_team = template::Clearspace_end(htmlentities(addslashes($value[14])));
        $home_team_logo = htmlentities(addslashes($value[16]));
        $away_team_logo = htmlentities(addslashes($value[17]));
        $date = date("Y-m-d", strtotime($value[12]));
        $midate = date('Y-m-d h:i:s');
        $results = Db::table('rebel_penguin_article')->where('id_evento', $id_event)->count();
        $jornalist = $this->user->first_name;
        $jornalist_name = $this->user->first_name.' '.$this->user->last_name;
        if ($results == 0) {
            Db::table('rebel_penguin_article')->insert([
                    'id_evento' => template::Clearfeet($id_event),
                    'id_sport' =>  template::Clearfeet($id_sport),
                    'autor' =>$jornalist,
                    'autor_name' =>  $jornalist_name,
                    'date' => template::Clearfeet($date),
                    'date_h' => $hora,
                    'match_' => $event,
                    'country' => $country,
                    'liga' => $liga,
                    'artic_name' => $article_name,
                    'caption' => $article_caption,
                    'article_body' =>  $article_body,
                    'show_front' => $article_frontpage,
                    'permanet_front' =>  $article_prioritize,
                    'date_create' => $midate,
                    'date_update' => $midate,
                    'home_team' => template::Clearspace_end($home_team),
                    'away_team' => template::Clearspace_end($away_team),
                    'vip_article' =>  $vip_article,
                    'home_team_logo' => $home_team_logo,
                    'away_team_logo' =>  $away_team_logo,
                    'active' => 1
                ]);
            Db::table('rebel_penguin_listevent')->insert(['id_event' => $id_event, 'active' => 1]);
            $tokent = template::getTokendotherID($id_event);


            if($tokent == 'error'){template::UpdatetokenbyID($id_event,template::Clearfeet($id_sport));}
        }
        else {
            Db::update('update rebel_penguin_article set
                        date = "'.template::Clearfeet($date).'",
                        id_sport = "' . $id_sport . '",
                        date_h = "' . $hora . '",
                        match_ = "' . $event . '",
                        country = "' . $country . '",
                        liga = "' . $liga . '",
                        id_evento = "' . $id_event . '",
                        caption = "' . $article_caption . '",
                        autor = "' . $jornalist . '",
                        autor_name = "' . $jornalist_name . '",
                        artic_name = "' . $article_name . '",
                        article_body = "' . $article_body . '",
                        show_front = "' . $article_frontpage . '",
                        permanet_front = "' . $article_prioritize . '",
                        date_update = "' . $midate . '",
                        vip_article = "' . $vip_article . '"
                        where id_evento = ?', [$id_event]);
        }
        return $value;
    }
    public function onUrl()
    {
        $id = $_POST['id'];
        $id = explode('landpage_', $id);
        $id = $id[1];
        $data = Db::select('select * from allarticles where id = ?', [$id]);
        $result = array();
        $a = 0;
        if (count($data) != 0) {
            $url_free1 = template::Clearfeet($data[$a]->home_team);
            $url_free2 = template::Clearfeet($data[$a]->away_team);
            $url_date = date("Y-m-d", strtotime($data[$a]->date));

            $result = [
                'id' => $data[$a]->id,
                'id_evento' => $data[$a]->id_evento,
                'name' => $data[$a]->artic_name,
                'sport_name' => $data[$a]->sport_name,
                'date' => $data[$a]->date,
                'date_h' => $data[$a]->date_h,
                'match_' => $data[$a]->match_,
                'date_h' => $data[$a]->date_h,
                'date_h' => $data[$a]->date_h,
                'country' => $data[$a]->country,
                'liga' => $data[$a]->liga,
                'caption' => html_entity_decode($data[$a]->caption),
                'autor' => $data[$a]->autor,
                'artic_name' => html_entity_decode($data[$a]->artic_name),
                'article_body' => html_entity_decode($data[$a]->article_body),
                'show_front' => $data[$a]->show_front,
                'permanet_front' => $data[$a]->permanet_front,
                'date_create' => $data[$a]->date_create,
                'vip_article' => $data[$a]->vip_article,
                'date_update' => $data[$a]->date_update,
                'url_free' => $url_free1 . '-vs-' . $url_free2 . '-' . $url_date
            ];
            return $result;
        } else {
            $result[0]['error']= 'This match no have information yet, be the first at writter';
            return $result;
        }


    }
    public function onUpdateMacht()
    {
        $events = post('events', []);
        $value = $_POST['result'];
        $sport = $_POST['sport'];
        $conf = array();
        $tournaments = array();
        $result = General::service_fodbold_update($value, $sport);
        $sport_name = template::getSport($sport);
        if ($result == 'error') {
            $events[0]['name'] = 'Do not have information for this day';
            $events[0]['date'] = $value;
            $events[0]['error'] = 1;
        }
        else {
            $a=0;
            $b=0;
            for ($i = 0; $i < $result['count']; $i++) {
                if(template::ImExit($result['events'][$i]->id)=='true')
                {
                $events[$a]['error'] = 0;
                $events[$a]['start'] = $result['events'][$i]->start_date;
                $events[$a]['sport_name'] = $sport_name[0]['name'];
                $events[$a]['sport_id'] = $sport;
                $events[$a]['Error'] = '0';
                $events[$a]['count'] = $result['count'];
                $events[$a]['Error'] = '0';
                $events[$a]['id_box'] = $a + 1;
                $events[$a]['date_hour'] = date("Y-m-d H:s", strtotime($result['events'][$i]->start_date));
                $events[$a]['name'] = $result['events'][$i]->home->name . ' vs ' . $result['events'][$i]->away->name;
                $events[$a]['tournament'] = $result['events'][$i]->recurring_competition->name;
                $events[$a]['id'] = $result['events'][$i]->id;
                $events[$a]['mine'] = 'true';
                $events[$a]['date'] = date("Y-m-d", strtotime($result['events'][$i]->start_date));
                $events[$a]['home_team'] = template::Clearspace_end($result['events'][$i]->home->name);
                $events[$a]['away_team'] = template::Clearspace_end($result['events'][$i]->away->name);
                $url_date = date("Y-m-d", strtotime($result['events'][$i]->start_date));
                $url_free1 = template::Clearfeet($result['events'][$i]->away->name);
                $url_free2 = template::Clearfeet($result['events'][$i]->home->name);
                $events[$a]['url_free'] = $url_free1 . '-vs-' . $url_free2 . '-' . $url_date;
                $id_event_result = Db::table('rebel_penguin_article')->where('id_evento', '=', $events[$a]['id'])->count();
                if ($id_event_result == 0) $events[$a]['id_event_result'] = 0;else $events[$a]['id_event_result'] = 1;
                $showcase = Db::table('rebel_penguin_landingpage_showcase')->where('id_event', '=', $events[$a]['id'])->where('active', '=', 1)->count();
                if ($showcase == 0) $events[$a]['showcase'] = 0;
                else $events[$a]['showcase'] = 1;
                if (isset($result['events'][$i]->recurring_competition->region->alpha2)) {
                    $alfa2 = $result['events'][$i]->recurring_competition->region->alpha2;
                } else {
                    $alfa2 = "intl";
                }
                if (!isset($result['events'][$i]->recurring_competition->region->name)) {
                    $events[$a]['country'] = $result['events'][$i]->competition->region->name;
                } else {
                    $events[$a]['country'] = $result['events'][$i]->recurring_competition->region->name;
                }
                if (!isset($result['events'][$i]->recurring_competition->region->name)) {
                    $countrys[$i]['country'] = $result['events'][$i]->competition->region->name;
                } else {
                    $countrys[$i]['country'] = $result['events'][$i]->recurring_competition->region->name;
                }
                if (!isset($result['events'][$i]->away->logo)) {
                    $events[$a]['away_team_logo'] = "../../../../storage/app/media/General/people.png";
                } else {
                    $events[$a]['away_team_logo'] = $result['events'][$i]->away->logo;
                }
                if (!isset($result['events'][$i]->home->logo)) {
                    $events[$a]['home_team_logo'] = "../../../../storage/app/media/General/people.png";
                } else {
                    $events[$a]['home_team_logo'] = $result['events'][$i]->home->logo;
                }
                $streamsact = Db::table('rebel_penguin_restrictions_events')
                    ->select('rebel_penguin_restrictions_events.*')
                    ->where('rebel_penguin_restrictions_events.active', '=', 1)
                    ->where('rebel_penguin_restrictions_events.id_event', '=', $result['events'][$i]->id)
                    ->get();
                if (count($streamsact) > 0) {
                    $events[$a]['active_rest'] = $streamsact[0]->active;
                } else {
                    $events[$a]['active_rest'] = 0;
                }
                $blockevent = Db::table('rebel_penguin_listevent')
                    ->select('rebel_penguin_listevent.*')
                    ->where('rebel_penguin_listevent.active', '=', 1)
                    ->where('rebel_penguin_listevent.id_event', '=', $result['events'][$i]->id)
                    ->get();
                if (count($blockevent) > 0) {
                    $events[$a]['blockevent'] = $blockevent[0]->active;
                } else {
                    $events[$a]['blockevent'] = 0;
                }
                $a++;

            }
                else
                {
                    $eventsfalse[$b]['error'] = 0;
                    $eventsfalse[$b]['start'] = $result['events'][$i]->start_date;
                    $eventsfalse[$b]['sport_name'] = $sport_name[0]['name'];
                    $eventsfalse[$b]['sport_id'] = $sport;
                    $eventsfalse[$b]['Error'] = '0';
                    $eventsfalse[$b]['count'] = $result['count'];
                    $eventsfalse[$b]['Error'] = '0';
                    $eventsfalse[$b]['id_box'] = $b + 1;
                    $eventsfalse[$b]['date_hour'] = date("Y-m-d H:s", strtotime($result['events'][$i]->start_date));
                    $eventsfalse[$b]['name'] = $result['events'][$i]->home->name . ' vs ' . $result['events'][$i]->away->name;
                    $eventsfalse[$b]['tournament'] = $result['events'][$i]->recurring_competition->name;
                    $eventsfalse[$b]['id'] = $result['events'][$i]->id;
                    $eventsfalse[$b]['mine'] = 'false';
                    $eventsfalse[$b]['date'] = date("Y-m-d", strtotime($result['events'][$i]->start_date));
                    $eventsfalse[$b]['home_team'] = template::Clearspace_end($result['events'][$i]->home->name);
                    $eventsfalse[$b]['away_team'] = template::Clearspace_end($result['events'][$i]->away->name);
                    $url_date = date("Y-m-d", strtotime($result['events'][$i]->start_date));
                    $url_free1 = template::Clearfeet($result['events'][$i]->away->name);
                    $url_free2 = template::Clearfeet($result['events'][$i]->home->name);
                    $eventsfalse[$b]['url_free'] = $url_free1 . '-vs-' . $url_free2 . '-' . $url_date;

                    $id_event_result = Db::table('rebel_penguin_article')
                        ->where('id_evento', '=', $eventsfalse[$b]['id'])
                        ->count();
                    if ($id_event_result == 0) $eventsfalse[$b]['id_event_result'] = 0;
                    else $eventsfalse[$b]['id_event_result'] = 1;

                    $showcase = Db::table('rebel_penguin_landingpage_showcase')
                        ->where('id_event', '=', $eventsfalse[$b]['id'])
                        ->where('active', '=', 1)
                        ->count();

                    if ($showcase == 0) $eventsfalse[$b]['showcase'] = 0;
                    else $eventsfalse[$b]['showcase'] = 1;


                    if (isset($result['events'][$i]->recurring_competition->region->alpha2)) {
                        $alfa2 = $result['events'][$i]->recurring_competition->region->alpha2;
                    } else {
                        $alfa2 = "intl";
                    }

                    if (!isset($result['events'][$i]->recurring_competition->region->name)) {
                        $eventsfalse[$b]['country'] = $result['events'][$i]->competition->region->name;
                    } else {
                        $eventsfalse[$b]['country'] = $result['events'][$i]->recurring_competition->region->name;
                    }

                    if (!isset($result['events'][$i]->recurring_competition->region->name)) {
                        $countrys[$i]['country'] = $result['events'][$i]->competition->region->name;
                    } else {
                        $countrys[$i]['country'] = $result['events'][$i]->recurring_competition->region->name;
                    }

                    if (!isset($result['events'][$i]->away->logo)) {
                        $eventsfalse[$b]['away_team_logo'] = "../../../../storage/app/media/General/people.png";
                    } else {
                        $eventsfalse[$b]['away_team_logo'] = $result['events'][$i]->away->logo;
                    }

                    if (!isset($result['events'][$i]->home->logo)) {
                        $eventsfalse[$b]['home_team_logo'] = "../../../../storage/app/media/General/people.png";
                    } else {
                        $eventsfalse[$b]['home_team_logo'] = $result['events'][$i]->home->logo;
                    }

                    $streamsact = Db::table('rebel_penguin_restrictions_events')
                        ->select('rebel_penguin_restrictions_events.*')
                        ->where('rebel_penguin_restrictions_events.active', '=', 1)
                        ->where('rebel_penguin_restrictions_events.id_event', '=', $result['events'][$i]->id)
                        ->get();
                    if (count($streamsact) > 0) {
                        $eventsfalse[$b]['active_rest'] = $streamsact[0]->active;
                    } else {
                        $eventsfalse[$b]['active_rest'] = 0;
                    }


                    $blockevent = Db::table('rebel_penguin_listevent')
                        ->select('rebel_penguin_listevent.*')
                        ->where('rebel_penguin_listevent.active', '=', 1)
                        ->where('rebel_penguin_listevent.id_event', '=', $result['events'][$i]->id)
                        ->get();
                    if (count($blockevent) > 0) {
                        $eventsfalse[$b]['blockevent'] = $blockevent[0]->active;
                    } else {
                        $eventsfalse[$b]['blockevent'] = 0;
                    }
                    $b++;

                }
            }
        }

        while(!empty($eventsfalse))
        {
            $events[count($events)]=array_pop($eventsfalse);
        }
        $events[0]['count']=count($events);
        return $events;
    }
    /*--------------Article System fb_--------------------*/
    public function onLoadArticle_fb_Data()
    {
        $data = Db::table('rebel_penguin_article')
            ->join('rebel_penguin_sports', 'rebel_penguin_sports.id_sport', '=', 'rebel_penguin_article.id_sport')
            ->select('rebel_penguin_sports.name as sport_name', 'rebel_penguin_article.*')
            ->where('rebel_penguin_article.active', '=', '1')
            ->orderby('rebel_penguin_sports.name')
            ->orderby('rebel_penguin_article.id', 'desc')
            ->get();

        $result = array();
        $a = 0;
        if (count($data) != 0) {
            for ($i = 0; $i < count($data); $i++) {
                $hora = date("d/m/Y : h:m:s ", strtotime($data[$i]->date_h));
                $result[$data[$i]->sport_name][] = [
                    'id' => $data[$i]->id,
                    'name' => $data[$i]->artic_name,
                    'date' => $data[$i]->date,
                    'date_h' => $hora,
                    'match_' => $data[$i]->match_,
                    'country' => $data[$i]->country,
                    'liga' => $data[$i]->liga,
                    'caption' => html_entity_decode($data[$i]->caption),
                    'autor' => $data[$i]->autor,
                    'artic_name' => html_entity_decode($data[$i]->artic_name),
                    'article_body' => html_entity_decode($data[$i]->article_body),
                    'show_front' => $data[$i]->show_front,
                    'permanet_front' => $data[$i]->permanet_front,
                    'date_create' => $data[$i]->date_create,
                    'vip_article' => $data[$i]->vip_article,
                    'away_team_logo' => $data[$i]->away_team_logo,
                    'home_team_logo' => $data[$i]->home_team_logo,
                    'date_update' => $data[$i]->date_update];
            }

            return $result;
        } else {
            $result = ['error' => 'This match no have information yet, be the first at writter',];
            return $result;
        }


    }

    /*--------------Restrictions System--------------------*/
    public function onGetCountrys()
    {
        $list = array();
        $result = General::Service_Country();
        for ($i = 0; $i < count($result["regions"]); $i++) {
            if (gettype(@$result["regions"][$i]->alpha2) != 'string') {
                $list[$i]['alpha2'] = "intl";
            } else {
                $list[$i]['alpha2'] = $result["regions"][$i]->alpha2;
            }
            $list[$i]['alpha3'] = @$result["regions"][$i]->alpha3;
            $list[$i]['continent'] = @$result["regions"][$i]->continent;
            $list[$i]['id'] = $result["regions"][$i]->id;
            $list[$i]['name'] = $result["regions"][$i]->name;

            $streamsact = Db::table('rebel_penguin_restrictions_countrys')
                ->select('rebel_penguin_restrictions_countrys.*')
                ->where('rebel_penguin_restrictions_countrys.id_country', '=', $result["regions"][$i]->id)
                ->where('rebel_penguin_restrictions_countrys.active', '=', 1)
                ->get();
            if (count($streamsact) > 0) {
                $list[$i]['actrest'] = $streamsact[0]->active;
            } else {
                $list[$i]['actrest'] = 0;
            }
        }
        return $list;
    }
    public function onGetLigas()
    {
        $id_sport = $_POST['sport'];;
        $id_country = $_POST['id'];
        if ($id_sport == '') {
            $id_sport = 'a0c77e28-69fb-11e4-85c8-5254005a5aa0';
        }
        $result = General::Service_ligas($id_country, $id_sport);
        $list = array();
        if (count($result['competitions']) > 0) {
            for ($z = 0; $z < count($result['competitions']); $z++) {
                $list[$z]['id'] = $result['competitions'][$z]->id;
                $list[$z]['name'] = $result['competitions'][$z]->name;
                $list[$z]['cont'] = count($result['competitions']);
                $active = Db::select('select * from rebel_penguin_listligas where id_liga = ?', [$result['competitions'][$z]->id]);
                if (count($active) > 0) {
                    $list[$z]['act'] = $active[0]->active;
                } else {
                    $list[$z]['act'] = 0;
                }

                $streamsact = Db::table('rebel_penguin_restrictions_league')
                    ->select('rebel_penguin_restrictions_league.*')
                    ->where('rebel_penguin_restrictions_league.id_liga', '=', $result['competitions'][$z]->id)
                    ->where('rebel_penguin_restrictions_league.active', '=', 1)
                    ->get();
                if (count($streamsact) > 0) {
                    $list[$z]['actrest'] = $streamsact[0]->active;
                } else {
                    $list[$z]['actrest'] = 0;
                }
            }
        } else {
            $list[0]['cont'] = 'null';
        }
        return $list;
    }
    public function onUpdaterest()
    {
        $id = $_POST['id'];
        $info = $_POST['info'];
        $buttom = $_POST['buttom'];


        if ($info == 0) {
            $id = explode('rest_lig_', $id);
            $data = Db::table('rebel_penguin_listligas')
                ->select('rebel_penguin_listligas.*')
                ->where('rebel_penguin_listligas.id_liga', '=', $id[1])
                ->get();
            if (count($data) > 0) {
                Db::table('rebel_penguin_listligas')
                    ->where('id_liga', $id[1])
                    ->update(['active' => $buttom]);
            } else {
                Db::table('rebel_penguin_listligas')
                    ->insert(['id_liga' => $id[1], 'active' => 1]);
            }

        } else if ($info == 1) {
            $id = explode('back_march_', $id);
            $data = Db::table('rebel_penguin_listevent')
                ->select('rebel_penguin_listevent.*')
                ->where('rebel_penguin_listevent.id_event', '=', $id[1])
                ->get();
            if (count($data) > 0) {
                Db::table('rebel_penguin_listevent')
                    ->where('id_event', $id[1])
                    ->update(['active' => $buttom]);
            } else {
                Db::table('rebel_penguin_listevent')
                    ->insert(['id_event' => $id[1], 'active' => 1]);
            }
        }

    }
    public function onLoadstreamperall()
    {
        $id = $_POST['id'];
        $info = $_POST['info'];

        $streamdata = array();
        $id_countrys = explode('black_', $id);
        $id_leagues = explode('black_lig_', $id);
        $id_events = explode('rest_march_', $id);

        $streams = Db::table('rebel_penguin_stream_p')
            ->select('rebel_penguin_stream_p.*')
            ->where('rebel_penguin_stream_p.active', '=', 1)
            ->get();

        if ($info == '1') {
            for ($z = 0; $z < count($streams); $z++) {
                $streamdata[$z]['cont'] = count($streams);
                $streamdata[$z]['id_stp'] = $streams[$z]->id_stp;
                $streamdata[$z]['id_all'] = $id_events[1];
                $streamdata[$z]['name'] = $streams[$z]->name;
                $streamdata[$z]['url'] = $streams[$z]->url;
                $streamdata[$z]['info'] = $info;
                $streamsact = Db::table('rebel_penguin_restrictions_events')
                    ->select('rebel_penguin_restrictions_events.*')
                    ->where('rebel_penguin_restrictions_events.id_stream', '=', $streams[$z]->id_stp)
                    ->where('rebel_penguin_restrictions_events.id_event', '=', $id_events[1])
                    ->get();

                if (count($streamsact) > 0) {
                    $streamdata[$z]['active'] = $streamsact[0]->active;
                } else {
                    $streamdata[$z]['active'] = 0;
                }

            }
        }
        if ($info == '0') {
            for ($z = 0; $z < count($streams); $z++) {
                $streamdata[$z]['cont'] = count($streams);
                $streamdata[$z]['id_stp'] = $streams[$z]->id_stp;
                $streamdata[$z]['name'] = $streams[$z]->name;
                $streamdata[$z]['id_all'] = $id_leagues[1];
                $streamdata[$z]['url'] = $streams[$z]->url;
                $streamdata[$z]['info'] = $info;
                $streamsact = Db::table('rebel_penguin_restrictions_league')
                    ->select('rebel_penguin_restrictions_league.*')
                    ->where('rebel_penguin_restrictions_league.id_stream', '=', $streams[$z]->id_stp)
                    ->where('rebel_penguin_restrictions_league.id_liga', '=', $id_leagues[1])
                    ->get();

                if (count($streamsact) > 0) {
                    $streamdata[$z]['active'] = $streamsact[0]->active;
                } else {
                    $streamdata[$z]['active'] = 0;
                }

            }
        }
        if ($info == '2') {
            for ($z = 0; $z < count($streams); $z++) {
                $streamdata[$z]['cont'] = count($streams);
                $streamdata[$z]['id_stp'] = $streams[$z]->id_stp;
                $streamdata[$z]['name'] = $streams[$z]->name;
                $streamdata[$z]['id_all'] = $id_countrys[1];
                $streamdata[$z]['url'] = $streams[$z]->url;
                $streamdata[$z]['info'] = $info;

                $streamsact = Db::table('rebel_penguin_restrictions_countrys')
                    ->select('rebel_penguin_restrictions_countrys.*')
                    ->where('rebel_penguin_restrictions_countrys.id_stream', '=', $streams[$z]->id_stp)
                    ->where('rebel_penguin_restrictions_countrys.id_country', '=', $id_countrys[1])
                    ->get();

                if (count($streamsact) > 0) {
                    $streamdata[$z]['active'] = $streamsact[0]->active;
                } else {
                    $streamdata[$z]['active'] = 0;
                }
            }
        }

        return $streamdata;

    }
    public function onRestrictionsstreams()
    {
        $id = $_POST['id'];
        $idsport = $_POST['idsport'];
        $info = $_POST['info'];
        $buttom = $_POST['buttom'];
        $id_stream = $_POST['id_stream'];
        $id_stream = explode('all_stream_', $id_stream);

        if ($info == '0') {
            $streamsact = Db::table('rebel_penguin_restrictions_league')
                ->select('rebel_penguin_restrictions_league.*')
                ->where('rebel_penguin_restrictions_league.id_stream', '=', $id_stream[1])
                ->where('rebel_penguin_restrictions_league.id_liga', '=', $id)
                ->get();

            if (count($streamsact) > 0) {
                Db::table('rebel_penguin_restrictions_league')
                    ->where('id_liga', $id)
                    ->where('id_stream', $id_stream[1])
                    ->update(['active' => $buttom]);
            } else {
                Db::table('rebel_penguin_restrictions_league')
                    ->insert([
                        'id_liga' => $id,
                        'id_stream' => $id_stream[1],
                        'idsport' => $idsport,
                        'active' => 1
                    ]);
            }


        }

        if ($info == '1') {
            $streamsact = Db::table('rebel_penguin_restrictions_events')
                ->select('rebel_penguin_restrictions_events.*')
                ->where('rebel_penguin_restrictions_events.id_stream', '=', $id_stream[1])
                ->where('rebel_penguin_restrictions_events.id_event', '=', $id)
                ->get();

            if (count($streamsact) > 0) {
                Db::table('rebel_penguin_restrictions_events')
                    ->where('id_event', $id)
                    ->where('id_stream', $id_stream[1])
                    ->update(['active' => $buttom]);
            } else {
                Db::table('rebel_penguin_restrictions_events')
                    ->insert([
                        'id_event' => $id,
                        'idsport' => $idsport,
                        'id_stream' => $id_stream[1],
                        'active' => 1
                    ]);
            }
        }

        if ($info == '2') {
            $streamsact = Db::table('rebel_penguin_restrictions_countrys')
                ->select('rebel_penguin_restrictions_countrys.*')
                ->where('rebel_penguin_restrictions_countrys.id_stream', '=', $id_stream[1])
                ->where('rebel_penguin_restrictions_countrys.id_country', '=', $id)
                ->get();

            if (count($streamsact) > 0) {
                Db::table('rebel_penguin_restrictions_countrys')
                    ->where('id_country', $id)
                    ->where('id_stream', $id_stream[1])
                    ->update(['active' => $buttom]);
            } else {
                Db::table('rebel_penguin_restrictions_countrys')
                    ->insert([
                        'id_country' => $id,
                        'id_stream' => $id_stream[1],
                        'idsport' => $idsport,
                        'active' => 1
                    ]);
            }
        }

    }

    /*--------------Restrictions System--------------------*/

    public function onLoadStream(){
        $id_event = $_POST['id_event'];
        $id_sport = $_POST['id_sport'];
        $result = array();        
        $streamsact = Db::table('rebel_penguin_confstreambyevent')
            ->select('rebel_penguin_confstreambyevent.*')
            ->where('rebel_penguin_confstreambyevent.id_sport', '=', $id_sport)
            ->where('rebel_penguin_confstreambyevent.id_event', '=', $id_event)
            ->get();        
        $streams = Db::table('rebel_penguin_stream_p')
            ->select('rebel_penguin_stream_p.*')
            ->where('rebel_penguin_stream_p.active', '=', 1)
            ->get();
        
        if(count($streamsact)>0){        
        for($i=0; $i< count($streams);$i++){
            $esta= false;
            $index= '';
            for($a=0; $a< count($streamsact);$a++){
                if(@$streamsact[$i]->id_stream == @$streams[$a]->id_stp)
                {
                    $esta = true;
                    $index= $a;
                }
            }
            if($esta == true){
                $result[$i]['count']= count($streams);
                $result[$i]['id_stp']= $streams[$i]-> id_stp;
                $result[$i]['name']= $streams[$i]-> name;
                $result[$i]['promo_active']= $streamsact[$index]->promo_active;
                $result[$i]['promo_stream']= 1;

                }
            else{
                $result[$i]['count']= count($streams);
                $result[$i]['id_stp']= $streams[$i]-> id_stp;
                $result[$i]['name']= $streams[$i]-> name;
                $result[$i]['promo_active']= 0;
                $result[$i]['promo_stream']= 0;
                }            
            }
            return $result;
         }    
        else{

            for($i=0; $i< count($streams);$i++){             
                $result[$i]['count']= count($streams);
                $result[$i]['id_stp']= $streams[$i]-> id_stp;
                $result[$i]['name']= $streams[$i]-> name;
                $result[$i]['promo_active']= 0;
                $result[$i]['promo_stream']= 0;
            }
            return $result;
        }
        
}
    public function onPromoEvents(){
        $id_stream = $_POST['id_stream'];
        $id_event = $_POST['id_event'];
        $id_sport = $_POST['id_sport'];
        $value = $_POST['value'];
        $id = explode('activepromo_', $id_stream);
        $id_stream = $id[1];

        $data = Db::table('rebel_penguin_confstreambyevent')->select('rebel_penguin_confstreambyevent.*')
            ->where('rebel_penguin_confstreambyevent.id_event', '=', $id_event)
            ->where('rebel_penguin_confstreambyevent.id_sport', '=', $id_sport)
            ->where('rebel_penguin_confstreambyevent.id_stream', '=', $id_stream)
            ->get();

        if(count($data)>0){
            /*update*/
            if($value=='true'){$value=1;}else {$value=0;}
            Db::table('rebel_penguin_confstreambyevent')
                ->where('id_event', $id_event)
                ->where('id_sport', $id_sport)
                ->where('id_stream', $id_stream)
                ->update(['promo_active' => $value]);
        }
        else {
            /*Insert*/
            Db::table('rebel_penguin_confstreambyevent')->insert(
                [
                  'id_event' => $id_event,
                  'id_sport' => $id_sport,
                  'id_stream' =>  $id_stream,
                  'promo_active' => 1
                ]
            );

        }


    }
    public function onListStreamEvents(){
        $id_stream = $_POST['id_stream'];
        $id_event = explode('art_',$_POST['id_event']);
        $id_event =  $id_event[1];
        $id_sport = $_POST['id_sport'];
        $value = $_POST['value'];
        $id = explode('conf_', $id_stream);
        $id_stream = $id[1];

        $data = Db::table('rebel_penguin_confstreambyevent')->select('rebel_penguin_confstreambyevent.*')
            ->where('rebel_penguin_confstreambyevent.id_event', '=', $id_event)
            ->where('rebel_penguin_confstreambyevent.id_sport', '=', $id_sport)
            ->where('rebel_penguin_confstreambyevent.id_stream', '=', $id_stream)
            ->get();

        if($value=='true'){$value=1;}else {$value=0;}
        if(count($data)>0 and $value==0){
            /*update*/
            Db::table('rebel_penguin_confstreambyevent')
                ->where('id_event', $id_event)
                ->where('id_sport', $id_sport)
                ->where('id_stream', $id_stream)
                ->delete();
        }
        else if(count($data)>0 and $value==1){
            /*update*/
            Db::table('rebel_penguin_confstreambyevent')
                ->where('id_event', $id_event)
                ->where('id_sport', $id_sport)
                ->where('id_stream', $id_stream)
                ->update(['promo_active' => 0]);
        }
        else {
            /*Insert*/
            Db::table('rebel_penguin_confstreambyevent')
                ->insert([
                    'id_event' => $id_event,
                    'id_sport' => $id_sport,
                    'id_stream' =>  $id_stream,
                    'promo_active' => 0
                ]
            );

        }
    }


}

/**
 * Created by PhpStorm.
 * User: eddy
 * Date: 26/11/2015
 * Time: 15:44
 */
