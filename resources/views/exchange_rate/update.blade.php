@extends('layouts.master')
@section('content')
@if(Session::has('alert-success'))
<div class="alert alert-success">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Success!</strong> {{ Session::get('alert-success') }}
</div>
@endif
<div class="page-content-inner">
    <!-- Form for the exchange rate -->
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i> Please correct the exchange rate
            </div>
            <div class="tools">
                <a href="" class="collapse"> </a> <a href="#portlet-config"
                                                     data-toggle="modal" class="config"> </a> <a href=""
                                                     class="reload"> </a> <a href="" class="remove"> </a>
            </div>
        </div>
        <div class="portlet-body form">
            <form role="form" method="post" action="/exchange-rate/update" class="form-horizontal" method="post">
                {{ csrf_field() }}
                <div class="form-body">
                    <input type="hidden" value="{{$show->id}}" name="id" type="text" class="form-control">
                    <div style="display:none;" class="form-group {{ $errors->has('minRange') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Min Range</label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips"
                                   data-original-title="Min Range"
                                   data-container="body"></i> 
                                <input value="{{$show->min_range}}" name="minRange" type="text" class="form-control">
                                @if($errors->has('minRange'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('minRange') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('maxRange') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Max Range</label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips"
                                   data-original-title="Max Range"
                                   data-container="body"></i> 
                                <input value="{{$show->max_range}}" name="maxRange" type="text" class="form-control">
                                @if($errors->has('maxRange'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('maxRange') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group {{ $errors->has('rate') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Rate</label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips"
                                   data-original-title="Exchange Rate"
                                   data-container="body"></i> 
                                <input value="{{$show->rate}}" name="rate" type="text" class="form-control">
                                @if($errors->has('rate'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('rate') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('fee') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Fee</label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips"
                                   data-original-title="Fees Charged For Every Transaction"
                                   data-container="body"></i> 
                                <input value="{{$show->fee}}" name="fee" type="text" class="form-control">
                            </div>
                            @if($errors->has('rate'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('fee') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>                    
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-4 col-md-8">
                            <button type="submit" class="btn blue">SAVE</button>
                            <a href="{{ route('exchange-rate') }}" type="button" class="btn default">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection