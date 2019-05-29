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