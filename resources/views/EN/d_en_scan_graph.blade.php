@extends('ekarat')

@section('content')
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-success pull-right">All</span>
                        <h5>จำนวนแฟ้มทั้งหมด</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{$scan['Count_All']}} </h1>
                        <div class="stat-percent font-bold text-success">100% <i class="fa fa-book"></i></div>
                        <small>แฟ้ม</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-info pull-right">OK</span>
                        <h5>แสกนสำเร็จ (แฟ้ม)</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{$scan['Count_OK']}}</h1>
                        <small>แฟ้ม</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-info pull-right">Pages scanned</span>
                        <h5>แสกนสำเร็จ (หน้า)</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{$scan['page_scan']}}</h1>

                        <small>หน้า</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-info pull-right">Progress</span>
                        <h5>แสกนสำเร็จ (%)</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{$scan['progress']}}%</h1>
                        <small>&nbsp;</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-warning pull-right">Days</span>
                        <h5>จำนวนวันสแกน</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{$scan['day_scan']}} </h1>
                        <div class="stat-percent font-bold text-warning">เริ่มเมื่อ 8 มี.ค. 59 <i class="fa fa-calendar "></i></div>
                        <small>วัน</small>
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
                        <h1 class="no-margins">{{$scan['speed']}}</h1>

                        <small>แฟ้ม / วัน</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-danger pull-right">Complete on</span>
                        <h5>กำหนดเสร็จภายใน</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{$scan['est']}}</h1>

                        <small>เดือน</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>ผลการแสกนแฟ้มแบบสั่งงาน</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-9">
                                <div>
                                    <canvas id="canvas" height="100" ></canvas>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="statistic-box">
                                    <ul class="list-group clear-list m-t">
                                        <li class="list-group-item fist-item">
                                            <span class="label label-default">&nbsp;</span> แฟ้มที่แสกนทั้งหมด
                                        </li>
                                        <li class="list-group-item">
                                            <span class="label label-success">&nbsp;</span> ผ่านการตรวจสอบ
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </div>
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



    {{--<!-- Flot -->--}}
    {{--<script src="{{ asset(env('ASSET_PATH')).'/'}}js/plugins/flot/jquery.flot.js"></script>--}}
    {{--<script src="{{ asset(env('ASSET_PATH')).'/'}}js/plugins/flot/jquery.flot.tooltip.min.js"></script>--}}
    {{--<script src="{{ asset(env('ASSET_PATH')).'/'}}js/plugins/flot/jquery.flot.spline.js"></script>--}}
    {{--<script src="{{ asset(env('ASSET_PATH')).'/'}}js/plugins/flot/jquery.flot.resize.js"></script>--}}
    {{--<script src="{{ asset(env('ASSET_PATH')).'/'}}js/plugins/flot/jquery.flot.pie.js"></script>--}}
    {{--<script src="{{ asset(env('ASSET_PATH')).'/'}}js/plugins/flot/jquery.flot.symbol.js"></script>--}}
    {{--<script src="{{ asset(env('ASSET_PATH')).'/'}}js/plugins/flot/jquery.flot.time.js"></script>--}}

    <!-- Custom and plugin javascript -->
    <script src="{{ asset(env('ASSET_PATH').'/js/inspinia.js') }}"></script>
    <script src="{{ asset(env('ASSET_PATH').'/js/plugins/pace/pace.min.js') }}"></script>
    <!-- jQuery UI -->
    <script src="{{ asset(env('ASSET_PATH')).'/'}}js/plugins/jquery-ui/jquery-ui.min.js"></script>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
        });
    </script>
    <script src="{{ asset(env('ASSET_PATH')).'/'}}js/plugins/chartJs/Chart.min.js"></script>
    <script>
        var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
        var lineChartData = {
            labels : <?=json_encode($scan['Date']);?>,
            datasets : [
                {
                    label: "My First dataset",
                    fillColor : "rgba(220,220,220,0.2)",
                    strokeColor : "rgba(220,220,220,1)",
                    pointColor : "rgba(220,220,220,1)",
                    pointStrokeColor : "#fff",
                    pointHighlightFill : "#fff",
                    pointHighlightStroke : "rgba(220,220,220,1)",
                    data : <?=json_encode($scan['All']);?>
                },
                {
                    label: "My Second dataset",
                    fillColor : "rgba(151,187,205,0.2)",
                    strokeColor : "rgba(151,187,205,1)",
                    pointColor : "rgba(151,187,205,1)",
                    pointStrokeColor : "#fff",
                    pointHighlightFill : "#fff",
                    pointHighlightStroke : "rgba(151,187,205,1)",
                    data : <?=json_encode($scan['Complete']);?>
                }
            ]
        }
        window.onload = function(){
            var ctx = document.getElementById("canvas").getContext("2d");
//            window.myLine = new Chart(ctx).Line(lineChartData, {
//                responsive: true
//            });
            window.myLine = new Chart(ctx).Line(lineChartData, {
                scaleShowLabels : false,
                responsive: true,
                showTooltips: false,
                onAnimationComplete: function () {

                    var ctx = this.chart.ctx;
                    ctx.font = this.scale.font;
                    ctx.fillStyle = this.scale.textColor
                    ctx.textAlign = "center";
                    ctx.textBaseline = "bottom";

                    this.datasets.forEach(function (dataset) {
                        dataset.points.forEach(function (points) {
                            ctx.fillText(points.value, points.x, points.y - 8);
                        });
                    })
                }
            });
        }
    </script>

@stop
