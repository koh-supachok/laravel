@extends('ekarat')

@section('content')
    <input type="hidden" id="alldoc" value={{$scan_det['all']}}>
    <input type="hidden" id="allok" value={{$scan_det['allok']}}>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-success pull-right">All</span>
                        <h5>จำนวนแฟ้มสแกนวันนี้</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins" id="all">{{$scan_det['Count_today']}} </h1>

                        <small>แฟ้ม</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-info pull-right">OK</span>
                        <h5>แสกนสำเร็จวันนี้</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins" id="ok">{{$scan_det['Count_today_OK']}}</h1>

                        <small>แฟ้ม</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-primary pull-right">Speed</span>
                        <h5>ความเร็วเฉลี่ย (3วัน)</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{$scan_det['speed']}}</h1>

                        <small>แฟ้ม / วัน</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-danger pull-right">Progress</span>
                        <h5>ความก้าวหน้า</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins" id="progress">{{$scan_det['progress']}}%</h1>
                        <div class="progress progress-mini">
                            <div style="width: {{$scan_det['progress']}}%;" class="progress-bar" id="progress_bar"></div>
                        </div>
                        <small></small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>ผลการแสกนเอกสาร</h5>
                    </div>
                    <div class="ibox-content">

                        <table class="table table-hover" id="sresult">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>แฟ้มที่</th>
                                <th>รายละเอียด</th>
                                <th>เวลา</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($scan as $data)

                                <tr>
                                    <td style="vertical-align:middle">{{ $data->id }}</td>
                                    <td style="vertical-align:middle">{{ $data->file }}</td>
                                    <td style="vertical-align:middle">{!! nl2br($data->detail) !!}</td>
                                    <td style="vertical-align:middle">{{ $data->ca_dt }}</td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                        <div class="pagination"> {!! $scan->render() !!} </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('includes.footer')

    </div>
    </div>
@stop

@section('script')
        <!-- Mainly scripts -->
    <script src="{{ asset(env('ASSET_PATH').'/js/jquery-2.1.1.js') }}"></script>
    <script src="{{ asset(env('ASSET_PATH').'/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset(env('ASSET_PATH').'/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset(env('ASSET_PATH').'/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset(env('ASSET_PATH').'/js/inspinia.js') }}"></script>
    <script src="{{ asset(env('ASSET_PATH').'/js/plugins/pace/pace.min.js') }}"></script>

    <!-- iCheck -->
    <script src="{{ asset(env('ASSET_PATH').'/js/plugins/iCheck/icheck.min.js') }}"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
        });
    </script>
    <script>
        $(document).ready(function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
            var $row = $('table tr:nth-child(1) td:nth-child(1)').text();
            var $col= [];
            var all = document.getElementById("alldoc").value;
            var ok = document.getElementById("allok").value;
            var fetch = setInterval(refresh, 3000);
            //$row = 40;
            function nl2br (str, is_xhtml) {
                var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br ' + '/>' : '<br>';
                return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
            }

            var QueryString = function () {
                // This function is anonymous, is executed immediately and
                // the return value is assigned to QueryString!
                var query_string = {};
                var query = window.location.search.substring(1);
                var vars = query.split("&");
                for (var i=0;i<vars.length;i++) {
                    var pair = vars[i].split("=");
                    // If first entry with this name
                    if (typeof query_string[pair[0]] === "undefined") {
                        query_string[pair[0]] = decodeURIComponent(pair[1]);
                        // If second entry with this name
                    } else if (typeof query_string[pair[0]] === "string") {
                        var arr = [ query_string[pair[0]],decodeURIComponent(pair[1]) ];
                        query_string[pair[0]] = arr;
                        // If third or later entry with this name
                    } else {
                        query_string[pair[0]].push(decodeURIComponent(pair[1]));
                    }
                }
                return query_string;
            }();
            var newok = 0;
            function refresh(){
                //$("<tr><td>"+$row+"</td><td>test id</td><td>"+$row+"</td><td>date</td></tr>").prependTo("table > tbody");
                //$row++;
                if((!(QueryString.page > 1))||((QueryString.page === null)))
                $.ajax({
                    url: "ajax/refresh_log",
                    method: 'POST',
                    data:  { row_id: $row },

                    success: function(data) {
                        var $i = 0;

                        if( data['update']!="" ) {
                            //alert(QueryString.page);
                            //var allok = document.getElementById("ok").value;
                            //alert(JSON.stringify(data));
                            newok = Number(ok) + (Number(data['ok']) - Number(document.querySelector('#ok').innerHTML));
                            newok = (newok*100) / Number(all);
                            document.querySelector('#all').innerHTML = data['all'];
                            document.querySelector('#ok').innerHTML = data['ok'];
                            document.querySelector('#progress').innerHTML = newok;
                            document.getElementById("progress_bar").style.width = newok +"%";

                        }
                        //alert(data['update']);
                        $.each(data['update'], function() {
                            $.each(this, function(k, v) {
                                //console.log(k +"-"+v);
                                $col[k]=v;
                            });
                            $row = $col['id'];
                            $("<tr><td style=\"vertical-align:middle\">"
                                    +$col['id']+"</td><td style=\"vertical-align:middle\">"
                                    +$col['file']+"</td><td style=\"vertical-align:middle\">"
                                    +nl2br($col['detail'])+"</td><td style=\"vertical-align:middle\">"
                                    +$col['ca_dt']+"</td></tr>").prependTo("table > tbody");
                        });
                        //console.log("success");
                    },
                    error: function(data) {
                        console.log(data);
                        console.log("error");
                    }
                });
            }
            //$("<tr><td>test id</td><td>test id</td><td>"+$row+"</td><td>date</td></tr>").prependTo("table > tbody").slideDown( "slow" );
        });
    </script>
@stop
