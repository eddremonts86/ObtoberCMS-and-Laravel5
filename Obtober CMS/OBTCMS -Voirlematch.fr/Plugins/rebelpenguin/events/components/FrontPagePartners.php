<?php namespace Rebelpenguin\Events\Components;
use Cms\Classes\ComponentBase;
use Db;
use App;
use Request;
use ApplicationException;
use Rebelpenguin\Events\Classes\General;

class FrontPagePartners extends ComponentBase
{

    public function onRun()
    {
        $this->addCss('/plugins/rebelpenguin/events/assets/css/animate.min.css');
        $this->addCss('/plugins/rebelpenguin/events/assets/css/styles_.css');
        $this->addJs('/plugins/rebelpenguin/events/assets/js/components/HomeVores.js');

    }

    public function componentDetails()
    {
        return [
            'name' => 'Front Page Partners',
            'description' => 'Plugin to associate Vores samarbejdspartnere.'
        ];
    }

    public function defineProperties()
    {
        return [
            'Name' => [
                'description' => 'Escriba el nombre del componente',
                'title' => 'Name of a component',
                'default' => 'Vores samarbejdspartnere',
                'type' => 'string',
                'group' => 'Text-Config',
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
    public function onHomev(){
        $result_name = array();
        $result = array();
        $conf = array();
        //$data = Db::select('select * from rebel_penguin_stream_page_details where active = ?', [1]);
        $data = Db::table('rebel_penguin_stream_data')
            ->join('rebel_penguin_stream_p', 'rebel_penguin_stream_data.id_stp', '=', 'rebel_penguin_stream_p.id_stp')
            ->select('rebel_penguin_stream_data.*')
            ->where('rebel_penguin_stream_p.active', '=', 1)
            ->orderBy('rebel_penguin_stream_data.gnr_sort', 'asc')
            ->get();

        for ($a = 0; $a < count($data); $a++) {
            $result[$a]['id'] = $data[$a]->id;
            $result[$a]['id_stp'] = $data[$a]->id_stp;
            $result[$a]['name'] = $data[$a]->gnr_label;
        }
        $result_name= $this->property('Name');
        $Link = $this->property('Link');
        $conf[0]['Link']=  $Link;
        $conf[0]['stream']=  $result_name;

        $this->page['conf'] = $conf;
        $this->page['streams']= $result;

    }
}