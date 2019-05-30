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
                            <select name="type" lay-search>
                            @foreach($brands as $key => $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('car.label.name') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="name" autocomplete="off" placeholder="请输入{{ trans('car.label.name') }}" class="layui-input" value="{{ $car->name }}">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('car.label.price') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="price" autocomplete="off" placeholder="请输入{{ trans('car.label.price') }}" class="layui-input" value="{{ $car->price }}">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('car.label.selling_price') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="selling_price" autocomplete="off" placeholder="请输入{{ trans('car.label.selling_price') }}" class="layui-input" value="{{ $car->selling_price }}">
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
                            <input type="text" name="year" autocomplete="off" placeholder="请输入{{ trans('car.label.year') }}" class="layui-input" value="{{ $car->year }}">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('car.label.production_date') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="production_date" autocomplete="off" placeholder="请输入{{ trans('car.label.production_date') }}" class="layui-input" value="{{ $car->production_date }}">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('car.label.emission_standard') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="emission_standard" autocomplete="off" placeholder="请输入{{ trans('car.label.emission_standard') }}" class="layui-input" value="{{ $car->emission_standard }}">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('car.label.note') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="note" autocomplete="off" placeholder="请输入{{ trans('car.label.note') }}" class="layui-input" value="{{ $car->note }}">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">图片</label>
                        {!! $car->files('image')
                        ->url($car->getUploadUrl('image'))
                        ->uploader()!!}
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">分类</label>
                        <div class="layui-input-block">
                            <input type="checkbox" name="category[full]" class="full_checkbox" title="全款购车" checked lay-filter="full">
                            <input type="checkbox" name="category[instalment]" class="instalment_checkbox" title="金融分期" lay-filter="instalment">
                            <input type="checkbox" name="category[rent]" class="rent_checkbox" title="以租代售" lay-filter="rent">
                        </div>
                    </div>

                    <div class="layui-form-item" id="instalment" style="display:none;">
                        @foreach($instalment_financial_products as $key => $product)
                        <input type="hidden" name="financial_product_id[]" value="{{ $product->id }}">
                        <fieldset class="layui-elem-field" id="photos">
                            <legend>{{ $product->name }}</legend>

                            <div class="layui-form-item">
                                <label class="layui-form-label">首付：</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="down[]" autocomplete="off" placeholder="首付" class="layui-input" value="">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">比例：</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="ratio[]" autocomplete="off" placeholder="比例" class="layui-input" value="">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">比例：</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="month_installment[]" autocomplete="off" placeholder="月供" class="layui-input" value="">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">比例：</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="periods[]" autocomplete="off" placeholder="期数" class="layui-input" value="">
                                </div>
                            </div>
                        </fieldset>
                        @endforeach
                            @foreach($rent_financial_products as $key => $product)
                                <input type="hidden" name="financial_product_id[]" value="{{ $product->id }}">
                                <fieldset class="layui-elem-field" id="rent">
                                    <legend>{{ $product->name }}</legend>

                                    <div class="layui-form-item">
                                        <label class="layui-form-label">首付：</label>
                                        <div class="layui-input-inline">
                                            <input type="text" name="down[]" autocomplete="off" placeholder="首付" class="layui-input" value="">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">比例：</label>
                                        <div class="layui-input-inline">
                                            <input type="text" name="ratio[]" autocomplete="off" placeholder="比例" class="layui-input" value="">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">比例：</label>
                                        <div class="layui-input-inline">
                                            <input type="text" name="month_installment[]" autocomplete="off" placeholder="月供" class="layui-input" value="">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">比例：</label>
                                        <div class="layui-input-inline">
                                            <input type="text" name="periods[]" autocomplete="off" placeholder="期数" class="layui-input" value="">
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

    layui.use(['jquery','element','table'], function() {
        var table = layui.table;
        var form = layui.form;
        var $ = layui.$;
        form.on('checkbox(rent)', function(data){
            if(data.elem.checked)
            {
                $(".full_checkbox").prop('checked',false);
                $(".instalment_checkbox").prop('checked',false);
                $("#instalment").hide();
                $("#full").hide();
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
            }
            form.render();
        });


    });
</script>