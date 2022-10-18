<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use App\Models\Setting;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response ;
use PHPUnit\Framework\Constraint\Count;
// use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Cookie;

class CounterController extends Controller
{
    public function dashboard(Request $request)
    {
        $data  = Counter::all();
        $minute = [];
        $variation = [];
        $control = [];
        $variation_sum = 0;
        $control_sum = 0;
        foreach ($data as $dat) {
            $variation_sum += $dat->variation;
            $control_sum += $dat->control;
            $minute[] = $dat->minute;
            $variation[] = $variation_sum;
            $control[] = $control_sum;
        }
      

        return view("dashboard", [
            'minute'=>  sizeof($minute) ? $minute:[0],
            'variation'=>  sizeof($variation)? $variation: [0],
            'control'=>  sizeof($control)? $control:[0],
        ]);
    }
    public function setting(Request $request)
    {
        $setting = Setting::first();
        $deadline = $setting->deadline;
        $remaining_minutes = floor(($deadline - time())/60);
        
        return view('setting',['minutes'=>$remaining_minutes]);
    }
    public function settingUpdate(Request $request)
    {
        $setting = Setting::first();
        if (!$setting) {
            Setting::create(
                [
                    'minutes' => $request->setting,
                    'deadline' => ((int)$request->setting*60 + time()), //deadline in seconds
                    'demo_mode' => 1, //demo mode enabled.
                ]
            );
        } else {
            $setting->minutes = $request->setting;
            $setting->deadline = ((int)$request->setting*60 + time());
            $setting->save();

            //delete counter records.
            Counter::truncate();
            
        }

         return redirect('dashboard');
    }

    public function control(Request $request)
    {
        
         $setting = Setting::first();
        if (!$setting) {
            return redirect('settingu');
        }
        
        $is_demo = $setting->demo_mode;

        $ip   = request()->ip();
        $ip = $this->ipToString($ip);

        $cookie = $request->cookie($ip);
        $deadline = $setting->deadline;
        $remaining_minutes = floor(($deadline - time())/60);

        $incrementing_minute = (int)($setting->minutes - $remaining_minutes);

        if ($incrementing_minute < $setting->minutes && ($is_demo || !$cookie)) {

            
                $counter = Counter::where('minute',$incrementing_minute)->first();
            
                if ($counter) {
                    $counter->control = $counter->control + 1;
                    $counter->save();
                } else {
                    Counter::create([
                       'control'=>1,
                       'minute'=>$incrementing_minute,
                    ]);
                }
    
                $response = new \Illuminate\Http\Response('Hello World');
                $response->withCookie(cookie($ip, $ip, 60));
                return $response;
            
           
        }


        return redirect('dashboard');
    }

    public function variation(Request $request)
    {
        
         $setting = Setting::first();
        if (!$setting) {
            return redirect('settingu');
        }
        $is_demo = $setting->demo_mode;
        $ip   = request()->ip();
        $ip = $this->ipToString($ip);

        $cookie = $request->cookie($ip);
        $deadline = $setting->deadline;
        $remaining_minutes = floor(($deadline - time())/60);

        $incrementing_minute = (int)($setting->minutes - $remaining_minutes);

        if ($incrementing_minute < $setting->minutes && ($is_demo || !$cookie)) {
            $counter = Counter::where('minute',$incrementing_minute)->first();
             
            if ($counter) {
                $counter->variation = $counter->variation + 1;
                $counter->save();
            } else {
                Counter::create([
                   'variation'=>1,
                   'minute'=>$incrementing_minute,
                ]);
            }

            $response = new \Illuminate\Http\Response('Hello World');
            $response->withCookie(cookie($ip, $ip, 60));
            return $response;
        }


        return redirect('dashboard');
    }


    public function ipToString($ip)
    {
        $arr = explode('.', $ip);
        $str = implode('_', $arr);
        return $str;
    }
}
