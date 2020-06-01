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
                                <th>Customer Name</th>
                                <th>Personnumber</th>
                                <th>City</th>
                                <th>Mobile</th>
                                <th>Create</th>
                                {{--<th>Last Login</th> --}}

                            </tr>
                        </thead>
                        <tbody>
                            @if(count($main)>0)
                                @foreach($main as $row)
                                    <tr>
                                        <td><a href="{{ url('customer-profile', [$row->id]) }}" >{{ $row->first_name .' '. $row->last_name }}</a></td>
                                        <td><a href="{{ url('customer-profile', [$row->id]) }}">{{ $row->personnumber }}</a></td>
                                        <td>{{ $row->city }}</td>
                                        <td>{{ $row->mobile }}</td>
                                        <td> {{ date('Y-m-d', strtotime($row->date_create))}} </td>
                                        <!--<td> {{-- date('Y-m-d', strtotime($row->date_update)) --}} </td>-->
                                    </tr>
                                @endforeach
                            @else
                                echo '<tr><td colspan="5">No Data Fount</td></tr>';
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- End: life time stats -->
    </div>
</div>

@endsection
