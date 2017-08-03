@extends('layouts.app')

@section('htmlheader_title')
    Post Home
@endsection


@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><h2>Post List</h2></div>
                    <div class="panel-body">
                        <table class="table table-hover" id="userlist">
                            <thead>
                            <td class="info">User Id</td>
                            <td class="info">Title</td>
                            <td class="info">Content</td>
                            </thead>
                            <tbody>
                            @foreach($Post_list as $Post)
                                <tr>
                                    <td>{{ $Post-> id}}</td>
                                    <td><a href="/admin/post/{{ $Post-> id}}">{{ $Post-> title}}</a></td>
                                    <td>{{ $Post-> body}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


