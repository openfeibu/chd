<div class="main">
    <div class="layui-card fb-minNav">
        <div class="layui-breadcrumb" lay-filter="breadcrumb" style="visibility: visible;">
            <a href="{{ guard_url('home') }}">主页</a><span lay-separator="">/</span>
            <a><cite>{{ trans('car.name') }}详情</cite></a>
        </div>
    </div>
    <div class="main_full">
        <div class="layui-col-md12">
            {!! Theme::partial('message') !!}
            <div class="fb-main-table">
                <form class="layui-form" action="{{guard_url('car')}}" method="post" method="post" lay-filter="fb-form">
                    
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('brand.name') }}</label>

                        <div class="layui-input-inline">
                            <select name="type" lay-search lay-filter="brand_id" lay-verify="required" >
                                <option value="0">请选择品牌</option>
                                @foreach($brands as $key => $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('car.label.name') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="name" autocomplete="off" placeholder="请输入{{ trans('car.label.name') }}" class="layui-input" value="{{ $car->name }}" lay-verify="required">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">外观</label>
                        <div class="layui-input-block label_content">
                            <div class="label-selected">
                                <input type="text" name="labelName" class="labelName" placeholder="输入颜色，回车键确认输入">
                                <input type="hidden" name="shade_color" class="label">
                            </div>
                            <div class="layui-col-md12" id="labelItem">
                                <!--标签库-->
                                <div class="label-item shade-color-item">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">内饰</label>
                        <div class="layui-input-block label_content">
                            <div class="label-selected">
                                <input type="text" name="labelName" class="labelName" placeholder="输入颜色，回车键确认输入">
                                <input type="hidden" name="interior_color" class="label">
                            </div>
                            <div class="layui-col-md12" id="labelItem">
                                <!--标签库-->
                                <div class="label-item interior-color-item">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('car.label.price') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="price" autocomplete="off" placeholder="请输入{{ trans('car.label.price') }}" class="layui-input" value="{{ $car->price }}" lay-verify="required">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('car.label.selling_price') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="selling_price" autocomplete="off" placeholder="请输入{{ trans('car.label.selling_price') }}" class="layui-input" value="{{ $car->selling_price }}" lay-verify="required">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('car.label.commercial_insurance_price') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="commercial_insurance_price" autocomplete="off" placeholder="请输入{{ trans('car.label.commercial_insurance_price') }}" class="layui-input" value="{{ $car->commercial_insurance_price }}">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('car.label.year') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="year" autocomplete="off" placeholder="请输入{{ trans('car.label.year') }}" class="layui-input" value="{{ $car->year }}" id="year">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('car.label.production_date') }}</label>
                        <div class="layui-input-inline">
                            <select class="layui-select" name="production_date">
                            @foreach(config('model.car.car.production_date') as $key => $production_date)
                                <option value="{{ $production_date }}">{{ $production_date }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('car.label.emission_standard') }}</label>
                        <div class="layui-input-inline">
                            <select class="layui-select" name="emission_standard">
                            @foreach(config('model.car.car.emission_standard') as $key => $emission_standard)
                                <option value="{{ $emission_standard }}">{{ $emission_standard }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('car.label.note') }}</label>
                        <div class="layui-input-inline">
                            <select class="layui-select" name="note">
                            @foreach(config('model.car.car.note') as $key => $note)
                                <option value="{{ $note }}">{{ $note }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('car.label.content') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="content" autocomplete="off" placeholder="请输入{{ trans('car.label.content') }}" class="layui-input" value="{{ $car->content }}">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">图片</label>
                        {!! $car->files('image',true)
                        ->url($car->getUploadUrl('image'))
                        ->uploaders()!!}
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">首页推荐</label>
                        <input type="checkbox" name="recommend_type[]" value="new" title="新车上架">
                        <input type="checkbox" name="recommend_type[]" value="hot" title="为你推荐">
                        <input type="checkbox" name="recommend_type[]" value="rent" title="以租代售">
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">分类</label>
                        <div class="layui-input-block">
                            <input type="checkbox" name="category[instalment]" class="instalment_checkbox" title="金融分期" lay-filter="instalment"  value="instalment" checked>
                            <input type="checkbox" name="category[full]" class="full_checkbox" title="全款购车"  lay-filter="full" value="full">
                            <input type="checkbox" name="category[rent]" class="rent_checkbox" title="以租代售" lay-filter="rent" value="rent">
                        </div>
                    </div>

                    <div class="layui-form-item" id="instalment">
                        @foreach($instalment_financial_products as $key => $product)
                        <input type="hidden" name="instalment_financial_product_id[]" value="{{ $product->id }}">
                        <fieldset class="layui-elem-field" product-id="{{ $product->id }}">
                            <legend>{{ $product->name }}</legend>
                            <div class="financial_product financial_product_{{ $product->id }}" product-id="{{ $product->id }}">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">首付：</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="instalment_financial_product_down_{{ $product->id }}[]" autocomplete="off" placeholder="首付" class="layui-input" value="">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">比例：</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="instalment_financial_product_ratio_{{ $product->id }}[]" autocomplete="off" placeholder="比例" class="layui-input" value="98">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">月供：</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="instalment_financial_product_month_installment_{{ $product->id }}[]" autocomplete="off" placeholder="月供" class="layui-input" value="">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">期数：</label>
                                    <div class="layui-input-inline">
                                        <select name="instalment_financial_product_periods_{{ $product->id }}[]">
                                            @foreach(config('common.periods') as $key => $periods)
                                                <option value="{{ $periods }}" >{{ $periods }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <div class="layui-input-inline">
                                    <i class="handle_count add layui-icon layui-icon-add-circle-fine"></i>
                                    <i class="handle_count delete layui-icon layui-icon-close-fill"></i>
                                </div>
                            </div>
                        </fieldset>
                        @endforeach
                    </div>
                    <div class="layui-form-item" id="rent" style="display:none;">
                        @foreach($rent_financial_products as $key => $product)
                            <input type="hidden" name="rent_financial_product_id[]" value="{{ $product->id }}">
                            <fieldset class="layui-elem-field" product-id="{{ $product->id }}">
                                <legend>{{ $product->name }}</legend>
                                <div class="financial_product financial_product_{{ $product->id }}" product-id="{{ $product->id }}">
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">首付：</label>
                                        <div class="layui-input-inline">
                                            <input type="text" name="rent_financial_product_down_{{ $product->id }}[]" autocomplete="off" placeholder="首付" class="layui-input" value="">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">比例：</label>
                                        <div class="layui-input-inline">
                                            <input type="text" name="rent_financial_product_ratio_{{ $product->id }}[]" autocomplete="off" placeholder="比例" class="layui-input" value="98">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">月供：</label>
                                        <div class="layui-input-inline">
                                            <input type="text" name="rent_financial_product_month_installment_{{ $product->id }}[]" autocomplete="off" placeholder="月供" class="layui-input" value="">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">期数：</label>
                                        <div class="layui-input-inline">
                                            <select name="rent_financial_product_periods_{{ $product->id }}[]">
                                                @foreach(config('common.periods') as $key => $periods)
                                                    <option value="{{ $periods }}" >{{ $periods }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <div class="layui-input-inline">
                                        <i class="handle_count add layui-icon layui-icon-add-circle-fine"></i>
                                        <i class="handle_count delete layui-icon layui-icon-close-fill"></i>
                                    </div>
                                </div>
                            </fieldset>
                        @endforeach
                    </div>


                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
                        </div>
                    </div>
                    {!!Form::token()!!}
                </form>
            </div>

        </div>
    </div>
</div>
{!! Theme::asset()->container('ueditor')->scripts() !!}
<script>

    layui.use(['jquery','element','table','laydate'], function() {
        var table = layui.table;
        var form = layui.form;
        var $ = layui.$;
        form.render();
        var laydate = layui.laydate;

        //执行一个laydate实例
        laydate.render({
            elem: '#year' //指定元素
            ,type: 'year'
        });
        form.on('checkbox(rent)', function(data){
            if(data.elem.checked)
            {
                $(".full_checkbox").prop('checked',false);
                $(".instalment_checkbox").prop('checked',false);
                $("#instalment").hide();
                $("#full").hide();
                $("#rent").show();
            }else{
                $("#rent").hide();
            }
            form.render();
        });
        form.on('checkbox(full)', function(data){
            if(data.elem.checked)
            {
                $(".rent_checkbox").prop('checked',false);
                $("#rent").hide();
            }
            form.render();
        });
        form.on('checkbox(instalment)', function(data){
            if(data.elem.checked)
            {
                $(".rent_checkbox").prop('checked',false);
                $("#instalment").show();
                $("#rent").hide();
            }else{
                $("#instalment").hide();
            }
            form.render();
        });
        form.on('select(brand_id)', function(data){
            if(data.value)
            {
                var load = layer.load();
                var shade_html = "";
                var interior_html = "";
                $.ajax({
                    url : "{{ guard_url('brandColors') }}",
                    data : {'brand_id':data.value,'_token':"{!! csrf_token() !!}"},
                    type : 'get',
                    success : function (data) {
                        layer.close(load);
                        var brand_shade_colors = data.data.brand_shade_colors;
                        $.each(brand_shade_colors, function(i, val) {
                            shade_html += "<li data='"+val.name+"'><span>"+val.name+"</span></li>";
                        });
                        $(".shade-color-item").html(shade_html);
                        var brand_interior_colors = data.data.brand_interior_colors;
                        $.each(brand_interior_colors, function(i, val) {
                            interior_html += "<li data='"+val.name+"'><span>"+val.name+"</span></li>";
                        });
                        $(".interior-color-item").html(interior_html);
                    },
                    error : function (jqXHR, textStatus, errorThrown) {
                        layer.close(load);
                        layer.msg('服务器出错');
                    }
                });
            }
            form.render();
        });
        $(".handle_count").click(function(){
            var product_id = $(this).parents("fieldset").attr('product-id');
            var count = $(".financial_product_"+product_id).length;

            if($(this).hasClass('add'))
            {
                var html = "<div class='financial_product financial_product_"+product_id+"'>" +$(".financial_product_"+product_id).first().html()+"</div>" ;
                $(".financial_product_"+product_id).last().after(html);
            }
            if($(this).hasClass('delete'))
            {
                if(count >=2)
                {
                    $(".financial_product_"+product_id).last().remove();
                }
            }
            form.render();
        });
        $(".labelName").bind('keypress',function(event){
            var parent = $(this).parents(".label_content");
            if (event.keyCode == 13) {
                var text = $(this).val();
                if (text.length == 0) {
                    return false;
                }
                var labelHTML = "<li data='" + text + "''>x " + text + "</li>";
                parent.find(".label-selected").prepend(labelHTML);
                val = '';
                for (var i = 0; i < parent.find(".label-selected").children("li").length; i++) {
                    val += parent.find(".label-selected").children("li").eq(i).attr("data") + ',';
                }
                parent.find(".label").val(val);
                $(this).val("")
                return false;
            }

        });
        $(".label-item").on("click", "li", function() {
            var parent = $(this).parents(".label_content");
            var id = $(this).attr("data");
            var text = $(this).children("span").html();
            var labelHTML = "<li data='" + text + "'>x " + text + "</li>";
            if ($(this).hasClass("selected")) {
                return false;
            }
            parent.find(".label-selected").prepend(labelHTML);
            val = '';
            for (var i = 0; i < parent.find(".label-selected").children("li").length; i++) {
                val += parent.find(".label-selected").children("li").eq(i).attr("data") + ',';
            }
            parent.find(".label").val(val);
            $(this).addClass("selected");
        });
        var val = "";
        $(".label-selected").on("click", "li", function() {
            var parent = $(this).parents(".label_content");
            var id = $(this).attr("data");
            val = '';
            $(this).remove();
            for (var i = 0; i < $(this).children("li").length; i++) {
                val += $(this).children("li").eq(i).attr("data") + ',';
            }
            parent.find("input[name='label']").val(val);
            parent.find(".label-item").find("li[data='" + id + "']").removeClass("selected");
        });

    });
</script>