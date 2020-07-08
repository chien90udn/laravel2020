@extends('layouts.front')

@section('styles')
    {{--styles--}}
@endsection

@section('content')

    <div class="center" id="hlcenter" style="; border: none;">
        <div id="container" class="w-clear">
            <div class="row" style="margin-right: -5px;margin-left: -5px;">
                @include('front.element.menuProfile')
                <div class="col-md-10" id="halink-right" style="padding-left: 5px;padding-right: 5px;">
                    <input type="hidden" value="" id="crp">
                    <div class="main-tit">
                        <h2>{{ __('front.Your products') }}</h2>
                        <span>
                            <label for="name" class="ten">
                                <a href="{{route('add_new_product')}}">{{ __('front.Publish your ad for free') }}</a>
                            </label>
                        </span>
                    </div>
                    <section class="content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-info" id="tableProduct">
                                    <table class="table table-bordered">
                                        <tbody>
                                        <tr>
                                            <th  class="hidden-xs">{{ __('front.Title') }}</th>
                                            <th  class="hidden-xs">{{ __('front.Price') }}</th>
                                            <th  class="hidden-xs">{{ __('front.Approve') }}</th>
                                            <th  class="hidden-xs">{{ __('front.Status') }}</th>
                                            <th  class="hidden-xs">{{ __('front.Action') }}</th>
                                        </tr>
                                        @foreach($products as $product)
                                            <tr>
                                                <td style="width: 60%">
                                                    {{ str_limit($product->title) }}
                                                </td>
                                                <td style="width: 10%; text-align: right">{{ $product->currency->name.$product->price }}</td>
                                                <td>{!! nameHtmlApprove($product->approve) !!}</td>
                                                <td style="text-align: center">
                                                    @if($product -> sold == Config::get('settings.SOLD'))
                                                        <span class="sold2">{{ __('front.Sold') }}</span>
                                                    @else
                                                        {!! nameHtmlStatus($product->status) !!}
                                                    @endif

                                                </td>
                                                <td align="center">
                                                    <a title="Edit" href="{{ route('productEdit',['id'=>$product->id]) }}">
                                                        <span class="btn btn-primary btn-sm" style="width: 30px"><i class="fa fa-edit"></i></span>
                                                    </a>
{{--                                                    @if($product->approve==Config::get('settings.GLOBAL_APPROVE.ENABLED.code'))--}}
{{--                                                        <i class="fa fa-unlock" style="font-size:24px;color:green"></i>--}}
{{--                                                    @else--}}
{{--                                                        <i class="fa fa-lock" style="font-size:24px;color:red"></i>--}}

{{--                                                    @endif--}}
                                                    <a title="Delete" href="{{ route('productDelete',['id'=>$product->id]) }}" onclick="return confirm('{{ __('front.Are you sure you want to delete this item?') }}')">
                                                        <span class="btn btn-danger btn-sm" style="width: 30px">
                                                            <i class="fa fa-trash"></i>
                                                        </span>

                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div><!-- /.box -->
                                <div>{{ $products->links() }}</div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>


    </div>
    </div>
@endsection

