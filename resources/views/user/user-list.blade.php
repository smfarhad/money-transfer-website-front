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
                                <th>ID</th>
                                <th>Customer Name</th>
                                
                                <th>Date Create</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($main as $row)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$row->customer_name}}</td>
                                    <td> {{date('Y-m-d', strtotime($row->created_at))}} </td>
                                    <td>
                                        <form class="user-status-form" action="{{ route('users-status')}}" method="post">
                                            {{ csrf_field() }}
                                            @if($row->status==1)
                                            <input name="id" type="hidden" value="{{$row->id}}">
                                            <input name="status" type="hidden" value="0">
                                            <button type="submit" class="btn btn-circle btn-sm green-sharp btn-outline  btn-block sbold uppercase">
                                               {{'Active'}}
                                            </button>
                                            @else
                                            <input name="id" type="hidden" value="{{$row->id}}">
                                            <input name="status" type="hidden" value="1">
                                            <button type="submit" class="btn btn-circle btn-sm red btn-outline  btn-block sbold uppercase">
                                               {{'InActive'}}
                                            </button>
                                            @endif
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
