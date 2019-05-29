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
                        <label class="layui-form-label">{{ trans('car.name') }}：</label>
                        <div class="layui-input-block">
                            <p class="input-p">{{ $order->car_name }}</p>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('order.label.color') }}：</label>
                        <div class="layui-input-block">
                            <p class="input-p">{{ $order->color }}</p>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('order.label.company') }}：</label>
                        <div class="layui-input-block">
                            <p class="input-p">{{ $order->company }}</p>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('order.label.linkman') }}：</label>
                        <div class="layui-input-block">
                            <p class="input-p">{{ $order->linkman }}</p>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('order.label.phone') }}：</label>
                        <div class="layui-input-block">
                            <p class="input-p">{{ $order->phone }}</p>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('order.label.city') }}：</label>
                        <div class="layui-input-block">
                            <p class="input-p">{{ $order->city }}</p>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('order.label.buy_type') }}：</label>
                        <div class="layui-input-block">
                            <p class="input-p">{{ $order->buy_type }}</p>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('order.label.status') }}：</label>
                        <div class="layui-input-block">
                            <p class="input-p">{{ $order->status_desc }}</p>
                        </div>
                    </div>

                    <?php $order_financial = $order->order_financial;?>
                    @if($order_financial)
                        <fieldset class="layui-elem-field">
                            <legend>金融资料</legend>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_financial.label.name') }}：</label>
                                <div class="layui-input-block">
                                    <p class="input-p">{{ $order_financial->name }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_financial.label.id_card') }}：</label>
                                <div class="layui-input-block">
                                    <p class="input-p">{{ $order_financial->id_card }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_financial.label.phone') }}：</label>
                                <div class="layui-input-block">
                                    <p class="input-p">{{ $order_financial->phone }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_financial.label.marital_status') }}：</label>
                                <div class="layui-input-block">
                                    <p class="input-p">{{ trans('order_financial.marital_status.'.$order_financial->marital_status) }}</p>
                                </div>
                            </div>

                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_financial.label.id_card_image_a') }}：</label>
                                <div class="layui-input-block">
                                    <img src="{{ url('image/original'.$order_financial->id_card_image_a) }}">
                                </div>
                            </div>
                        </fieldset>
                    @endif


                </form>
            </div>

        </div>
    </div>
</div>
{!! Theme::asset()->container('ueditor')->scripts() !!}