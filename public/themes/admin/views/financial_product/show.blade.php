<div class="main">
    <div class="layui-card fb-minNav">
        <div class="layui-breadcrumb" lay-filter="breadcrumb" style="visibility: visible;">
            <a href="{{ guard_url('home') }}">主页</a><span lay-separator="">/</span>
            <a><cite>{{ trans('financial_product.name') }}详情</cite></a>
        </div>
    </div>
    <div class="main_full">
        <div class="layui-col-md12">
            {!! Theme::partial('message') !!}
            <div class="fb-main-table">
                <form class="layui-form" action="{{guard_url('financial_product/'.$financial_product->id)}}" method="post" method="post" lay-filter="fb-form">
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('financial_product.label.name') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="name" autocomplete="off" placeholder="请输入{{ trans('financial_product.label.name') }}" class="layui-input" value="{{ $financial_product->name }}">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('financial_product.label.content') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="content" autocomplete="off" placeholder="请输入{{ trans('financial_product.label.content') }}" class="layui-input" value="{{ $financial_product->content }}">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">授权书名称</label>
                        <div class="layui-input-inline">
                            <input type="text" name="auth_file_name" autocomplete="off" placeholder="请输入授权书名称" class="layui-input" value="{{ $financial_product->auth_file_name }}">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">授权书模板</label>
                        {!! $financial_product->files('auth_file',true)
                        ->url($financial_product->getUploadUrl('auth_file'))
                        ->uploaders()!!}
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