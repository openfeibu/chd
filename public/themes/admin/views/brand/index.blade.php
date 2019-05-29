<div class="main">
    <div class="layui-card fb-minNav">
        <div class="layui-breadcrumb" lay-filter="breadcrumb" style="visibility: visible;">
            <a href="{{ guard_url('home') }}">主页</a><span lay-separator="">/</span>
            <a><cite>{{ trans('car.name') }}管理</cite></a>
        </div>
    </div>
    <div class="main_full">
        <div class="layui-col-md12">
            <div class="tabel-message">

            </div>

            <table id="fb-table" class="layui-table"  lay-filter="fb-table">

            </table>
        </div>
    </div>
</div>

<script type="text/html" id="barDemo">
    <a class="layui-btn layui-btn-sm" lay-event="edit">查看详情</a>
</script>
<script type="text/html" id="imageTEM">
    <img src="@{{d.image}}" alt="" height="28">
</script>

<script>
    var main_url = "{{guard_url('car')}}";
    var delete_all_url = "{{guard_url('car/destroyAll')}}";
    layui.use(['jquery','element','table'], function(){
        var table = layui.table;
        var form = layui.form;
        var $ = layui.$;
        table.render({
            elem: '#fb-table'
            ,url: main_url
            ,cols: [[
                {checkbox: true, fixed: true}
                ,{field:'id',title:'ID', width:80, sort: true}
                ,{field:'car_name',title:"{{ trans('car.label.car_name') }}"}
                ,{field:'color',title:"{{ trans('car.label.color') }}"}
                ,{field:'company',title:"{{ trans('car.label.company') }}"}
                ,{field:'linkman',title:"{{ trans('car.label.linkman') }}"}
                ,{field:'phone',title:"{{ trans('car.label.phone') }}"}
                ,{field:'city',title:"{{ trans('car.label.city') }}"}
                ,{field:'buy_type',title:"{{ trans('car.label.buy_type') }}"}
                ,{field:'status_desc',title:"{{ trans('car.label.status_desc') }}"}
                ,{field:'score',title:'操作', width:120, align: 'right',toolbar:'#barDemo'}
            ]]
            ,id: 'fb-table'
            ,page: true
            ,limit: 10
            ,height: 'full-200'
        });


    });
</script>
{!! Theme::partial('common_handle_js') !!}