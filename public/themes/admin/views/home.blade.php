<div class="main">
    <div class="main_full">
        <div class="layui-col-md12">
            <div class="layui-card">
                <!-- <div class="layui-card-header">待办事项</div> -->
                <div class="layui-card-body">

                    <div class="fb-carousel fb-backlog " lay-anim="" lay-indicator="inside" lay-arrow="none" >
                        <div carousel-item="">
                            <ul class="layui-row fb-clearfix ">
                                <li class="layui-col-xs3">
                                    @permission(home())
                                    <a lay-href="" class="fb-backlog-body">
                                        <h3>用户量</h3>
                                        <p><cite>{{ $user_count }}</cite></p>
                                    </a>
                                    @endpermission
                                </li>
                                <li class="layui-col-xs3">
                                    <a lay-href="" class="fb-backlog-body">
                                        <h3>今日新增用户量</h3>
                                        <p><cite>{{ $new_user_count }}</cite></p>
                                    </a>
                                </li>
                                <li class="layui-col-xs3">
                                    <a lay-href="" class="fb-backlog-body">
                                        <h3>订单量</h3>
                                        <p><cite>{{ $order_count }}</cite></p>
                                    </a>
                                </li>
                                <li class="layui-col-xs3">
                                    <a lay-href="" class="fb-backlog-body">
                                        <h3>今日新增订单量</h3>
                                        <p><cite>{{ $new_order_count }}</cite></p>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>