<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
//use App\Http\Controllers\Controller;
use Session, DB;
use Input;
//use App\Model\en_scan as EN_scan;
use App\Model\en_scan_complete as EN_scan_complete;

class EN_Scan_Controller extends Controller
{
    //
	public function __construct()
	{
		$this->middleware('auth');
	}


	public function en_scan()
	{
		$user = Auth::user();
		//$scan = DB::connection('mysql2')->select('select * from en_scan_log ORDER BY ca_dt DESC LIMIT 20');
		$scan = DB::connection('mysql2')->table("en_scan_log")->orderBy("ca_dt", "desc")->paginate(10);
		if ($user)
		{
			return view('EN.d_en_scan_result',compact('name','user','scan'));
		}
		return view('test.solar',compact('name','user','scan'));
	}

	public function en_scan_graph()
	{
		$user = Auth::user();
        //$en_scan = EN_scan::get();
        $en_scan_complete = EN_scan_complete::get();
        //$en_scan2 = EN_scan::with( 'FILE')->min('FILE')->get();
        //$en_scan_ok = EN_scan_complete::groupBy(DB::raw('DATE(ca_dt)'))->get();
        //$scan = DB::connection('mysql2')->select('select * from en_scan_log ORDER BY ca_dt DESC LIMIT 20');
		//$scan = DB::connection('mysql2')->table("en_scan_log")->orderBy("ca_dt", "desc")->paginate(10);
		$scan = array();

		$rawqry = "select t1.All, t2.Complete, t1.Date from (SELECT COUNT(*)AS 'All',DATE(`ca_dt`)AS Date FROM `en_scan_log` GROUP BY DATE(`ca_dt`)) t1 left join (SELECT COUNT(*)AS 'Complete',DATE(`ca_dt`)AS Date FROM `en_scan_complete` GROUP BY DATE(`ca_dt`)) t2 on t1.Date = t2.Date";
		$results = DB::select( DB::raw($rawqry) );

        $rawqry = "SELECT MAX(CAST(`FILE` AS UNSIGNED) ) AS 'mfile' FROM `en_scan` WHERE concat('',`FILE` * 1) = `FILE` ORDER BY CAST(`FILE` AS UNSIGNED) DESC";
        $en_scan = DB::select( DB::raw($rawqry) );

        $last_3 = $arr = array_slice($results, -3);
        $en_scan_avg = ($last_3[0]->Complete + $last_3[1]->Complete + $last_3[2]->Complete)/3;


		$cnt = 0;
//        $currentSeries = array();
//		foreach ($results as $rec) {
//            {
//                $tsmp = strtotime($rec->Date)*1000;
//                $all[] = array($tsmp, (int)$rec->All); //push row data into object
//                $cmp[] = array($tsmp, (int)$rec->Complete);
//            }
//        }
//            $currentSeries["label"] = "All";
//            $currentSeries["data"] = $all;
//            $flot[] = $currentSeries;
//
//            $currentSeries["label"] = "OK";
//            $currentSeries["data"] =  $cmp;
//            $flot[] = $currentSeries;
        $scan['Count_All'] = number_format($en_scan[0]->mfile);
        $scan['Count_OK'] = number_format($en_scan_complete->count());
        $scan['speed'] = number_format($en_scan_avg);
        $scan['est'] = number_format(($en_scan[0]->mfile/$en_scan_avg)/22, 2, '.', '');

		foreach ($results as $rec) {
			$scan['All'][$cnt] = (int)$rec->All;
			$scan['Complete'][$cnt] = (int)$rec->Complete;
			$scan['Date'][$cnt] = date("M d", strtotime($rec->Date));
			$cnt++;
		}
		if ($user)
		{
			return view('EN.d_en_scan_graph',compact('name','user','scan'));
		}
		return view('test.solar',compact('name','user','scan'));
	}

	public function refresh_scan_log(Request $request)
	{
		$rid = $request->input()['row_id'];
		$log = DB::connection('mysql2')->select('select * from en_scan_log where id > :id ', ['id' => $rid]);
		return \Response::json($log);
	}

	public function scan_summary_api(Request $request)
	{
		$arrLabels = array("January","February","March","April","May","June","July");
		$arrDatasets = array('label' => "My First dataset",'fillColor' => "rgba(220,220,220,0.2)", 'strokeColor' => "rgba(220,220,220,1)", 'pointColor' => "rgba(220,220,220,1)", 'pointStrokeColor' => "#fff", 'pointHighlightFill' => "#fff", 'pointHighlightStroke' => "rgba(220,220,220,1)", 'data' => array('28', '48', '40', '19', '86', '27', '90'));

		$arrReturn = array(array('labels' => $arrLabels, 'datasets' => $arrDatasets));

		print (json_encode($arrReturn));
	}
}
