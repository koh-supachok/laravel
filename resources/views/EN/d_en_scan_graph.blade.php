@extends('ekarat')

@section('content')
    <div class="wrapper wrapper-content" >
            <div class="row">
                <div class="col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-success pull-right">All</span>
                            <h5 style='text-align:justify;'>จำนวนแฟ้มทั้งหมด</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins">{{$scan['Count_All']}} </h1>
                            <div class="stat-percent font-bold text-success">100% <i class="fa fa-book"></i></div>
                            <small style='text-align:justify;'>แฟ้ม</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">OK</span>
                            <h5 style='text-align:justify;'>แสกนสำเร็จ (แฟ้ม)</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins">{{$scan['Count_OK']}}</h1>
                            <small style='text-align:justify;'>แฟ้ม</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">Pages</span>
                            <h5 style='text-align:justify;'>แสกนสำเร็จ (หน้า)</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins">{{$scan['page_scan']}}</h1>

                            <small style='text-align:justify;'>หน้า</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">Progress</span>
                            <h5 style='text-align:justify;'>แสกนสำเร็จ (%)</h5>
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
                            <h5 style='text-align:justify;'>จำนวนวันสแกน</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins">{{$scan['day_scan']}} </h1>
                            <div class="stat-percent font-bold text-warning" style='text-align:justify;'>เริ่มเมื่อ 8 มี.ค. 59 <i class="fa fa-calendar "></i></div>
                            <small style='text-align:justify;'>วัน</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-primary pull-right">Speed</span>
                            <h5 style='text-align:justify;'>ความเร็วเฉลี่ย (3วัน)</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins">{{$scan['speed']}}</h1>

                            <small style='text-align:justify;'>แฟ้ม / วัน</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-primary pull-right">Avg Speed</span>
                            <h5 style='text-align:justify;'>ความเร็วเฉลี่ย (3วัน)</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins">{{$scan['pages_avg']}}</h1>

                            <small style='text-align:justify;'>หน้า / วัน</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-danger pull-right">Complete on</span>
                            <h5 style='text-align:justify;'>กำหนดเสร็จภายใน</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins">{{$scan['est']}}</h1>

                            <small style='text-align:justify;'>เดือน</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5 style='text-align:justify;'>ผลการแสกนแฟ้มแบบสั่งงาน</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-10">
                                    <div>
                                        <canvas id="canvas" height="100" ></canvas>
                                    </div>
                                </div>
                                <div class="col-sm-2">
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
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5 style='text-align:justify;'>ผลการแสกนแฟ้มแบบสั่งงาน( จำนวนหน้าที่ผ่านการตรวจสอบ )</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-10">
                                    <div>
                                        <canvas id="canvas_page" height="100" ></canvas>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="statistic-box">
                                        <ul class="list-group clear-list m-t">
                                            <li class="list-group-item fist-item">
                                                <span class="label label-success" style="background-color:#186A3B;">&nbsp;</span> ผ่านการตรวจสอบ
                                            </li>
                                            <li class="list-group-item">
                                                    <span class="pull-right">รวม {{$scan['page_scan']}} หน้า</span>
                                            </li>
                                        </ul>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

        </div>
        <div class="row">
            <div class="col-xs-12">
                <a class="btn btn-primary pull-right" id="sav_btn">
                    <i class="fa fa-image"></i>
                </a>
                <a class="btn btn-danger pull-right" id="pdf_btn">
                    <i class="fa fa-file-pdf-o"></i>
                </a>
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
    <script src="{{ asset(env('ASSET_PATH').'/js/plugins/jsPDF/jspdf.min.js') }}"></script>
    <script src="{{ asset(env('ASSET_PATH').'/js/plugins/html2canvas/html2canvas.js') }}"></script>
    <script src="{{ asset(env('ASSET_PATH').'/js/plugins/FileSaver/FileSaver.js') }}"></script>
    <script src="{{ asset(env('ASSET_PATH').'/js/plugins/canvas-toBlob/canvas-toBlob.js') }}"></script>
    <script src="{{ asset(env('ASSET_PATH').'/js/plugins/Blob/Blob.js') }}"></script>
    <!-- jQuery UI -->
    <script src="{{ asset(env('ASSET_PATH')).'/'}}js/plugins/jquery-ui/jquery-ui.min.js"></script>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
        });
    </script>
    <script src="{{ asset(env('ASSET_PATH')).'/'}}js/plugins/chartJs/Chart.min.js"></script>
    <script>
        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(?:\d{3})+(?!\d))/g, ",");
        }
        var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
        var lineChartData = {
            labels : <?=json_encode($scan['Date']);?>,
            datasets : [
                {
                    label: "All",
                    fillColor : "rgba(220,220,220,0.2)",
                    strokeColor : "rgba(220,220,220,1)",
                    pointColor : "rgba(220,220,220,1)",
                    pointStrokeColor : "#fff",
                    pointHighlightFill : "#fff",
                    pointHighlightStroke : "rgba(220,220,220,1)",
                    data : <?=json_encode($scan['All']);?>
                },
                {
                    label: "Ok",
                    fillColor : "rgba(151,187,205,0.2)",
                    strokeColor : "rgba(151,187,205,1)",
                    pointColor : "rgba(151,187,205,1)",
                    pointStrokeColor : "#fff",
                    pointHighlightFill : "#fff",
                    pointHighlightStroke : "rgba(151,187,205,1)",
                    data : <?=json_encode($scan['Complete']);?>
                }
            ]
        };

        var pagesData = {
            labels : <?=json_encode($scan['pDate']);?>,
            datasets : [
                {
                    label: "pages",
                    fillColor : "rgba(24, 106, 59,0.2)",
                    strokeColor : "rgba(24, 106, 59,1)",
                    pointColor : "rgba(24, 106, 59,1)",
                    pointStrokeColor : "#fff",
                    pointHighlightFill : "#fff",
                    pointHighlightStroke : "rgba(24, 106, 59,1)",
                    data : <?=json_encode($scan['page_day']);?>
                }
            ]
        };
        var today = new Date();
        var dd = today.toISOString();

        $("#sav_btn").click(function() {
            html2canvas($("#saveimg"), {
                onrendered: function(canvas) {
                    theCanvas = canvas;
                    //document.body.appendChild(canvas);
                    canvas.toBlob(function(blob) {
                        saveAs(blob, "Scan_summary_"+dd+".jpg");
                    }, "image/jpeg");
                }
            });
//            html2canvas($('#saveimg'), {
//                onrendered: function(canvas) {
//                    var img = canvas.toDataURL("image/jpeg")
//                    canvas.toBlob(function(blob) {
//                        saveAs(blob, "teaser-384x168px.png");
//                    }, "image/png");
//                }
//            });
        });

        $("#pdf_btn").click(function() {

            var doc = new jsPDF('p', 'pt', 'a4', false);
            html2canvas($("#saveimg"), {
                onrendered: function(canvas) {
                    theCanvas = canvas;
                    //document.body.appendChild(canvas);
                    canvas.toBlob(function(blob) {
                        //saveAs(blob, "Scan_summary_"+dd+".jpg");
                        var reader = new window.FileReader();
                        reader.readAsDataURL(blob);
                        reader.onloadend = function() {
                            base64data = reader.result;
                            //console.log(base64data );

                            doc.setFontSize(40);
                            doc.setDrawColor(0);
                            doc.setFillColor(238, 238, 238);
                            doc.rect(0, 0, 595.28,  841.89, 'F');
                            var imageUrl = URL.createObjectURL( blob );

                            doc.addImage(base64data, 'JPEG', 5, 5, 585,700, undefined, 'medium');

                            doc.save( "Scan_summary_"+dd+".pdf")
                        };
                    }, "image/JPEG");
                }
            });

        });

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
                        //console.log(JSON.stringify(dataset));
                        dataset.points.forEach(function (points) {
                            if(dataset.label == "All"){
                                ctx.fillStyle = "rgba(220,220,220,1)";
                                ctx.fillText(points.value, points.x, points.y - 26);
                            }
                            else if(dataset.label == "Ok"){
                                ctx.fillStyle = "#003366";
                                ctx.fillText(points.value, points.x, points.y - 8);
                            }
                            else {
                                //ctx.fillStyle = "#003366";
                                //ctx.fillText(points.value, points.x, points.y - 8);
                            }
                        });
                    })
                }
            });

            var page_ctx = document.getElementById("canvas_page").getContext("2d");

            window.myLine = new Chart(page_ctx).Line(pagesData, {
                scaleShowLabels : false,
                responsive: true,
                showTooltips: false,
                onAnimationComplete: function () {

                    var ctx = this.chart.ctx;
                    page_ctx.font = this.scale.font;
                    page_ctx.fillStyle = this.scale.textColor
                    page_ctx.textAlign = "center";
                    page_ctx.textBaseline = "bottom";

                    this.datasets.forEach(function (dataset) {
                        //console.log(JSON.stringify(dataset));
                        dataset.points.forEach(function (points) {

                            if(dataset.label == "pages"){
                                page_ctx.fillStyle = "rgba(24, 106, 59,1)";
                                //page_ctx.translate( points.x,  points.y);
                                //page_ctx.rotate(90);
                                //page_ctx.translate(x,300);
                                page_ctx.save();
                                page_ctx.translate( points.x + 8, points.y-8);
                                page_ctx.rotate(-Math.PI / 2 );

                                page_ctx.textAlign = 'left';
                                //page_ctx.textAlign = 'right';
                                //page_ctx.fillText('right', 0, lineHeight / 2);
                                page_ctx.fillText(numberWithCommas(points.value), 0, 0 );
                                page_ctx.restore();
                            }
                        });
                    })
                }
            });
        }
    </script>

@stop
