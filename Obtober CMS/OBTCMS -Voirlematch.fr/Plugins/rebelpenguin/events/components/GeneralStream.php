<?php namespace Rebelpenguin\Events\Components;

use Db;
use App;
use Request;
use Cms\Classes\ComponentBase;
use ApplicationException;
use Rebelpenguin\Events\Classes\General;

class GeneralStream extends ComponentBase
{
    public function onRun()
    {
        $this->addCss('/plugins/rebelpenguin/events/assets/css/animate.min.css');
        $this->addCss('/plugins/rebelpenguin/events/assets/css/styles_.css');
        $this->addJs('/plugins/rebelpenguin/events/assets/js/components/GeneralStream.js');
    }
    public function componentDetails()
    {
        return [
            'name' => 'General Stream',
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
            ],
            'Sport' => [
                'title' => 'Sport',
                'description' => 'Specifies whether the embedded Tweet should be left aligned, right aligned, or centered in the page.',
                'default' => 'Fodbold',
                'type' => 'dropdown',
                'group' => 'Filters',
            ],
            'Head' => [
                'title'             => 'Head',
                'description'       => 'Head of plugin',
                'type'              => 'string',
                'placeholder'       => 'Program – populære kampe',
                'group'             => 'Text-Config',
            ],'Link' => [
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
    public function onStreamData()
    {
        $stream = [];
        /* ---------- Plugin Conf ---------- */
        $cant = $max = $this->property('max');
        $Layout = $this->property('Layout');
        $Sport = $this->property('Sport');
        $head = $this->property('Head');
        $conf[0]['max']=  $max;
        $conf[0]['Layout']=  $Layout;
        $conf[0]['head']=  $head;
        $Link = $this->property('Link');
        $conf[0]['Link']=  $Link;
        $this->page['conf'] = $conf;
        /* ---------- end ---------- */

        /* ---------- SPORT DATA ---------- */
        $data = Db::select('select * from rebel_penguin_stream_general where id_sport = ? ', [$Sport]);

        $data = Db::table('rebel_penguin_stream_general')
            ->join('rebel_penguin_stream_general_manager', 'rebel_penguin_stream_general_manager.id_stream', '=', 'rebel_penguin_stream_general.id_stream')
            ->join('rebel_penguin_sports', 'rebel_penguin_sports.id_sport', '=', 'rebel_penguin_stream_general.id_sport')
            ->join('rebel_penguin_stream_p', 'rebel_penguin_stream_p.id_stp', '=', 'rebel_penguin_stream_general.id_stream')
            ->select('rebel_penguin_stream_general_manager.*', 'rebel_penguin_stream_general.*','rebel_penguin_sports.*')
            ->where('rebel_penguin_stream_general.id_sport','=',$Sport)
            ->where('rebel_penguin_stream_p.active','=',1)
            ->where('rebel_penguin_stream_general_manager.id_sport','=',$Sport)
            ->orderby('rebel_penguin_stream_general.gnr_sort')
            ->get();

        for($i=0; $i<count($data); $i++){
            $stream[$i]['id']=$data[$i]->id;
            $stream[$i]['name_sport']=$data[$i]->name;
            $stream[$i]['color']=$data[$i]->color;
            $stream[$i]['id_sport']=$data[$i]->id;
            $stream[$i]['id_stream']=$data[$i]->id_stream;
            $stream[$i]['gnr_label']=$data[$i]->gnr_label;
            $stream[$i]['gnr_rating']=$data[$i]->gnr_rating;
            $stream[$i]['gnr_afflink']=$data[$i]->gnr_false_aff;
            $stream[$i]['gnr_quality']=$data[$i]->gnr_quality;
            $stream[$i]['gnr_sort']=$data[$i]->gnr_sort;
            $stream[$i]['gnr_size']=$data[$i]->gnr_size;
            $stream[$i]['gnr_price']=$data[$i]->gnr_price;
            $stream[$i]['gpm_head']= html_entity_decode($data[$i]->gpm_head);
            $stream[$i]['gpm_active']= html_entity_decode($data[$i]->gpm_active);
            $stream[$i]['gpm_quality_head']= html_entity_decode($data[$i]->gpm_quality_head);
            $stream[$i]['gpm_quality_content']= html_entity_decode($data[$i]->gpm_quality_content);
            $stream[$i]['gpm_udv_head']= html_entity_decode($data[$i]->gpm_udv_head);
            $stream[$i]['gpm_udv_content']= html_entity_decode($data[$i]->gpm_udv_content);
            $stream[$i]['gpm_price_head']= html_entity_decode($data[$i]->gpm_price_head);
            $stream[$i]['gpm_price_content']= html_entity_decode($data[$i]->gpm_price_content);
            $stream[$i]['gpm_icon_H_one']= html_entity_decode($data[$i]->gpm_icon_H_one);
            $stream[$i]['gpm_icon_S_one']= html_entity_decode($data[$i]->gpm_icon_S_one);
            $stream[$i]['gpm_icon_H_two']= html_entity_decode($data[$i]->gpm_icon_H_two);
            $stream[$i]['gpm_icon_S_two']= html_entity_decode($data[$i]->gpm_icon_S_two);
            $stream[$i]['gpm_icon_H_three']= html_entity_decode($data[$i]->gpm_icon_H_three);
            $stream[$i]['gpm_icon_S_three']= html_entity_decode($data[$i]->gpm_icon_S_three);
            $stream[$i]['gpm_icon_N_three']= html_entity_decode($data[$i]->gpm_icon_N_three);
            $stream[$i]['gpm_button_rew']= html_entity_decode($data[$i]->gpm_button_rew);
            $stream[$i]['gpm_button_wlive']= html_entity_decode($data[$i]->gpm_button_wlive);
            $stream[$i]['gpm_button_aff']= html_entity_decode($data[$i]->gpm_false_button_aff);

        }
        $this->page['streams']= $stream;
    }

}