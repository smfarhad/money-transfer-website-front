@extends('layouts.master')
@section('content')
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i> Transection Detail
            </div>
            <div class="tools">
                <a href="" class="collapse"> </a> <a href="#portlet-config"
                                                     data-toggle="modal" class="config"> </a> <a href=""
                                                     class="reload"> </a> <a href="" class="remove"> </a>
            </div>
        </div>
        <div class="portlet-body form">
            <form role="form" action="{{route('transaction-update')}}" class="form-horizontal" method="post">
                {{ csrf_field() }}       
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-4 control-label">Transection ID</label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips"
                                   data-original-title="Transaction ID"
                                   data-container="body"></i> 
                                <input name="id" value="{{$main->id}}" type="text" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Customer Name</label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips"
                                   data-original-title="Email address"
                                   data-container="body"></i> 
                                <input type="text" value="{{$main->customer_name}}" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Personnumber</label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips"
                                   data-original-title="Email address"
                                   data-container="body"></i> 
                                <input type="text" value="{{$main->personnumber}}" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Service Type</label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <select name="service_type" class="form-control">
                                    <option value="1" {{ ($main->receive_type==1) ? 'selected' : '' }}  >Cash Pickup</option>
                                    <option value="2" {{ ($main->receive_type==2) ? 'selected' : '' }} >Mobile Money</option>
                                </select> 
                            </div>
                        </div>
                    </div>                    
                    <div class="form-group">
                        <label class="col-md-4 control-label">Recipient Mobile</label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <input type="hidden" name="recipientId" type="text" value="{{$main->recipientId}}" class="form-control" readonly>
                                <input name="mobile" type="text" value="{{$main->mobile}}" class="form-control">
                            </div>
                        </div>
                    </div>                    
                    <div class="form-group">
                        <label class="col-md-4 control-label">Amount</label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips"
                                   data-original-title="Email address"
                                   data-container="body"></i> 
                                <input type="text" value="{{$main->depositaedAmount}}"  class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Fees</label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips"
                                   data-original-title="Email address"
                                   data-container="body"></i> 
                                <input  type="text" value="{{$main->fees}}" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group has-success">
                        <label class="col-md-4 control-label">Total Amount</label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <i class="fa fa-check tooltips"
                                   data-original-title="You look OK!"
                                   data-container="body"></i> 
                                <input type="text" value="{{$main->source_total}}" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Amount USD</label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips"
                                   data-original-title="Email address"
                                   data-container="body"></i> 
                                <input type="text" value="{{$main->depositaedAmount_usd}}"  class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Fees USD</label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips"
                                   data-original-title="Email address"
                                   data-container="body"></i> 
                                <input name="fees_usd" type="text" value="{{$main->fees_usd}}" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group has-success">
                        <label class="col-md-4 control-label">Total Amount USD</label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <i class="fa fa-check tooltips"
                                   data-original-title="You look OK!"
                                   data-container="body"></i> 
                                <input type="text" value="{{ $main->depositaedAmount_usd+$main->fees_usd }}" class="form-control" readonly>
                            </div>
                        </div>
                    </div>      
                    <div class="form-group">
                        <label class="col-md-4 control-label">Receive Type</label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <input type="text" value=" {{ ($main->receive_type = 1) ? 'Cash Pickup' : 'Mobile Money' }}"  class="form-control" readonly>
                            </div>
                        </div>
                    </div>    
                    <div class="form-group">
                        <label class="col-md-4 control-label">Destination Country</label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <input type="text" value="{{ $main->destination_country}}" class="form-control" readonly>
                            </div>
                        </div>
                    </div>                     
                    <div class="form-group">
                        <label class="col-md-4 control-label">OCR</label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips"
                                   data-original-title="Email address"
                                   data-container="body"></i> 
                                <input type="text" value="{{$main->id}}"   class="form-control" readonly>
                            </div>
                        </div>
                    </div>
<!--                    <div class="form-group">
                        <label class="col-md-4 control-label">Payment method</label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips"
                                   data-original-title="Email address"
                                   data-container="body"></i> 
                                <input type="text"
                                   class="form-control"readonly>
                            </div>
                        </div>
                    </div>-->
                    <div class="form-group">
                        <label class="col-md-4 control-label">Change by</label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips"
                                   data-original-title="Email address"
                                   data-container="body"></i> 
                                <input value="{{$main->admin_name}}"  type="text" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Created date</label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips"
                                   data-original-title="Email address"
                                   data-container="body"></i>
                                <input value="{{ date('Y-m-d', strtotime($main->date_create))}}" type="text" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Execution date</label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips"
                                   data-original-title="Email address"
                                   data-container="body"></i>
                                <input type="text" value="{{ date('Y-m-d', strtotime($main->date_execution))}}" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Status</label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips"
                                   data-original-title="Email address"
                                   data-container="body"></i>
                                <input value="{{$main->status}}" type="text" class="form-control" readonly>
                                <input  name="status" value="{{$main->status_id}}" type="hidden" readonly>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-4 col-md-8">
                            @if($main->status_id == 4 || $main->status_id == 1 || $main->status_id == 2 )
                            <button type="submit" class="btn yellow">Update</button>
                            @endif 
                            <a href="{!! URL::previous() !!}"  class="btn default">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection