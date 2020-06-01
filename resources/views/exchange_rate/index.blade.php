@extends('layouts.master')
@section('content')
@if(Session::has('alert-success'))
<div class="alert alert-success">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Success!</strong> {{ Session::get('alert-success') }}
</div>
@endif
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
                    <a class="btn green btn-circle" href="/exchange-rate/create">
                        <i class="fa fa-plus" aria-hidden="true"></i> Add New 
                    </a>
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
                                <th>ID</th>
                                <th>Min Range</th>
                                <th>Max Range</th>
                                <th>Rate</th>
                                <th>Fee</th>
                                <th>updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($main as $row)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$row->min_range}}</td>
                                <td>{{$row->max_range}}</td>
                                <td>{{$row->rate}}</td>
                                <td>{{$row->fee}}</td>
                                <td> {{date('Y-m-d', strtotime($row->date_update))}}</td>
                                <td>
                                    <a class="text-bold btn btn-warning btn-xs" href="{{URL::to('/exchange-rate/'. $row->id . '/edit')}}"> <i class="fa fa-pencil " aria-hidden="true"></i></a>
                                    <a class="confirm-transection text-bold btn btn-danger btn-xs" href="{{URL::to('/exchange-rate/delete/'. $row->id )}}"> <i class="fa fa-trash" aria-hidden="true"></i></a>
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
