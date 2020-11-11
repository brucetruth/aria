<?php
/*
 * Copyright (c) 2020.  Bruce Mubangwa
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Core\tpl\tonic;


use Core\joi\System\Time;

use Github\Client;

class ExtDateTime
{

    private $tonic;


    public function __construct(Tonic $tonic)
    {

        if(!isset($tonic)){

            $tonic = new Tonic(); // dev level view leveler..
        }

        $this->tonic = $tonic;

        $this->extend();
    }

    private function extend()
    {

        $client = new Client();
        $time = new Time();



        $this->tonic::extendModifier('isday', static function () use ($time){
            return $time->isDay();
        });

        $this->tonic::extendModifier('stamp2period', static function ($input, $val) use($client){

            if(!isset($val) || !isset($input)){
                throw new \Exception('value must not be empty');
            }
              $val = (int)$val;
              $input = (int)$input;
            if(!is_int($val) || !is_int($input)){
                throw new \Exception('value must be an int');
            }

            $time = $input ?? $val;
            //litebase time function by Bruce Mubangwa
            $cur_time= time();
            $time_elapsed = $cur_time-$time;
            //we now get the seconds
            $seconds = $time_elapsed;
            $minutes = round($time_elapsed/60);
            $hours = round($time_elapsed/3600);
            $days = round($time_elapsed/86401);
            $weeks =round($time_elapsed/604800);
            $months= round($time_elapsed/2600640);
            $years= round($time_elapsed/31207680);

            if($seconds<=60){
                return "Just Now";
            }
            elseif($minutes<=60){
                if($minutes==1){
                    return "one minute ago";
                }else{
                    return "$minutes minutes ago";
                }
            }
            elseif($hours<=24){
                if($hours==1){
                    return "an hour ago";
                }else{
                    return "$hours hours ago";
                }
            }elseif($days<=7){
                if($days==1){
                    return "yesturday";
                }else{
                    return "$days days ago";
                }
            }elseif($weeks<=4.3){
                if($weeks==1){
                    return "a week ago";
                }else{
                    return "$weeks weeks ago";
                }
            }elseif($months<=12){
                if($months==1){
                    return "a month ago";
                }

                return "$months months ago";
            }else {

                if ($years == 1) {
                    return "one year ago";
                }

                return "$years years ago";

            }
        });


    }

}