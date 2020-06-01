@extends('layouts.master')
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Begin: life time stats -->
        <div class="portlet light portlet-fit portlet-datatable ">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-green"></i> <span
                        class="caption-subject font-green sbold uppercase">Trigger
                        Tools From Dropdown Menu</span>
                </div>
                <div class="actions">
                    
                    <div class="btn-group">
                        <a class="btn red btn-outline btn-circle"
                           href="javascript:;" data-toggle="dropdown"> <i
                                class="fa fa-share"></i> <span class="hidden-xs">
                                Trigger Tools </span> <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu pull-right" id="sample_3_tools">
                            <li><a href="javascript:;" data-action="0"
                                   class="tool-action"> <i class="icon-printer"></i> Print
                                </a></li>
                            <li><a href="javascript:;" data-action="1"
                                   class="tool-action"> <i class="icon-check"></i> Copy
                                </a></li>
                            <li><a href="javascript:;" data-action="2"
                                   class="tool-action"> <i class="icon-doc"></i> PDF
                                </a></li>
                            <li><a href="javascript:;" data-action="3"
                                   class="tool-action"> <i class="icon-paper-clip"></i>
                                    Excel
                                </a></li>
                            <li><a href="javascript:;" data-action="4"
                                   class="tool-action"> <i class="icon-cloud-upload"></i>
                                    CSV
                                </a></li>
                            <li class="divider"></li>
                            <li><a href="javascript:;" data-action="5"
                                   class="tool-action"> <i class="icon-refresh"></i>
                                    Reload
                                </a></li>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="portlet-body">
               
                <div class="table-container">
                    <table
                        class="table table-striped table-bordered table-hover"
                        id="sample_3">
                        <thead>
                            <tr>
                                <th>Transection ID</th>
                                <th>Customer Name</th>
                                <th>Personnumber</th>
                                <th>Recipient Name</th>
                                <th>Deposited amount</th>
                                
                                <th>Date Create</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($main as $row)
                            <tr>
                                <td><a href="{{ url('transection-details', [$row->id]) }}">{{$row->id}}</a></td>
                                <td><a href="{{ url('customer-profile', [$row->id]) }}">{{$row->customer_name}}</a></td>
                                <td><a href="{{ url('customer-profile', [$row->id]) }}">{{$row->personnumber}}</a></td>
                                <td>{{$row->recipient_name}}</td>
                                <td>{{-- $row->depositaedAmount --}}{{$row->source_amount+$row->fees*0}}</td>
                                <td> {{date('Y-m-d', strtotime($row->date_create)) }}</td>
                                <td>
                                    <form class="transaction-status-form-datafield" action="{{ route('transection-status')}}" method="post">
                                        {{ csrf_field() }}
                                        <input name="id" type="hidden" value="{{$row->id}}">
                                        <input name="status" type="hidden" value="1">
                                        <input name="apiType" type="hidden" value="2">
                                        <button type="submit" class="btn btn-circle btn-sm green-sharp btn-outline  btn-block sbold uppercase">Data Filed</button>
                                    </form>
                                    <form class="transaction-status-form-bakaal" action="{{ route('transection-status')}}" method="post">
                                        {{ csrf_field() }}
                                        <input name="id" type="hidden" value="{{$row->id}}">
                                        <input name="status" type="hidden" value="1">
                                        <input name="apiType" type="hidden" value="1">
                                        <button type="submit" class="btn btn-circle btn-sm green-sharp btn-outline  btn-block sbold uppercase">Bakaal</button>
                                    </form>
                                    <br>
                                    <form class="transaction-delete-form" action="{{ route('transaction-delete')}}" method="post">
                                        {{ csrf_field() }}
                                        <input name="id" type="hidden" value="{{$row->id}}">
                                        <input name="status" type="hidden" value="9">
                                        <button type="submit" class="btn btn-circle btn-sm btn-danger btn-outline  btn-block sbold uppercase">Delete</button>
                                    </form>                                    
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- End: life time stats -->
    </div>
</div>
@endsection
