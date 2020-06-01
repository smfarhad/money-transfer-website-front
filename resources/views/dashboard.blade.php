@extends('layouts.master')
@section('content')
<div class="row widget-row">
    <div class="col-md-3">
        <!-- BEGIN WIDGET THUMB -->
        <div
            class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
            <h4 class="widget-thumb-heading">Total customer</h4>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-green icon-users"></i>
                <div class="widget-thumb-body">
                     <span class="widget-thumb-subtitle">Number</span> 
                    <span class="widget-thumb-body-stat" data-counter="counterup" data-value="{{$number_of_cutomer}}">0</span>
                </div>
            </div>
        </div>
        <!-- END WIDGET THUMB -->
    </div>
    <div class="col-md-3">
        <!-- BEGIN WIDGET THUMB -->
        <div
            class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
            <h4 class="widget-thumb-heading">Number of Transection</h4>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-red icon-layers"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Number</span> 
                    <span
                        class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="{{$number_of_transection}}">0</span>
                </div>
            </div>
        </div>
        <!-- END WIDGET THUMB -->
    </div>
    <div class="col-md-3">
        <!-- BEGIN WIDGET THUMB -->
        <div
            class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
            <h4 class="widget-thumb-heading"> This Month Transection</h4>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-purple icon-calendar"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">SEK</span>
                     <span class="widget-thumb-body-stat" data-counter="counterup" data-value="{{$total_transection_monthly->amount}}">0</span>
                    
                </div>
            </div>
        </div>
        <!-- END WIDGET THUMB -->
    </div>
    <div class="col-md-3">
        <!-- BEGIN WIDGET THUMB -->
        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20">
            <h4 class="widget-thumb-heading">Total Transection Amount</h4>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-blue icon-bar-chart"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">SEK</span> 
                    <span class="widget-thumb-body-stat" data-counter="counterup" data-value="{{$total_transection->amount}}">0</span>
                </div>
            </div>
        </div>
        <!-- END WIDGET THUMB -->
    </div>
</div>
@endsection
