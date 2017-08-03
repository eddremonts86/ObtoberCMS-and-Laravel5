<?php namespace Rebelpenguin\Events\Components;

use Cms\Classes\ComponentBase;
use Rebelpenguin\Events\Classes\General;
use Rebelpenguin\Events\Classes\template;

class ArticleAPI extends ComponentBase
{


    public function onRun()
    {
        $this->addCss('/plugins/rebelpenguin/events/assets/css/animate.min.css');
        $this->addCss('/plugins/rebelpenguin/events/assets/css/styles_.css');
        $this->addJs('/plugins/rebelpenguin/events/assets/js/components/Articleapi.js');

    }

    public function componentDetails()
    {
        return [
            'name'        => 'ArticleAPI Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }


    public function onArticles(){
        $articles = General::ServiceArticules();
        $result=array();
        for($i=0;$i<count($articles);$i++ ){
            $result[$i]['id']=$articles[$i]->id;
            $result[$i]['idtags']=$articles[$i]->idtags;
            $result[$i]['tags']=$articles[$i]->tags;
            $result[$i]['path']=$articles[$i]->path;
            $result[$i]['promote']=$articles[$i]->promote;
            $result[$i]['uid']=$articles[$i]->uid;
            $result[$i]['created']=$articles[$i]->created;
            $result[$i]['field_image']=$articles[$i]->field_image;
            $result[$i]['title']=$articles[$i]->title;
            $result[$i]['body']=$articles[$i]->body;
        }
        $this->page['result'] = $result;
    }

}