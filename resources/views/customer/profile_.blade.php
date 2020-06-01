@extends('layouts.master')
@section('content')

<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PROFILE SIDEBAR -->
        @if (Session::has('success'))
        <div class="alert alert-success fade in alert-dismissable" style="margin-top:18px;">
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            <strong>Success!</strong> {!! Session::get('success') !!}
        </div>
        @endif
        <div class="profile-sidebar">
            <!-- PORTLET MAIN -->
            <div class="portlet light profile-sidebar-portlet ">
                <!-- SIDEBAR USERPIC -->
                <div class="profile-userpic">
                    <img src="assets/pages/media/profile/people19.png"
                         class="img-responsive" alt="">
                </div>
                <!-- END SIDEBAR USERPIC -->
                <!-- SIDEBAR USER TITLE -->
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name"> {{$profile->first_name.' '.$profile->last_name}} </div>
                    <div class="profile-usertitle-job">Customer</div>
                </div>
                <!-- END SIDEBAR USER TITLE -->
                <hr>
                <!-- SIDEBAR MENU -->
                
                <!-- END MENU -->
            </div>
            <!-- END PORTLET MAIN -->
            <!-- PORTLET MAIN -->
            <div class="portlet light ">
                <!-- STAT -->
                <div class="row list-separated profile-stat">
                    <div class="col-md-4 col-sm-4 col-xs-6">
                        <div class="uppercase profile-stat-title">{{$number_of_transection}}</div>
                        <div class="uppercase profile-stat-text">Transection</div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-6">
                        <div class="uppercase profile-stat-title">{{$total_transaction_amount}}</div>
                        <div class="uppercase profile-stat-text">Amount</div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-6">
                        <div class="uppercase profile-stat-title">{{ date("Y", strtotime($profile->date_create))}}</div>
                        <div class="uppercase profile-stat-text">Created</div>
                    </div>
                </div>
                <!-- END STAT -->
                <div>
                    <h4 class="profile-desc-title">About Ullah</h4>
                    <span class="profile-desc-text"> Very good customer </span>

                </div>
            </div>
            <!-- END PORTLET MAIN -->
        </div>
        <!-- END BEGIN PROFILE SIDEBAR -->
        <!-- BEGIN PROFILE CONTENT -->
        <div class="profile-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light ">
                        <div class="portlet-title tabbable-line">
                            <div class="caption caption-md">
                                <i class="icon-globe theme-font hide"></i> <span
                                    class="caption-subject font-blue-madison bold uppercase">Profile
                                    Account</span>
                            </div>
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab_1_1" data-toggle="tab">History</a></li>
                                <li><a href="#tab_1_2" data-toggle="tab">Personal Info</a></li>
                            </ul>
                        </div>
                        <div class="portlet-body">
                            <div class="tab-content">

                                <!-- CHANGE AVATAR TAB -->
                                <div class="tab-pane active" id="tab_1_1">
                                    <div class="portlet-body">
                                        <div class="table-container">
                                            <table
                                                class="table table-striped table-bordered table-hover"
                                                id="sample_3">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Recipient Name</th>
                                                        <th>Amount</th>
                                                        <th>Date Create</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(count($main))
                                                    @foreach($main as $row)
                                                    <tr>
                                                        <td><a href="{{ url('transection-details', [$row->id]) }}">{{$row->id}}</a></td>
                                                        <td>{{$row->recipient_name}}</td>
                                                        <td>{{$row->amount}}</td>
                                                        <td>{{ date('Y-m-d', strtotime($row->date_create))}}</td>
                                                        <td>{{$row->status}}</td>
                                                    </tr>
                                                    @endforeach
                                                    @else
                                                    
                                                    @endif                                  
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- END CHANGE AVATAR TAB -->

                                <!-- PERSONAL INFO TAB -->
                                <div class="tab-pane" id="tab_1_2">
                                    <form role="form" action="{{url()->current()}}" method="post">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label class="control-label">First Name</label> 
                                            <input name="firstName"  value="{{$profile->first_name}}" type="text" placeholder="First Name" class="form-control" readonly/>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Last Name</label> 
                                            <input name="lastName"  value="{{$profile->last_name}}" type="text" placeholder="Last Name" class="form-control" readonly/>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Person Number</label> 
                                            <input name="personNumber"  value="{{$profile->personnumber}}" type="text" placeholder="Person Number" class="form-control" readonly/>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Mobile Number</label> 
                                            <input name="mobileNumber" value="{{$profile->mobile}}" type="text" placeholder="+1 646 580 DEMO (6284)" class="form-control"/>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Address </label> 
                                            <input name="addressOne" value="{{$profile->address_1}}" type="text" placeholder="Address" class="form-control"/>
                                        </div>                                   
                                        {{-- <div class="form-group">
                                            <label class="control-label">Address 2</label> 
                                            <input name="addressTwo" value="{{$profile->address_2}}" type="text" placeholder="Address Two" class="form-control"/>
                                        </div>  --}}
                                        {{-- <div class="form-group">
                                            <label class="control-label">Suburb</label> 
                                            <input name="suburb" value="{{$profile->Suburb}}" type="text" placeholder="Suburb" class="form-control"/>
                                        </div>  --}}
                                        <div class="form-group">
                                            <label class="control-label">Postcode</label> 
                                            <input name="postcode" value="{{$profile->postcode}}" value="{{$profile->postcode}}" type="text" placeholder="" class="form-control" />
                                        </div>    
                                        <div class="form-group">
                                            <label class="control-label">City</label>
                                            <input name="city" value="{{$profile->city}}" type="text" placeholder="City Name" class="form-control" />
                                        </div>   
                                        <div class="form-group">
                                            <label class="control-label">Country</label> 
                                            <input name="country" value="{{$profile->country_name}}" type="text" placeholder="Country" class="form-control" readonly=""/>
                                        </div>     
                                        <div class="form-group">
                                            <label class="control-label">Email</label> 
                                            <input name="email" value="{{$profile->email}}" type="text" placeholder="xyz@xyz.xyz" class="form-control" />
                                        </div> <div class="form-group">
                                            <label class="control-label"> Transection Document </label> 
                                            @foreach($customer_files as $row) <a href="$row->file_name">Doc </a>  @endforeach
                                        </div>
                                        <div class="margiv-top-10">
                                           
                                            <input type="submit" class="btn green" value="Save Changes">
<!--                                            <a href="javascript:;"
                                                            class="btn default"> Cancel </a>-->
                                        </div>
                                    </form>
                                </div>
                                <!-- END PERSONAL INFO TAB -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PROFILE CONTENT -->
    </div>
</div>
@endsection
