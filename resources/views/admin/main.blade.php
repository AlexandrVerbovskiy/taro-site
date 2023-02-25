@extends('layouts.admin')
@section('content')
    <style>
        .row{
            margin: 20px 20px 20px 0;
        }
        .card{
            margin: 10px;
            border: 0;
            border-radius: 25px;
            background: #a9c6ff;
            /*height: 110px;*/
        }
        @media only screen and (max-width: 380px) {
            .card-body > h5{
                font-size: 16px;
            }
        }
    </style>
<div class="container">
    <div class="row" style="margin-top: 24px">
        <div class="col-sm card">
            <div class="card-body">
                <h5 class="card-title">Count all masters</h5>
                <p class="card-text">{{$statistic["count_masters"]}}</p>
            </div>
        </div>
        <div class="col-sm card">
            <div class="card-body">
                <h5 class="card-title">Count showed masters</h5>
                <p class="card-text">{{$statistic["count_showed_master"]}}</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm card">
            <div class="card-body">
                <h5 class="card-title">Count all users</h5>
                <p class="card-text">{{$statistic["count_all_users"]}}</p>
            </div>
        </div>
        <div class="col-sm card">
            <div class="card-body">
                <h5 class="card-title">Count users</h5>
                <p class="card-text">{{$statistic["count_users"]}}</p>
            </div>
        </div>
        <div class="col-sm card">
            <div class="card-body">
                <h5 class="card-title">Count admins</h5>
                <p class="card-text">{{$statistic["count_admins"]}}</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm card">
            <div class="card-body">
                <h5 class="card-title">Count all events</h5>
                <p class="card-text">{{$statistic["count_events"]}}</p>
            </div>
        </div>
        <div class="col-sm card">
            <div class="card-body">
                <h5 class="card-title">Count showed events</h5>
                <p class="card-text">{{$statistic["count_showed_events"]}}</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm card">
            <div class="card-body">
                <h5 class="card-title">Count all activities</h5>
                <p class="card-text">{{$statistic["count_activities"]}}</p>
            </div>
        </div>
        <div class="col-sm card">
            <div class="card-body">
                <h5 class="card-title">Count showed activities</h5>
                <p class="card-text">{{$statistic["count_showed_activities"]}}</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm card">
            <div class="card-body">
                <h5 class="card-title">Count all posts in infos</h5>
                <p class="card-text">{{$statistic["count_infos_posts"]}}</p>
            </div>
        </div>
        <div class="col-sm card">
            <div class="card-body">
                <h5 class="card-title">Count showed posts in infos</h5>
                <p class="card-text">{{$statistic["count_showed_infos_posts"]}}</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm card">
            <div class="card-body">
                <h5 class="card-title">Count all studies</h5>
                <p class="card-text">{{$statistic["count_studies"]}}</p>
            </div>
        </div>
        <div class="col-sm card">
            <div class="card-body">
                <h5 class="card-title">Count showed studies</h5>
                <p class="card-text">{{$statistic["count_showed_studies"]}}</p>
            </div>
        </div>
    </div>
</div>
@stop
