@extends('layouts.master')
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PROFILE SIDEBAR -->
        <div class="profile-sidebar">
            <!-- PORTLET MAIN -->
            <div class="portlet light profile-sidebar-portlet ">
                <!-- SIDEBAR USERPIC -->
                <div class="profile-userpic">
                    <img
                        @if(Auth::user()->profile_pic)
                           src="{{URL::to('/')}}{{ Auth::user()->profile_pic}}
                         @else 
                             src="/assets/pages/media/profile/avatar.png" 
                         @endif
                        
                         class="profile_img img-responsive" alt="{{ Auth::user()->last_name}}">
                </div>
                <!-- END SIDEBAR USERPIC -->
                <!-- SIDEBAR USER TITLE -->
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name"> {{ Auth::user()->first_name .' '. Auth::user()->last_name }}  </div>
                    <div class="profile-usertitle-job">Admin</div>
                </div>
                <!-- END SIDEBAR USER TITLE -->
                <hr>
            </div>
            <!-- END PORTLET MAIN -->
            <!-- PORTLET MAIN -->
<!--            <div class="portlet light">
                 STAT 
                <div class="row list-separated profile-stat">
                    <div class="col-md-4 col-sm-4 col-xs-6">
                        <div class="uppercase profile-stat-title">37</div>
                        <div class="uppercase profile-stat-text">Projects</div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-6">
                        <div class="uppercase profile-stat-title">51</div>
                        <div class="uppercase profile-stat-text">Tasks</div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-6">
                        <div class="uppercase profile-stat-title">61</div>
                        <div class="uppercase profile-stat-text">Uploads</div>
                    </div>
                </div>
                 END STAT 
                <div>
                    <h4 class="profile-desc-title">About Marcus Doe</h4>
                    <span class="profile-desc-text"> Lorem ipsum dolor sit
                        amet diam nonummy nibh dolore. </span>
                </div>
            </div>-->
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
                                <li class="active"><a href="#tab_1_1" data-toggle="tab">Personal
                                        Info</a></li>
                                <li><a href="#tab_1_2" data-toggle="tab">Change Avatar</a>
                                </li>
                                <li><a href="#tab_1_3" data-toggle="tab">Change
                                        Password</a></li>
<!--                                <li><a href="#tab_1_4" data-toggle="tab">Privacy
                                        Settings</a></li>-->
                            </ul>
                        </div>
                        <div class="portlet-body">
                            <div class="tab-content">
                                <!-- PERSONAL INFO TAB -->
                                <div class="tab-pane active" id="tab_1_1">
                                    <form id="editProfile" role="form" action="{{ route('profile') }}" method="post">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label class="control-label">First Name</label> 
                                            <input name="firstName" value="{{ Auth::user()->first_name }}"
                                                   type="text" placeholder="John" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Last Name</label> <input
                                                name="lastName" value="{{ Auth::user()->last_name }}"
                                                type="text" placeholder="Doe" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Mobile Number</label> <input
                                                name="mobileNumber" value="{{ Auth::user()->mobile }}"
                                                type="text" placeholder="+1 646 580 DEMO (6284)"
                                                class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Email</label> <input
                                                name="email" value="{{ Auth::user()->email }}"
                                                type="text" placeholder="abc@gmail.com"
                                                class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Notes</label>
                                            <textarea class="form-control" rows="3"name="note" 
                                                      placeholder="We are KeenThemes!!!">{{ Auth::user()->note }}</textarea>
                                        </div>

                                        <div class="margiv-top-10">
                                            <input type="submit" value="Save Changes" name="save" class="btn green">
                                            <!--<a href="javascript:;"  class="btn default"> Cancel </a>-->
                                        </div>
                                    </form>
                                </div>
                                <!-- END PERSONAL INFO TAB -->
                                <!-- CHANGE AVATAR TAB -->
                                <div class="tab-pane" id="tab_1_2">
                                    <p></p>
                                    <form id="addPic" action="{{ route('addprofilepic') }}" role="form" enctype="multipart/form-data" method="post">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail" style="width:160px; height: auto">
                                                    <img class="profile_img" style="height:200px; width:150px"
                                                         src="{{URL::to('/')}}{{ Auth::user()->profile_pic}}"
                                                         alt="{{ Auth::user()->first_name}} {{ Auth::user()->last_name}}" />
                                                </div>
                                                <div>
                                                    <div class="form-group">
                                                        <label class="btn btn-primary" for="exampleInputFile">Upload a Profile Picture <i class="fa fa-upload"></i> </label>
                                                        <input name="profile_pic" type="file" id="exampleInputFile" style="display:none">
                                                        <p class="help-block">  </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="clearfix margin-top-10">
                                                <span class="label label-danger">NOTE! </span> <span> Attached
                                                    image thumbnail is supported in Latest Firefox,
                                                    Chrome, Opera, Safari and Internet Explorer 10 only 
                                                </span>
                                            </div>
                                        </div>
                                        <div class="margin-top-10">
                                            <input type="submit" class="btn green" value="Submit">
                                        </div>
                                    </form>
                                </div>
                                <!-- END CHANGE AVATAR TAB -->
                                <!-- CHANGE PASSWORD TAB -->
                                <div class="tab-pane" id="tab_1_3">
                                    <form id="changePassword" action="{{ route('change-password') }}" role="form" method="post">
                                        {{ csrf_field() }}
                                        <!--                                        <div class="form-group">
                                                                                    <label class="control-label">Current Password</label>
                                                                                    <input type="password" class="form-control" />
                                                                                </div>-->
                                        <div id="password" class="form-group">
                                            <label class="control-label">New Password</label> 
                                            <input name="password" type="password" class="form-control" />
                                            <span id="password_error" class="help-block">

                                            </span>
                                        </div>
                                        <div id="confirm_password" class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                            <label class="control-label">Re-type New Password</label>
                                            <input name="password_confirmation" type="password" class="form-control" />
                                            <span id="confirm_password_error" class="help-block">

                                            </span>
                                        </div>
                                        <div class="margin-top-10">
                                            <input type="submit" class="btn green" name="change_password" value="Change Password">
                                            <!--                                                 <a href="javascript:;" class="btn default"> Cancel </a>-->
                                        </div>
                                    </form>
                                </div>
                                <!-- END CHANGE PASSWORD TAB -->
                               
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