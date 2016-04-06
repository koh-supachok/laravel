@extends('ekarat')

@section('css')
<link href="{{ asset(env('ASSET_PATH')).'/'}}css/plugins/jqGrid/ui.jqgrid.css" rel="stylesheet">
<link href="{{ asset(env('ASSET_PATH')).'/'}}css/plugins/chosen/chosen.css" rel="stylesheet">

@stop

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">

                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Chosen select <small>http://harvesthq.github.io/chosen/</small></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        รหัสแฟ้ม
                                    </div>
                                    <div class="panel-body">
                                        <input type="text" id="search_file" placeholder="รหัสแฟ้ม" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        หมายเลขแบบ
                                    </div>
                                    <div class="panel-body">
                                        <input type="text" id="search_dwg" placeholder="หมายเลขแบบ" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
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

            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>jQuery Grid Plugin – jqGrid</h5>
                    </div>
                    <div class="ibox-content">

                        <h4>Basic example</h4>

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
        $.ajaxSetup({
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
        });
    </script>

    <script type="text/javascript">
        jQuery(function($) {
            var grid_selector = "#grid-table";
            var pager_selector = "#grid-pager";

            //resize to fit page size
            $(window).on('resize.jqGrid', function () {
                $(grid_selector).jqGrid( 'setGridWidth', $(".page-content").width() );
            })
            //resize on sidebar collapse/expand
            var parent_column = $(grid_selector).closest('[class*="col-"]');
            $(document).on('settings.ace.jqGrid' , function(ev, event_name, collapsed) {
                if( event_name === 'sidebar_collapsed' || event_name === 'main_container_fixed' ) {
                    //setTimeout is for webkit only to give time for DOM changes and then redraw!!!
                    setTimeout(function() {
                        $(grid_selector).jqGrid( 'setGridWidth', parent_column.width() );
                    }, 0);
                }
            })

            jQuery(grid_selector).jqGrid({
                //subgrid options
                subGrid : true,
                subGridOptions : {
                    hasSubgrid: function (options) {
                        return (options.data.Scan == "Yes");
                    },
                    plusicon : "ace-icon fa fa-plus center bigger-110 blue",
                    minusicon  : "ace-icon fa fa-minus center bigger-110 blue",
                    openicon : "ace-icon fa fa-chevron-right center orange"
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
                height: 541,
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
                multiboxonly: true,
                loadComplete : function() {
                    var table = this;
//                    setTimeout(function(){
//                        styleCheckbox(table);
//
//                        updateActionIcons(table);
//                        updatePagerIcons(table);
//                        enableTooltips(table);
//
//                    }, 0);
//                    var ids = jQuery("#grid-table").jqGrid('getDataIDs');
//                    for(var i=0;i < ids.length;i++){
//                        var cl = ids[i];
//                        be = "<a href=\"?pagetype=priest&subtype=priest_profile&ps_id="+cl+"\" class=\"btn btn-link\"><i class=\"ace-icon fa fa-pencil-square-o bigger-120 icon-only\"></i></a>";
//                        jQuery("#grid-table").jqGrid('setRowData',ids[i],{act:be});
//                    }
                },

                //editurl: "/dummy.html"//nothing is saved
                //caption: "ข้อมูลพระสมนศักดิ์"

                //,autowidth: true,


                /**
                 ,
                 grouping:true,
                 groupingView : {
						 groupField : ['name'],
						 groupDataSorted : true,
						 plusicon : 'fa fa-chevron-down bigger-110',
						 minusicon : 'fa fa-chevron-up bigger-110'
					},
                 caption: "Grouping"
                 */

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

            $(window).triggerHandler('resize.jqGrid');//trigger window resize to make the grid get the correct size



            //switch element when editing inline
            function aceSwitch( cellvalue, options, cell ) {
                setTimeout(function(){
                    $(cell) .find('input[type=checkbox]')
                            .addClass('ace ace-switch ace-switch-5')
                            .after('<span class="lbl"></span>');
                }, 0);
            }
            //enable datepicker
            function pickDate( cellvalue, options, cell ) {
                setTimeout(function(){
                    $(cell) .find('input[type=text]')
                            .datepicker({format:'yyyy-mm-dd' , autoclose:true});
                }, 0);
            }


            //navButtons
            jQuery(grid_selector).jqGrid('navGrid',pager_selector,
                    { 	//navbar options
                        edit: false,
                        editicon : 'ace-icon fa fa-pencil blue',
                        add: false,
                        addicon : 'ace-icon fa fa-plus-circle purple',
                        del: false,
                        delicon : 'ace-icon fa fa-trash-o red',
                        search: false,
                        searchicon : 'ace-icon fa fa-search orange',
                        refresh: false,
                        refreshicon : 'ace-icon fa fa-refresh green',
                        view: false,
                        viewicon : 'ace-icon fa fa-search-plus grey'
                    },
                    {
                        //edit record form
                        //closeAfterEdit: true,
                        //width: 700,
                        recreateForm: false,
                        beforeShowForm : function(e) {
                            var form = $(e[0]);
                            form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
                            style_edit_form(form);
                        }
                    },
                    {
                        //new record form
                        //width: 700,
                        closeAfterAdd: true,
                        recreateForm: true,
                        viewPagerButtons: false,
                        beforeShowForm : function(e) {
                            var form = $(e[0]);
                            form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar')
                                    .wrapInner('<div class="widget-header" />')
                            style_edit_form(form);
                        }
                    },
                    {
                        //delete record form
                        recreateForm: true,
                        beforeShowForm : function(e) {
                            var form = $(e[0]);
                            if(form.data('styled')) return false;

                            form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
                            style_delete_form(form);

                            form.data('styled', true);
                        },
                        onClick : function(e) {
                            //alert(1);
                        }
                    },
                    {
                        //search form
                        recreateForm: true,
                        afterShowSearch: function(e){
                            var form = $(e[0]);
                            form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
                            style_search_form(form);
                        },
                        afterRedraw: function(){
                            style_search_filters($(this));
                        }
                        ,
                        multipleSearch: true,
                        /**
                         multipleGroup:true,
                         showQuery: true
                         */
                    },
                    {
                        //view record form
                        recreateForm: true,
                        beforeShowForm: function(e){
                            var form = $(e[0]);
                            form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
                        }
                    }
            )



            function style_edit_form(form) {
                //enable datepicker on "sdate" field and switches for "stock" field
                form.find('input[name=sdate]').datepicker({format:'yyyy-mm-dd' , autoclose:true})

                form.find('input[name=stock]').addClass('ace ace-switch ace-switch-5').after('<span class="lbl"></span>');
                //don't wrap inside a label element, the checkbox value won't be submitted (POST'ed)
                //.addClass('ace ace-switch ace-switch-5').wrap('<label class="inline" />').after('<span class="lbl"></span>');


                //update buttons classes
                var buttons = form.next().find('.EditButton .fm-button');
                buttons.addClass('btn btn-sm').find('[class*="-icon"]').hide();//ui-icon, s-icon
                buttons.eq(0).addClass('btn-primary').prepend('<i class="ace-icon fa fa-check"></i>');
                buttons.eq(1).prepend('<i class="ace-icon fa fa-times"></i>')

                buttons = form.next().find('.navButton a');
                buttons.find('.ui-icon').hide();
                buttons.eq(0).append('<i class="ace-icon fa fa-chevron-left"></i>');
                buttons.eq(1).append('<i class="ace-icon fa fa-chevron-right"></i>');
            }

            function style_delete_form(form) {
                var buttons = form.next().find('.EditButton .fm-button');
                buttons.addClass('btn btn-sm btn-white btn-round').find('[class*="-icon"]').hide();//ui-icon, s-icon
                buttons.eq(0).addClass('btn-danger').prepend('<i class="ace-icon fa fa-trash-o"></i>');
                buttons.eq(1).addClass('btn-default').prepend('<i class="ace-icon fa fa-times"></i>')
            }

            function style_search_filters(form) {
                form.find('.delete-rule').val('X');
                form.find('.add-rule').addClass('btn btn-xs btn-primary');
                form.find('.add-group').addClass('btn btn-xs btn-success');
                form.find('.delete-group').addClass('btn btn-xs btn-danger');
            }
            function style_search_form(form) {
                var dialog = form.closest('.ui-jqdialog');
                var buttons = dialog.find('.EditTable')
                buttons.find('.EditButton a[id*="_reset"]').addClass('btn btn-sm btn-info').find('.ui-icon').attr('class', 'ace-icon fa fa-retweet');
                buttons.find('.EditButton a[id*="_query"]').addClass('btn btn-sm btn-inverse').find('.ui-icon').attr('class', 'ace-icon fa fa-comment-o');
                buttons.find('.EditButton a[id*="_search"]').addClass('btn btn-sm btn-purple').find('.ui-icon').attr('class', 'ace-icon fa fa-search');
            }

            function beforeDeleteCallback(e) {
                var form = $(e[0]);
                if(form.data('styled')) return false;

                form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
                style_delete_form(form);

                form.data('styled', true);
            }

            function beforeEditCallback(e) {
//        var form = $(e[0]);
//        form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
//        style_edit_form(form);
                alert("fddss");
                window.location.replace("?pagetype=priest&subtype=priest_list");
            }



            //it causes some flicker when reloading or navigating grid
            //it may be possible to have some custom formatter to do this as the grid is being created to prevent this
            //or go back to default browser checkbox styles for the grid
            function styleCheckbox(table) {
                /**
                 $(table).find('input:checkbox').addClass('ace')
                 .wrap('<label />')
                 .after('<span class="lbl align-top" />')


                 $('.ui-jqgrid-labels th[id*="_cb"]:first-child')
                 .find('input.cbox[type=checkbox]').addClass('ace')
                 .wrap('<label />').after('<span class="lbl align-top" />');
                 */
            }


            //unlike navButtons icons, action icons in rows seem to be hard-coded
            //you can change them like this in here if you want
            function updateActionIcons(table) {
                /**
                 var replacement =
                 {
                     'ui-ace-icon fa fa-pencil' : 'ace-icon fa fa-pencil blue',
                     'ui-ace-icon fa fa-trash-o' : 'ace-icon fa fa-trash-o red',
                     'ui-icon-disk' : 'ace-icon fa fa-check green',
                     'ui-icon-cancel' : 'ace-icon fa fa-times red'
                 };
                 $(table).find('.ui-pg-div span.ui-icon').each(function(){
						var icon = $(this);
						var $class = $.trim(icon.attr('class').replace('ui-icon', ''));
						if($class in replacement) icon.attr('class', 'ui-icon '+replacement[$class]);
					})
                 */
            }

            //replace icons with FontAwesome icons like above
            function updatePagerIcons(table) {
                var replacement =
                {
                    'ui-icon-seek-first' : 'ace-icon fa fa-angle-double-left bigger-140',
                    'ui-icon-seek-prev' : 'ace-icon fa fa-angle-left bigger-140',
                    'ui-icon-seek-next' : 'ace-icon fa fa-angle-right bigger-140',
                    'ui-icon-seek-end' : 'ace-icon fa fa-angle-double-right bigger-140'
                };
                $('.ui-pg-table:not(.navtable) > tbody > tr > .ui-pg-button > .ui-icon').each(function(){
                    var icon = $(this);
                    var $class = $.trim(icon.attr('class').replace('ui-icon', ''));

                    if($class in replacement) icon.attr('class', 'ui-icon '+replacement[$class]);
                })
            }

            function enableTooltips(table) {
                $('.navtable .ui-pg-button').tooltip({container:'body'});
                $(table).find('.ui-pg-div').tooltip({container:'body'});
            }

            //var selr = jQuery(grid_selector).jqGrid('getGridParam','selrow');

            $(document).one('ajaxloadstart.page', function(e) {
                $(grid_selector).jqGrid('GridUnload');
                $('.ui-jqdialog').remove();
            });
        });

        function wordExport(){
            //       alert("On process... W"+$("#search_item").val());
            window.open('priest/priest_list_word.php?search='+$("#search_item").val());
        }
        function excelExport(){
//        alert("ยังไม่สามารถใช้งานได้"+search_item);
            window.open('priest/priest_list_excel.php?search='+$("#search_item").val());
        }
        function pdfExport(){
//        alert("On process... P"+search_item);
            window.open('priest/priest_list_pdf.php?search='+$("#search_item").val());
        }
    </script>

    <script>
        $(document).ready(function () {

            // Examle data for jqGrid
            var mydata = [
                {id: "1", invdate: "2010-05-24", name: "test", note: "note", tax: "10.00", total: "2111.00"} ,
                {id: "2", invdate: "2010-05-25", name: "test2", note: "note2", tax: "20.00", total: "320.00"},
                {id: "3", invdate: "2007-09-01", name: "test3", note: "note3", tax: "30.00", total: "430.00"},
                {id: "4", invdate: "2007-10-04", name: "test", note: "note", tax: "10.00", total: "210.00"},
                {id: "5", invdate: "2007-10-05", name: "test2", note: "note2", tax: "20.00", total: "320.00"},
                {id: "6", invdate: "2007-09-06", name: "test3", note: "note3", tax: "30.00", total: "430.00"},
                {id: "7", invdate: "2007-10-04", name: "test", note: "note", tax: "10.00", total: "210.00"},
                {id: "8", invdate: "2007-10-03", name: "test2", note: "note2", amount: "300.00", tax: "21.00", total: "320.00"},
                {id: "9", invdate: "2007-09-01", name: "test3", note: "note3", amount: "400.00", tax: "30.00", total: "430.00"},
                {id: "11", invdate: "2007-10-01", name: "test", note: "note", amount: "200.00", tax: "10.00", total: "210.00"},
                {id: "12", invdate: "2007-10-02", name: "test2", note: "note2", amount: "300.00", tax: "20.00", total: "320.00"},
                {id: "13", invdate: "2007-09-01", name: "test3", note: "note3", amount: "400.00", tax: "30.00", total: "430.00"},
                {id: "14", invdate: "2007-10-04", name: "test", note: "note", amount: "200.00", tax: "10.00", total: "210.00"},
                {id: "15", invdate: "2007-10-05", name: "test2", note: "note2", amount: "300.00", tax: "20.00", total: "320.00"},
                {id: "16", invdate: "2007-09-06", name: "test3", note: "note3", amount: "400.00", tax: "30.00", total: "430.00"},
                {id: "17", invdate: "2007-10-04", name: "test", note: "note", amount: "200.00", tax: "10.00", total: "210.00"},
                {id: "18", invdate: "2007-10-03", name: "test2", note: "note2", amount: "300.00", tax: "20.00", total: "320.00"},
                {id: "19", invdate: "2007-09-01", name: "test3", note: "note3", amount: "400.00", tax: "30.00", total: "430.00"},
                {id: "21", invdate: "2007-10-01", name: "test", note: "note", amount: "200.00", tax: "10.00", total: "210.00"},
                {id: "22", invdate: "2007-10-02", name: "test2", note: "note2", amount: "300.00", tax: "20.00", total: "320.00"},
                {id: "23", invdate: "2007-09-01", name: "test3", note: "note3", amount: "400.00", tax: "30.00", total: "430.00"},
                {id: "24", invdate: "2007-10-04", name: "test", note: "note", amount: "200.00", tax: "10.00", total: "210.00"},
                {id: "25", invdate: "2007-10-05", name: "test2", note: "note2", amount: "300.00", tax: "20.00", total: "320.00"},
                {id: "26", invdate: "2007-09-06", name: "test3", note: "note3", amount: "400.00", tax: "30.00", total: "430.00"},
                {id: "27", invdate: "2007-10-04", name: "test", note: "note", amount: "200.00", tax: "10.00", total: "210.00"},
                {id: "28", invdate: "2007-10-03", name: "test2", note: "note2", amount: "300.00", tax: "20.00", total: "320.00"},
                {id: "29", invdate: "2007-09-01", name: "test3", note: "note3", amount: "400.00", tax: "30.00", total: "430.00"}
            ];

            // Configuration for jqGrid Example 1
            $("#table_list_1").jqGrid({
                data: mydata,
                datatype: "local",
                height: 250,
                autowidth: true,
                shrinkToFit: true,
                rowNum: 14,
                rowList: [10, 20, 30],
                colNames: ['Inv No', 'Date', 'Client', 'Amount', 'Tax', 'Total', 'Notes'],
                colModel: [
                    {name: 'id', index: 'id', width: 60, sorttype: "int"},
                    {name: 'invdate', index: 'invdate', width: 90, sorttype: "date", formatter: "date"},
                    {name: 'name', index: 'name', width: 100},
                    {name: 'amount', index: 'amount', width: 80, align: "right", sorttype: "float", formatter: "number"},
                    {name: 'tax', index: 'tax', width: 80, align: "right", sorttype: "float"},
                    {name: 'total', index: 'total', width: 80, align: "right", sorttype: "float"},
                    {name: 'note', index: 'note', width: 150, sortable: false}
                ],
                pager: "#pager_list_1",
                viewrecords: true,
                caption: "Example jqGrid 1",
                hidegrid: false
            });

            // Configuration for jqGrid Example 2
            $("#table_list_2").jqGrid({
                data: mydata,
                datatype: "local",
                height: 450,
                autowidth: true,
                shrinkToFit: true,
                rowNum: 20,
                rowList: [10, 20, 30],
                colNames:['Inv No','Date', 'Client', 'Amount','Tax','Total','Notes'],
                colModel:[
                    {name:'id',index:'id', editable: true, width:60, sorttype:"int",search:true},
                    {name:'invdate',index:'invdate', editable: true, width:90, sorttype:"date", formatter:"date"},
                    {name:'name',index:'name', editable: true, width:100},
                    {name:'amount',index:'amount', editable: true, width:80, align:"right",sorttype:"float", formatter:"number"},
                    {name:'tax',index:'tax', editable: true, width:80, align:"right",sorttype:"float"},
                    {name:'total',index:'total', editable: true, width:80,align:"right",sorttype:"float"},
                    {name:'note',index:'note', editable: true, width:100, sortable:false}
                ],
                pager: "#pager_list_2",
                viewrecords: true,
                caption: "Example jqGrid 2",
                add: true,
                edit: true,
                addtext: 'Add',
                edittext: 'Edit',
                hidegrid: false
            });

            // Add selection
            $("#table_list_2").setSelection(4, true);


            // Setup buttons
            $("#table_list_2").jqGrid('navGrid', '#pager_list_2',
                    {edit: true, add: true, del: true, search: true},
                    {height: 200, reloadAfterSubmit: true}
            );

            // Add responsive to jqGrid
            $(window).bind('resize', function () {
                var width = $('.jqGrid_wrapper').width();
                $('#table_list_1').setGridWidth(width);
                $('#table_list_2').setGridWidth(width);
            });
        });

    </script>

    <script>
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

@stop
