@extends('layouts.app')

@section('htmlheader_title')
    Post
@endsection


@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3>{{ $Post-> title}}</h3>
                    </div>
                    <div class="panel-body">
                        {{ $Post-> body}}
                        </table>
                    </div>
                    <div class="panel-footer">
                        <a href="/admin/post_list">Go back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


