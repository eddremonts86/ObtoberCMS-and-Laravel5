<?php namespace Rebelpenguin\Events\Components;

use Db;
use App;
use Rebelpenguin\Events\Classes\template;
use Request;
use Cms\Classes\ComponentBase;
use ApplicationException;
use Rebelpenguin\Events\Classes\General;

class StreamProviders extends ComponentBase
{

    public function onRun()
    {
        $this->addCss('/plugins/rebelpenguin/events/assets/css/animate.min.css');
        $this->addCss('/plugins/rebelpenguin/events/assets/css/styles_.css');
        $this-> addJs('/plugins/rebelpenguin/events/assets/js/components/streamprovider.js');

    }
    public function componentDetails()
    {
        return [
            'name' => 'Stream Providers List',
            'description' => 'Stream Providers List - Provider Pages'
        ];
    }
    public function defineProperties()
    {
        return [
            'StreamProviders' => [
                'title' => 'Stream Providers',
                'description' => ' ',
                'default' => '',
                'type' => 'dropdown',
                'options' => [
                    'Live' => 'Live Stream',
                    'Reviews' => 'Provider Reviews'
                ]
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
            'SubHead1' => [
                'title'             => 'SubHead1',
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
    public function onStreamProvide()
    {
        $result = array();

        $data = Db::table('rebel_penguin_stream_data')
            ->join('rebel_penguin_stream_p', 'rebel_penguin_stream_data.id_stp', '=', 'rebel_penguin_stream_p.id_stp')
            ->select('rebel_penguin_stream_data.*', 'rebel_penguin_stream_p.name')
            ->where('rebel_penguin_stream_p.active', '=', 1)
            ->orderBy('rebel_penguin_stream_data.gnr_sort', 'asc')
            ->get();
        for ($a = 0; $a < count($data); $a++) {
            $result[$a]['id'] = $data[$a]->id_stp;
            $result[$a]['gnr_label'] = $data[$a]->name;
            $result[$a]['gnr_affi'] = $data[$a]->gnr_false;
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

            $data_result=explode('.',$result[$a]['gnr_rating']);
            if(@$data_result[1]=='5'){$result[$a]['gnr_rating_half'] = 1;}


            $result[$a]['meta_title'] = $data[$a]->meta_title;
            $result[$a]['meta_desc'] = $data[$a]->meta_desc;
            $result[$a]['meta_keywords'] = $data[$a]->meta_keywords;

            $result[$a]['cont_pros'] =  htmlspecialchars_decode($data[$a]->cont_pros);
            $result[$a]['cont_introduction'] = htmlspecialchars_decode($data[$a]->cont_introduction);
            $result[$a]['cont_bonus'] = $data[$a]->cont_bonus;
            $result[$a]['cont_topbutton'] = $data[$a]->cont_topbutton;
            $result[$a]['cont_botbutton'] = $data[$a]->cont_botbutton;
            $result[$a]['cont_affiliate'] = $data[$a]->cont_false_affiliate;
            $result[$a]['cont_active'] = $data[$a]->cont_active;

            $result[$a]['udv_heading'] = $data[$a]->udv_heading;
            $result[$a]['udv_ratin'] = $data[$a]->udv_ratin;
            @$data_result=explode('.',$result[$a]['udv_ratin']);
            if(@$data_result[1]=='5'){$result[$a]['udv_ratin_half'] = 1;}
            $result[$a]['udv_content'] = html_entity_decode($data[$a]->udv_content);

            $result[$a]['prod_heading'] = $data[$a]->prod_heading;
            $result[$a]['prod_ratin'] = $data[$a]->prod_ratin;
            @$data_result=explode('.',$result[$a]['prod_ratin']);
            if(@$data_result[1]=='5'){$result[$a]['prod_ratin_half'] = 1;}
            $result[$a]['prod_content'] = html_entity_decode($data[$a]->prod_content);

            $result[$a]['lives_heading'] = $data[$a]->lives_heading;
            $result[$a]['lives_ratin'] = $data[$a]->lives_ratin;
            @$data_result=explode('.',$result[$a]['lives_ratin']);
            if(@$data_result[1]=='5'){$result[$a]['lives_ratin_half'] = 1;}
            $result[$a]['lives_content'] = html_entity_decode($data[$a]->lives_content);

            $result[$a]['odds_heading'] = $data[$a]->odds_heading;
            $result[$a]['odds_ratin'] = $data[$a]->odds_ratin;
            @$data_result=explode('.',$result[$a]['odds_ratin']);
            if(@$data_result[1]=='5'){$result[$a]['odds_ratin_half'] = 1;}
            $result[$a]['odds_content'] = html_entity_decode($data[$a]->odds_content);

            $result[$a]['supp_heading'] = $data[$a]->supp_heading;
            $result[$a]['supp_ratin'] = $data[$a]->supp_ratin;
            @$data_result=explode('.',$result[$a]['supp_ratin']);
            if(@$data_result[1]=='5'){$result[$a]['supp_ratin_half'] = 1;}
            $result[$a]['supp_content'] = html_entity_decode($data[$a]->supp_content);

            $result[$a]['bonusser_heading'] = $data[$a]->bonusser_heading;
            $result[$a]['bonusser_ratin'] = $data[$a]->bonusser_ratin;
            @$data_result=explode('.',$result[$a]['bonusser_ratin']);
            if(@$data_result[1]=='5'){$result[$a]['bonusser_ratin_half'] = 1;}
            $result[$a]['bonusser_content'] = html_entity_decode($data[$a]->bonusser_content);

            $result[$a]['bruger_heading'] = $data[$a]->bruger_heading;
            $result[$a]['bruger_ratin'] = $data[$a]->bruger_ratin;
            @$data_result=explode('.',$result[$a]['bruger_ratin']);
            if(@$data_result[1]=='5'){$result[$a]['bruger_ratin_half'] = 1;}
            $result[$a]['bruger_content'] = html_entity_decode($data[$a]->bruger_content);

            $result[$a]['ind_og_heading'] = $data[$a]->ind_og_heading;
            $result[$a]['ind_og_ratin'] = $data[$a]->ind_og_ratin;
            @$data_result=explode('.',$result[$a]['ind_og_ratin']);
            if(@$data_result[1]=='5'){$result[$a]['ind_og_ratin_half'] = 1;}
            $result[$a]['ind_og_content'] = html_entity_decode($data[$a]->ind_og_content);

            $result[$a]['vores_heading'] = $data[$a]->vores_heading;
            $result[$a]['vores_ratin'] = $data[$a]->vores_ratin;
            @$data_result=explode('.',$result[$a]['vores_ratin']);
            if(@$data_result[1]=='5'){$result[$a]['vores_ratin_half'] = 1;}
            $result[$a]['vores_content'] = html_entity_decode($data[$a]->vores_content);

            $result[$a]['bruger_heading'] = $data[$a]->bruger_heading;
            $result[$a]['bruger_ratin'] = $data[$a]->bruger_ratin;
            @$data_result=explode('.',$result[$a]['bruger_ratin']);
            if(@$data_result[1]=='5'){$result[$a]['bruger_ratin_half'] = 1;}
            $result[$a]['bruger_content'] = html_entity_decode($data[$a]->bruger_content);


            $result[$a]['liveb_heading'] = $data[$a]->liveb_heading;
            $result[$a]['liveb_ratin'] = $data[$a]->liveb_ratin;
            @$data_result=explode('.',$result[$a]['liveb_ratin']);
            if(@$data_result[1]=='5'){$result[$a]['liveb_ratin_half'] = 1;}
            $result[$a]['liveb_content'] = html_entity_decode($data[$a]->liveb_content);


            $result[$a]['indsat_heading'] = $data[$a]->indsat_heading;
            $result[$a]['indsat_ratin'] = $data[$a]->indsat_ratin;
            @$data_result=explode('.',$result[$a]['indsat_ratin']);
            if(@$data_result[1]=='5'){$result[$a]['indsat_ratin_half'] = 1;}
            $result[$a]['indsat_content'] = html_entity_decode($data[$a]->indsat_content);

            $result[$a]['konk_heading'] = $data[$a]->konk_heading;
            $result[$a]['konk_ratin'] = $data[$a]->konk_ratin;
            @$data_result=explode('.',$result[$a]['konk_ratin']);
            if(@$data_result[1]=='5'){$result[$a]['konk_ratin_half'] = 1;}
            $result[$a]['konk_content'] = html_entity_decode($data[$a]->konk_content);

        }
        $idst='xcdgffgfdg dfg dfg';
        $general = @$this->param('general');
        if(isset($general)) {
            $taken = explode(':', $general);
            $general = $taken[1];
            $idstream = template::getStreambyname($general);

            if($idstream == 0){$idst  = $result[0]['id'] ;}
            else {$idst = $idstream[0]['id_stp'];}
            
        }



        $this->page['STP'] = $result;
        $type= $this->property('StreamProviders');
        $head = $this->property('Head');
        $SubHead = $this->property('SubHead');
        $SubHead1 = $this->property('SubHead1');
        $Link = $this->property('Link');

        $conf[0]['idstream']= $idst;
        $conf[0]['type']=  $type;
        $conf[0]['head']=  $head;
        $conf[0]['SubHead']=  $SubHead;
        $conf[0]['SubHead1']=  $SubHead1;
        $conf[0]['Link']=  $Link;
        $this->page['conf'] = $conf;
    }
}