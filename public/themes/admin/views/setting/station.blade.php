<div class="main">
    <div class="layui-card fb-minNav">
        <div class="layui-breadcrumb" lay-filter="breadcrumb" style="visibility: visible;">
            <a href="index.html">主页</a><span lay-separator="">/</span>
            <a><cite>站点信息管理</cite></a><span lay-separator="">/</span>
        </div>
    </div>
    <div class="main_full">
        <div class="layui-col-md12">
            {!! Theme::partial('message') !!}
            <div class="fb-main-table">
                <form class="layui-form" action="{{guard_url('setting/updateStation')}}" method="post" lay-filter="fb-form">
                    <div class="layui-form-item">
                        <label class="layui-form-label">站点名称</label>
                        <div class="layui-input-inline">
                            <input type="text" name="station_name" lay-verify="companyName" autocomplete="off" placeholder="请输入站点名称" class="layui-input" value="{{$setting['station_name']}}">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">开户银行</label>
                        <div class="layui-input-inline">
                            <input type="text" name="bank"  autocomplete="off" placeholder="开户银行" class="layui-input" value="{{$setting['bank']}}">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">开户银行账号名称</label>
                        <div class="layui-input-inline">
                            <input type="text" name="bank_name"  autocomplete="off" placeholder="开户银行账号名称" class="layui-input" value="{{$setting['bank_name']}}">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">开户银行银行账号</label>
                        <div class="layui-input-inline">
                            <input type="text" name="bank_account"  autocomplete="off" placeholder="开户银行银行账号" class="layui-input" value="{{$setting['bank_account']}}">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">保险返佣备注</label>
                        <div class="layui-input-inline">
                            <input type="text" name="insurance_rebate_text"  autocomplete="off" placeholder="保险返佣备注" class="layui-input" value="{{$setting['insurance_rebate_text']}}">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">微信审核已通过?</label>
                        <div class="layui-input-inline">
                            <input type="radio" name="wechat_check" value="1" title="是" @if($setting['wechat_check'] == 1) checked @endif>
                            <input type="radio" name="wechat_check" value="0" title="否" @if($setting['wechat_check'] == 0) checked @endif>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<script>
    layui.use(['jquery','element','form','table','upload'], function(){
        var form = layui.form;
        var $ = layui.$;
        form.render();
        //监听提交
        form.on('submit(demo1)', function(data){
            data = JSON.stringify(data.field);
            data = JSON.parse(data);
            data['_token'] = "{!! csrf_token() !!}";
            var load = layer.load();
            $.ajax({
                url : "{{guard_url('setting/updateStation')}}",
                data :  data,
                type : 'POST',
                success : function (data) {
                    layer.close(load);
                    layer.msg('更新成功');
                },
                error : function (jqXHR, textStatus, errorThrown) {
                    layer.close(load);
                    layer.msg('服务器出错');
                }
            });
            return false;
        });

    });
</script>