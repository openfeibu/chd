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
                <form class="layui-form" action="{{guard_url('car/'.$car->id)}}" method="post" method="post" lay-filter="fb-form">
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('brand.name') }}</label>

                        <div class="layui-input-inline">
                            <select name="type" lay-search>
                                @foreach($brands as $key => $brand)
                                    <option value="{{ $brand->id }}" @if($brand->id == $car->type) selected @endif)>{{ $brand->name }}</option>
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
                        <label class="layui-form-label">{{ trans('car.label.content') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="content" autocomplete="off" placeholder="请输入{{ trans('car.label.content') }}" class="layui-input" value="{{ $car->content }}">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">图片</label>
                        {!! $car->files('image')
                        ->url($car->getUploadUrl('image'))
                        ->uploader()!!}
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">推荐</label>
                        <input type="radio" name="recommend_type" value="hot" title="热销" @if($car->recommend_type == 'hot') checked @endif>
                        <input type="radio" name="recommend_type" value="rent" title="以租代售推荐" @if($car->recommend_type == 'rent') checked @endif>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">分类</label>
                        <div class="layui-input-block">
                            <input type="checkbox" name="category[full]" class="full_checkbox" title="全款购车" lay-filter="full" value="full" @if($car->is_full) checked @endif>
                            <input type="checkbox" name="category[instalment]" class="instalment_checkbox" title="金融分期" lay-filter="instalment"  value="instalment" @if($car->is_instalment) checked @endif>
                            <input type="checkbox" name="category[rent]" class="rent_checkbox" title="以租代售" lay-filter="rent" value="rent" @if($car->is_rent) checked @endif>
                        </div>
                    </div>

                    <div class="layui-form-item" id="instalment" @if(!$car->is_instalment) style="display:none;" @endif>
                        @foreach($instalment_financial_products as $key => $product)
                            <input type="hidden" name="instalment_financial_product_id[]" value="{{ $product->id }}">
                            <fieldset class="layui-elem-field" id="photos">
                                <legend>{{ $product->name }}</legend>

                                <div class="layui-form-item">
                                    <label class="layui-form-label">首付：</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="instalment_financial_product_down[]" autocomplete="off" placeholder="首付" class="layui-input" value="{{ $product['down'] }}">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">比例：</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="instalment_financial_product_ratio[]" autocomplete="off" placeholder="比例" class="layui-input" value="{{ $product['ratio'] }}">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">月供：</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="instalment_financial_product_month_installment[]" autocomplete="off" placeholder="月供" class="layui-input" value="{{ $product['month_installment'] }}">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">期数：</label>
                                    <div class="layui-input-inline">
                                        <select name="instalment_financial_product_periods[]">
                                            @foreach(config('common.periods') as $key => $periods)
                                            <option value="{{ $periods }}" @if($product['periods'] == $periods) selected @endif>{{ $periods }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                        @endforeach
                    </div>
                    <div class="layui-form-item" id="rent" @if(!$car->is_rent) style="display:none;" @endif>
                        @foreach($rent_financial_products as $key => $product)
                            <input type="hidden" name="rent_financial_product_id[]" value="{{ $product->id }}">
                            <fieldset class="layui-elem-field" >
                                <legend>{{ $product->name }}</legend>

                                <div class="layui-form-item">
                                    <label class="layui-form-label">首付：</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="rent_financial_product_down[]" autocomplete="off" placeholder="首付" class="layui-input" value="{{ $product['down'] }}">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">比例：</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="rent_financial_product_ratio[]" autocomplete="off" placeholder="比例" class="layui-input" value="{{ $product['ratio'] }}">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">月供：</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="rent_financial_product_month_installment[]" autocomplete="off" placeholder="月供" class="layui-input" value="{{ $product['month_installment'] }}">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">期数：</label>
                                    <div class="layui-input-inline">
                                        <select name="rent_financial_product_periods[]">
                                            @foreach(config('common.periods') as $key => $periods)
                                                <option value="{{ $periods }}" @if($product['periods'] == $periods) selected @endif>{{ $periods }}</option>
                                            @endforeach
                                        </select>
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
                    <input type="hidden" name="_method" value="PUT">
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


    });
</script>