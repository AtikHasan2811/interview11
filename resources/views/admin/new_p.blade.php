@extends('layouts.app')
@section('content')
    <div class="container-fluid app-body app-home">
        @if(Auth::user()->name)
            <h1> Hello {{ucwords(Auth::user()->name) }}!</h1>
        @endif
        <div class="row">
            <div class="col-md-12">
		//h
            @if(Auth::user()->plansubs())
                <?php
		
                $timestamp = Auth::user()->plansubs()['subscription']->current_period_start;
                if (!$timestamp) {
                    $timestamp = date('Y-m');
                    $timestamp = date('Y-m-d H:i:s', strtotime($timestamp));

                }
                $user_current_pph = \Bulkly\BufferPosting::where('user_id', Auth::user()->id)->where('created_at', '>', $timestamp)->count();
                ?>
                @if(Auth::user()->plansubs()['plan'])
                    @if( $user_current_pph > Auth::user()->plansubs()['plan']->ppm)
                        <!--
    				<div class="alert alert-danger text-center" role="alert"> 
    					Whoops! You've reached your monthly limit of {{$user->plansubs()['plan']->ppm}} which is the number of posts you can send to Buffer. <b>Need to send more?</b> <a href="/settings">Visit your settings page to upgrade your account</a>.
    					</div> 
    				-->
                    @endif
                @endif
            @else
                <!--<div class="alert alert-danger text-center" role="alert"> You have not any active subscription plan now</a>.
				</div> -->

                @endif



                @unless(session()->has('buffer_token'))
                    <div class="panel panel-default">
                        <div class="panel-body notconnected">
                            <div class="alert text-center" role="alert">
                                <!--<h4>Please connect your Buffer Account</h4>
                                <p>When you click the button below, you'll grant access to Bulkly to add social media updates on your behalf.</p> -->

                                <h4>Ready to get started? <br> Simply connect Bulkly with your Buffer account</h4>
                                <br><br>
                                <p><a class="btn btn-default width-btn btn-dc"
                                      href="https://bufferapp.com/oauth2/authorize?client_id={{env('BUFFER_CLIENT_ID')}}&redirect_uri={{env('BUFFER_REDIRECT')}}&response_type=code">Connect
                                        Your Buffer account</a></p>
                            </div>
                        </div>
                    </div>
                @endunless
            </div>
        </div>
        @if(session()->has('buffer_token'))


            <div class="row">
                

            <div class="row home-block">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        
                        <div class="panel-body">
                            <h3>Recent Post Send To Buffer</h3>
                            <div class="activities">
                                
                           
                                       
                                           
                                    <table class="table">
                                         <form>
                                            <tr>
                                                <th>
                                                    <input class="form-control search" type="text" name="search" placeholder="Search"  onkeyup="fetch()">
                                                    <button class="pull-right" style=" position: relative; margin-top: -27px; border: 0px; background: 0px;  padding-right: 12px; outline: none !important;"> <i class="glyphicon glyphicon-search"></i> </button>
                                                </th>
                                                <th>
                                                     <input class="form-control date" type="date" name="date" value="{{date('M d , Y')}}" onkeypress="fetch()">
                                                </th>
                                                <th>
                                                     <select calss="form-control group" id="group"  name="group" onchange="fetch()">
                                                         <option value="1">All Group</option>
                                                         <?php 

                                                           $groups= \Bulkly\SocialPostGroups::get();
                                                          ?>
                                                          @foreach($groups as $group)
                                                                <option value="{{$group->id}}">{{$group->name}}</option>
                                                          @endforeach
                                                     </select>
                                                </th>
                                            </tr>
                                    </form>
                                    </table>
                                <div id="record">
                                <table class="table table-bordered table-stripped"> 
                                    <thead> 
                                        <tr> 
                                            <th>Group Name</th>
                                            <th>Group Type</th>
                                            <th>Account Name</th>
                                            <th>Post Text</th>
                                            <th>Time</th>
                                        </tr> 
                                    </thead> 
                                    <tbody> 
                                        <?php 


                                            $records=\Bulkly\BufferPosting::paginate(100);
                                         ?>
                                        @foreach($records as  $record)
                                        <tr> 
                                        
                                            <td>{{!empty($record->groupInfo->name)?$record->groupInfo->name:""}}</td> 
                                            <td>{{!empty($record->groupInfo->type)?$record->groupInfo->type:""}}</td> 
                                            <td>{{!empty($record->accountInfo->name)?$record->accountInfo->name:""}}</td> 
                                            <td>{{$record->post_text}}</td>
                                            <td>
                                                {{$record->created_at->format('d M , Y h:i a')}}

                                                <?php 

                                                    $tz = date_timezone_get($record->created_at);
                                                        echo timezone_name_get($tz);
                                                 ?>
                                            </td> 
                                            

                                        </tr>
                                        @endforeach
                                     </tbody> 
                                 </table>
                                 {{$records->links()}}
                             </div>
                            </div>
                        </div>
                    </div>
                </div>
                
               
            </div>


        @endif
    </div>

    <script type="text/javascript">
        
        function fetch(){
            var search,date,group;
           
            search= $('.search').val();
            date=$('.date').val();
            group=$('#group').val();
            // alert(group);
            var url='{{URL::to('/fetch_data')}}';
            var token='{{csrf_token()}}';
            if(search && date && group){


             $.ajax({
                type: "POST",
                url: url,
                data: {search:search,_token:token,date:date,group:group},
                success: function success(msg) {
                    $('#record').html(msg);
                },
                error: function error(xhr, ajaxOptions, thrownError) {
                    alert('Something is not right. Please try again.')
                }
            });
          }
        }
    </script>
@endsection