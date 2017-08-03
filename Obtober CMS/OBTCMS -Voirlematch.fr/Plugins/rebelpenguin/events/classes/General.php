<?php

/**
 * Created by PhpStorm.
 * User: eddy
 * Date: 04/01/2016
 * Time: 9:14
 */
namespace Rebelpenguin\Events\Classes;
use Rebelpenguin\Events\Classes\template;
class General
{
    public static $locale = 'fr';
    

    static function SyncEvents(){
        $Sport = template::sport_name();
        $syncdate = template::syncdate();
        if($syncdate == false){
            for($a=0;$a<count($Sport);$a++){
                $day=0;
                for($i=0 ; $i < 1; $i++){
                    $fecha = date('Y-m-j');
                    $nuevafecha = strtotime ( '+'.$i.' day' , strtotime ( $fecha ) );
                    $date = date ( 'Y-m-d' , $nuevafecha );
                    $data = template::getdate($date);
                    if(count($data)==0){
                        template::Update($date);
                        $eventList = self::ServiceEventgeneral($Sport[$a]['id_sport'],$date);
                        template::Updatetoken($eventList,$date);
                    }
                    else{
                        $eventList = self::ServiceEventgeneral($Sport[$a]['id_sport'],$date);
                        template::Updatetoken($eventList,$date);
                    }
                }
            }
        }
        else{
            $i=7;
            $fecha = date('Y-m-j');
            $nuevafecha = strtotime ( '+'.$i.' day' , strtotime ( $fecha ) );
            $datetope = date ( 'Y-m-d' , $nuevafecha );
            for($z=0;$z<count($syncdate);$z++){
                if($syncdate[$z]['date'] <= $datetope){
                    if($syncdate[$z]['goingto']!='false' ){
                       $data = template::getdate($syncdate[$z]['date']);
                        if(count($data)==0){
                            template::Update($syncdate[$z]['date']);
                            $eventList = self::ServiceEventgeneralUrl($syncdate[$z]['goingto']);
                            template::Updatetoken($eventList,$syncdate[$z]['date']);
                        }
                        else{
                            $eventList = self::ServiceEventgeneralUrl($syncdate[$z]['goingto']);
                            template::Updatetoken($eventList,$syncdate[$z]['date']);
                        }
                    }
                    else{
                        $i=1;
                        $fecha = $syncdate[$z]['date'];
                        $nuevafecha = strtotime ( '+'.$i.' day' , strtotime ( $fecha ) );
                        $date = date ( 'Y-m-d' , $nuevafecha );
                        $data = template::getdate($date);
                        if(count($data)==0){
                            template::Update($date);
                            $eventList = self::ServiceEventgeneral($syncdate[$z]['sport'],$date);
                            template::Updatetoken($eventList,$date);
                        }
                        else{
                            $eventList = self::ServiceEventgeneral($syncdate[$z]['sport'],$date);
                            template::Updatetoken($eventList,$date);
                        }
                    }
                }
                else{

                            $date = date('Y-m-d');
                            $data = template::getdate($date);

                            if(count($data)==0){
                                template::Update($date);
                                $eventList = self::ServiceEventgeneral($syncdate[$z]['sport'],$date);
                                template::Updatetoken($eventList,$date);
                            }
                            else{
                                $eventList = self::ServiceEventgeneral($syncdate[$z]['sport'],$date);
                                template::Updatetoken($eventList,$date);
                            }


                }
            }
        }
        return true;
    }
    static function sportservice($date,$sport)
    {
        //$weburlserv = "http://eurytus.livegoals.dk/api/v1.1/schedule/".$date."?sport=".$sport."&locale=".self::$locale;
        $weburlserv = "http://eurytus.livegoals.dk/api/v1.1/schedule/".$date."?sport=".$sport."&locale=".self::$locale."&options=streams&rank=999";
        $client = curl_init($weburlserv);
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        $respon = curl_exec($client);
        $arreglo = (array)json_decode($respon);

        if(@$arreglo['error']=='500')
            return 'error';
        else
        return $arreglo;;

    }
    static function service_fodbold()
    {
        /*$weburlserv = "http://eurytus.livegoals.dk/api/v1.1/schedule/";*/
        $sport=template::sport_name();
        $date=date("Y-m-d");
        //$weburlserv = "http://eurytus.livegoals.dk/api/v1.1/schedule/".$date."?sport=".$sport[0]['id_sport']."&locale=".self::$locale;
        $weburlserv = "http://eurytus.livegoals.dk/api/v1.1/schedule/".$date."?sport=".$sport[0]['id_sport']."&locale=".self::$locale."&options=streams&rank=999";
        $client = curl_init($weburlserv);
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        $respon = curl_exec($client);
        $result = (array)json_decode($respon);
        return $result;

    }
    static function service_fodbold_update($date,$sport)
    {
        if($date == null){$date=date("Y-m-d");}
        //$weburlserv = "http://eurytus.livegoals.dk/api/v1.1/schedule/".$date."?sport=".$sport."&locale=".self::$locale;
        $weburlserv = "http://eurytus.livegoals.dk/api/v1.1/schedule/".$date."?sport=".$sport."&locale=".self::$locale."&options=streams&rank=999";
        $client = curl_init($weburlserv);
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        $respon = curl_exec($client);
        $arreglo = (array)json_decode($respon);
        if(@$arreglo['error']=='500')
            return 'error';
        else
            return $arreglo;;

    }
    static function service_fodbold_stramp($id)
    {
        /*$weburlserv = "http://web1.livegoals.dk:9255/api/v1.1/event/".$id."/streams";*/
        $weburlserv = "http://eurytus.livegoals.dk/api/v1.1/event/".$id."/streams";
        $client = curl_init($weburlserv);
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        $respon = curl_exec($client);
        $result = (array)json_decode($respon);
        if(@$result['error']=='500') return 'error';
        else  return $result;

    }
    static function service_fodbold_odds($id)
    {
        //$weburlserv = "http://web1.livegoals.dk:9255/api/v1.1/event/".$id."/odds";
        $weburlserv = "http://eurytus.livegoals.dk/api/v1.1/event/".$id."/odds";
        $client = curl_init($weburlserv);
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        $respon = curl_exec($client);
        $result = (array)json_decode($respon);
        return $result;
    }
    static function service_event($id)
    {
       /* $weburlserv = "http://web1.livegoals.dk:9255/api/v1.1/event/".$id."?locale=".self::$locale;*/

        $weburlserv = "http://eurytus.livegoals.dk/api/v1.1/event/".$id."?locale=".self::$locale;
        $client = curl_init($weburlserv);
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        $respon = curl_exec($client);
        $result = (array)json_decode($respon);
        return $result;
    }
    static function ServiceEvent( $Sport,$date,$Layout)
    {

        $result= array();
        if($date == null and $Layout=="Table"  ){
            $day=0;
            for($i=0 ; $i < 7; $i++){
                $fecha = date('Y-m-j');
                $nuevafecha = strtotime ( '+'.$i.' day' , strtotime ( $fecha ) );
                $date = date ( 'Y-m-d' , $nuevafecha );
                //$weburlserv = "http://eurytus.livegoals.dk/api/v1.1/schedule/".$date."?sport=".$Sport."&locale=".self::$locale;
                $weburlserv = "http://eurytus.livegoals.dk/api/v1.1/schedule/".$date."?sport=".$Sport."&locale=".self::$locale."&options=streams&rank=999";
                $client = curl_init($weburlserv);
                curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
                $respon = curl_exec($client);
                $arreglo = (array)json_decode($respon);
                if(@$arreglo['error']!='500'){
                    $result[$day] = $arreglo;
                    $day ++;
                }
            }
            return $result;
        }
        else if($date == null and $Layout=="TableProgram"){
            $day=0;
            for($i=0 ; $i < 3; $i++){
                $fecha = date('Y-m-j');
                $nuevafecha = strtotime ( '+'.$i.' day' , strtotime ( $fecha ) );
                $date = date ( 'Y-m-d' , $nuevafecha );
                //$weburlserv = "http://eurytus.livegoals.dk/api/v1.1/schedule/".$date."?sport=".$Sport."&locale=".self::$locale;
                $weburlserv = "http://eurytus.livegoals.dk/api/v1.1/schedule/".$date."?sport=".$Sport."&locale=".self::$locale."&options=streams&rank=999";
                $client = curl_init($weburlserv);
                curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
                $respon = curl_exec($client);
                $arreglo = (array)json_decode($respon);
                if(@$arreglo['error']!='500'){
                    $result[$day] = $arreglo;
                    $day ++;
                }
            }
            return $result;
        }
        else if($date != null and $Layout=="TableNew"){

            //$weburlserv = "http://eurytus.livegoals.dk/api/v1.1/schedule/".$date."?sport=".$Sport."&locale=".self::$locale;
            $weburlserv = "http://eurytus.livegoals.dk/api/v1.1/schedule/".$date."?sport=".$Sport."&locale=".self::$locale."&options=streams&rank=999";
            $client = curl_init($weburlserv);
            curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
            $respon = curl_exec($client);
            $arreglo = (array)json_decode($respon);
            if(@$arreglo['error']=='500') return 'error';
            else $result[0] = $arreglo;
            return $result;
			}
		else{
			$date = date ( 'Y-m-d' );
            //$weburlserv = "http://eurytus.livegoals.dk/api/v1.1/schedule/".$date."?sport=".$Sport."&locale=".self::$locale;
            $weburlserv = "http://eurytus.livegoals.dk/api/v1.1/schedule/".$date."?sport=".$Sport."&locale=".self::$locale."&options=streams&rank=999";
            $client = curl_init($weburlserv);
            curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
            $respon = curl_exec($client);
            $arreglo = (array)json_decode($respon);
            if(@$arreglo['error']=='500')return 'error';
            else $result[0] = $arreglo;
            return $result;


        }

    }
    static function Service_STP()
    {
        $weburlserv = "http://eurytus.livegoals.dk/api/v1.1/stream_provider/list";
        $client = curl_init($weburlserv);
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        $respon = curl_exec($client);
        $result = (array)json_decode($respon);
        return $result;

    }
    static function Service_Sport()
    {
        $weburlserv = "http://web1.livegoals.dk:9255/api/v1.1/sport/list";
        $weburlserv = "http://eurytus.livegoals.dk/api/v1.1/sport/list?locale=".self::$locale;
        $client = curl_init($weburlserv);
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        $respon = curl_exec($client);
        $result = (array)json_decode($respon);
        return $result;

    }
    static function Service_Country()
    {
        $weburlserv = "http://eurytus.livegoals.dk/api/v1.1/region/list?locale=".self::$locale;
        //$weburlserv = "http://eurytus.livegoals.dk/api/v1.1/region/list?locale=en&version=1";
        $client = curl_init($weburlserv);
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        $respon = curl_exec($client);
        $arreglo = (array)json_decode($respon);
        if(@$arreglo['error']=='500')
            return 'error';
        else
            return $arreglo;
    }
    static function Service_ligas($region,$sport)
    {
        $weburlserv = "http://eurytus.livegoals.dk/api/v1.1/competition/list?region=".$region."&sport=".$sport;

        $client = curl_init($weburlserv);
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        $respon = curl_exec($client);
        $arreglo = (array)json_decode($respon);

        if(@$arreglo['error']=='500')
            return 'error';
        else
            return $arreglo;;




    }
    static function Service_URL($id){
        $data = template::getTokend($id);
        return $data ;
    }
    static function ServiceEventgeneral($Sport,$date)
    {
        $result= array();
        //$weburlserv = "http://eurytus.livegoals.dk/api/v1.1/schedule/".$date."?sport=".$Sport."&locale=".self::$locale;
        $weburlserv = "http://eurytus.livegoals.dk/api/v1.1/schedule/".$date."?sport=".$Sport."&locale=".self::$locale."&options=streams&rank=999";
        //var_dump($weburlserv);
        $client = curl_init($weburlserv);
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        $respon = curl_exec($client);
        $arreglo = (array)json_decode($respon);
        return $arreglo;
    }
    static function ServiceEventgeneralNext($url)
    {
        $result= array();
        $client = curl_init($url);
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        $respon = curl_exec($client);
        $arreglo = (array)json_decode($respon);
        return $arreglo;
    }
    static function Service_onload()
    {
        $weburlserv = "http://eurytus.livegoals.dk/api/v1.1/stream_provider/list";
        $client = curl_init($weburlserv);
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        $respon = curl_exec($client);
        $result = (array)json_decode($respon);
        return $result;

    }
    static function ServiceEventgeneralUrl($url)
    {
        $result= array();
        $client = curl_init($url);
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        $respon = curl_exec($client);
        $arreglo = (array)json_decode($respon);
        return $arreglo;
    }

    static function ServiceArticules()
    {
        $weburlserv = "http://content.rebelpenguin.dk/getpromotedarticlelist";
        $client = curl_init($weburlserv);
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        $respon = curl_exec($client);
        $result = (array)json_decode($respon);
        return $result;

    }
}