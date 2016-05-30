@extends('ekarat')

@section('css')
    <link href="{{ asset(env('ASSET_PATH')).'/'}}css/plugins/jQueryUI/jquery-ui-1.10.4.custom.min.css" rel="stylesheet">
    <link href="{{ asset(env('ASSET_PATH')).'/'}}css/plugins/jqGrid/ui.jqgrid.css" rel="stylesheet">
    <link href="{{ asset(env('ASSET_PATH')).'/'}}css/plugins/chosen/chosen.css" rel="stylesheet">

@stop

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">

                <div class="ibox float-e-margins" id="basic_srh">
                    <div class="ibox-title">
                        <h5>ค้นหา </h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                            &nbsp;
                            <button class="btn btn-xs btn-success" type="button" id="adv_srh_btn">อย่างละเอียด</button>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-xs-4">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        รหัสแฟ้ม
                                    </div>
                                    <div class="panel-body">
                                        <input type="text" id="search_file" placeholder="รหัสแฟ้ม" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        หมายเลขแบบ
                                    </div>
                                    <div class="panel-body">
                                        <input type="text" id="search_dwg" placeholder="หมายเลขแบบ" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        S/O
                                    </div>
                                    <div class="panel-body">
                                        <input type="text" id="search_so" placeholder="หมายเลข S/O" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ibox float-e-margins" id="adv_srh">
                    <div class="ibox-title">
                        <h5>ค้นหา  - อย่างละเอียด</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-down"></i>
                            </a>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                            &nbsp;
                            <button class="btn btn-xs btn-info" type="button" id="bas_srh_btn">อย่างง่าย</button>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="font-noraml">KVA</label>
                                    <div class="input-group">
                                        <select  class="chosen-select" style="width:150px;" id="kva">
                                            <option value="">&nbsp;</option>
                                                @foreach ($option['kva'] as $item)
                                                    <option value="{{ $item->KVA }}">{{ $item->KVA }}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="font-noraml">TYPE</label>
                                    <div class="input-group">
                                        <select class="chosen-select" style="width:150px;" id="type">
                                            <option value="">&nbsp;</option>
                                            @foreach ($option['type'] as $item)
                                                <option value="{{ $item->TYPE }}">{{ $item->TYPE }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="font-noraml">PH</label>
                                    <div class="input-group">
                                        <select class="chosen-select" style="width:150px;" id="ph">
                                            <option value="">&nbsp;</option>
                                            @foreach ($option['ph'] as $item)
                                                <option value="{{ $item->PH }}">{{ $item->PH }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="font-noraml">VECTOR</label>
                                    <div class="input-group">
                                        <select class="chosen-select" style="width:150px;" id="vector">
                                            <option value="">&nbsp;</option>
                                            @foreach ($option['vector'] as $item)
                                                <option value="{{ $item->VECTOR }}">{{ $item->VECTOR }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="font-noraml">VOLT</label>
                                    <div class="input-group">
                                        <select class="chosen-select" style="width:250px;" id="volt">
                                            <option value="">&nbsp;</option>
                                            @foreach ($option['volt'] as $item)
                                                <option value="{{ $item->VOLT }}">{{ $item->VOLT }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label class="font-noraml"></label>
                                    <div class="input-group">
                                        <button class="btn btn-primary" type="button" id="asrh_btn">ค้นหา</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>รายการแบบสั่งงาน</h5>
                    </div>
                    <div class="ibox-content">


                        <div class="jqGrid_wrapper">
                            <table id="grid-table"></table>
                            <div id="grid-pager"></div>
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

    <!-- jqGrid -->
    <script src="{{ asset(env('ASSET_PATH')).'/'}}js/plugins/jqGrid/i18n/grid.locale-en.js"></script>
    <script src="{{ asset(env('ASSET_PATH')).'/'}}js/plugins/jqGrid/jqgrid.src.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset(env('ASSET_PATH').'/js/inspinia.js') }}"></script>
    <script src="{{ asset(env('ASSET_PATH').'/js/plugins/pace/pace.min.js') }}"></script>
    <!-- jQuery UI -->
    <script src="{{ asset(env('ASSET_PATH')).'/'}}js/plugins/jquery-ui/jquery-ui.min.js"></script>

    <!-- Chosen -->
    <script src="{{ asset(env('ASSET_PATH')).'/'}}js/plugins/chosen/chosen.jquery.js"></script>


    <script type="text/javascript">
        var config = {
            '.chosen-select'           : {},
            '.chosen-select-deselect'  : {allow_single_deselect:true},
            '.chosen-select-no-single' : {disable_search_threshold:10},
            '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
            '.chosen-select-width'     : {width:"95%"}
        }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }
    </script>


    <script type="text/javascript">
        $.ajaxSetup({
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
        });
    </script>

    <script>
        $(document).ready(function () {
            $("#adv_srh").hide();
            $("#adv_srh_btn").click(function(){
                $("#basic_srh").fadeOut(700,function(){
                    $("#adv_srh").fadeIn(700);
                });
            });
            $("#bas_srh_btn").click(function(){
                $("#adv_srh").fadeOut(700,function(){
                    $("#basic_srh").fadeIn(700);
                });
            });

            $("#asrh_btn").click(function(){
                //doSearch("volt","VOLT");
                //alert($("#volt").chosen().val());
                $volt = $("#volt").chosen().val();
                $type = $("#type").chosen().val();
                $ph = $("#ph").chosen().val();
                $vector = $("#vector").chosen().val();
                $kva = $("#kva").chosen().val();
                $search = "en_scan_search_feed?&asearch=YES&type="+$type+"&kva="+$kva+"&volt="+$volt+"&ph="+$ph+"&vector="+$vector;
                //alert($search);
                jQuery(grid_selector).jqGrid('setGridParam',{url:$search,page:1}).trigger("reloadGrid");
            });

            var grid_selector = "#grid-table";
            var pager_selector = "#grid-pager";


            // Configuration for jqGrid Example 1
            jQuery(grid_selector).jqGrid({
                subGrid : true,
                subGridOptions : {
                    hasSubgrid: function (options) {
                        return (options.data.Scan == "Yes");
                    },
//                    plusicon : "fa fa-plus center bigger-110 blue",
//                    minusicon  : "fa fa-minus center bigger-110 blue",
//                    openicon : "fa fa-chevron-right center orange"
                    "plusicon"  : "ui-icon-triangle-1-e",
                    "minusicon" : "ui-icon-triangle-1-s",
                    "openicon"  : "ui-icon-arrowreturn-1-e"
                },
                //for this example we are using local data
                subGridRowExpanded: function (subgridDivId, rowId) {
                    var subgridTableId = subgridDivId + "_t";
                    $("#" + subgridDivId).html("<table id='" + subgridTableId + "'></table>");
                    $("#" + subgridTableId).jqGrid({
                        //url:'priest/priest_list_master.php?q=ps_sub&id='+rowId,
                        url:'en_scan_search_feed?q=sub&id='+rowId,
                        datatype: "json",
                        height: '100%',
                        colNames: ['รหัสเอกสาร','บทที่','รายการ','ดาวน์โหลด'],
                        colModel: [
                            { name: 'doc', width: 80 , align:"center"},
                            { name: 'chapter', width: 50 , align:"center"},
                            { name: 'chapter_name', width: 300, align:"center" },
                            { name: 'download', width: 110, align:"center" }
                        ]
                    });
                },



//        data: grid_data,
//        datatype: "local",
                url:'en_scan_search_feed',
                datatype: "json",
                height: '100%',
                //colNames:[' ', 'ID','Last Sales','Name', 'Stock', 'Ship via','Notes'],
                colNames:['DESIGN','FILE','TYPE', 'KVA', 'PH','VECTOR','VOLT','REMARK','SO','Scan'],
                colModel:[
//            {name:'id',index:'id', width:60, sorttype:"int", editable: true},
//            {name:'sdate',index:'sdate',width:90, editable:true, sorttype:"date",unformat: pickDate},
//            {name:'name',index:'name', width:150,editable: true,editoptions:{size:"20",maxlength:"30"}},
//            {name:'stock',index:'stock', width:70, editable: true,edittype:"checkbox",editoptions: {value:"Yes:No"},unformat: aceSwitch},
//            {name:'ship',index:'ship', width:90, editable: true,edittype:"select",editoptions:{value:"FE:FedEx;IN:InTime;TN:TNT;AR:ARAMEX"}},
//            {name:'note',index:'note', width:150, sortable:false,editable: true,edittype:"textarea", editoptions:{rows:"2",cols:"10"}}
                    {name:'DESIGN',index:'DESIGN', width:100, align:"center"},
                    {name:'FILE',index:'FILE', width:80, align:"center"},
                    {name:'TYPE',index:'TYPE', width:60, align:"center"},
                    {name:'KVA',index:'KVA', width:80, align:"center"},
                    {name:'PH',index:'PH', width:60, align:"center"},
                    {name:'VECTOR',index:'VECTOR', width:60, align:"center"},
                    {name:'VOLT',index:'VOLT', width:150, align:"center"},
                    {name:'REMARK',index:'REMARK', width:200, align:"center"},
                    {name:'SO',index:'SO', width:100, align:"center"},
                    {name:'Scan', width:50, align:"center"}
                ],

                viewrecords : true,
                rowNum:10,
                rowList:[10,20,30],
                pager : pager_selector,
                altRows: true,
                //toppager: true,
                sortname: 'up_dt',
                sortorder: "desc",
                multiselect: false,
                //multikey: "ctrlKey",
                multiboxonly: true

            });

            $( "#search_file" ).keydown(function(e) {
                if(e.which == 13) {
                    doSearch("search_file","FILE");
                }
            });
            $( "#search_dwg" ).keydown(function(e) {
                if(e.which == 13) {
                    doSearch("search_dwg","DESIGN");
                }
            });
            $( "#search_so" ).keydown(function(e) {
                if(e.which == 13) {
                    doSearch("search_so","SO");
                }
            });
            var timeoutHnd;
            var flAuto = true;
            function doSearch(input,type){
                if(!flAuto)
                    return;
                if(timeoutHnd)
                    clearTimeout(timeoutHnd)
                timeoutHnd = setTimeout(gridReload(input,type),500)
            }
            function gridReload(input,type){
                var search_item = $('#'+input).val();
                //search_item = input + "=" + search_item;
                //alert(search_item);
                //jQuery(grid_selector).jqGrid('setGridParam',{url:"en_scan_search_feed?&"+encodeURIComponent(search_item),page:1}).trigger("reloadGrid");
                jQuery(grid_selector).jqGrid('setGridParam',{url:"en_scan_search_feed?&search="+(search_item)+"&type="+type,page:1}).trigger("reloadGrid");
            }
            // Add responsive to jqGrid
            $(window).bind('resize', function () {
                var width = $('.jqGrid_wrapper').width();
                $('#table_list_1').setGridWidth(width);
                $('#table_list_2').setGridWidth(width);
            });
        });

    </script>

@stop
