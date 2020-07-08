@extends('layouts.front')

@section('styles')
    {{--styles--}}
@endsection

@section('content')

    <div class="center" id="hlcenter" style="; border: none;">
        <div id="container" class="w-clear">
            <div class="row" style="margin-right: -5px;margin-left: -5px;">
                @include('front.element.menuPC')

                <div class="col-md-10" id="halink-right" style="padding-left: 5px;padding-right: 5px;">
                    <div class="row" style="margin-right: -5px;margin-left: -5px;">

                        <div class="col-md-8" style="padding-left: 5px;padding-right: 5px;">
                            <div class="vip width_common box_category box_home">
                                <div class="title_boxhome width_common">
                                    <strong>仲介業者一覧画面</strong>
                                </div>
                                <div class="content_boxhome">
                                    <table class="table table-condensed">
                                        <tr>
                                            <th>会社名</th>
                                            <th>郵便番号</th>
                                            <th>所在地</th>
                                            <th>電話番号</th>
                                            <th>対応言語</th>
                                        </tr>
                                        <tr>
                                            <td>株式会社ABCDEFG</td>
                                            <td>111-2222</td>
                                            <td>東京都千代田区九段下9-99-9</td>
                                            <td>03-1234-5678</td>
                                            <td>中国語、日本語</td>
                                        </tr>
                                        <tr>
                                            <td>株式会社ABCDEFG</td>
                                            <td>111-2222</td>
                                            <td>東京都千代田区九段下9-99-9</td>
                                            <td>03-1234-5678</td>
                                            <td>中国語、日本語</td>
                                        </tr>
                                        <tr>
                                            <td>株式会社ABCDEFG</td>
                                            <td>111-2222</td>
                                            <td>東京都千代田区九段下9-99-9</td>
                                            <td>03-1234-5678</td>
                                            <td>中国語、日本語</td>
                                        </tr>
                                        <tr>
                                            <td>株式会社ABCDEFG</td>
                                            <td>111-2222</td>
                                            <td>東京都千代田区九段下9-99-9</td>
                                            <td>03-1234-5678</td>
                                            <td>中国語、日本語</td>
                                        </tr>
                                        <tr>
                                            <td>株式会社ABCDEFG</td>
                                            <td>111-2222</td>
                                            <td>東京都千代田区九段下9-99-9</td>
                                            <td>03-1234-5678</td>
                                            <td>中国語、日本語</td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">
                                                <button type="button" class="btn btn-primary" onclick="goBack()">{{ __('front.Back') }}</button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>
                        <div class="col-md-4 " style="padding-left: 5px;padding-right: 5px;">
                            @include('front.commons.right')
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

