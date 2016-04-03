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

        $last_3 = $arr = array_slice($results, -4);
        $en_scan_avg = ($last_3[0]->Complete + $last_3[1]->Complete + $last_3[2]->Complete)/3;

		$cnt = 0;

        $scan['Count_All'] = number_format($en_scan[0]->mfile);
        $scan['Count_OK'] = number_format($en_scan_complete->count());
        $scan['speed'] = number_format($en_scan_avg);
        $scan['est'] = number_format(($en_scan[0]->mfile/$en_scan_avg)/22, 2, '.', '');
        $scan['progress'] = number_format($en_scan_complete->count()*100/(($en_scan[0]->mfile)), 2, '.', '');

		foreach ($results as $rec) {
			$scan['All'][$cnt] = (int)$rec->All;
			$scan['Complete'][$cnt] = (int)$rec->Complete;
			$scan['Date'][$cnt] = date("M d", strtotime($rec->Date));
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
        return view('EN.d_en_scan_search',compact('menu','user'));
    }

	public function en_scan_search_feed(Request $request)
	{
		if(!isset($request->input()["q"])) {
			$page = $request->input()['page']; // get the requested page
			$limit = $request->input()['rows']; // get how many rows we want to have into the grid
			$sidx = $request->input()['sidx']; // get index row - i.e. user click to sort
			$sord = $request->input()['sord']; // get the direction
			if (!$sidx) $sidx = 1;
			$en_scan = EN_scan::get();
			$responce = array();
			if (isset($request->input()["search"]))
				$count = EN_scan::where('FILE', 'like', '%' . $request->input()["search"] . '%')->get()->count();
			else $count = EN_scan::get()->count();;
			if ($count > 0) {
				$total_pages = ceil($count / $limit);
			} else {
				$total_pages = 0;
			}
			if ($page > $total_pages) $page = $total_pages;
			$start = $limit * $page - $limit; // do not put $limit*($page - 1)
			if ($start < 0) $start = 0;
			if (isset($request->input()["search"]))
				$users = EN_scan::with('scan')->where('FILE', 'like', '%' . $request->input()["search"] . '%')->orderBy($sidx, $sord)->take($limit)->skip($start)->get();
			else $users = EN_scan::with('scan')->orderBy($sidx, $sord)->take($limit)->skip($start)->get();

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
			$sub = EN_scan_pages::where('file', $request->input()['id'])->get();

			$i = 0;
			$responce['page'] = 1;
			$responce['total'] = 1;
			$responce['records'] = 1;
			$responce['rows'][$i]['id'] = $i;
			$responce['rows'][$i]['cell'] = array('EN-D-001', 'ทั้งหมด', '-', '<a href="#">download</a>');
			$i++;
			$ch2ea = explode ("#", $sub[0]->en_d_002);

			foreach ($ch2ea as $user) {
				$ch_num = explode (":", $user)[0];
				$chap_name = EN_scan_chapter::where('id', $ch_num)->get();
				$responce['rows'][$i]['id'] = $i;
				$responce['rows'][$i]['cell'] = array('EN-D-002',  $ch_num, $chap_name[0]->name, '<a href="#">download</a>');
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
