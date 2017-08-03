<?php namespace Rebelpenguin\Events\Components;

use Db;
use App;
use Request;
use Cms\Classes\ComponentBase;
use ApplicationException;
use Rebelpenguin\Events\Classes\General;
use Rebelpenguin\Events\Classes\template;

class StreamUdbyder extends ComponentBase
{

    public function onRun()
    {
        $this->addCss('/plugins/rebelpenguin/events/assets/css/animate.min.css');
        $this->addCss('/plugins/rebelpenguin/events/assets/css/styles_.css');
        $this->addJs('/plugins/rebelpenguin/events/assets/js/components/StreamUdbyder.js');
    }
    public function componentDetails()
    {
        return [
            'name' => 'Stream Udbyder',
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
                'default' => '',
                'type' => 'dropdown',
                'group' => 'Config',
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
        $contr['TABLE']= 'TABLE';
        $contr['TABLELEFT']= 'TABLELEFT';
        $contr['LIVEEVENTS']= 'LIVEEVENTS';
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
        $SubHead = $this->property('SubHead');
        $Sport_name = template::getSport($Sport);

        $conf[0]['name_sport']=  $Sport_name[0]['name'];
        $conf[0]['max']=  $max;
        $conf[0]['Layout']=  $Layout;
        $conf[0]['head']= $head;
        $conf[0]['SubHead']= $SubHead;
        $this->page['conf'] = $conf;
        $Link = $this->property('Link');
        $conf[0]['Link']=  $Link;

        $data = Db::table('streampersport')
            ->join('rebel_penguin_stream_p', 'rebel_penguin_stream_p.id_stp', '=', 'streampersport.id_stp')
            ->where('rebel_penguin_stream_p.active', '=', 1)
            ->where('streampersport.id_sport','=',$Sport)
            ->orderby('streampersport.gnr_sort')
            ->get();
        for($i=0; $i<count($data); $i++){
            $stream[$i]['name_sport']=$data[$i]->name;
            $stream[$i]['color']=$data[$i]->color;
            $stream[$i]['id_sport']=$data[$i]->id_sport;
            $stream[$i]['id_stream']=$data[$i]->id_stp;

            $stream[$i]['gnr_label']=$data[$i]->gnr_label;
            $stream[$i]['gnr_rating']=$data[$i]->gnr_rating;
            $stream[$i]['gpm_button_rew']=html_entity_decode($data[$i]->gpm_button_rew);
            $stream[$i]['gpm_icon_H_one']=html_entity_decode($data[$i]->gpm_icon_H_one);

            $stream[$i]['gnr_afflink']=$data[$i]->gnr_false_aff;
            $stream[$i]['gpm_afflink']=$data[$i]->gpm_false_button_aff;
            $stream[$i]['gpd_afflink']=$data[$i]->gpd_false_button_aff;
            $stream[$i]['gpp_afflink']=$data[$i]->gpp_false_button_aff;

            $stream[$i]['gnr_quality']=$data[$i]->gnr_quality;
            $stream[$i]['gnr_sort']=$data[$i]->gnr_sort;
            $stream[$i]['gnr_size']=$data[$i]->gnr_size;
            $stream[$i]['gnr_price']=$data[$i]->gnr_price;

            $stream[$i]['gpd_head']= html_entity_decode($data[$i]->gpd_head);
            $stream[$i]['gpm_active']= html_entity_decode($data[$i]->gpm_active);
            $stream[$i]['gpp_udv_head']= html_entity_decode($data[$i]->gpp_udv_head);
            $stream[$i]['gpp_udv_content']= html_entity_decode($data[$i]->gpp_udv_content);
            $stream[$i]['gpp_quality_head']= html_entity_decode($data[$i]->gpp_quality_head);
            $stream[$i]['gpp_quality_content']= html_entity_decode($data[$i]->gpp_quality_content);
            $stream[$i]['gpp_price_head']= html_entity_decode($data[$i]->	gpp_price_head);
            $stream[$i]['gpp_price_content']= html_entity_decode($data[$i]->gpp_price_content);

            $stream[$i]['gpp_icon_H_one']= html_entity_decode($data[$i]->gpp_icon_H_one);
            $stream[$i]['gpp_icon_S_one']= html_entity_decode($data[$i]->gpp_icon_S_one);
            $stream[$i]['gpp_icon_H_two']= html_entity_decode($data[$i]->gpp_icon_H_two);
            $stream[$i]['gpp_icon_S_two']= html_entity_decode($data[$i]->gpp_icon_S_two);
            $stream[$i]['gpp_icon_H_three']= html_entity_decode($data[$i]->gpp_icon_H_three);
            $stream[$i]['gpp_icon_S_three']= html_entity_decode($data[$i]->gpp_icon_S_three);
            $stream[$i]['gpp_icon_note']= html_entity_decode($data[$i]->gpp_icon_note);
            $stream[$i]['gpp_button_disclaimer']= html_entity_decode($data[$i]->gpp_button_disclaimer);

            $stream[$i]['gpd_points_head_']= html_entity_decode($data[$i]->gpd_points_head_);
            $stream[$i]['gpd_points_pointOne_']= html_entity_decode($data[$i]->gpd_points_pointOne_);
            $stream[$i]['gpd_points_pointTwo_']= html_entity_decode($data[$i]->gpd_points_pointTwo_);
            $stream[$i]['gpd_points_pointTree_']= html_entity_decode($data[$i]->gpd_points_pointTree_);


        }
        //var_dump($stream);
        $this->page['streams']= $stream;

    }

}