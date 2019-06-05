<div class="main">
    <div class="layui-card fb-minNav">
        <div class="layui-breadcrumb" lay-filter="breadcrumb" style="visibility: visible;">
            <a href="{{ guard_url('home') }}">主页</a><span lay-separator="">/</span>
            <a><cite>{{ trans('app.edit') }}{{ trans('page.about_rent.name') }}</cite></a>
        </div>
    </div>
    <div class="main_full">
        <div class="layui-col-md12">
            {!! Theme::partial('message') !!}
            <div class="fb-main-table">
                <form class="layui-form" action="{{guard_url('page/about_rent/update/'.$page->id)}}" method="post" lay-filter="fb-form">
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{  trans('app.title') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="title" lay-verify="title" autocomplete="off" placeholder="请输入{{  trans('app.title') }}" class="layui-input" value="{{ $page->title }}">
                        </div>
                    </div>
                   <!-- <div class="layui-form-item">
                        <label class="layui-form-label">{{  trans('app.video') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="video" lay-verify="title" autocomplete="off" placeholder="请输入{{  trans('app.video') }}" class="layui-input" value="{{ $page->video }}">
                        </div>
                    </div> -->
                    <div class="layui-form-item layui-form-text">
                        <label class="layui-form-label">{{  trans('app.content') }}</label>
                        <div class="layui-input-block">
                            <script type="text/plain" id="content" name="content" style="width:1000px;height:240px;">{!! $page->content !!}</script>
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
<script>
    var ue = getUe();
</script>