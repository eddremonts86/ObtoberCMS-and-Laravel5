<?php
/**
 * Created by PhpStorm.
 * User: eddy
 * Date: 19/01/2016
 * Time: 16:43
 */

namespace Rebelpenguin\Events\Classes;

use Db;
use App;
use Request;
use Cms\Classes\ComponentBase;
use ApplicationException;
use Rebelpenguin\Events\Classes\General;

class template
{
    static function getSport($id)
    {
        $data = Db::table('rebel_penguin_sports')
            ->select('rebel_penguin_sports.*')
            ->where('rebel_penguin_sports.id_sport', '=', $id)
            ->get();
        for ($i = 0; $i < count($data); $i++) {
            $result[$i]['id'] = $data[$i]->id;
            $result[$i]['id_sport'] = $data[$i]->id_sport;
            $result[$i]['name'] = $data[$i]->name;
            $result[$i]['color'] = $data[$i]->color;
        }
        return $result;
    }

    static function getStream($id)
    {
        $data = Db::table('rebel_penguin_stream_p')
            ->select('rebel_penguin_stream_p.*')
            ->where('rebel_penguin_stream_p.id_stp', '=', $id)
            ->get();

        if (count($data) > 0) {
            for ($i = 0; $i < count($data); $i++) {
                $result[$i]['id'] = $data[$i]->id;
                $result[$i]['id_stp'] = $data[$i]->id_stp;
                $result[$i]['name'] = $data[$i]->name;
            }
            return $result;
        } else return 0;
    }

    static function getStreambyname($name)
    {
        $data = Db::table('rebel_penguin_stream_p')
            ->select('rebel_penguin_stream_p.*')
            ->where('rebel_penguin_stream_p.name', '=', $name)
            ->get();

        if (count($data) > 0) {
            for ($i = 0; $i < count($data); $i++) {
                $result[$i]['id'] = $data[$i]->id;
                $result[$i]['id_stp'] = $data[$i]->id_stp;
                $result[$i]['name'] = $data[$i]->name;
            }
            return $result;
        } else return 0;
    }

    static function getSportbyId($id)
    {
        $data = Db::table('rebel_penguin_sports')
            ->select('rebel_penguin_sports.*')
            ->where('rebel_penguin_sports.id_sport', '=', $id)
            ->get();
        for ($i = 0; $i < count($data); $i++) {
            $result[$i]['id'] = $data[$i]->id;
            $result[$i]['id_sport'] = $data[$i]->id_sport;
            $result[$i]['name'] = $data[$i]->name;
            $result[$i]['color'] = $data[$i]->color;
        }
        return $result;
    }

    static function getSportbyName($name)
    {
        $data = Db::table('rebel_penguin_sports')
            ->select('rebel_penguin_sports.*')
            ->where('rebel_penguin_sports.name', '=', $name)
            ->get();
        $result = [];
        for ($i = 0; $i < count($data); $i++) {
            $result[$i]['id'] = $data[$i]->id;
            $result[$i]['id_sport'] = $data[$i]->id_sport;
            $result[$i]['name'] = $data[$i]->name;
            $result[$i]['color'] = $data[$i]->color;
        }
        return $result;
    }

    static function fb_se_live($id_token)
    {
        $id = General::Service_URL($id_token);
        $data = Db::select('select * from rebel_penguin_article where id_evento = ?', [$id]);
        $result = array();
        $a = 0;
        if (count($data) != 0) {
            $result[0]['id'] = $data[$a]->id;
            $result[0]['artic_name'] = $data[$a]->artic_name;
            $result[0]['date'] = date("d-m-Y", strtotime($data[$a]->date));
            $result[0]['date_h'] = date("h:i", strtotime($data[$a]->date_h));
            $result[0]['match_'] = $data[$a]->match_;
            $result[0]['date_H'] = date("H:i", strtotime($data[$a]->date_h));
            $result[0]['date_D'] = date("d.M Y", strtotime($data[$a]->date));
            $result[0]['country'] = $data[$a]->country;
            $result[0]['liga'] = $data[$a]->liga;
            $result[0]['caption'] = html_entity_decode($data[$a]->caption);
            $result[0]['autor'] = $data[$a]->autor;
            $result[0]['autor_name'] = $data[$a]->autor_name;
            $result[0]['artic_name'] = $data[$a]->artic_name;
            $result[0]['article_body'] = html_entity_decode($data[$a]->article_body);
            $result[0]['show_front'] = $data[$a]->show_front;
            $result[0]['permanet_front'] = $data[$a]->permanet_front;
            $result[0]['date_create'] = $data[$a]->date_create;
            $result[0]['date_update'] = $data[$a]->date_update;
            $result[0]['away_team'] = $data[$a]->away_team;
            $result[0]['home_team'] = $data[$a]->home_team;
            $result[0]['away_team_logo'] = $data[$a]->away_team_logo;
            $result[0]['home_team_logo'] = $data[$a]->home_team_logo;
            $url_date = date("Y-m-d", strtotime($data[$a]->date));
            $url_free1 = self::Clearfeet($data[$a]->home_team);
            $url_free2 = self::Clearfeet($data[$a]->away_team);
            $result[0]['url_free'] = $url_free1 . '-vs-' . $url_free2 . '-' . $url_date;
            return $result;
        } else {
            $i = 0;
            $event = General::service_event($id);
            $result[$i]['date_hour'] = date("H:i", strtotime($event['start_date']));
            $result[$i]['date'] = date("H:i", strtotime($event['start_date']));
            $result[$i]['home_team'] = $event['home']->name;
            $result[$i]['away_team'] = $event['away']->name;
            $result[$i]['recurring_competition'] = $event['recurring_competition']->name;
            $result[$i]['competition'] = $event['competition']->name;
            @$logo = gettype($event['away']->logo);
            @$logo_home = gettype($event['home']->logo);
            if ($logo != 'string') {
                $result[$i]['away_team_logo'] = "/storage/app/media/General/people.png";
            } else {
                $result[$i]['away_team_logo'] = $event['away']->logo;
            }
            if ($logo_home != 'string') {
                $result[$i]['home_team_logo'] = "/storage/app/media/General/people.png";
            } else {
                $result[$i]['home_team_logo'] = $event['home']->logo;
            }
            $url_date = date("Y-m-d", strtotime($event['start_date']));
            $url_free1 = str_replace(' ', '-', strtolower($event['home']->name));
            $url_free2 = str_replace(' ', '-', strtolower($event['away']->name));
            $result[$i]['url_free'] = $url_free1 . '-vs-' . $url_free2 . '-' . $url_date;
            $result[$i]['date_h'] = date("d-m-Y", strtotime($event['start_date']));
            $result[$i]['date_H'] = date("H:i", strtotime($event['start_date']));
            $result[$i]['date_D'] = date("d.M Y", strtotime($event['start_date']));
            $result[$i]['caption'] = '';
            $result[0]['article_body'] = '';
            return $result;
        }
    }

    static function metadata($id_token)
    {
        $id = General::Service_URL($id_token);
        $data = Db::select('select * from rebel_penguin_article where id_evento = ?', [$id]);
        $result = array();
        $a = 0;
        if (count($data) != 0) {
            $result[0]['id'] = $data[$a]->id;
            $result[0]['artic_name'] = $data[$a]->artic_name;
            $result[0]['date'] = date("d-m-Y", strtotime($data[$a]->date));
            $result[0]['date_h'] = date("h:i", strtotime($data[$a]->date_h));
            $result[0]['match_'] = $data[$a]->match_;
            $result[0]['date_H'] = date("H:i", strtotime($data[$a]->date_h));
            $result[0]['date_D'] = date("d M. Y", strtotime($data[$a]->date));
            $result[0]['country'] = $data[$a]->country;
            $result[0]['liga'] = $data[$a]->liga;
            $result[0]['caption'] = html_entity_decode($data[$a]->caption);
            $result[0]['autor'] = $data[$a]->autor;
            $result[0]['autor_name'] = $data[$a]->autor_name;
            $result[0]['artic_name'] = $data[$a]->artic_name;
            $result[0]['article_body'] = html_entity_decode($data[$a]->article_body);
            $result[0]['show_front'] = $data[$a]->show_front;
            $result[0]['permanet_front'] = $data[$a]->permanet_front;
            $result[0]['date_create'] = $data[$a]->date_create;
            $result[0]['date_update'] = $data[$a]->date_update;
            $result[0]['away_team'] = $data[$a]->away_team;
            $result[0]['home_team'] = $data[$a]->home_team;
            $result[0]['away_team_logo'] = $data[$a]->away_team_logo;
            $result[0]['home_team_logo'] = $data[$a]->home_team_logo;
            $url_date = date("Y-m-d", strtotime($data[$a]->date));
            $url_free1 = self::Clearfeet($data[$a]->home_team);
            $url_free2 = self::Clearfeet($data[$a]->away_team);
            $result[0]['url_free'] = $url_free1 . '-vs-' . $url_free2 . '-' . $url_date;
            return $result;
        } else {
            $i = 0;
            $event = General::service_event($id);
            $result[$i]['date_hour'] = date("H:i", strtotime($event['start_date']));
            $result[$i]['date'] = date("H:i", strtotime($event['start_date']));
            $result[$i]['home_team'] = $event['home']->name;
            $result[$i]['away_team'] = $event['away']->name;
            $result[$i]['recurring_competition'] = $event['recurring_competition']->name;
            $result[$i]['competition'] = $event['competition']->name;
            @$logo = gettype($event['away']->logo);
            @$logo_home = gettype($event['home']->logo);
            if ($logo != 'string') {
                $result[$i]['away_team_logo'] = "/storage/app/media/General/people.png";
            } else {
                $result[$i]['away_team_logo'] = $event['away']->logo;
            }
            if ($logo_home != 'string') {
                $result[$i]['home_team_logo'] = "/storage/app/media/General/people.png";
            } else {
                $result[$i]['home_team_logo'] = $event['home']->logo;
            }
            $url_date = date("Y-m-d", strtotime($event['start_date']));
            $url_free1 = str_replace(' ', '-', strtolower($event['home']->name));
            $url_free2 = str_replace(' ', '-', strtolower($event['away']->name));
            $result[$i]['url_free'] = $url_free1 . '-vs-' . $url_free2 . '-' . $url_date;
            $result[$i]['date_h'] = date("d-m-Y", strtotime($event['start_date']));
            $result[$i]['date_H'] = date("H:i", strtotime($event['start_date']));
            $result[$i]['date_D'] = date("d M. Y", strtotime($event['start_date']));
            $result[$i]['caption'] = $event['home']->name . " møder " . $event['away']->name . " " . date("d.M Y", strtotime($event['start_date'])) . " kl. " . date("H:i", strtotime($event['start_date'])) . " i den spændende " . $event['competition']->name . " / " . $event['recurring_competition']->name . " kamp. Følg opgøret live - se med her.";
            $result[0]['article_body'] = $event['home']->name . " møder " . $event['away']->name . " " . date("d.M Y", strtotime($event['start_date'])) . " kl. " . date("H:i", strtotime($event['start_date'])) . " i den spændende " . $event['competition']->name . " / " . $event['recurring_competition']->name . " kamp. Følg opgøret live - se med her.";
            return $result;
        }
    }

    static function fb_se_live_header()
    {
        $data = Db::select('select * from rebel_penguin_article where vip_article = ?', [1]);
        $result = array();
        $a = 0;
        if (count($data) != 0) {
            $result[0]['id'] = $data[$a]->id;
            $result[0]['artic_name'] = $data[$a]->artic_name;
            $result[0]['date'] = date("d.m.y", strtotime($data[$a]->date));
            $result[0]['hora'] = date("H:s", strtotime($data[$a]->date));
            $result[0]['date_h'] = $data[$a]->date_h;
            $result[0]['match_'] = $data[$a]->match_;
            $result[0]['date_h'] = $data[$a]->date_h;
            $result[0]['country'] = $data[$a]->country;
            $result[0]['liga'] = $data[$a]->liga;
            $result[0]['caption'] = $data[$a]->caption;
            $result[0]['autor'] = $data[$a]->autor;
            $result[0]['artic_name'] = $data[$a]->artic_name;
            $result[0]['article_body'] = html_entity_decode($data[$a]->article_body);
            $result[0]['show_front'] = $data[$a]->show_front;
            $result[0]['permanet_front'] = $data[$a]->permanet_front;
            $result[0]['date_create'] = $data[$a]->date_create;
            $result[0]['date_update'] = $data[$a]->date_update;
            $result[0]['away_team'] = $data[$a]->away_team;
            $result[0]['home_team'] = $data[$a]->home_team;
            $result[0]['away_team_logo'] = $data[$a]->away_team_logo;
            $result[0]['home_team_logo'] = $data[$a]->home_team_logo;


            $url_date = date("Y-m-d", strtotime($data[$a]->date));
            $url_free1 = self::Clearfeet($data[$a]->home_team);
            $url_free2 = self::Clearfeet($data[$a]->away_team);
            $result[0]['url_free'] = $url_free1 . '-vs-' . $url_free2 . '-' . $url_date;

            return $result;

        } else {
            $result = ['error' => 'This match no have information yet, be the first at writter',];
            return $result;
        }
    }

    static function sport_name_home($name)
    {

        $data = Db::table('rebel_penguin_sports')
            ->where('rebel_penguin_sports.active', '=', 1)
            ->where('rebel_penguin_sports.name', '=', $name)
            ->get();
        $result = array();
        $a = 0;
        if (count($data) != 0) {
            for ($i = 0; $i < count($data); $i++) {
                $result[$i]['id'] = $data[$i]->id;
                $result[$i]['id_sport'] = $data[$i]->id_sport;
                $result[$i]['name'] = $data[$i]->name;
                $result[$i]['color'] = $data[$i]->color;
            }
            return $result;
        } else {
            $result = ['error' => 'This match no have information yet, be the first at writter',];
            return $result;
        }
    }

    static function sport_name()
    {
        $data = Db::table('rebel_penguin_sports')
            ->where('rebel_penguin_sports.active', '=', 1)
            ->get();
        $result = array();
        $a = 0;
        if (count($data) != 0) {
            for ($i = 0; $i < count($data); $i++) {
                $result[$i]['id'] = $data[$i]->id;
                $result[$i]['id_sport'] = $data[$i]->id_sport;
                $result[$i]['active'] = $data[$i]->active;
                $result[$i]['realname'] = $data[$i]->realname;
                $result[$i]['name'] = $data[$i]->name;
                $result[$i]['color'] = $data[$i]->color;
            }
            return $result;
        } else {
            $result = ['error' => 'This match no have information yet, be the first at writter',];
            return $result;
        }
    }

    static function straemp_event($id)
    {
        $streamp = array();
        $result = General::service_fodbold_stramp($id);
        $cantstream = @count($result['stream_providers']);
        $data = Db::table('rebel_penguin_stream_data')
            ->join('rebel_penguin_stream_p', 'rebel_penguin_stream_data.id_stp', '=', 'rebel_penguin_stream_p.id_stp')
            ->select('rebel_penguin_stream_data.*', 'rebel_penguin_stream_p.name')
            ->where('rebel_penguin_stream_p.active', '=', 1)
            ->orderBy('rebel_penguin_stream_data.id_stp', 'desc')
            ->get();

        for ($i = 0; $i < count($data); $i++) {
            $streamp[$i]['name'] = $data[$i]->gnr_label;;
            $streamp[$i]['id'] = $data[$i]->id;
            $streamp[$i]['id_stp'] = $data[$i]->id_stp;
            $streamp[$i]['gnr_label'] = $data[$i]->gnr_label;
            $streamp[$i]['gnr_coment'] = html_entity_decode($data[$i]->gnr_coment);
            $streamp[$i]['cont_pros'] = html_entity_decode($data[$i]->cont_pros);
            $streamp[$i]['cont_introduction'] = html_entity_decode($data[$i]->cont_introduction);
            $streamp[$i]['prod_content'] = html_entity_decode($data[$i]->prod_content);
        }

        if ($cantstream > 0) {
            for ($i = 0; $i < count($data); $i++) {
                $cant = 0;
                for ($z = 0; $z < count($streamp); $z++) {
                    if ($data[$i]->id == $streamp[$i]['id']) {
                        $cant++;
                    }
                }
                if ($cant == 0) {
                    $a = count($streamp) + $i;
                    $streamp[$a]['name'] = $data[$i]->gnr_label;;
                    $streamp[$a]['id'] = $data[$i]->id;
                    $streamp[$a]['id_stp'] = $data[$i]->id_stp;
                    $streamp[$a]['gnr_label'] = $data[$i]->gnr_label;
                }
            }

        }
        return $streamp;
    }

    static function StraempPerEvent($id_token, $Sport)
    {
        $id = General::Service_URL($id_token);
        $data = array();
        $steam = Db::table('rebel_penguin_confstreambyevent')
            ->select('rebel_penguin_confstreambyevent.*')
            ->where('rebel_penguin_confstreambyevent.id_event', '=', $id)
            ->where('rebel_penguin_confstreambyevent.id_sport', '=', $Sport)
            ->orderby('rebel_penguin_confstreambyevent.promo_active', 'desc')
            ->get();
        if (count($steam) > 0) {
            for ($p = 0; $p < count($steam); $p++) {
                $result = Db::table('streampersport')
                    ->select('streampersport.*')
                    ->join('rebel_penguin_stream_p', 'rebel_penguin_stream_p.id_stp', '=', 'streampersport.id_stp')
                    ->where('rebel_penguin_stream_p.active', '=', 1)
                    ->where('streampersport.id_stp', '=', $steam[$p]->id_stream)
                    ->where('streampersport.id_sport', '=', $Sport)
                    ->get();
                if (count($result) > 0) {
                    $rest = self::restictions($id_token, $result[0]->id_stp, $Sport);
                    if ($rest == 'true') {
                        $data[$p]['rest'] = 'Accessible seulement avec IP Française';
                    } else {
                        $data[$p]['rest'] = '';
                    }

                    $data[$p]['name'] = $result[0]->name;
                    $data[$p]['id_sport'] = $result[0]->id_sport;
                    $data[$p]['id_stream'] = $result[0]->id_stp;

                    /* -------------- Genera Info ---------------- */
                    $data[$p]['gnr_label'] = $result[0]->gnr_label;
                    $data[$p]['gnr_afflink'] = $result[0]->gnr_false_aff;
                    $data[$p]['gnr_quality'] = $result[0]->gnr_quality;
                    $data[$p]['gnr_sort'] = $result[0]->gnr_sort;
                    $data[$p]['gnr_size'] = $result[0]->gnr_size;
                    $data[$p]['gnr_price'] = $result[0]->gnr_price;
                    $data[$p]['gnr_active'] = $result[0]->gnr_active;
                    $data[$p]['gnr_rating'] = $result[0]->gnr_rating;

                    /* --------------Stream_general_manager ---------------- */
                    $data[$p]['gpm_head'] = html_entity_decode($result[0]->gpm_head);
                    $data[$p]['gpm_active'] = html_entity_decode($result[0]->gpm_active);
                    $data[$p]['gpm_quality_head'] = html_entity_decode($result[0]->gpm_quality_head);
                    $data[$p]['gpm_quality_content'] = html_entity_decode($result[0]->gpm_quality_content);
                    $data[$p]['gpm_udv_head'] = html_entity_decode($result[0]->gpm_udv_head);
                    $data[$p]['gpm_udv_content'] = html_entity_decode($result[0]->gpm_udv_content);
                    $data[$p]['gpm_price_head'] = html_entity_decode($result[0]->gpm_price_head);
                    $data[$p]['gpm_price_content'] = html_entity_decode($result[0]->gpm_price_content);
                    $data[$p]['gpm_icon_H_one'] = html_entity_decode($result[0]->gpm_icon_H_one);
                    $data[$p]['gpm_icon_S_one'] = html_entity_decode($result[0]->gpm_icon_S_one);
                    $data[$p]['gpm_icon_H_two'] = html_entity_decode($result[0]->gpm_icon_H_two);
                    $data[$p]['gpm_icon_S_two'] = html_entity_decode($result[0]->gpm_icon_S_two);
                    $data[$p]['gpm_icon_H_three'] = html_entity_decode($result[0]->gpm_icon_H_three);
                    $data[$p]['gpm_icon_S_three'] = html_entity_decode($result[0]->gpm_icon_S_three);
                    $data[$p]['gpm_icon_N_three'] = html_entity_decode($result[0]->gpm_icon_N_three);
                    $data[$p]['gpm_button_rew'] = html_entity_decode($result[0]->gpm_button_rew);
                    $data[$p]['gpm_button_wlive'] = html_entity_decode($result[0]->gpm_button_wlive);
                    $data[$p]['gpm_button_aff'] = html_entity_decode($result[0]->gpm_false_button_aff);

                    /* -------------- Stream_page_details ---------------- */
                    $data[$p]['gpd_head'] = html_entity_decode($result[0]->gpd_head);
                    $data[$p]['gpd_icon_note'] = html_entity_decode($result[0]->gpd_icon_note);
                    $data[$p]['gpd_icon_H_one'] = html_entity_decode($result[0]->gpd_icon_H_one);
                    $data[$p]['gpd_icon_S_one'] = html_entity_decode($result[0]->gpd_icon_S_one);
                    $data[$p]['gpd_icon_H_two'] = html_entity_decode($result[0]->gpd_icon_H_two);
                    $data[$p]['gpd_icon_S_two'] = html_entity_decode($result[0]->gpd_icon_S_two);
                    $data[$p]['gpd_icon_H_three'] = html_entity_decode($result[0]->gpd_icon_H_three);
                    $data[$p]['gpd_icon_S_three'] = html_entity_decode($result[0]->gpd_icon_S_three);
                    $data[$p]['gpd_button_head'] = html_entity_decode($result[0]->gpd_button_head);
                    $data[$p]['gpd_button_subhead'] = html_entity_decode($result[0]->gpd_button_subhead);
                    $data[$p]['gpd_button_aff'] = html_entity_decode($result[0]->gpd_false_button_aff);
                    $data[$p]['gpd_button_disclaimer'] = html_entity_decode($result[0]->gpd_button_disclaimer);
                    $data[$p]['gpd_points_head_'] = html_entity_decode($result[0]->gpd_points_head_);
                    $data[$p]['gpd_points_pointOne_'] = html_entity_decode($result[0]->gpd_points_pointOne_);
                    $data[$p]['gpd_points_pointTwo_'] = html_entity_decode($result[0]->gpd_points_pointTwo_);
                    $data[$p]['gpd_points_pointTree_'] = html_entity_decode($result[0]->gpd_points_pointTree_);

                    /* -------------- Stream_provider_page ---------------- */
                    $data[$p]['gpp_head'] = html_entity_decode($result[0]->gpp_head);
                    $data[$p]['gpp_quality_head'] = html_entity_decode($result[0]->gpp_quality_head);
                    $data[$p]['gpp_quality_content'] = html_entity_decode($result[0]->gpp_quality_content);
                    $data[$p]['gpp_udv_head'] = html_entity_decode($result[0]->gpp_udv_head);
                    $data[$p]['gpp_udv_content'] = html_entity_decode($result[0]->gpp_udv_content);
                    $data[$p]['gpp_price_head'] = html_entity_decode($result[0]->gpp_price_head);
                    $data[$p]['gpp_price_content'] = html_entity_decode($result[0]->gpp_price_content);
                    $data[$p]['gpp_icon_H_one'] = html_entity_decode($result[0]->gpp_icon_H_one);
                    $data[$p]['gpp_icon_S_one'] = html_entity_decode($result[0]->gpp_icon_S_one);
                    $data[$p]['gpp_icon_H_two'] = html_entity_decode($result[0]->gpp_icon_H_two);
                    $data[$p]['gpp_icon_S_two'] = html_entity_decode($result[0]->gpp_icon_S_two);
                    $data[$p]['gpp_icon_H_three'] = html_entity_decode($result[0]->gpp_icon_H_three);
                    $data[$p]['gpp_icon_S_three'] = html_entity_decode($result[0]->gpp_icon_S_three);
                    $data[$p]['gpp_icon_note'] = html_entity_decode($result[0]->gpp_icon_note);
                    $data[$p]['gpp_button_rew'] = html_entity_decode($result[0]->gpp_button_rew);
                    $data[$p]['gpp_button_wlive'] = html_entity_decode($result[0]->gpp_button_wlive);
                    $data[$p]['gpp_button_aff'] = html_entity_decode($result[0]->gpp_false_button_aff);
                    $data[$p]['gpp_button_disclaimer'] = html_entity_decode($result[0]->gpp_button_disclaimer);
                }

            }
        } else {
            $streamresult = General::service_fodbold_stramp($id);
            $dataSport = Db::table('rebel_penguin_sports')->select('rebel_penguin_sports.id_sport')->where('rebel_penguin_sports.id_sport', '=', $Sport)->get();
            $cantstream = @count($streamresult['stream_providers']);
            $dataSport = $dataSport[0]->id_sport;
            $p = 0;
            for ($i = 0; $i < $cantstream; $i++) {
                $result = Db::table('streampersport')
                    ->select('streampersport.*')
                    ->join('rebel_penguin_stream_p', 'rebel_penguin_stream_p.id_stp', '=', 'streampersport.id_stp')
                    ->where('rebel_penguin_stream_p.active', '=', 1)
                    ->where('streampersport.id_stp', '=', $streamresult['stream_providers'][$i]->id)
                    ->where('streampersport.id_sport', '=', $dataSport)
                    ->get();
                if (count($result) > 0) {
                    $rest = self::restictions($id_token, $result[0]->id_stp, $Sport);
                    if ($rest == 'true') {
                        $data[$p]['rest'] = 'Accessible seulement avec IP Française';
                    } else {
                        $data[$p]['rest'] = '';
                    }

                    $data[$p]['name'] = $result[0]->name;
                    $data[$p]['id_sport'] = $result[0]->id_sport;
                    $data[$p]['id_stream'] = $result[0]->id_stp;

                    /* -------------- Genera Info ---------------- */
                    $data[$p]['gnr_label'] = $result[0]->gnr_label;
                    $data[$p]['gnr_afflink'] = $result[0]->gnr_false_aff;
                    $data[$p]['gnr_quality'] = $result[0]->gnr_quality;
                    $data[$p]['gnr_sort'] = $result[0]->gnr_sort;
                    $data[$p]['gnr_size'] = $result[0]->gnr_size;
                    $data[$p]['gnr_price'] = $result[0]->gnr_price;
                    $data[$p]['gnr_active'] = $result[0]->gnr_active;
                    $data[$p]['gnr_rating'] = $result[0]->gnr_rating;

                    /* --------------Stream_general_manager ---------------- */
                    $data[$p]['gpm_head'] = html_entity_decode($result[0]->gpm_head);
                    $data[$p]['gpm_active'] = html_entity_decode($result[0]->gpm_active);
                    $data[$p]['gpm_quality_head'] = html_entity_decode($result[0]->gpm_quality_head);
                    $data[$p]['gpm_quality_content'] = html_entity_decode($result[0]->gpm_quality_content);
                    $data[$p]['gpm_udv_head'] = html_entity_decode($result[0]->gpm_udv_head);
                    $data[$p]['gpm_udv_content'] = html_entity_decode($result[0]->gpm_udv_content);
                    $data[$p]['gpm_price_head'] = html_entity_decode($result[0]->gpm_price_head);
                    $data[$p]['gpm_price_content'] = html_entity_decode($result[0]->gpm_price_content);
                    $data[$p]['gpm_icon_H_one'] = html_entity_decode($result[0]->gpm_icon_H_one);
                    $data[$p]['gpm_icon_S_one'] = html_entity_decode($result[0]->gpm_icon_S_one);
                    $data[$p]['gpm_icon_H_two'] = html_entity_decode($result[0]->gpm_icon_H_two);
                    $data[$p]['gpm_icon_S_two'] = html_entity_decode($result[0]->gpm_icon_S_two);
                    $data[$p]['gpm_icon_H_three'] = html_entity_decode($result[0]->gpm_icon_H_three);
                    $data[$p]['gpm_icon_S_three'] = html_entity_decode($result[0]->gpm_icon_S_three);
                    $data[$p]['gpm_icon_N_three'] = html_entity_decode($result[0]->gpm_icon_N_three);
                    $data[$p]['gpm_button_rew'] = html_entity_decode($result[0]->gpm_button_rew);
                    $data[$p]['gpm_button_wlive'] = html_entity_decode($result[0]->gpm_button_wlive);
                    $data[$p]['gpm_button_aff'] = html_entity_decode($result[0]->gpm_false_button_aff);

                    /* -------------- Stream_page_details ---------------- */
                    $data[$p]['gpd_head'] = html_entity_decode($result[0]->gpd_head);
                    $data[$p]['gpd_icon_note'] = html_entity_decode($result[0]->gpd_icon_note);
                    $data[$p]['gpd_icon_H_one'] = html_entity_decode($result[0]->gpd_icon_H_one);
                    $data[$p]['gpd_icon_S_one'] = html_entity_decode($result[0]->gpd_icon_S_one);
                    $data[$p]['gpd_icon_H_two'] = html_entity_decode($result[0]->gpd_icon_H_two);
                    $data[$p]['gpd_icon_S_two'] = html_entity_decode($result[0]->gpd_icon_S_two);
                    $data[$p]['gpd_icon_H_three'] = html_entity_decode($result[0]->gpd_icon_H_three);
                    $data[$p]['gpd_icon_S_three'] = html_entity_decode($result[0]->gpd_icon_S_three);
                    $data[$p]['gpd_button_head'] = html_entity_decode($result[0]->gpd_button_head);
                    $data[$p]['gpd_button_subhead'] = html_entity_decode($result[0]->gpd_button_subhead);
                    $data[$p]['gpd_button_aff'] = html_entity_decode($result[0]->gpd_false_button_aff);
                    $data[$p]['gpd_button_disclaimer'] = html_entity_decode($result[0]->gpd_button_disclaimer);

                    $data[$p]['gpd_points_head_'] = html_entity_decode($result[0]->gpd_points_head_);
                    $data[$p]['gpd_points_pointOne_'] = html_entity_decode($result[0]->gpd_points_pointOne_);
                    $data[$p]['gpd_points_pointTwo_'] = html_entity_decode($result[0]->gpd_points_pointTwo_);
                    $data[$p]['gpd_points_pointTree_'] = html_entity_decode($result[0]->gpd_points_pointTree_);

                    /* -------------- Stream_provider_page ---------------- */
                    $data[$p]['gpp_head'] = html_entity_decode($result[0]->gpp_head);
                    $data[$p]['gpp_quality_head'] = html_entity_decode($result[0]->gpp_quality_head);
                    $data[$p]['gpp_quality_content'] = html_entity_decode($result[0]->gpp_quality_content);
                    $data[$p]['gpp_udv_head'] = html_entity_decode($result[0]->gpp_udv_head);
                    $data[$p]['gpp_udv_content'] = html_entity_decode($result[0]->gpp_udv_content);
                    $data[$p]['gpp_price_head'] = html_entity_decode($result[0]->gpp_price_head);
                    $data[$p]['gpp_price_content'] = html_entity_decode($result[0]->gpp_price_content);
                    $data[$p]['gpp_icon_H_one'] = html_entity_decode($result[0]->gpp_icon_H_one);
                    $data[$p]['gpp_icon_S_one'] = html_entity_decode($result[0]->gpp_icon_S_one);
                    $data[$p]['gpp_icon_H_two'] = html_entity_decode($result[0]->gpp_icon_H_two);
                    $data[$p]['gpp_icon_S_two'] = html_entity_decode($result[0]->gpp_icon_S_two);
                    $data[$p]['gpp_icon_H_three'] = html_entity_decode($result[0]->gpp_icon_H_three);
                    $data[$p]['gpp_icon_S_three'] = html_entity_decode($result[0]->gpp_icon_S_three);
                    $data[$p]['gpp_icon_note'] = html_entity_decode($result[0]->gpp_icon_note);
                    $data[$p]['gpp_button_rew'] = html_entity_decode($result[0]->gpp_button_rew);
                    $data[$p]['gpp_button_wlive'] = html_entity_decode($result[0]->gpp_button_wlive);
                    $data[$p]['gpp_button_aff'] = html_entity_decode($result[0]->gpp_false_button_aff);
                    $data[$p]['gpp_button_disclaimer'] = html_entity_decode($result[0]->gpp_button_disclaimer);
                    $p++;
                    /* -------------- End ---------------- */
                }

            }

        }
        return $data;
    }

    static function event($id)
    {
        $i = 0;
        $events = array();
        $result = General::service_event($id);
        $events[$i]['date_hour'] = date("H:i", strtotime($result['start_date']));
        $events[$i]['home_team'] = $result['home']->name;
        $events[$i]['home_team_logo'] = $result['home']->logo;
        $events[$i]['away_team'] = $result['away']->name;
        $events[$i]['away_team_logo'] = $result['away']->logo;
        return $events;
    }

    static function landingpage($name)
    {
        $sport = self::getSportbyName($name);
        $data = Db::table('rebel_penguin_landingpage_showcase')
            ->select('rebel_penguin_landingpage_showcase.*')
            ->where('rebel_penguin_landingpage_showcase.id_sport', '=', $sport[0]["id_sport"])
            ->get();
        $result = array();
        if (count($data) != 0) {
            for ($a = 0; $a < count($data); $a++) {
                $result[$a]['id'] = $data[$a]->id;
                $result[$a]['date'] = $data[$a]->eventdate;
                $result[$a]['date_h'] = $data[$a]->eventdate;
                $result[$a]['away_team'] = $data[$a]->away_team;
                $result[$a]['home_team'] = $data[$a]->home_team;
                $result[$a]['away_team_logo'] = $data[$a]->away_team_logo;
                $result[$a]['home_team_logo'] = $data[$a]->home_team_logo;

                $url_date = date("Y-m-d", strtotime($data[$a]->eventdate));
                $url_free1 = self::Clearfeet($data[$a]->home_team);
                $url_free2 = self::Clearfeet($data[$a]->away_team);
                $result[$a]['url_free'] = $url_free1 . '-vs-' . $url_free2 . '-' . $url_date;

            }
            return $result;

        } else {
            $result = ['error' => 'This match no have information yet, be the first at writter',];
            return $result;
        }
    }

    static function sportlivestream($Sport, $id_token)
    {
        $date = date('Y-m-d');
        $data = Db::table('rebel_penguin_landingpage_showcase')
            ->select('rebel_penguin_landingpage_showcase.*')
            ->where('rebel_penguin_landingpage_showcase.id_sport', '=', $Sport)
            ->where('rebel_penguin_landingpage_showcase.active', '=', 1)
            ->where('rebel_penguin_landingpage_showcase.eventdate', '>=', $date)
            ->orderby('rebel_penguin_landingpage_showcase.eventdate', 'asc')
            ->get();
        $result = array();
        $result_ = array();

        if (empty($data)) {
            $data = Db::table('rebel_penguin_token')
                ->where('rebel_penguin_token.sportid', $Sport)
                ->where('rebel_penguin_token.start', $date)
                ->orderBy('rebel_penguin_token.hour', 'asc')
                ->get();
            for ($a = 0; $a < count($data); $a++) {
                $result[$a]['count'] = count($data);
                $result[$a]['id'] = $data[$a]->id;
                $result[$a]['id_event'] = $data[$a]->id_events;
                $result[$a]['date'] = date("d.m.y H:i", strtotime($data[$a]->hour));
                $result[$a]['date_d'] = date("d.m.y", strtotime($data[$a]->hour));
                $result[$a]['date_h'] = date("H:i", strtotime($data[$a]->hour));
                $result[$a]['away_team'] = $data[$a]->away_team;
                $result[$a]['home_team'] = $data[$a]->home_team;
                $result[$a]['away_team_logo'] = $data[$a]->away_team_logo;
                $result[$a]['home_team_logo'] = $data[$a]->home_team_logo;
                $result[$a]['url_free'] = $data[$a]->token;
            }
            return $result;

        } else {
            if (count($data) != 0 && $id_token[1] != 'id_march') {
                for ($a = 0; $a < count($data); $a++) {
                    $result[$a]['id'] = $data[$a]->id;
                    $result[$a]['id_event'] = $data[$a]->id_event;
                    $result[$a]['date'] = date("d.m.y H:i", strtotime($data[$a]->eventdate));
                    $result[$a]['date_d'] = date("d.m.y", strtotime($data[$a]->eventdate));
                    $result[$a]['date_h'] = date("H:i", strtotime($data[$a]->eventhour));
                    $result[$a]['away_team'] = $data[$a]->away_team;
                    $result[$a]['home_team'] = $data[$a]->home_team;
                    $result[$a]['away_team_logo'] = $data[$a]->away_team_logo;
                    $result[$a]['home_team_logo'] = $data[$a]->home_team_logo;
                    $url_date = date("Y-m-d", strtotime($data[$a]->eventdate));
                    $url_free1 = self::Clearfeet($data[$a]->home_team);
                    $url_free2 = self::Clearfeet($data[$a]->away_team);
                    $result[$a]['url_free'] = $url_free1 . '-vs-' . $url_free2 . '-' . $url_date;
                }
                for ($a = 0; $a < count($result); $a++) {
                    $show = General::Service_URL($id_token[1]);
                    if ($result[$a]['id_event'] == $show) {
                        $result_[0] = $result[$a];
                    }
                }

                if (count($result_) == 1)
                    return $result_;
                else  return $result;
            }
            if (count($data) != 0 && $id_token[1] == 'id_march') {
                for ($a = 0; $a < count($data); $a++) {
                    $result[$a]['count'] = count($data);
                    $result[$a]['id'] = $data[$a]->id;
                    $result[$a]['id_event'] = $data[$a]->id_event;
                    $result[$a]['date'] = date("d.m.y H:i", strtotime($data[$a]->eventdate));
                    $result[$a]['date_d'] = date("d.m.y", strtotime($data[$a]->eventdate));
                    $result[$a]['date_h'] = date("H:i", strtotime($data[$a]->eventhour));
                    $result[$a]['away_team'] = $data[$a]->away_team;
                    $result[$a]['home_team'] = $data[$a]->home_team;
                    $result[$a]['away_team_logo'] = $data[$a]->away_team_logo;
                    $result[$a]['home_team_logo'] = $data[$a]->home_team_logo;
                    $url_date = date("Y-m-d", strtotime($data[$a]->eventdate));
                    $url_free1 = self::Clearfeet($data[$a]->home_team);
                    $url_free2 = self::Clearfeet($data[$a]->away_team);
                    $result[$a]['url_free'] = $url_free1 . '-vs-' . $url_free2 . '-' . $url_date;
                }
                return $result;
            } else {
                $result = ['error' => 'This match no have information yet, be the first at writter',];
                return $result;
            }
        }
    }

    static function landingpage_stream()
    {
        $result = array();
        $data = Db::table('rebel_penguin_stream_data')
            ->join('rebel_penguin_stream_p', 'rebel_penguin_stream_data.id_stp', '=', 'rebel_penguin_stream_p.id_stp')
            ->select('rebel_penguin_stream_data.*', 'rebel_penguin_stream_p.name')
            ->where('rebel_penguin_stream_p.active', '=', 1)
            ->get();
        for ($a = 0; $a < count($data); $a++) {
            $result[$a]['id'] = $data[$a]->id_stp;
            $result[$a]['gnr_label'] = $data[$a]->name;
            $result[$a]['gnr_affi'] = $data[$a]->gnr_affi;
            $result[$a]['gnr_review_butt'] = $data[$a]->gnr_review_butt;
            $result[$a]['gnr_live_butt'] = $data[$a]->gnr_live_butt;
            $result[$a]['gnr_sort'] = $data[$a]->gnr_sort;
            $result[$a]['gnr_active'] = $data[$a]->gnr_active;
            $result[$a]['gnr_rating'] = $data[$a]->gnr_rating;
            $result[$a]['gnr_coment'] = html_entity_decode($data[$a]->gnr_coment);
            $result[$a]['gnr_coment'] = html_entity_decode($data[$a]->gnr_coment);
            $result[$a]['img_genr'] = html_entity_decode($data[$a]->img_genr);
            $result[$a]['img_cont'] = html_entity_decode($data[$a]->img_cont);
            $result[$a]['img_cont'] = html_entity_decode($data[$a]->img_cont);
            $data_result = explode('.', $result[$a]['gnr_rating']);
            if (@$data_result[1] == '5') {
                $result[$a]['gnr_rating_half'] = 1;
            }


            $result[$a]['meta_title'] = $data[$a]->meta_title;
            $result[$a]['meta_desc'] = $data[$a]->meta_desc;
            $result[$a]['meta_keywords'] = $data[$a]->meta_keywords;

            $result[$a]['cont_pros'] = htmlspecialchars_decode($data[$a]->cont_pros);
            $result[$a]['cont_introduction'] = htmlspecialchars_decode($data[$a]->cont_introduction);
            $result[$a]['cont_bonus'] = $data[$a]->cont_bonus;
            $result[$a]['cont_topbutton'] = $data[$a]->cont_topbutton;
            $result[$a]['cont_botbutton'] = $data[$a]->cont_botbutton;
            $result[$a]['cont_affiliate'] = $data[$a]->cont_affiliate;
            $result[$a]['cont_active'] = $data[$a]->cont_active;

            $result[$a]['udv_heading'] = $data[$a]->udv_heading;
            $result[$a]['udv_ratin'] = $data[$a]->udv_ratin;
            @$data_result = explode('.', $result[$a]['udv_ratin']);
            if (@$data_result[1] == '5') {
                $result[$a]['udv_ratin_half'] = 1;
            }
            $result[$a]['udv_content'] = html_entity_decode($data[$a]->udv_content);

            $result[$a]['prod_heading'] = $data[$a]->prod_heading;
            $result[$a]['prod_ratin'] = $data[$a]->prod_ratin;
            @$data_result = explode('.', $result[$a]['prod_ratin']);
            if (@$data_result[1] == '5') {
                $result[$a]['prod_ratin_half'] = 1;
            }
            $result[$a]['prod_content'] = html_entity_decode($data[$a]->prod_content);

            $result[$a]['lives_heading'] = $data[$a]->lives_heading;
            $result[$a]['lives_ratin'] = $data[$a]->lives_ratin;
            @$data_result = explode('.', $result[$a]['lives_ratin']);
            if (@$data_result[1] == '5') {
                $result[$a]['lives_ratin_half'] = 1;
            }
            $result[$a]['lives_content'] = html_entity_decode($data[$a]->lives_content);

            $result[$a]['odds_heading'] = $data[$a]->odds_heading;
            $result[$a]['odds_ratin'] = $data[$a]->odds_ratin;
            @$data_result = explode('.', $result[$a]['odds_ratin']);
            if (@$data_result[1] == '5') {
                $result[$a]['odds_ratin_half'] = 1;
            }
            $result[$a]['odds_content'] = html_entity_decode($data[$a]->odds_content);

            $result[$a]['supp_heading'] = $data[$a]->supp_heading;
            $result[$a]['supp_ratin'] = $data[$a]->supp_ratin;
            @$data_result = explode('.', $result[$a]['supp_ratin']);
            if (@$data_result[1] == '5') {
                $result[$a]['supp_ratin_half'] = 1;
            }
            $result[$a]['supp_content'] = html_entity_decode($data[$a]->supp_content);

            $result[$a]['bonusser_heading'] = $data[$a]->bonusser_heading;
            $result[$a]['bonusser_ratin'] = $data[$a]->bonusser_ratin;
            @$data_result = explode('.', $result[$a]['bonusser_ratin']);
            if (@$data_result[1] == '5') {
                $result[$a]['bonusser_ratin_half'] = 1;
            }
            $result[$a]['bonusser_content'] = html_entity_decode($data[$a]->bonusser_content);

            $result[$a]['bruger_heading'] = $data[$a]->bruger_heading;
            $result[$a]['bruger_ratin'] = $data[$a]->bruger_ratin;
            @$data_result = explode('.', $result[$a]['bruger_ratin']);
            if (@$data_result[1] == '5') {
                $result[$a]['bruger_ratin_half'] = 1;
            }
            $result[$a]['bruger_content'] = html_entity_decode($data[$a]->bruger_content);

            $result[$a]['ind_og_heading'] = $data[$a]->ind_og_heading;
            $result[$a]['ind_og_ratin'] = $data[$a]->ind_og_ratin;
            @$data_result = explode('.', $result[$a]['ind_og_ratin']);
            if (@$data_result[1] == '5') {
                $result[$a]['ind_og_ratin_half'] = 1;
            }
            $result[$a]['ind_og_content'] = html_entity_decode($data[$a]->ind_og_content);

            $result[$a]['vores_heading'] = $data[$a]->vores_heading;
            $result[$a]['vores_ratin'] = $data[$a]->vores_ratin;
            @$data_result = explode('.', $result[$a]['vores_ratin']);
            if (@$data_result[1] == '5') {
                $result[$a]['vores_ratin_half'] = 1;
            }
            $result[$a]['vores_content'] = html_entity_decode($data[$a]->vores_content);

            $result[$a]['bruger_heading'] = $data[$a]->bruger_heading;
            $result[$a]['bruger_ratin'] = $data[$a]->bruger_ratin;
            @$data_result = explode('.', $result[$a]['bruger_ratin']);
            if (@$data_result[1] == '5') {
                $result[$a]['bruger_ratin_half'] = 1;
            }
            $result[$a]['bruger_content'] = html_entity_decode($data[$a]->bruger_content);


            $result[$a]['liveb_heading'] = $data[$a]->liveb_heading;
            $result[$a]['liveb_ratin'] = $data[$a]->liveb_ratin;
            @$data_result = explode('.', $result[$a]['liveb_ratin']);
            if (@$data_result[1] == '5') {
                $result[$a]['liveb_ratin_half'] = 1;
            }
            $result[$a]['liveb_content'] = html_entity_decode($data[$a]->liveb_content);


            $result[$a]['indsat_heading'] = $data[$a]->indsat_heading;
            $result[$a]['indsat_ratin'] = $data[$a]->indsat_ratin;
            @$data_result = explode('.', $result[$a]['indsat_ratin']);
            if (@$data_result[1] == '5') {
                $result[$a]['indsat_ratin_half'] = 1;
            }
            $result[$a]['indsat_content'] = html_entity_decode($data[$a]->indsat_content);

            $result[$a]['konk_heading'] = $data[$a]->konk_heading;
            $result[$a]['konk_ratin'] = $data[$a]->konk_ratin;
            @$data_result = explode('.', $result[$a]['konk_ratin']);
            if (@$data_result[1] == '5') {
                $result[$a]['konk_ratin_half'] = 1;
            }
            $result[$a]['konk_content'] = html_entity_decode($data[$a]->konk_content);

        }
        return $result;
    }

    static function gectArticle($id)
    {
        $data = Db::table('rebel_penguin_article')
            ->where('rebel_penguin_article.active', '=', 1)
            ->where('rebel_penguin_article.id_sport', '=', $id)
            ->get();
        $result = array();
        $a = 0;
        if (count($data) != 0) {
            for ($i = 0; $i < count($data); $i++) {
                $result[$i]['artic_name'] = $data[$i]->artic_name;
                $result[$i]['id_evento'] = $data[$i]->id_evento;
                $result[$i]['date'] = $newDate = date("d.m.y", strtotime($data[$i]->date));
                $result[$i]['hora'] = $newDate = date("H:s", strtotime($data[$i]->date));
                $url_date = date("Y-m-d", strtotime($data[$i]->date));
                $url_free1 = self::Clearfeet($data[$i]->home_team);
                $url_free2 = self::Clearfeet($data[$i]->away_team);
                $result[$i]['url_free'] = $url_free1 . '-vs-' . $url_free2 . '-' . $url_date;
            }
            return $result;
        } else {
            $result = ['error' => 'This match no have information yet, be the first at writter',];
            return $result;
        }
    }

    static function landinPagesGobal($id_token)
    {
        /*
         * 1- Buscar los datos de la bd.
         * 2- Generar las consultas en evento y config de la pag.
         * 3- Si no esta en bd, buscar los datos en el API.
         * 4- Traer los datos de bd generales de lo strems en ese deporte que esten en bd.
         *
         * */

        $id = General::Service_URL($id_token);
        $result = array();
        $data = Db::table('rebel_penguin_article')
            ->where('rebel_penguin_article.active', '=', 1)
            ->where('rebel_penguin_article.id_evento', '=', $id)
            ->get();

        if (count($data) > 0) {
            $data = Db::table('allarticles')->where('allarticles.id_evento', '=', $id)->get();
            for ($i = 0; $i < count($data); $i++) {
                $result[$i]['id'] = $data[$i]->id;
                $result[$i]['id_evento'] = $data[$i]->id_evento;
                $result[$i]['id_sport'] = $data[$i]->id_sport;
                $result[$i]['date'] = $data[$i]->date;
                $result[$i]['date_h'] = $data[$i]->date_h;
                $result[$i]['match_'] = $data[$i]->match_;
                $result[$i]['country'] = $data[$i]->country;
                $result[$i]['liga'] = $data[$i]->liga;
                $result[$i]['caption'] = $data[$i]->caption;
                $result[$i]['autor'] = $data[$i]->autor;
                $result[$i]['artic_name'] = $data[$i]->artic_name;
                $result[$i]['article_body'] = $data[$i]->article_body;
                $result[$i]['permanet_front'] = $data[$i]->permanet_front;
                $result[$i]['date_create'] = $data[$i]->date_create;
                $result[$i]['date_update'] = $data[$i]->date_update;
                $result[$i]['home_team'] = $data[$i]->home_team;
                $result[$i]['away_team'] = $data[$i]->away_team;
                $result[$i]['vip_article'] = $data[$i]->vip_article;
                $result[$i]['away_team_logo'] = $data[$i]->away_team_logo;
                $result[$i]['home_team_logo'] = $data[$i]->home_team_logo;
                $result[$i]['sport_name'] = $data[$i]->sport_name;
                $result[$i]['sportactive'] = $data[$i]->sportactive;
                $result[$i]['color'] = $data[$i]->color;
            }
            return $result;
        } else {
            $event = General::service_event($id);
            $i = 0;
            $result[$i]['id_evento'] = $event['id'];
            $result[$i]['date'] = date("d.M Y", strtotime($event['start_date']));
            $result[$i]['date_h'] = date("H:i", strtotime($event['start_date']));
            $result[$i]['match_'] = $event['home']->name . ' VS ' . $event['away']->name;
            $result[$i]['home_team'] = $event['home']->name;
            $result[$i]['away_team'] = $event['away']->name;
            $result[$i]['away_team_logo'] = $event['home']->logo;
            $result[$i]['home_team_logo'] = $event['away']->logo;

            return $result;

        }


    }

    static function landinPagesstream($id_token, $sport)
    {
        /*
         * 1- Buscar los datos de la bd.
         * 2- Generar las consultas en evento y config de la pag.
         * 3- Si no esta en bd, buscar los datos en el API.
         * 4- Traer los datos de bd generales de lo strems en ese deporte que esten en bd.
         *
         * */

        $id = General::Service_URL($id_token);
        $result = array();
        $data = Db::table('landainPagesData')
            ->where('landainPagesData.eventoid', '=', $id)
            ->where('landainPagesData.sponsored', '==', '1')
            ->orderby('landainPagesData.stream_sort', 'asc')
            ->get();
        if (count($data) > 0) {
            /* $data = Db::table('landainPagesData')
                 ->where('landainPagesData.eventoid', '=', $id)
                 ->where('landainPagesData.sponsored', '!=', '1')
                 ->orderby ('landainPagesData.stream_sort' , 'asc')
                 ->get();*/
            for ($i = 0; $i < count($data); $i++) {
                $result[$i]['sport_name'] = $data[$i]->sport_name;
                $result[$i]['id_sport'] = $data[$i]->id_sport;
                $result[$i]['color'] = $data[$i]->color;
                $result[$i]['sport_actve'] = $data[$i]->sport_actve;
                $result[$i]['pagetitle'] = $data[$i]->pagetitle;
                $result[$i]['urltoken'] = $data[$i]->urltoken;
                $result[$i]['metadescrip'] = $data[$i]->metadescrip;
                $result[$i]['metakeyb'] = $data[$i]->metakeyb;
                $result[$i]['prombox_head'] = $data[$i]->prombox_head;
                $result[$i]['prombox_affil'] = $data[$i]->prombox_affil;
                $result[$i]['prombox_aff_tv'] = $data[$i]->prombox_aff_tv;
                $result[$i]['prombox_banner_head'] = $data[$i]->prombox_banner_head;
                $result[$i]['Sponsoreret'] = $data[$i]->Sponsoreret;
                $result[$i]['usedarticle'] = $data[$i]->usedarticle;
                $result[$i]['stream_head'] = $data[$i]->stream_head;
                $result[$i]['stream_aff'] = $data[$i]->stream_aff;
                $result[$i]['stream_content'] = $data[$i]->stream_content;
                $result[$i]['stream_sort'] = $data[$i]->stream_sort;
                $result[$i]['stream_icon_one'] = $data[$i]->stream_icon_one;
                $result[$i]['stream_icon_two'] = $data[$i]->stream_icon_two;
                $result[$i]['stream_icon_tree'] = $data[$i]->stream_icon_tree;
                $result[$i]['stream_buttons_phrase'] = $data[$i]->stream_buttons_phrase;
                $result[$i]['promobox'] = $data[$i]->promobox;
                $result[$i]['stream_buttons_butt'] = $data[$i]->stream_buttons_butt;
                $result[$i]['landingActive'] = $data[$i]->landingActive;
                $result[$i]['stream_name'] = $data[$i]->stream_name;
                $result[$i]['id_stp'] = $data[$i]->id_stp;
                $result[$i]['article_id'] = $data[$i]->article_id;
                $result[$i]['eventoid'] = $data[$i]->eventoid;
                $result[$i]['promobox_link'] = $data[$i]->promobox_link;
                $result[$i]['prombox_banner_subH'] = $data[$i]->prombox_banner_subH;
                $result[$i]['Price'] = $data[$i]->Price;
                $result[$i]['Quality'] = $data[$i]->Quality;
                $result[$i]['Rating'] = $data[$i]->Rating;
                $result[$i]['sponsored'] = $data[$i]->sponsored;
                $result[$i]['Disclaimer'] = $data[$i]->Disclaimer;
            }

            return $result;
        } else {
            $event = self::landinPagesGobal($id_token);
            $stramp = General::service_fodbold_stramp($id);

            $z = 0;
            for ($i = 0; $i < count($stramp['stream_providers']); $i++) {
                $stramp_id = $stramp['stream_providers'][$i]->id;
                $data = Db::table('streampersport')
                    ->join('rebel_penguin_stream_p', 'rebel_penguin_stream_p.id_stp', '=', 'streampersport.id_stp')
                    ->where('rebel_penguin_stream_p.active', '=', 1)
                    ->where('streampersport.id_stp', '=', $stramp_id)
                    ->orderby('streampersport.gnr_sort', 'asc')
                    ->get();
                if (count($data) > 0) {
                    $data = (array)$data[0];
                    $result[$z]['sport_name'] = $data['name'];
                    $result[$z]['id_sport'] = $data['id_sport'];
                    $result[$z]['color'] = $data['color'];
                    $result[$z]['pagetitle'] = 'dsækml g';
                    $result[$z]['urltoken'] = $data['gnr_false_aff'];
                    $result[$z]['metadescrip'] = '';
                    $result[$z]['metakeyb'] = '';
                    $result[$z]['prombox_head'] = 'Livestream NU';
                    $result[$z]['prombox_affil'] = $data['gnr_false_aff'];

                    $result[$z]['prombox_aff_tv'] = $data['gpp_icon_H_two'];
                    $result[$z]['prombox_banner_head'] = 'Gå til ' . $data['gnr_label'];

                    $result[$z]['Sponsoreret'] = '';
                    $result[$z]['usedarticle'] = '';
                    $result[$z]['stream_head'] = $data['gnr_false_aff'];
                    $result[$z]['stream_aff'] = $data['gnr_false_aff'];
                    $result[$z]['stream_content'] = 'dlkfnds ';
                    $result[$z]['stream_sort'] = $data['gnr_sort'];
                    $result[$z]['stream_icon_one'] = $data['gpm_icon_H_one'];
                    $result[$z]['stream_icon_two'] = $data['gpm_icon_H_two'];
                    $result[$z]['stream_icon_tree'] = $data['gpm_icon_H_three'];

                    $result[$z]['stream_buttons_phrase'] = '-hos ' . $data['gnr_label'];

                    $result[$z]['promobox'] = $data['gpm_icon_N_three'];
                    $result[$z]['stream_buttons_butt'] = 'Se live ' . $data['name'];
                    $result[$z]['landingActive'] = '0';
                    $result[$z]['stream_name'] = $data['gnr_label'];
                    $result[$z]['id_stp'] = $data['id_stp'];
                    $result[$z]['article_id'] = '1';
                    $result[$z]['eventoid'] = $id_token;

                    $result[$z]['promobox_link'] = $data['gnr_false_aff'];
                    $result[$z]['prombox_banner_subH'] = $data['gpd_icon_H_one'];

                    $result[$z]['Price'] = $data['gnr_price'];
                    $result[$z]['Quality'] = $data['gnr_quality'];
                    $result[$z]['Rating'] = $data['gnr_rating'];
                    $z++;
                }

            }

            return $result;
        }


    }

    static function liveheader($sport, $Stream)
    {
        $id_sport = $sport;
        $namesport = self::getSport($sport);
        $namestrem = self::getStream($Stream);
        $date = date('Y-m-d');
        $data = Db::table('rebel_penguin_article')
            ->select('rebel_penguin_article.*')
            ->where('rebel_penguin_article.vip_article', '=', 1)
            ->where('rebel_penguin_article.id_sport', '=', $id_sport)
            ->where('rebel_penguin_article.active', '=', 1)
            ->where('rebel_penguin_article.date', '>=', $date)
            ->orderby('rebel_penguin_article.date', 'asc')
            ->get();

        $result = array();
        $index = 0;
        if (count($data) > 0) {
            for ($a = 0; $a < count($data); $a++) {
                $stream = General::service_fodbold_stramp(self::Clearfeet($data[$a]->id_evento));
                if (count(@$stream['stream_providers']) > 0 && $stream != 'error') {
                    for ($z = 0; $z < count($stream['stream_providers']); $z++) {
                        if (isset($stream['stream_providers']) and $stream['stream_providers'][$z]->id == $Stream) {
                            $result[$index]['id'] = $data[$a]->id;
                            $result[$index]['id_evento'] = $data[$a]->id_evento;
                            $result[$index]['artic_name'] = $data[$a]->artic_name;
                            $result[$index]['date'] = date("d.m.y", strtotime($data[$a]->date));
                            $result[$index]['hora'] = date("H:i", strtotime($data[$a]->date_h));
                            $result[$index]['match_'] = $data[$a]->match_;
                            $result[$index]['date_h'] = $data[$a]->date_h;
                            $result[$index]['country'] = $data[$a]->country;
                            $result[$index]['liga'] = $data[$a]->liga;
                            $result[$index]['Url'] = "/redirect/:" . self::Clearfeet($namesport[0]['name']) ."/:".$namestrem[0]['name']."/:fpd";
                            $result[$index]['StreamName'] = $namestrem[0]['name'];
                            $result[$index]['color'] = $namesport[0]['color'];
                            $result[$index]['sport'] = $namesport[0]['name'];
                            $result[$index]['caption'] = $data[$a]->caption;
                            $result[$index]['autor'] = $data[$a]->autor;
                            $result[$index]['artic_name'] = $data[$a]->artic_name;
                            $result[$index]['article_body'] = html_entity_decode($data[$a]->article_body);
                            $result[$index]['show_front'] = $data[$a]->show_front;
                            $result[$index]['permanet_front'] = $data[$a]->permanet_front;
                            $result[$index]['date_create'] = $data[$a]->date_create;
                            $result[$index]['date_update'] = $data[$a]->date_update;
                            $result[$index]['away_team'] = $data[$a]->away_team;
                            $result[$index]['home_team'] = $data[$a]->home_team;
                            $result[$index]['away_team_logo'] = $data[$a]->away_team_logo;
                            $result[$index]['home_team_logo'] = $data[$a]->home_team_logo;
                            $url_date = date("Y-m-d", strtotime($data[$a]->date));
                            $url_free1 = self::Clearfeet($data[$a]->home_team);
                            $url_free2 = self::Clearfeet($data[$a]->away_team);
                            $result[$index]['url_free'] = $url_free1 . '-vs-' . $url_free2 . '-' . $url_date;
                            $rest = self::restictions($result[$index]['url_free'], $Stream, $id_sport);
                            if ($rest == 'true') {
                                $result[$index]['rest'] = 'Accessible seulement avec IP Française';
                            } else {
                                $result[$index]['rest'] = '';
                            }
                            $index++;
                        }
                    }
                }
            }
        } else {
            $data = Db::table('rebel_penguin_token')
                ->select('rebel_penguin_token.*')
                ->where('rebel_penguin_token.sportid', '=', $id_sport)
                ->where('rebel_penguin_token.start', '>=', $date)
                ->get();
            if (count($data) > 0) {
                for ($a = 0; $a < count($data); $a++) {
                    $whitelist = template::whitelistface($data[$a]->id_events, $data[$a]->tournament_id);
                    if ($whitelist == 'true') {
                        $stream = General::service_fodbold_stramp(self::Clearfeet($data[$a]->id_events));
                        if (count(@$stream['stream_providers']) > 0 && $stream != 'error') {
                            for ($z = 0; $z < count($stream['stream_providers']); $z++) {
                                if (isset($stream['stream_providers']) and $stream['stream_providers'][$z]->id == $Stream) {
                                    $result[$index]['id'] = $data[$a]->id;
                                    $result[$index]['id_evento'] = $data[$a]->id_events;
                                    $result[$index]['date'] = date("d.m.y", strtotime($data[$a]->hour));
                                    $result[$index]['hora'] = date("H:i", strtotime($data[$a]->hour));
                                    $result[$index]['Url'] = "/redirect/:" . self::Clearfeet($namesport[0]['name']) . "/:" .$namestrem[0]['name']. "/:fpd";
                                    $result[$index]['StreamName'] = $namestrem[0]['name'];
                                    $result[$index]['color'] = $namesport[0]['color'];
                                    $result[$index]['sport'] = $namesport[0]['name'];
                                    $result[$index]['artic_name'] = $data[$a]->away_team . ' vs ' . $data[$a]->home_team;
                                    $result[$index]['away_team_logo'] = $data[$a]->away_team_logo;
                                    $result[$index]['home_team_logo'] = $data[$a]->home_team_logo;
                                    $result[$index]['url_free'] = $data[$a]->token;
                                    $rest = self::restictions($result[$index]['url_free'], $Stream, $id_sport);
                                    if ($rest == 'true') {
                                        $result[$index]['rest'] = 'Accessible seulement avec IP Française';
                                    } else {
                                        $result[$index]['rest'] = '';
                                    }
                                    $index++;
                                }
                            }
                        }
                    }

                }
            }
        }
        return $result;
    }

    static function fakeurl($sport, $stream, $area)
    {

        $sport = explode(':', $sport);
        $stream = explode(':', $stream);
        $area = explode(':', $area);
        $area = $area[1];
        $url = '/' . $sport[1] . '';

        $result = Db::table('rebel_penguin_stream_p')
            ->select('rebel_penguin_stream_p.*')
            ->where('rebel_penguin_stream_p.name', '=', $stream[1])
            ->get();
        $sport = self::getSportbyName($sport[1]);

        /* var_dump($id_sport[0]->id_sport);
         exit();*/

        if ($area == 'g' or $area == 'cont') {

            $data = Db::table('rebel_penguin_stream_data')
                ->where('rebel_penguin_stream_data.gnr_label', '=', $stream[1])
                ->get();

            if ($area == 'g') {
                $url = $data[0]->gnr_affi;
            }
            if ($area == 'cont') {
                $url = $data[0]->cont_affiliate;
            }
        } else {
            $data = Db::table('streampersport')
                ->where('streampersport.id_sport', '=', $sport[0]["id_sport"])
                ->where('streampersport.id_stp', '=', $result[0]->id_stp)
                ->get();

            if ($area == 'gnr') {
                $url = $data[0]->gnr_afflink;
            }
            if ($area == 'fpd') {
                $url = $data[0]->gpm_button_aff;
            }
            if ($area == 'ppd') {
                $url = $data[0]->gpp_button_aff;
            }
            if ($area == 'gpd') {
                $url = $data[0]->gpd_button_aff;
            }
        }

        $urll =  self::Clearspace_end($url);
        return $urll;
    }

    static function whitelist($obj)
    {
        $events = Db::table('rebel_penguin_listevent')
            ->where('rebel_penguin_listevent.id_event', '=', $obj->id_events)
            ->where('rebel_penguin_listevent.active', '=', 1)
            ->get();

        $liga = Db::table('rebel_penguin_listligas')
            ->where('rebel_penguin_listligas.id_liga', '=', $obj->tournament_id)
            ->where('rebel_penguin_listligas.active', '=', 1)
            ->get();


        if (count($events) > 0) {
            return 'true';
        } else if (count($liga) > 0) {
            return 'true';
        } else {
            return 'false';
        }

    }

    static function whitelistface($id, $torn)
    {
        $events = Db::table('rebel_penguin_listevent')
            ->where('rebel_penguin_listevent.id_event', '=', $id)
            ->where('rebel_penguin_listevent.active', '=', 1)
            ->get();

        $liga = Db::table('rebel_penguin_listligas')
            ->where('rebel_penguin_listligas.id_liga', '=', $torn)
            ->where('rebel_penguin_listligas.active', '=', 1)
            ->get();


        if (count($events) > 0) {
            return 'true';
        } else if (count($liga) > 0) {
            return 'true';
        } else {
            return 'false';
        }

    }


    static function restictions($id_token, $stp, $id_sport)
    {
        $result = 'false';
        $id = General::Service_URL($id_token);
        $streamresult = General::service_event($id);

        $cunt = @$streamresult['recurring_competition']->region->id;
        $lige = @$streamresult['recurring_competition']->id;
        $events = @$streamresult['id'];


        if (!isset($cunt)) {
            $cunt = @$streamresult['competition']->region->id;
        }
        if (!isset($lige)) {
            $lige = @$streamresult['competition']->id;
        }

        $country = Db::table('rebel_penguin_restrictions_countrys')
            ->where('rebel_penguin_restrictions_countrys.id_country', '=', $cunt)
            ->where('rebel_penguin_restrictions_countrys.id_stream', '=', $stp)
            ->where('rebel_penguin_restrictions_countrys.idsport', '=', $id_sport)
            ->where('rebel_penguin_restrictions_countrys.active', '=', 1)
            ->get();
        if (count($country) > 0) {
            $resultcontry = 'true';
        }


        $liga = Db::table('rebel_penguin_restrictions_league')
            ->where('rebel_penguin_restrictions_league.id_liga', '=', $lige)
            ->where('rebel_penguin_restrictions_league.id_stream', '=', $stp)
            ->where('rebel_penguin_restrictions_league.idsport', '=', $id_sport)
            ->where('rebel_penguin_restrictions_league.active', '=', 1)
            ->get();
        if (count($liga) > 0) {
            $resultliga = 'true';
        }


        $even = Db::table('rebel_penguin_restrictions_events')
            ->where('rebel_penguin_restrictions_events.id_event', '=', $events)
            ->where('rebel_penguin_restrictions_events.id_stream', '=', $stp)
            ->where('rebel_penguin_restrictions_events.idsport', '=', $id_sport)
            ->where('rebel_penguin_restrictions_events.active', '=', 1)
            ->get();
        if (count($even) > 0) {
            $resultevant = 'false';
        }


        if (@$resultevant == 'false') {
            return $result = 'false';
        } else if (@$resultcontry == 'true') {
            return $result = 'true';
        } else if (@$resultcontry == 'true') {
            return $result = 'true';
        } else {
            return $result = 'false';
        }
    }

    static function Clearfeet($s)
    {
        /* $s= trim($s,"\t\n\r\0\x0B");
         $s= str_replace(' ', '-', $s);
         //--- Latin ---//
         $s = str_replace('ü', 'u', $s);
         $s = str_replace('Á', 'A', $s);
         $s = str_replace('á', 'a', $s);
         $s = str_replace('é', 'e', $s);
         $s = str_replace('É', 'E', $s);
         $s = str_replace('í', 'i', $s);
         $s = str_replace('Í', 'I', $s);
         $s = str_replace('ó', 'o', $s);
         $s = str_replace('Ó', 'O', $s);
         $s = str_replace('Ú', 'U', $s);
         $s= str_replace('ú', 'u', $s);
         //--- Nordick ---//
         $s = str_replace('ø', 'o', $s);
         $s = str_replace('Ø', 'O', $s);
         $s = str_replace('Æ', 'E', $s);
         $s = str_replace('æ', 'e', $s);
         $s = str_replace('Å', 'A', $s);
         $s = str_replace('å', 'a', $s);
         //--- Others ---//
         $s= str_replace('.', '', $s);
         $s= str_replace('\"', '', $s);
         $s= str_replace(':', '', $s);
         $s= str_replace(',', '', $s);
         $s= str_replace(';', '', $s);
         $s= str_replace('/', '-', $s);*/

        $s = self::Clearfeet_sport($s);
        $s = strtolower($s);
        return $s;
    }

    static function Clearfeet_sport($s)
    {
        $s = trim($s, "\t\n\r\0\x0B");
        $s = str_replace(' ', '-', $s);
        //--- Latin ---//
        $s = str_replace('ü', 'u', $s);
        $s = str_replace('Á', 'A', $s);
        $s = str_replace('á', 'a', $s);
        $s = str_replace('é', 'e', $s);
        $s = str_replace('É', 'E', $s);
        $s = str_replace('í', 'i', $s);
        $s = str_replace('Í', 'I', $s);
        $s = str_replace('ó', 'o', $s);
        $s = str_replace('Ó', 'O', $s);
        $s = str_replace('Ú', 'U', $s);
        $s = str_replace('ú', 'u', $s);
        //--- Nordick ---//
        $s = str_replace('ø', 'o', $s);
        $s = str_replace('Ø', 'O', $s);
        $s = str_replace('Æ', 'E', $s);
        $s = str_replace('æ', 'e', $s);
        $s = str_replace('Å', 'A', $s);
        $s = str_replace('å', 'a', $s);
        //--- Others ---//
        $s = str_replace('.', '', $s);
        $s = str_replace('\"', '', $s);
        $s = str_replace(':', '', $s);
        $s = str_replace(',', '', $s);
        $s = str_replace(';', '', $s);
        $s = str_replace('/', '-', $s);
        return $s;
    }

    static function Clearspace($s)
    {
        $s = str_replace(' ', '', $s);
        $s = trim($s, "\t\n\r\0\x0B");
        return $s;
    }

    static function Clearspace_end($s)
    {
        $s = trim($s, "\t\n\r\0\x0B");
        return $s;
    }

    static function Day($day)
    {
        $locale = General::$locale;
        if ($locale == 'dk') {
            $dias = array("Søndag", "Mandag", "Tirsdag", "Onsdag", "Torsdag", "Fredag", "Lørdag");
        } else if ($locale == 'es') {
            $dias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado");
        } else if ($locale == 'fr') {
            $dias = array("Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi");
        } else {
            $dias = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
        }
        return $dias[$day];
    }

    static function Mons($mom)
    {
        $locale = General::$locale;
        if ($locale == 'dk') {
            $meses = array("Januar", "Februar", "Marts", "April", "Maj", "Juni", "Juli", "August", "September", "Oktober", "November", "December");
        } else if ($locale == 'es') {
            $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        } else if ($locale == 'fr') {
            $meses = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
        } else {
            $meses = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        }
        return $meses[$mom];
    }

    static function Clearstream($s)
    {
        $s = str_replace("\ ", '-', $s);
        return $s;
    }


//================SYNC EVENTS==========================//
    static function syncdate()
    {
        $data = Db::table('rebel_penguin_syncdate')->get();
        $result = array();
        $a = 0;
        if (count($data) != 0) {
            for ($i = 0; $i < count($data); $i++) {
                $result[$i]['sport'] = $data[$i]->sport;
                $result[$i]['date'] = $data[$i]->date;
                $result[$i]['goingto'] = $data[$i]->goingto;
            }
            return $result;
        } else {
            $result = false;
            return $result;
        }
    }

    static function syncdateIns($sport, $date, $goto)
    {
        Db::table('rebel_penguin_syncdate')->insert(
            [
                'sport' => $sport,
                'date' => $date,
                'goingto' => $goto
            ]
        );


    }

    static function syncdateDel($sport)
    {
        Db::table('rebel_penguin_syncdate')
            ->where('sport', $sport)
            ->delete();
    }


    static function getdate($date)
    {
        $data = Db::table('rebel_penguin_date')->where('rebel_penguin_date.updatedate', '=', $date)->get();
        return $data;
    }

    static function Update($date)
    {
        Db::table('rebel_penguin_date')->insert(['updatedate' => $date,]);
    }

    static function Updatetoken($event, $midate)
    {
        for ($i = 0; $i < @$event['count']; $i++) {
            $eventList = $event['events'];
            $id = self::Clearfeet($eventList[$i]->id);
            $cantstream =@count($eventList[$i]->streams);
            $b = 0;
            if ($cantstream > 0) {
                for ($k = 0; $k < $cantstream; $k++) {
                    $star = (array)$eventList[$i]->streams;
                    $data_active = Db::table('rebel_penguin_stream_p')
                        ->select('rebel_penguin_stream_p.*')
                        ->where('rebel_penguin_stream_p.id_stp', '=', $star[$k]->id)
                        ->where('rebel_penguin_stream_p.active', '=', 1)
                        ->get();
                    if (@count($data_active) > 0) {
                        $b++;
                    }
                }
            }
            if ($b > 0) {
                $url_date = date("Y-m-d", strtotime($eventList[$i]->start_date));
                $url_free1 = self::Clearfeet($eventList[$i]->home->name);
                $url_free2 = self::Clearfeet($eventList[$i]->away->name);
                $result = $url_free2.'-vs-' . $url_free1.'-'. $url_date;
                @$regiontype = gettype($eventList[$i]->recurring_competition->region->name);
                @$logo = gettype($eventList[$i]->away->logo);
                @$logo_home = gettype($eventList[$i]->home->logo);
                if ($regiontype == 'string') {
                    $region = $eventList[$i]->recurring_competition->region->name;
                    $region_id = $eventList[$i]->recurring_competition->region->id;
                    @$alfa2 = $eventList[$i]->recurring_competition->region->alpha2;
                } else {
                    $region = $eventList[$i]->competition->region->name;
                    $region_id = $eventList[$i]->competition->region->id;
                    @$alfa2 = $eventList[$i]->competition->region->alpha2;
                }
                if ($logo != 'string') {
                    $away_team_logo = "/storage/app/media/General/people.png";
                } else {
                    $away_team_logo = $eventList[$i]->away->logo;
                }
                if ($logo_home != 'string') {
                    $home_team_logo = "/storage/app/media/General/people.png";
                } else {
                    $home_team_logo = $eventList[$i]->home->logo;
                }
                if ($alfa2 == "") {
                    @$alfa2 = "intl";
                }
                $data_active = Db::table('rebel_penguin_token')->select('rebel_penguin_token.*')->where('rebel_penguin_token.id_events', '=', $id)->get();
                if (@count($data_active) > 0) {

                    Db::table('rebel_penguin_token')
                        ->where('rebel_penguin_token.id_events', '=', $id)
                        ->update([
                            'id_events' => $id,
                            'token' => $result,
                            'sportid' => $event['sport']->id,
                            'sport' => $event['sport']->name,
                            'start' => date("Y-m-d", strtotime($eventList[$i]->start_date)),
                            'hour' => $eventList[$i]->start_date,
                            'home_team' => $eventList[$i]->home->name,
                            'away_team' => $eventList[$i]->away->name,
                            'away_team_logo' => $away_team_logo,
                            'home_team_logo' => $home_team_logo,
                            'tournament' => $eventList[$i]->recurring_competition->name,
                            'tournament_id' => $eventList[$i]->recurring_competition->id,
                            'country_alpha2' => $alfa2,
                            'countryid' => $region_id,
                            'country' => $region,
                        ]);
                } else {
                    Db::table('rebel_penguin_token')->insert(
                        [
                            'id_events' => $id,
                            'token' => $result,
                            'sportid' => $event['sport']->id,
                            'sport' => $event['sport']->name,
                            'start' => date("Y-m-d", strtotime($eventList[$i]->start_date)),
                            'hour' => $eventList[$i]->start_date,
                            'home_team' => $eventList[$i]->home->name,
                            'away_team' => $eventList[$i]->away->name,
                            'away_team_logo' => $away_team_logo,
                            'home_team_logo' => $home_team_logo,
                            'tournament' => $eventList[$i]->recurring_competition->name,
                            'tournament_id' => $eventList[$i]->recurring_competition->id,
                            'country_alpha2' => $alfa2,
                            'countryid' => $region_id,
                            'country' => $region,
                        ]
                    );
                }
            }
        }
        if (isset($event['next_request'])) {
            self::syncdateDel($event['sport']->id);
            self::syncdateIns($event['sport']->id, $midate, $event['next_request']);
        } else {
            self::syncdateDel($event['sport']->id);
            self::syncdateIns($event['sport']->id, $midate, 'false');
        }
        return true;
    }

    static function UpdatetokenbyID($id, $idsport)
    {
        //$stream = General::service_fodbold_stramp($id);
        $eventList = General::service_event($id);
        //$cantstream = @count($stream['stream_providers']);
        $sport = self::getSport($idsport);
        /*$b = 0;
        if ($cantstream > 0) {
            for ($k = 0; $k < $cantstream; $k++) {
                $data_active = Db::table('rebel_penguin_stream_p')
                    ->select('rebel_penguin_stream_p.*')
                    ->where('rebel_penguin_stream_p.id_stp', '=', @$stream['stream_providers'][$k]->id)
                    ->where('rebel_penguin_stream_p.active', '=', 1)
                    ->get();
                if (@count($data_active) > 0) {
                    $b++;
                }
            }
        }
        if (1 > 0) {*/
            $url_date = date("Y-m-d", strtotime($eventList["start_date"]));
            $url_free1 = self::Clearfeet($eventList['home']->name);
            $url_free2 = self::Clearfeet($eventList['away']->name);
            $result = $url_free1 . '-vs-' . $url_free2 . '-' . $url_date;

            @$regiontype = gettype($eventList['recurring_competition']->region->name);
            @$logo = gettype($eventList['away']->logo);
            @$logo_home = gettype($eventList['home']->logo);

            if ($regiontype == 'string') {
                $region = $eventList['recurring_competition']->region->name;
                $region_id = $eventList['recurring_competition']->region->id;
                @$alfa2 = $eventList['recurring_competition']->region->alpha2;
            } else {
                $region = $eventList['competition']->region->name;
                $region_id = $eventList['competition']->region->id;
                @$alfa2 = $eventList['competition']->region->alpha2;
            }
            if ($logo != 'string') {
                $away_team_logo = "/storage/app/media/General/people.png";
            } else {
                $away_team_logo = $eventList['away']->logo;
            }
            if ($logo_home != 'string') {
                $home_team_logo = "/storage/app/media/General/people.png";
            } else {
                $home_team_logo = $eventList['home']->logo;
            }
            if ($alfa2 == "") {
                @$alfa2 = "intl";
            }

            Db::table('rebel_penguin_token')->insert([
                    'id_events' => $id,
                    'token' => $result,
                    'sportid' => $idsport,
                    'sport' => $sport[0]['name'],
                    'start' => date("Y-m-d", strtotime($eventList['start_date'])),
                    'hour' => $eventList['start_date'],
                    'home_team' => $eventList['away']->name,
                    'away_team' => $eventList['home']->name,
                    'away_team_logo' => $away_team_logo,
                    'home_team_logo' => $home_team_logo,
                    'tournament' => $eventList['recurring_competition']->name,
                    'tournament_id' => $eventList['recurring_competition']->id,
                    'country_alpha2' => $alfa2,
                    'countryid' => $region_id,
                    'country' => $region,
                ]
            );
        //}
        return true;
    }


    static function ImExit($id)
    {
        $ext = '';
        $data = Db::table('rebel_penguin_token')
            ->where('rebel_penguin_token.id_events', '=', $id)
            ->count();
        if ($data > 0) {
            $ext = 'true';
        } else {
            $ext = 'false';
        }
        return $ext;
    }

    static function getTokend($id)
    {
        $data = Db::table('rebel_penguin_token')
            ->where('rebel_penguin_token.token', '=', $id)
            ->get();
        if (count($data) > 0) {
            return $data[0]->id_events;
        } else return 'error';
    }

    static function getTokendotherID($id)
    {
        $data = Db::table('rebel_penguin_token')
            ->where('rebel_penguin_token.id_events', '=', $id)
            ->get();
        if (count($data) > 0) {
            return $data[0]->id_events;
        } else return 'error';
    }

    static function getEventList($Sport, $date, $Layout)
    {

        $result = array();
        if ($date == null and $Layout == "Table") {
            $day = 0;
            for ($i = 0; $i < 7; $i++) {
                $fecha = date('Y-m-j');
                $nuevafecha = strtotime('+' . $i . ' day', strtotime($fecha));
                $date = date('Y-m-d', $nuevafecha);
                $arreglo = Db::table('rebel_penguin_token')
                    ->where('rebel_penguin_token.start', '=', $date)
                    ->where('rebel_penguin_token.sportid', '=', $Sport)
                    ->orderby('rebel_penguin_token.hour')
                    ->get();
                if (count($arreglo) > 0) {
                    $result[$day] = $arreglo;
                    $day++;
                }
            }
            return $result;
        } else if ($date == null and $Layout == "TableProgram") {
            $day = 0;
            for ($i = 0; $i < 3; $i++) {
                $fecha = date('Y-m-j');
                $nuevafecha = strtotime('+' . $i . ' day', strtotime($fecha));
                $date = date('Y-m-d', $nuevafecha);
                $arreglo = Db::table('rebel_penguin_token')
                    ->where('rebel_penguin_token.start', '=', $date)
                    ->where('rebel_penguin_token.sportid', '=', $Sport)
                    ->orderby('rebel_penguin_token.hour')
                    ->get();
                if (count($arreglo) > 0) {
                    $result[$day] = $arreglo;
                    $day++;
                }
            }
            return $result;
        } else if ($date != null and $Layout == "TableNew") {
            $arreglo = Db::table('rebel_penguin_token')
                ->where('rebel_penguin_token.start', '=', $date)
                ->where('rebel_penguin_token.sportid', '=', $Sport)
                ->orderby('rebel_penguin_token.hour')
                ->get();
            if (count($arreglo) > 0) {
                $result[0] = $arreglo;
                return $result;
            } else {
                $result = 'error';
                return $result;
            }
        } else {
            if ($date == '') {
                $date = date('Y-m-d');
            }
            $arreglo = Db::table('rebel_penguin_token')
                ->where('rebel_penguin_token.start', '=', $date)
                ->where('rebel_penguin_token.sportid', '=', $Sport)
                ->orderby('rebel_penguin_token.hour')
                ->get();
            if (count($arreglo) > 0) {
                $result[0] = $arreglo;
                return $result;
            } else {
                $result[0]['error'] = 'true';
                return $result;
            }

        }

    }


}