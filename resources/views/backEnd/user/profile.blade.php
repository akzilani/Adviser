<style>
    .modal-body h4 {
    font-size: 1.5rem;
    background: #777;
    color: #fff;
    padding: 10px 10px;
}
</style>
<div class="modal-content">            
    <div class="modal-header">
        <h5 class="modal-title" > {{ $data->first_name }} {{ $data->last_name }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> 
    
    <div class="modal-body row"> 
        <div class="col-12 col-md-10 row">
            <div class="col-12 row mt-4">
                <div class="col-12 font-weight-bold"> 
                    <h4>Basic Profile</h4>
                    
                </div>
            </div>
            <div class="col-6 row mt-2">
                <div class="col-12 col-md-5 font-weight-bold"> Email </div>
                <div class="col-12 col-md-7"> {{ $data->email }}</div>
            </div>
            <div class="col-6 row mt-2">
                <div class="col-12 col-md-5 font-weight-bold"> name </div>
                <div class="col-12 col-md-7 "> {{ ucfirst($data->first_name) }} {{ ucfirst($data->last_name) }}</div>
            </div>
            <div class="col-6 row mt-2">
                <div class="col-12 col-md-5 font-weight-bold"> Phone Number </div>
                <div class="col-12 col-md-7 "> {{ $data->phone }}</div>
            </div>
            <div class="col-6 row mt-2">
                <div class="col-12 col-md-5 font-weight-bold"> Creating Account </div>
                <div class="col-12 col-md-7 "> {{ ucfirst($data->creating_account) }}</div>
            </div>
            <div class="col-6 row mt-2">
                <div class="col-12 col-md-5 font-weight-bold"> Looking For </div>
                <div class="col-12 col-md-7 "> {{ ucfirst($data->looking_for) }}</div>
            </div>
            <div class="col-6 row mt-2">
                <div class="col-12 col-md-5 font-weight-bold"> Gender </div>
                <div class="col-12 col-md-7 "> {{ $data->gender == 'M' ? 'Male' : 'Female' }}</div>
            </div> 
            <div class="col-6 row mt-2">
                <div class="col-12 col-md-5 font-weight-bold"> Religion </div>
                <div class="col-12 col-md-7 "> {{ isset($data->religionCast->name) ? $data->religionCast->name . ' - ' : 'N/A' }}{{ isset($data->religious->name) ? $data->religious->name : 'N/A' }}</div>
            </div> 
            <div class="col-6 row mt-2">
                <div class="col-12 col-md-5 font-weight-bold"> Location </div>
                <div class="col-12 col-md-7 "> {{ ucfirst($data->location_country) }}</div>
            </div>
            <div class="col-6 row mt-2">
                <div class="col-12 col-md-5 font-weight-bold">Mother tongue </div>
                <div class="col-12 col-md-7 "> {{ is_null($data->mother_tongue) ? 'N/A' : $data->mother_tongue }}</div>
            </div>
            <div class="col-6 row mt-2">
                <div class="col-12 col-md-5 font-weight-bold">NID</div>
                <div class="col-12 col-md-7 "> {{ is_null($data->nid) ? 'N/A' : $data->nid }}</div>
            </div>
            <div class="col-6 row mt-2">
                <div class="col-12 col-md-5 font-weight-bold"> Smoke </div>
                <div class="col-12 col-md-7 "> {{ is_null($data->smoke) ? 'N/A' : $data->smoke }}</div>
            </div> 
            <div class="col-6 row mt-2">
                <div class="col-12 col-md-5 font-weight-bold"> Marital Status </div>
                <div class="col-12 col-md-7 "> 
                    @if( $data->marital_status == "M" )
                        Married
                    @elseif( $data->marital_status == "U" )
                        Unmarried
                    @elseif( $data->marital_status == "D" )
                        Divorce
                    @else
                        {{ ucfirst($data->marital_status) }}
                    @endif
                </div>
            </div> 
            <div class="col-6 row mt-2">
                <div class="col-12 col-md-5 font-weight-bold"> Gardian Contact </div>
                <div class="col-12 col-md-7 "> {{ is_null($data->gardian_contact_no) ? 'N/A' : $data->gardian_contact_no }}</div>
            </div>           
        </div> 
        <div class="col-12 col-md-2 text-center">
            <strong>Profile Image</strong><br>
            <img src="{{ isset($data->profilePic->image_path) && file_exists($data->profilePic->image_path) ? asset($data->profilePic->image_path) : asset('image/dummy_user.jpg') }}"  alt="N/A" class="img-fluid img-thumbnail"> 
        </div> 
        
        <!-- Address -->
        <div class="col-12 row">
            <div class="col-12 row mt-4">
                <div class="col-12 font-weight-bold"> 
                    <h4>Address</h4>
                   
                </div>
            </div>            
            <div class="col-6 col-lg-4 row mt-2">
                <div class="col-12 col-md-6 font-weight-bold"> Present Address</div>
                <div class="col-12 col-md-6 "> {{ ucfirst($data->user_present_address) }}</div>
            </div>
            <div class="col-6 col-lg-4 row mt-2">
                <div class="col-12 col-md-6 font-weight-bold"> Present City </div>
                <div class="col-12 col-md-6 "> {{ ucfirst($data->user_present_city) }}</div>
            </div>
            <div class="col-6 col-lg-4 row mt-2">
                <div class="col-12 col-md-6 font-weight-bold"> Present County </div>
                <div class="col-12 col-md-6 "> {{ ucfirst($data->user_present_country) }}</div>
            </div>
            <!-- Permanent -->
            <div class="col-6 col-lg-4 row mt-2">
                <div class="col-12 col-md-6 font-weight-bold"> Permanent Address</div>
                <div class="col-12 col-md-6 "> {{ ucfirst($data->user_permanent_address) }}</div>
            </div>
            <div class="col-6 col-lg-4 row mt-2">
                <div class="col-12 col-md-6 font-weight-bold"> Permanent City </div>
                <div class="col-12 col-md-6 "> {{ ucfirst($data->user_permanent_city) }}</div>
            </div>
            <div class="col-6 col-lg-4 row mt-2">
                <div class="col-12 col-md-6 font-weight-bold"> Permanent County </div>
                <div class="col-12 col-md-6 "> {{ ucfirst($data->user_permanent_country) }}</div>
            </div>
        </div>

        <!-- Career -->
        <div class="col-12 row">
            <div class="col-12 row mt-4">
                <div class="col-12 font-weight-bold"> 
                    <h4>Education & career</h4>
                   
                </div>
            </div>  
            <div class="col-6 col-lg-4 row mt-2">
                <div class="col-12 col-md-6 font-weight-bold"> Education Level </div>
                <div class="col-12 col-md-6 "> {{ isset($data->educationLevel->name) ? $data->educationLevel->name : 'N/A' }}</div>
            </div>
            <div class="col-6 col-lg-4 row mt-2">
                <div class="col-12 col-md-6 font-weight-bold"> Institute </div>
                <div class="col-12 col-md-6 "> {{ isset($data->edu_institute_name) ? $data->edu_institute_name : 'N/A' }}</div>
            </div>
            <div class="col-6 col-lg-4 row mt-2">
                <div class="col-12 col-md-6 font-weight-bold"> Major subject </div>
                <div class="col-12 col-md-6 "> {{ isset($data->major_subject) ? $data->major_subject : 'N/A' }}</div>
            </div>
            <div class="col-6 col-lg-4 row mt-2">
                <div class="col-12 col-md-6 font-weight-bold"> Working / Post</div>
                <div class="col-12 col-md-6 "> {{ isset($data->career_working_name) ? $data->career_working_name: 'N/A' }}</div>
            </div>          
            <div class="col-6 col-lg-4 row mt-2">
                <div class="col-12 col-md-6 font-weight-bold"> Profession Name</div>
                <div class="col-12 col-md-6 "> {{ isset($data->careerProfession->name) ? $data->careerProfession->name : 'N/A' }}</div>
            </div>
            <div class="col-6 col-lg-4 row mt-2">
                <div class="col-12 col-md-6 font-weight-bold"> Organisation Name</div>
                <div class="col-12 col-md-6 "> {{ !is_null($data->organisation) ? $data->organisation : 'N/A' }}</div>
            </div>
            <div class="col-6 col-lg-4 row mt-2">
                <div class="col-12 col-md-6 font-weight-bold"> Monthly Income </div>
                <div class="col-12 col-md-6 "> {{ isset($data->monthlyIncome->range) ? $data->monthlyIncome->range : 'N/A' }}</div>
            </div>
            
        </div>
        
           
        <div class="col-12 row">
            <div class="col-12 row mt-4">
                <div class="col-12 font-weight-bold"> 
                    <h4>Personal Information</h4>                   
                </div>
            </div>            
            <div class="col-6 col-lg-4 row mt-2">
                <div class="col-12 col-md-6 font-weight-bold"> Height </div>
                <div class="col-12 col-md-6 "> {{ isset($data->user_height) ? $data->user_height : 'N/A' }}</div>
            </div>
            <div class="col-6 col-lg-4 row mt-2">
                <div class="col-12 col-md-6 font-weight-bold"> Blood Group </div>
                <div class="col-12 col-md-6 "> {{ isset($data->user_blood_group) ? $data->user_blood_group : 'N/A' }}</div>
            </div>
            <div class="col-6 col-lg-4 row mt-2">
                <div class="col-12 col-md-6 font-weight-bold"> Blood Weight </div>
                <div class="col-12 col-md-6 "> {{ isset($data->user_body_weight) ? $data->user_body_weight : 'N/A' }}</div>
            </div>
            <div class="col-6 col-lg-4 row mt-2">
                <div class="col-12 col-md-6 font-weight-bold"> Blood Color </div>
                <div class="col-12 col-md-6 "> {{ isset($data->user_body_color) ? $data->user_body_color : 'N/A' }}</div>
            </div>
            <div class="col-6 col-lg-4 row mt-2">
                <div class="col-12 col-md-6 font-weight-bold"> Eye Color </div>
                <div class="col-12 col-md-6 "> {{ isset($data->eye_color) ? $data->eye_color : 'N/A' }}</div>
            </div>
            <div class="col-6 col-lg-4 row mt-2">
                <div class="col-12 col-md-6 font-weight-bold"> Hair Color </div>
                <div class="col-12 col-md-6 "> {{ isset($data->hair_color) ? $data->hair_color : 'N/A' }}</div>
            </div>
            <div class="col-6 col-lg-4 row mt-2">
                <div class="col-12 col-md-6 font-weight-bold"> Complexion </div>
                <div class="col-12 col-md-6 "> {{ isset($data->complexion) ? $data->complexion : 'N/A' }}</div>
            </div>
            <div class="col-6 col-lg-4 row mt-2">
                <div class="col-12 col-md-6 font-weight-bold"> Diet </div>
                <div class="col-12 col-md-6 "> {{ isset($data->diet) ? $data->diet : 'N/A' }}</div>
            </div>
            <div class="col-6 col-lg-4 row mt-2">
                <div class="col-12 col-md-6 font-weight-bold"> Drink </div>
                <div class="col-12 col-md-6 "> {{ isset($data->drink) ? $data->drink : 'N/A' }}</div>
            </div>
            <div class="col-6 col-lg-4 row mt-2">
                <div class="col-12 col-md-6 font-weight-bold"> Fitness Disabilities </div>
                <div class="col-12 col-md-6 "> {{ isset($data->user_fitness_disabilities) ? $data->fitness_disabilities == 'Y' ? 'Yes' : 'No' : 'N/A' }}</div>
            </div>

            <div class="col-6 col-lg-4 row mt-2">
                <div class="col-12 col-md-5 font-weight-bold"> Date of Birth </div>
                <div class="col-12 col-md-7 "> {{ Carbon\Carbon::parse($data->date_of_birth)->format('d-M, Y') }}</div>
            </div>
            <div class="col-6 col-lg-4 row mt-2">
                <div class="col-12 col-md-6 font-weight-bold"> Life Style </div>
                <div class="col-12 col-md-6 "> {{ isset($data->lifestyle_id) ? $data->lifestyle->name : 'N/A' }}</div>
            </div>
            
            <div class="col-6 col-lg-4 row mt-2">
                <div class="col-12 col-md-6 font-weight-bold"> User Status </div>
                <div class="col-12 col-md-6"> {!! $data->user_status  == 1 ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Deactive</span>' !!}</div>
            </div>            
            
            <div class="col-6 col-lg-4 row mt-2">
                <div class="col-12 col-md-6 font-weight-bold"> Email Verify </div>
                <div class="col-12 col-md-6"> {!! is_null($data->email_verified_at) ? '<span class="label label-warning">Unverified</span>' : '<span class="label label-success">Verified</span>' !!}</div>
            </div>
            
            
        </div>

        <div class="col-12 row">
            <div class="col-12 row mt-4">
                <div class="col-12 font-weight-bold"> 
                    <h4>Family Information</h4>                   
                </div>
                <div class="col-6 col-lg-4 row mt-2">
                    <div class="col-12 col-md-6 font-weight-bold"> Father's name </div>
                    <div class="col-12 col-md-6 "> {{ !is_null($data->father_name) ? $data->father_name : 'N/A' }}</div>
                </div>
                <div class="col-6 col-lg-4 row mt-2">
                    <div class="col-12 col-md-6 font-weight-bold"> Mother's Name </div>
                    <div class="col-12 col-md-6 "> {{ !is_null($data->mother_name) ? $data->mother_name : 'N/A' }}</div>
                </div>
                <div class="col-6 col-lg-4 row mt-2">
                    <div class="col-12 col-md-6 font-weight-bold"> Father Occupation </div>
                    <div class="col-12 col-md-6 "> {{ !is_null($data->father_occupation) ? $data->father_occupation : 'N/A' }}</div>
                </div>                
                <div class="col-6 col-lg-4 row mt-2">
                    <div class="col-12 col-md-6 font-weight-bold"> Mother Occupation </div>
                    <div class="col-12 col-md-6 "> {{ !is_null($data->mother_occupation) ? $data->mother_occupation : 'N/A' }}</div>
                </div>
                <div class="col-6 col-lg-4 row mt-2">
                    <div class="col-12 col-md-6 font-weight-bold"> No of Brother </div>
                    <div class="col-12 col-md-6 "> {{ !is_null($data->no_of_brother) ? $data->no_of_brother : 'N/A' }}</div>
                </div>
                <div class="col-6 col-lg-4 row mt-2">
                    <div class="col-12 col-md-6 font-weight-bold"> No of Sister </div>
                    <div class="col-12 col-md-6 "> {{ !is_null($data->no_of_sister) ? $data->no_of_sister : 'N/A' }}</div>
                </div>
                <div class="col-6 col-lg-4 row mt-2">
                    <div class="col-12 col-md-6 font-weight-bold"> No of Children </div>
                    <div class="col-12 col-md-6 "> {{ !is_null($data->no_children) ? $data->no_children : 'N/A' }}</div>
                </div>
                <div class="col-6 col-lg-4 row mt-2">
                    <div class="col-12 col-md-6 font-weight-bold"> Family Value </div>
                    <div class="col-12 col-md-6 "> {{ !is_null($data->family_values) ? $data->family_values : 'N/A' }}</div>
                </div>
                <div class="col-12 row mt-2">
                    <div class="col-12 col-sm-2 font-weight-bold"> Family Details </div>
                    <div class="col-12 col-sm-10 "> {!! !is_null($data->family_details) ? $data->family_details : 'N/A' !!}</div>
                </div>                
            </div>
        </div>

        <div class="col-12 row">
            <div class="col-12 row mt-4">
                <div class="col-12 font-weight-bold"> 
                    <h4>Partner Information</h4>                   
                </div>
                @php
                    $min_height = explode('.', $data->partner_min_height);
                    $max_height = explode('.', $data->partner_max_height);
                @endphp
                <div class="col-12 col-sm-6 row mt-2">
                    <div class="col-12 col-md-6 font-weight-bold"> Min Height </div>
                    <div class="col-12 col-md-6 "> {{ isset($min_height[0]) && !empty($min_height[0]) ? $min_height[0] . 'Feet,' : 'N/A' }} {{ isset($min_height[1]) ? $min_height[1] . 'Inch' : Null }}</div>
                </div>
                <div class="col-12 col-sm-6 row mt-2">
                    <div class="col-12 col-md-6 font-weight-bold"> Max Height </div>
                    <div class="col-12 col-md-6 "> {{ isset($max_height[0]) && !empty($max_height[0]) ? $max_height[0] . 'Feet,' : 'N/A' }} {{ isset($max_height[1]) ? $max_height[1] . 'Inch' : Null }}</div>
                </div>
                <div class="col-12 col-sm-6 row mt-2">
                    <div class="col-12 col-md-6 font-weight-bold"> Min Age </div>
                    <div class="col-12 col-md-6 "> {{ !is_null($data->partner_min_age) ? $data->partner_min_age.'Years' : 'N/A' }} </div>
                </div>
                <div class="col-12 col-sm-6 row mt-2">
                    <div class="col-12 col-md-6 font-weight-bold"> Max Age </div>
                    <div class="col-12 col-md-6 "> {{ !is_null($data->partner_max_age) ? $data->partner_max_age.'Years' : 'N/A' }} </div>
                </div>
                <div class="col-12 col-sm-6 row mt-2">
                    <div class="col-12 col-md-6 font-weight-bold"> Body Color </div>
                    <div class="col-12 col-md-6 "> {{ !is_null($data->partner_body_color) ? $data->partner_body_color : 'N/A' }} </div>
                </div>
                <div class="col-12 col-sm-6 row mt-2">
                    <div class="col-12 col-md-6 font-weight-bold"> Blood Group </div>
                    <div class="col-12 col-md-6 "> {{ !is_null($data->partner_blood_group) && is_array($data->partner_blood_group) ? implode(', ',$data->partner_blood_group) : 'N/A' }} </div>
                </div>
                <div class="col-12 col-sm-6 row mt-2">
                    <div class="col-12 col-md-6 font-weight-bold"> Eye Color </div>
                    <div class="col-12 col-md-6 "> {{ !is_null($data->partner_eye_color) && is_array($data->partner_eye_color) ? implode(', ',$data->partner_eye_color) : 'N/A' }} </div>
                </div>
                <div class="col-12 col-sm-6 row mt-2">
                    <div class="col-12 col-md-6 font-weight-bold"> Complexion </div>
                    <div class="col-12 col-md-6 "> {{ !is_null($data->partner_complexion) && is_array($data->partner_complexion) ? implode(', ',$data->partner_complexion) : 'N/A' }} </div>
                </div>
                <div class="col-12 col-sm-6 row mt-2">
                    <div class="col-12 col-md-6 font-weight-bold"> Diet </div>
                    <div class="col-12 col-md-6 "> {{ !is_null($data->partner_dite) && is_array($data->partner_dite) ? implode(', ',$data->partner_dite) : 'N/A' }} </div>
                </div>
                <div class="col-12 col-sm-6 row mt-2">
                    <div class="col-12 col-md-6 font-weight-bold"> Marital status </div>
                    <div class="col-12 col-md-6 "> {{ !is_null($data->partner_marital_status) && is_array($data->partner_marital_status) ? implode(', ',$data->partner_marital_status) : 'N/A' }} </div>
                </div>
                <div class="col-12 col-sm-6 row mt-2">
                    <div class="col-12 col-md-6 font-weight-bold"> Religion </div>
                    <div class="col-12 col-md-6 "> {{ !is_null($data->partner_religion) && is_array($data->partner_religion) ? implode(', ',$data->partner_religion) : 'N/A' }} </div>
                </div>
                <div class="col-12 col-sm-6 row mt-2">
                    <div class="col-12 col-md-6 font-weight-bold"> Religion Cast</div>
                    <div class="col-12 col-md-6 "> {{ !is_null($data->partner_religion_cast) && is_array($data->partner_religion_cast) ? implode(', ',$data->partner_religion_cast) : 'N/A' }} </div>
                </div>
                <div class="col-12 col-sm-6 row mt-2">
                    <div class="col-12 col-md-6 font-weight-bold"> County</div>
                    <div class="col-12 col-md-6 "> {{ !is_null($data->partner_country) && is_array($data->partner_country) ? implode(', ',$data->partner_country) : 'N/A' }} </div>
                </div>
                <div class="col-12 col-sm-6 row mt-2">
                    <div class="col-12 col-md-6 font-weight-bold"> Mother tongue</div>
                    <div class="col-12 col-md-6 "> {{ !is_null($data->partner_mother_tongue) && is_array($data->partner_mother_tongue) ? implode(', ',$data->partner_mother_tongue) : 'N/A' }} </div>
                </div>
                <div class="col-12 col-sm-6 row mt-2">
                    <div class="col-12 col-md-6 font-weight-bold"> Education</div>
                    <div class="col-12 col-md-6 "> {{ !is_null($data->partner_education) && is_array($data->partner_education) ? implode(', ',$data->partner_education) : 'N/A' }} </div>
                </div>
                <div class="col-12 col-sm-6 row mt-2">
                    <div class="col-12 col-md-6 font-weight-bold"> Profession</div>
                    <div class="col-12 col-md-6 "> {{ !is_null($data->partner_profession) && is_array($data->partner_profession) ? implode(', ',$data->partner_profession) : 'N/A' }} </div>
                </div>
                
            </div>
        </div>

        <div class="col-12"> <hr/> </div>
        <div class="col-6 row">
            <div class="col-12 col-md-5 font-weight-bold"> Account Create Ip</div>
            <div class="col-12 col-md-7 "> {{ isset($data->signup_ip) ? $data->signup_ip : 'N/A' }}</div>
        </div>
        <div class="col-6 row">
            <div class="col-12 col-md-5 font-weight-bold"> Account Create Location</div>
            <div class="col-12 col-md-7 "> 
                @php
                    $ip_details = "";
                    if($data->signup_ip){
                        $ip_details = $data->getIPDetails($data->signup_ip);                        
                    }                    
                @endphp
                {{ isset($ip_details->city) ? $ip_details->city.', '. $ip_details->country : 'N/A'}}
            </div>
        </div>

        <div class="col-6 row">
            <div class="col-12 col-md-5 font-weight-bold"> Created By </div>
            <div class="col-12 col-md-7 "> {{ isset($data->createdBy->name) ? $data->createdBy->name : 'N/A' }}</div>
        </div>
        <div class="col-6 row">
            <div class="col-12 col-md-5 font-weight-bold"> Created At </div>
            <div class="col-12 col-md-7"> {{ Carbon\carbon::parse($data->created_at)->format($system->date_format) }}</div>
        </div>

        <div class="col-6 row">
            <div class="col-12 col-md-5 font-weight-bold"> Updated By </div>
            <div class="col-12 col-md-7 "> {{ isset($data->modifiedBy->name) ? $data->modifiedBy->name : 'N/A'}}</div>
        </div>
        <div class="col-6 row">
            <div class="col-12 col-md-5 font-weight-bold"> Updated At </div>
            <div class="col-12 col-md-7"> {{ Carbon\carbon::parse($data->updated_at)->format($system->date_format) }}</div>
        </div>

    </div>
                    
    <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-danger float-left" data-dismiss="modal">Close</button>
    </div>
</div>