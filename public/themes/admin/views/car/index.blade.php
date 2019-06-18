<div class="main">
    <div class="layui-card fb-minNav">
        <div class="layui-breadcrumb" lay-filter="breadcrumb" style="visibility: visible;">
            <a href="{{ guard_url('home') }}">主页</a><span lay-separator="">/</span>
            <a><cite>{{ trans('car.name') }}管理</cite></a>
        </div>
    </div>
    <div class="main_full">
        <div class="layui-col-md12">
            <div class="tabel-message layui-form">
                <div class="layui-inline tabel-btn">
                    <button class="layui-btn layui-btn-warm "><a href="{{ guard_url('car/create') }}">添加{{ trans('car.name') }}</a></button>
                    <button class="layui-btn layui-btn-primary " data-type="del" data-events="del">删除</button>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">分类</label>
                    <div class="layui-input-block">
                        <select name="category" class="search_key">
                            <option value="">全部</option>
                            <option value="full">全款购车</option>
                            <option value="instalment">金融分期</option>
                            <option value="rent">以租代售</option>
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">首页推荐</label>
                    <div class="layui-input-block">
                        <select name="recommend_type" class="search_key">
                            <option value="">全部</option>
                            <option value="new">新车上架</option>
                            <option value="hot">为你推荐</option>
                            <option value="rent">以租代售</option>
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <input class="layui-input search_key" name="search_name" id="demoReload" placeholder="车名" autocomplete="off">
                </div>
                <div class="layui-inline">
                    <button class="layui-btn" data-type="reload">搜索</button>
                </div>
            </div>

            <table id="fb-table" class="layui-table"  lay-filter="fb-table">

            </table>
        </div>
    </div>
</div>

<script type="text/html" id="barDemo">
    <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
</script>
<script type="text/html" id="imageTEM">
    <img src="@{{d.image}}" alt="" height="28">
</script>

<script>
    var main_url = "{{guard_url('car')}}";
    var update_field_url = "{{guard_url('car/updateField')}}";
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
                ,{field:'name',title:"{{ trans('car.label.name') }}",edit:'text'}
                ,{field:'brand_name',title:"{{ trans('brand.name') }}",edit:'text'}
                ,{field:'price',title:"{{ trans('car.label.price') }}",edit:'text'}
                ,{field:'commercial_insurance_price',title:"{{ trans('car.label.commercial_insurance_price') }}",edit:'text'}
                ,{field:'selling_price',title:"{{ trans('car.label.selling_price') }}",edit:'text'}
                ,{field:'year',title:"{{ trans('car.label.year') }}",edit:'text'}
                ,{field:'production_date',title:"{{ trans('car.label.production_date') }}",edit:'text'}
                ,{field:'emission_standard',title:"{{ trans('car.label.emission_standard') }}",edit:'text'}
                ,{field:'note',title:"{{ trans('car.label.note') }}",edit:'text'}
                ,{field:'score',title:'操作', width:150, align: 'right',toolbar:'#barDemo'}
            ]]
            ,id: 'fb-table'
            ,page: true
            ,limit: 10
            ,height: 'full-200'
        });


    });
</script>
{!! Theme::partial('common_handle_js') !!}