<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Classes\Menu;
//use App\Http\Controllers\Controller;
use Session, DB;
use Input;
use App\Model\en_scan as EN_scan;
use App\Model\en_scan_complete as EN_scan_complete;
use App\Model\en_scan_pages as EN_scan_pages;
use App\Model\en_scan_chapter as EN_scan_chapter;
//use App\Model\en_scan_log as EN_scan_log;

class EN_Scan_Controller extends Controller
{
    //
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function scan_today()
	{
		$scan_today = array();
		$rawqry = "SELECT COUNT(id) AS Cnt FROM `en_scan_log` WHERE `ca_dt` like '%".date('Y-m-d')."%'";
		$scan_today['all'] = DB::select( DB::raw($rawqry) );

		$rawqry = "SELECT COUNT(id) AS Cnt FROM `en_scan_complete` WHERE `ca_dt` like '%".date('Y-m-d')."%'";
		$scan_today['ok'] = DB::select( DB::raw($rawqry) );
		return $scan_today;
	}

	public function en_scan()
	{
		$user = Auth::user();
		$menu = Menu::create();
        $scan_det = array();
        $en_scan_complete = EN_scan_complete::get();
        //$en_scan_log = EN_scan_log::where('ca_dt', '>=', date('Y-m-d').' 00:00:00')->get();
        //$en_scan_log = EN_scan_log::where(DATE(`ca_dt`), '=', '2016-03-25 ')->get();
        //$en_scan_lo = $en_scan_log->whereDate('created_at', '=', date('Y-m-d'));
		$today = $this->scan_today();
		$en_scan_log = $today['all'];
		$en_scan_ok_today = $today['ok'];

		$scan = DB::connection('mysql2')->table("en_scan_log")->orderBy("ca_dt", "desc")->paginate(10);

        $rawqry = "select t1.All, t2.Complete, t1.Date from (SELECT COUNT(*)AS 'All',DATE(`ca_dt`)AS Date FROM `en_scan_log` GROUP BY DATE(`ca_dt`)) t1 left join (SELECT COUNT(*)AS 'Complete',DATE(`ca_dt`)AS Date FROM `en_scan_complete` GROUP BY DATE(`ca_dt`)) t2 on t1.Date = t2.Date";
        $results = DB::select( DB::raw($rawqry) );
        $last_3 = $arr = array_slice($results, -4);
        $en_scan_avg = ($last_3[0]->Complete + $last_3[1]->Complete + $last_3[2]->Complete)/3;

        $rawqry = "SELECT MAX(CAST(`FILE` AS UNSIGNED) ) AS 'mfile' FROM `en_scan` WHERE concat('',`FILE` * 1) = `FILE` ORDER BY CAST(`FILE` AS UNSIGNED) DESC";
        $en_scan = DB::select( DB::raw($rawqry) );
        $scan_det['all'] = $en_scan[0]->mfile;
        $scan_det['allok'] = $en_scan_complete->count();
        $scan_det['Count_today'] = number_format((int)$en_scan_log[0]->Cnt);
        $scan_det['Count_today_OK'] = number_format((int)$en_scan_ok_today[0]->Cnt);
        $scan_det['speed'] = number_format($en_scan_avg);
        $scan_det['progress'] = number_format($en_scan_complete->count()*100/(($en_scan[0]->mfile)), 2, '.', '');
        //print_r($scan['Count_today']);
		if ($user)
		{
			return view('EN.d_en_scan_result',compact('menu','user','scan','scan_det'));
		}
		return view('test.solar',compact('name','user','scan','scan_det'));
	}

	public function en_scan_graph()
	{
		$user = Auth::user();
        //$en_scan = EN_scan::get();
        $en_scan_complete = EN_scan_complete::get();
		$menu = Menu::create();
        //$en_scan2 = EN_scan::with( 'FILE')->min('FILE')->get();
        //$en_scan_ok = EN_scan_complete::groupBy(DB::raw('DATE(ca_dt)'))->get();
        //$scan = DB::connection('mysql2')->select('select * from en_scan_log ORDER BY ca_dt DESC LIMIT 20');
		//$scan = DB::connection('mysql2')->table("en_scan_log")->orderBy("ca_dt", "desc")->paginate(10);
		$scan = array();

		$rawqry = "select t1.All, t2.Complete, t1.Date from (SELECT COUNT(*)AS 'All',DATE(`ca_dt`)AS Date FROM `en_scan_log` GROUP BY DATE(`ca_dt`)) t1 left join (SELECT COUNT(*)AS 'Complete',DATE(`ca_dt`)AS Date FROM `en_scan_complete` GROUP BY DATE(`ca_dt`)) t2 on t1.Date = t2.Date";
		$results = DB::select( DB::raw($rawqry) );

        $rawqry = "SELECT MAX(CAST(`FILE` AS UNSIGNED) ) AS 'mfile' FROM `en_scan` WHERE concat('',`FILE` * 1) = `FILE` ORDER BY CAST(`FILE` AS UNSIGNED) DESC";
        $en_scan = DB::select( DB::raw($rawqry) );

		$rawqry = "SELECT SUM(en_d_001+en_d_002_pages+en_d_003+other) as total FROM `en_scan_complete` LEFT JOIN en_scan_pages ON en_scan_complete.file = en_scan_pages.file";
		$page_scan = DB::select( DB::raw($rawqry) );

		$rawqry = "SELECT COUNT(DISTINCT DATE(ca_dt)) as days FROM `en_scan_complete`";
		$day_scan = DB::select( DB::raw($rawqry) );

		//$rawqry = "SELECT SUM(en_d_001+en_d_002_pages+en_d_003+other) as total FROM `en_scan_complete` LEFT JOIN en_scan_pages ON en_scan_complete.file = en_scan_pages.file GROUP BY DATE(en_scan_complete.ca_dt) ORDER BY DATE(en_scan_complete.ca_dt) DESC LIMIT 3";
		$rawqry = "SELECT DATE(en_scan_complete.ca_dt) as date ,SUM(en_d_001+en_d_002_pages+en_d_003+other) as total FROM `en_scan_complete` LEFT JOIN en_scan_pages ON en_scan_complete.file = en_scan_pages.file GROUP BY DATE(en_scan_complete.ca_dt) ORDER BY DATE(en_scan_complete.ca_dt)";
		$page_scan3 = DB::select( DB::raw($rawqry) );

        $last_3 = array_slice($results, -4);
        $en_scan_avg = ($last_3[0]->Complete + $last_3[1]->Complete + $last_3[2]->Complete)/3;

<<<<<<< HEAD
		$page_last3_cnt = count($page_scan3);
		$page_last3 = 	($page_scan3[$page_last3_cnt-1]->total)+($page_scan3[$page_last3_cnt-2]->total)+($page_scan3[$page_last3_cnt-3]->total);

=======
		
>>>>>>> 86491193df6a9f64d33e22bbb8854478fb58d16a
		$cnt = 0;
		$cmpsum = 0;

        $scan['Count_All'] = number_format($en_scan[0]->mfile);
        $scan['Count_OK'] = number_format($en_scan_complete->count());
        $scan['speed'] = number_format($en_scan_avg);
        $scan['est'] = number_format(($en_scan[0]->mfile/$en_scan_avg)/22, 2, '.', '');
        $scan['progress'] = number_format($en_scan_complete->count()*100/(($en_scan[0]->mfile)), 2, '.', '');
		$scan['page_scan'] = number_format($page_scan[0]->total);
		$scan['day_scan'] = number_format($day_scan[0]->days);
		$scan['ok_avg'] = number_format(($en_scan_complete->count())/($day_scan[0]->days));
		//$scan['pages_avg'] = number_format(($page_scan[0]->total)/($day_scan[0]->days));
		$scan['pages_avg'] = number_format($page_last3/3);
		foreach ($results as $rec) {
			$scan['All'][$cnt] = (int)$rec->All;
			$scan['Complete'][$cnt] = (int)$rec->Complete;
			$cmpsum += (int)$rec->Complete;
			$scan['Cumu'][$cnt] = $cmpsum;
			$scan['Date'][$cnt] = date("M d", strtotime($rec->Date));
			$cnt++;
		}
		$cnt = 0;
		foreach ($page_scan3 as $rec) {
			$scan['page_day'][$cnt] = (int)$rec->total;
			$scan['pDate'][$cnt] = date("M d", strtotime($rec->date));
			$cnt++;
		}
		if ($user)
		{
			return view('EN.d_en_scan_graph',compact('menu','user','scan'));
		}
		return view('test.solar',compact('name','user','scan'));
	}

	public function refresh_scan_log(Request $request)
	{
		$log = array();
		$rid = $request->input()['row_id'];
		$log['update'] = DB::connection('mysql2')->select('select * from en_scan_log where id > :id ', ['id' => $rid]);
        $today = $this->scan_today();
        $log['all'] = $today['all'][0]->Cnt;
        $log['ok'] = $today['ok'][0]->Cnt;
		return \Response::json($log);
	}

	public function scan_summary_api(Request $request)
	{
		$arrLabels = array("January","February","March","April","May","June","July");
		$arrDatasets = array('label' => "My First dataset",'fillColor' => "rgba(220,220,220,0.2)", 'strokeColor' => "rgba(220,220,220,1)", 'pointColor' => "rgba(220,220,220,1)", 'pointStrokeColor' => "#fff", 'pointHighlightFill' => "#fff", 'pointHighlightStroke' => "rgba(220,220,220,1)", 'data' => array('28', '48', '40', '19', '86', '27', '90'));

		$arrReturn = array(array('labels' => $arrLabels, 'datasets' => $arrDatasets));

		print (json_encode($arrReturn));
	}

    public function en_scan_search()
    {
        $user = Auth::user();
		$menu = Menu::create();
		$option['kva'] = EN_scan::select('KVA')->groupBy('KVA')->get();
		$option['type'] = EN_scan::select('TYPE')->groupBy('TYPE')->get();
		$option['ph'] = EN_scan::select('PH')->groupBy('PH')->get();
		$option['vector'] = EN_scan::select('VECTOR')->groupBy('VECTOR')->get();
		$option['volt'] = EN_scan::select('VOLT')->groupBy('VOLT')->get();
        return view('EN.d_en_scan_search',compact('menu','user','option'));
    }

	public function en_scan_search_feed(Request $request)
	{
		if(!isset($request->input()["q"])) {
			$page = $request->input()['page']; // get the requested page
			$limit = $request->input()['rows']; // get how many rows we want to have into the grid
			$sidx = $request->input()['sidx']; // get index row - i.e. user click to sort
			$sord = $request->input()['sord']; // get the direction
			if (!$sidx) $sidx = 1;
			//$en_scan = EN_scan::get();
			$responce = array();
			if(!isset($request->input()['asearch'])) {
				if (isset($request->input()["search"]))
					$count = EN_scan::where($request->input()["type"], $request->input()["search"])->get()->count();
				else $count = EN_scan::get()->count();
				if ($count > 0) {
					$total_pages = ceil($count / $limit);
				} else {
					$total_pages = 0;
				}
				if ($page > $total_pages) $page = $total_pages;
				$start = $limit * $page - $limit; // do not put $limit*($page - 1)
				if ($start < 0) $start = 0;
				if (isset($request->input()["search"]))
					$users = EN_scan::with('scan')->where($request->input()["type"], $request->input()["search"])->orderBy($sidx, $sord)->take($limit)->skip($start)->get();
				else $users = EN_scan::with('scan')->orderBy($sidx, $sord)->take($limit)->skip($start)->get();
			}
			else{
				$whereq = [];
				$catg = "volt" ;if(isset($request->input()[$catg]) && !empty($request->input()[$catg])) $whereq[$catg] = $request->input()[$catg];
				$catg = "type" ;if(isset($request->input()[$catg]) && !empty($request->input()[$catg])) $whereq[$catg] = $request->input()[$catg];
				$catg = "ph" ;if(isset($request->input()[$catg]) && !empty($request->input()[$catg])) $whereq[$catg] = $request->input()[$catg];
				$catg = "vector" ;if(isset($request->input()[$catg]) && !empty($request->input()[$catg])) $whereq[$catg] = $request->input()[$catg];
				$catg = "kva" ;if(isset($request->input()[$catg]) && !empty($request->input()[$catg])) $whereq[$catg] = $request->input()[$catg];
				//$whereq["type"] =  isset($request->input()["type"]) && !empty($request->input()["type"]) ? $request->input()["type"] : "";
				//$whereq["ph"] = isset($request->input()["ph"]) && !empty($request->input()["ph"]) ?  $request->input()["ph"] : "";
				//$whereq["vector"] = isset($request->input()["vector"]) && !empty($request->input()["vector"]) ?  $request->input()["vector"] : "";
				//$whereq["kva"] = isset($request->input()["kva"]) && !empty($request->input()["kva"]) ?  $request->input()["kva"] : "";

				$count = EN_scan::where($whereq)->get()->count();

				if ($count > 0) {
					$total_pages = ceil($count / $limit);
				} else {
					$total_pages = 0;
				}
				if ($page > $total_pages) $page = $total_pages;
				$start = $limit * $page - $limit; // do not put $limit*($page - 1)
				if ($start < 0) $start = 0;
				//if (isset($request->input()["search"]))
					$users = EN_scan::with('scan')->where($whereq)->orderBy($sidx, $sord)->take($limit)->skip($start)->get();
				//else $users = EN_scan::with('scan')->orderBy($sidx, $sord)->take($limit)->skip($start)->get();
			}
			$i = 0;
			$responce['page'] = $page;
			$responce['total'] = $total_pages;
			$responce['records'] = $count;
			foreach ($users as $user) {
				$responce['rows'][$i]['id'] = $user->FILE;
				$responce['rows'][$i]['cell'] = array($user->DESIGN, $user->FILE, $user->TYPE, $user->KVA, $user->PH, $user->VECTOR, $user->VOLT, $user->REMARK,$user->SO, (isset($user->scan->file) ? "Yes" : "No"));
				$i++;
			}
			return \Response::json($responce);
		}
		else
		{
			$file = $request->input()['id'];
			$sub = EN_scan_pages::where('file',$file)->get();

			$i = 0;
			if($sub[0]->en_d_001 > 0) {
				$responce['page'] = 1;
				$responce['total'] = 1;
				$responce['records'] = 1;
				$responce['rows'][$i]['id'] = $i;
				$responce['rows'][$i]['cell'] = array('EN-D-001', 'ทั้งหมด', '-', '<a target="_blank" href="/assets/docscan/OK/' . $file . '/EN-D-001 - All.pdf">download</a>');
				$i++;
			}
			if($sub[0]->en_d_002_pages > 0) {
				$ch2ea = explode("#", $sub[0]->en_d_002);
				$ch2_idx = 0;
				foreach ($ch2ea as $user) {
					$ch_num = explode(":", $user)[0];
					$chap_name = EN_scan_chapter::where('id', $ch_num)->get();
					$responce['rows'][$i]['id'] = $i;//EN-D-002 - บทที่ 0 - สารบัญ
					$responce['rows'][$i]['cell'] = array('EN-D-002', $ch_num, $chap_name[0]->name, '<a target="_blank" href="/assets/docscan/OK/' . $file . '/EN-D-002 - บทที่ ' . $ch2_idx . ' - ' . $chap_name[0]->name . '.pdf">download</a>');
					$i++;
					$ch2_idx++;
				}
			}
			if($sub[0]->en_d_003 > 0) {
				$responce['page'] = 1;
				$responce['total'] = 1;
				$responce['records'] = 1;
				$responce['rows'][$i]['id'] = $i;
				$responce['rows'][$i]['cell'] = array('EN-D-003', 'ทั้งหมด', '-', '<a target="_blank" href="/assets/docscan/OK/' . $file . '/EN-D-003 - All.pdf">download</a>');
				$i++;
			}
			if($sub[0]->other > 0) {
				$responce['page'] = 1;
				$responce['total'] = 1;
				$responce['records'] = 1;
				$responce['rows'][$i]['id'] = $i;
				$responce['rows'][$i]['cell'] = array('อื่นๆ', 'ทั้งหมด', '-', '<a target="_blank" href="/assets/docscan/OK/' . $file . '/EN-D-004 - All.pdf">download</a>');
				$i++;
			}
//			$responce['page'] = 1;
//			$responce['total'] = 1;
//			$responce['records'] = 1;
//			$responce['rows'][0]['id'] = 0;
//			$responce['rows'][0]['cell'] = array('EN-D-001', 'บทที่ 1', $request->input()['id'],'<a type="button" class="btn btn-success btn-xs">Download</a>');
			return \Response::json($responce);
		}
	}
}
