<?php namespace Rebelpenguin\Events\Components;

use Db;
use App;
use Request;
use Cms\Classes\ComponentBase;
use ApplicationException;
use Rebelpenguin\Events\Classes\General;
use Rebelpenguin\Events\Classes\template;

class SportEvents extends ComponentBase
{

    public function onRun()
    {
        $this->addCss('/plugins/rebelpenguin/events/assets/css/animate.min.css');
        $this->addCss('/plugins/rebelpenguin/events/assets/css/styles_.css');
        $this->addJs('/plugins/rebelpenguin/events/assets/js/components/SportEvent.js');
    }
    public function componentDetails()
    {
        return [
            'name' => 'Sport Events',
            'description' => 'Plugin to associate various sporting events .'
        ];
    }
    public function defineProperties()
    {
        return [
            'max' => [
                'description' => 'It refers to the amount of information to show',
                'title' => 'Maximum items',
                'default' => 10,
                'type' => 'string',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'The Max Items value is required and should be integer.',
                'group' => 'Config',
            ],
            'VIM' => [
                'title'             => 'VIM',
                'description'       => 'Very Important March',
                'type'              => 'checkbox',
                'group' => 'Config',
            ],
            'Frompage' => [
                'title'             => 'Frompage',
                'description'       => 'Show in Frontpage Showcase',
                'type'              => 'checkbox',
                'group' => 'Config',
            ],
            'Prioritize' => [
                'title'             => 'Prioritize',
                'description'       => 'Prioritize in Showcase',
                'type'              => 'checkbox',
                'group' => 'Config',
            ],
            'Active' => [
                'title'             => 'Active',
                'description'       => 'Active or inactive article',
                'type'              => 'checkbox',
                'group' => 'Config',
            ],
            'Layout' => [
                'title' => 'Layout',
                'description' => 'Layouts',
                'default' => '',
                'type' => 'dropdown',
                'group' => 'Config',
                'options' => [
                    'New' => 'New',
                    'Clasic' => 'Clasic',
                    'Blog' => 'Blog'
                ],
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
        $contr = array();
        $contr['New']= 'New';
        $contr['Clasic']= 'Clasic';
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
    public function onInitData(){
        $max = $this->property('max');
        $Sport = $this->property('Sport');
        $Layout = $this->property('Layout');
        $VIM = $this->property('VIM');
        $Frompage = $this->property('Frompage');
        $Prioritize = $this->property('Prioritize');
        $active = $this->property('Active');
		$head = $this->property('Head');
		$SubHead = $this->property('SubHead');
        if($VIM == null){$VIM =0;}
        if($Frompage == null){$Frompage =0;}
        if($Prioritize == null){$Prioritize =0;}
        if($active == null){$active =0;}
		$date = date('Y-m-d');
		$color=template::getSport($Sport);
		if($Layout=='New' or $Layout=='Clasic'){
        if($VIM==0 & $Frompage==0 & $Prioritize==0){
			$data = Db::table('rebel_penguin_article')
				->where('id_sport', $Sport)
				->where('date', '>=' ,$date)
				->orderBy('vip_article', 'desc')
				->orderBy('date_h', 'desc')
				->get();
			
			}
        if($VIM==1 & $Frompage==1 & $Prioritize==1){	
			$data = Db::table('rebel_penguin_article')
				->where('id_sport', $Sport)
				->where('show_front', $Frompage)
				->where('vip_article', $VIM)
				->where('permanet_front', $Prioritize)
				->where('active', $active)	
				->where('date', '>=' ,$date)				
				->orderBy('vip_article', 'desc')
				->orderBy('date_h', 'desc')
				->get();
			}
        if($VIM==1 & $Frompage==0 & $Prioritize==0){
			$data = Db::table('rebel_penguin_article')
				->where('id_sport', $Sport)
				->where('vip_article', $VIM)				 
				->where('active', $active)
				->where('date', '>=' ,$date)				
				->orderBy('vip_article', 'desc')
				->orderBy('date_h', 'desc')
				->get();
			}
        if($VIM==0 & $Frompage==1 & $Prioritize==0){			
			$data = Db::table('rebel_penguin_article')
				->where('id_sport', $Sport)
				->where('show_front', $Frompage)				
				->where('active', $active)->where('date', '>=' ,$date)				
				->orderBy('vip_article', 'desc')
				->orderBy('date_h', 'desc')
				->get();
			}
        if($VIM==0 & $Frompage==0 & $Prioritize==1){
			$data = Db::table('rebel_penguin_article')
				->where('id_sport', $Sport)				
				->where('permanet_front', $Prioritize)
				->where('active', $active)	->where('date', '>=' ,$date)			
				->orderBy('vip_article', 'desc')
				->orderBy('date_h', 'desc')
				->get();
		}
        if($VIM==1 & $Frompage==1 & $Prioritize==0){			
			$data = Db::table('rebel_penguin_article')
				->where('id_sport', $Sport)
				->where('show_front', $Frompage)
				->where('vip_article', $VIM)				
				->where('active', $active)->where('date', '>=' ,$date)				
				->orderBy('vip_article', 'desc')
				->orderBy('date_h', 'desc')
				->get();
			}
        if($VIM==0 & $Frompage==1 & $Prioritize==1){
			$data = Db::table('rebel_penguin_article')
				->where('id_sport', $Sport)
				->where('show_front', $Frompage)				
				->where('permanet_front', $Prioritize)
				->where('active', $active)->where('date', '>=' ,$date)				
				->orderBy('vip_article', 'desc')
				->orderBy('date_h', 'desc')
				->get();
		}
        if($VIM==1 & $Frompage==0 & $Prioritize==1){			
			$data = Db::table('rebel_penguin_article')
				->where('id_sport', $Sport)				
				->where('vip_article', $VIM)
				->where('permanet_front', $Prioritize)
				->where('active', $active)->where('date', '>=' ,$date)				
				->orderBy('vip_article', 'desc')
				->orderBy('date_h', 'desc')
				->get();
		
		}
		}
		else {
			$data = Db::table('rebel_penguin_article')
				->where('id_sport', $Sport)
				->orderBy('date_h', 'desc')
				->get();
		}

		$conf = array();

		$Link = $this->property('Link');
        $conf[0]['Link']=  $Link;

        $conf[0]['Layout']=  $Layout;
		$conf[0]['color']=$color[0]['color'];
        $conf[0]['max']=  $max;
		if($max==0){$conf[0]['tabs']= 1;}
		else {$conf[0]['tabs'] = count($data) / $max;}
		$Sport_ = template::getSport($Sport);
        $conf[0]['sport']= $Sport_[0]['name'];
		$conf[0]['head']=  $head;
		$conf[0]['SubHead']=  $SubHead;
        $result = array();

        if(count($data)>0){
            if($max==0){$max=count($data);}
            if($max>count($data)){$max=count($data);}
            for($a=0; $a < $max ;$a++){
                $result[$a]['id'] = $data[$a]->id;
                $result[$a]['id_evento'] = $data[$a]->id_evento;
                $result[$a]['artic_name'] = $data[$a]->artic_name;
                $result[$a]['date'] = date("d.m.Y",strtotime($data[$a]->date));
                $result[$a]['date_h'] = date("H:i",strtotime($data[$a]->date_h));
                $result[$a]['match_'] = $data[$a]->match_;
                $result[$a]['country'] = $data[$a]->country;
                $result[$a]['liga'] = $data[$a]->liga;
                $result[$a]['caption'] = html_entity_decode($data[$a]->caption);
                $result[$a]['autor'] = $data[$a]->autor;
                $result[$a]['artic_name'] = $data[$a]->artic_name;
                $result[$a]['article_body'] = html_entity_decode($data[$a]->article_body);
                $result[$a]['show_front'] = $data[$a]->show_front;
                $result[$a]['permanet_front'] = $data[$a]->permanet_front;
                $result[$a]['date_create'] = $data[$a]->date_create;
                $result[$a]['date_update'] = $data[$a]->date_update;
                $result[$a]['away_team'] = html_entity_decode($data[$a]->away_team);
                $result[$a]['home_team'] = html_entity_decode($data[$a]->home_team);
                $result[$a]['vip_article'] = $data[$a]->vip_article;
                @$logo = gettype($data[$a]->away_team_logo);
                @$logo_home = gettype($data[$a]->home_team_logo);
                if($logo !='string')
                {
                    $result[$a]['away_team_logo']= "storage/app/media/General/people.png";
                }
                else{
                    $result[$a]['away_team_logo'] = $data[$a]->away_team_logo;
                }
                if($logo_home !='string')
                {
                    $result[$a]['home_team_logo']= "storage/app/media/General/people.png";
                }
                else{
                    $result[$a]['home_team_logo'] = $data[$a]->home_team_logo;
                }
				$url_date = template::Clearspace_end(date("Y-m-d",strtotime($data[$a]->date)));
				$url_free1=template::Clearfeet(html_entity_decode($data[$a]->home_team));
				$url_free2=template::Clearfeet(html_entity_decode($data[$a]->away_team));
				$result[$a]['url_free'] =$url_free2.'-vs-'.$url_free1.'-'.$url_date;

            }
			if($Layout=='Blog'){
				$a=0;
				$i=0;
				$z=0;
				$arrayblog=array();
				$arrayblogDel= $result;
				while(!empty($arrayblogDel)){
					if($a==0){
						$result[$a]['page']=$z;
						$result[$a]['inicio']='true';
						array_shift ($arrayblogDel);
						$i++;
					}
					else if($a!=0 && $a%4 != 0){
						$result[$a]['page']=$z;
						$result[$a]['inicio']='false';
						array_shift ($arrayblogDel);
						$i++;
					}
					else{
						$z++;
						$result[$a]['page']=$z;
						$result[$a]['inicio']='true';
						array_shift ($arrayblogDel);
					}
					$a++;
				}
				$this->page['events'] =  $result;
				$arrayblog=array_pop($result);
				$conf[0]['bloc']=  $arrayblog['page'];
				$this->page['confs'] =  $conf;

			}
			else{
				$conf[0]['items']=  count($result);
				$this->page['confs'] =  $conf;
				$this->page['events'] =  $result;
			}
        }
        else{
			$cant=0;
			$result=array();
			$data = Db::table('rebel_penguin_token')
				->where('rebel_penguin_token.sportid', $Sport)
				->where('rebel_penguin_token.start', $date)
				->orderBy('rebel_penguin_token.hour', 'asc')
				->get();
			$maxima = $this->property('max');
			$total=0;
			for($a=0; $a < count($data) ;$a++){
				$whitelist = template::whitelistface($data[$a]->id_events,$data[$a]->tournament_id);
				if($whitelist=='true' && $total<$maxima) {
					$total++;
					$result[$a]['id'] = $data[$a]->id;
					$result[$a]['id_evento'] = $data[$a]->id_events;
					$result[$a]['artic_name'] = $data[$a]->token;
					$result[$a]['date'] = date("d.m.Y", strtotime($data[$a]->hour));
					$result[$a]['date_h'] = date("H:i", strtotime($data[$a]->hour));
					$result[$a]['match_'] = $data[$a]->token;
					$result[$a]['country'] = $data[$a]->country;
					$result[$a]['liga'] = $data[$a]->tournament;
					$result[$a]['caption'] = '';

					$result[$a]['autor'] = '';
					$result[$a]['artic_name'] = '';
					$result[$a]['article_body'] = '';

					$result[$a]['show_front'] = 1;
					$result[$a]['permanet_front'] = 1;
					$result[$a]['date_create'] = $data[$a]->hour;
					$result[$a]['date_update'] = $data[$a]->hour;

					$result[$a]['away_team'] = html_entity_decode($data[$a]->away_team);
					$result[$a]['home_team'] = html_entity_decode($data[$a]->home_team);
					$result[$a]['vip_article'] = 1;
					@$logo = gettype($data[$a]->away_team_logo);
					@$logo_home = gettype($data[$a]->home_team_logo);
					if ($logo != 'string') {
						$result[$a]['away_team_logo'] = "storage/app/media/General/people.png";
					} else {
						$result[$a]['away_team_logo'] = $data[$a]->away_team_logo;
					}
					if ($logo_home != 'string') {
						$result[$a]['home_team_logo'] = "storage/app/media/General/people.png";
					} else {
						$result[$a]['home_team_logo'] = $data[$a]->home_team_logo;
					}
					$result[$a]['url_free'] = $data[$a]->token;
				}
			}

			if($Layout=='Blog') {
				$a = 0;
				$i = 0;
				$z = 0;
				$arrayblog = array();
				$arrayblogDel = $result;
				while (!empty($arrayblogDel)) {
					if ($a == 0) {
						$result[$a]['page'] = $z;
						$result[$a]['inicio'] = 'true';
						array_shift($arrayblogDel);
						$i++;
					} else if ($a != 0 && $a % 4 != 0) {
						$result[$a]['page'] = $z;
						$result[$a]['inicio'] = 'false';
						array_shift($arrayblogDel);
						$i++;
					} else {
						$z++;
						$result[$a]['page'] = $z;
						$result[$a]['inicio'] = 'true';
						array_shift($arrayblogDel);
					}
					$a++;
				}
				$this->page['events'] = $result;
				$arrayblog = array_pop($result);
				$conf[0]['bloc'] = $arrayblog['page'];
				$this->page['confs'] = $conf;
			}
			else {
				$conf[0]['items'] = count($result);
				$this->page['confs'] = $conf;
				$this->page['events'] = $result;
			}



        }
    }
}