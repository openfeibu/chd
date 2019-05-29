<div class="main">
    <div class="layui-card fb-minNav">
        <div class="layui-breadcrumb" lay-filter="breadcrumb" style="visibility: visible;">
            <a href="{{ guard_url('home') }}">主页</a><span lay-separator="">/</span>
            <a><cite>{{ trans('order.name') }}详情</cite></a>
        </div>
    </div>
    <div class="main_full">
        <div class="layui-col-md12">
            {!! Theme::partial('message') !!}
            <div class="fb-main-table">
                <form class="layui-form" action="{{guard_url('order/'.$order->id)}}" method="post" method="post" lay-filter="fb-form">
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('order.label.name') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="name" autocomplete="off" placeholder="请输入{{ trans('order.label.name') }}" class="layui-input" value="{{ $order->name }}">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('order.label.linkman') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="linkman" autocomplete="off" placeholder="请输入{{ trans('order.label.linkman') }}" class="layui-input" value="{{ $order->linkman }}">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('order.label.phone') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="phone" autocomplete="off" placeholder="请输入{{ trans('order.label.phone') }}" class="layui-input" value="{{ $order->phone }}">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('order.label.wechat') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="wechat" autocomplete="off" placeholder="请输入{{ trans('order.label.wechat') }}" class="layui-input" value="{{ $order->wechat }}">
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