@extends('layouts.admin')
@section('breadcrumb', __('admin.user.manage'))
<div class="row">
    @section('content')
    <div class="col-md-12">
        <div class="box-header with-border">
            <h3 class="box-title">{{ __('admin.user.detail') }}</h3>
        </div>
        <div class="box ">
            <!-- /.box-header -->
            <div class="box-body no-padding">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td class="col-md-2" style="background: #f0f0f0">{{ __('admin.user.name') }}</td>
                            <td>
                            	{{ $user["name"] }}
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-2" style="background: #f0f0f0">{{ __('admin.user.email') }}</td>
                            <td>
                            	{{ $user["email"] }}
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-2" style="background: #f0f0f0">{{ __('admin.user.status') }}</td>
                            <td>
                            	{{ nameStatus($user["status"]) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
    @endsection
</div>
