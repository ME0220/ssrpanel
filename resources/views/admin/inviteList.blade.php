@extends('admin.layouts')

@section('css')
@endsection
@section('title', '控制面板')
@section('content')
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE BREADCRUMB -->
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{{url('admin/inviteList')}}">邀请码管理</a>
                <i class="fa fa-circle"></i>
            </li>
        </ul>
        <!-- END PAGE BREADCRUMB -->
        <!-- BEGIN PAGE BASE CONTENT -->
        <div class="row">
            <div class="col-md-4">
                <div class="tab-pane active" id="tab_0">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-dark bold uppercase">生成邀请码</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="alert alert-info">
                                注意：每次仅生成 <strong> 5 </strong> 个邀请码
                            </div>
                            <button type="submit" class="btn blue" onclick="makeInvite()"> 生 成 </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="tab-pane active">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-dark bold uppercase">邀请码列表</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-scrollable table-scrollable-borderless">
                                <table class="table table-hover table-light">
                                    <thead>
                                        <tr class="uppercase">
                                            <th> # </th>
                                            <th> 邀请码 </th>
                                            <th> 有效期 </th>
                                            <th> 生成者 </th>
                                            <th> 使用者 </th>
                                            <th> 状态 </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($inviteList->isEmpty())
                                            <tr>
                                                <td colspan="6" style="text-align: center;">暂无数据</td>
                                            </tr>
                                        @else
                                            @foreach($inviteList as $invite)
                                                <tr>
                                                    <td> {{$invite->id}} </td>
                                                    <td> {{$invite->code}} </td>
                                                    <td> {{$invite->dateline}} </td>
                                                    <td> {{$invite->generator->username}} </td>
                                                    <td> {{empty($invite->user) ? '' : $invite->user->username}} </td>
                                                    <td>
                                                        @if($invite->status == '0')
                                                            <span class="label label-sm label-success"> 未使用 </span>
                                                        @elseif($invite->status == '1')
                                                            <span class="label label-sm label-danger"> 已使用 </span>
                                                        @else
                                                            <span class="label label-sm label-default"> 已过期 </span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-5 col-sm-5">
                                    <div class="dataTables_info" role="status" aria-live="polite">共 {{$inviteList->total()}} 个邀请码</div>
                                </div>
                                <div class="col-md-7 col-sm-7">
                                    <div class="dataTables_paginate paging_bootstrap_full_number pull-right">
                                        {{ $inviteList->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE BASE CONTENT -->
    </div>
    <!-- END CONTENT BODY -->
@endsection
@section('script')
    <script src="/assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>

    <script type="text/javascript">
        // 生成邀请码
        function makeInvite() {
            var _token = '{{csrf_token()}}';

            $.ajax({
                type: "POST",
                url: "{{url('admin/makeInvite')}}",
                async: false,
                data: {_token:_token},
                dataType: 'json',
                success: function (ret) {
                    if (ret.status == 'success') {
                        bootbox.alert(ret.message, function () {
                            window.location.reload();
                        });
                    } else {
                        bootbox.alert(ret.message);
                    }
                }
            });

            return false;
        }
    </script>
@endsection