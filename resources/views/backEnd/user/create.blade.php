<div class="modal-content">            
    <div class="modal-header">
        <h5 class="modal-title" > {{ isset($data->id) ? 'Edit ' : 'Add ' }} User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> 
    {!! Form::open(['route'=>'user.create', 'method' => 'post', 'files' => 'true','class'=>'ajax-form']) !!}
        <input type="hidden" name="id" value="{{ isset($data->id) ? $data->id : 0 }}" >   
        <div class="modal-body">
            <div class="page">
                <div class="row">
                    <div class="col-12">
                        <h3>Basic Profile</h3>
                        <hr/>
                    </div>

                    <!-- Ceating Account -->
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Creating Account<span class="text-danger">*</span> </label>
                            <select name="creating_account" required class="form-control">
                                <option value="">Select Option</option>
                                <option value="self" {{ isset($data->id) && $data->creating_account == 'self' ? 'selected' : Null }} > {{ ucfirst('self') }} </option>
                                <option value="brother" {{ isset($data->id) && $data->creating_account == 'brother' ? 'selected' : Null }} > {{ ucfirst('brother') }} </option>
                                <option value="sister" {{ isset($data->id) && $data->creating_account == 'sister' ? 'selected' : Null }} > {{ ucfirst('sister') }} </option>
                                <option value="friend" {{ isset($data->id) && $data->creating_account == 'friend' ? 'selected' : Null }} > {{ ucfirst('friend') }} </option>
                                <option value="relatives" {{ isset($data->id) && $data->creating_account == 'relatives' ? 'selected' : Null }} > {{ ucfirst('relatives') }} </option>
                                <option value="father" {{ isset($data->id) && $data->creating_account == 'father' ? 'selected' : Null }} > {{ ucfirst('father') }} </option>
                                <option value="mother" {{ isset($data->id) && $data->creating_account == 'mother' ? 'selected' : Null }} > {{ ucfirst('mother') }} </option>
                            </select>
                        </div>
                    </div>
                    <!-- Looking for -->
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Looking For <span class="text-danger">*</span> </label>                                                        
                            <select name="looking_for" required class="form-control">
                                <option value="">Select Option</option>
                                <option value="bride" {{ isset($data->id) && $data->looking_for == 'bride' ? 'selected' : Null }} > {{ ucfirst('bride') }} </option>
                                <option value="groom" {{ isset($data->id) && $data->looking_for == 'groom' ? 'selected' : Null }} > {{ ucfirst('groom') }} </option>
                            </select>
                        </div>
                    </div>
                    <!-- Email -->
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Email <span class="text-danger">*</span> </label>
                            <input type="email" placeholder="example@gmail.com" name="email" value="{{ isset($data->id) ? $data->email : Null }}" class="form-control" required >
                        </div>
                    </div>

                    <!-- Merital Status for -->
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Marital Status<span class="text-danger">*</span> </label>                                                        
                            <select name="marital_status" required class="form-control">
                                <option value="">Select Option</option>
                                @foreach($maritalStatus as $mstatus)
                                    <option value="{{ $mstatus->name }}" {{ isset($data->id) && $data->marital_status == $mstatus->name ? 'selected' : Null }} > {{ ucfirst($mstatus->name ) }} </option>
                                @endforeach                                
                            </select>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="col-6 col-sm-6">
                        <div class="form-group">
                            <label>Phone </label>
                            <input type="tel" placeholder="Phone" value="{{ isset($data->id) ? $data->phone : Null }}" name="phone" class="form-control" >
                        </div>
                    </div>

                    <!-- Gardian Contact -->
                    <div class="col-6 col-sm-6">
                        <div class="form-group">
                            <label>Gardian contact Number</label>
                            <input type="tel" placeholder="Gardian Contact Number" value="{{ isset($data->id) ? $data->gardian_contact_no : Null }}" name="gardian_contact_no" class="form-control" >
                        </div>
                    </div>

                     <!-- First Name -->
                     <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>First Name <span class="text-danger">*</span> </label>                                                        
                            <input type="text" placeholder="your First Name" name="first_name" value="{{ isset($data->id) ? $data->first_name : Null }}" class="form-control" required >                        
                        </div>
                    </div>
                    
                    <!-- Last Name -->
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Last Name  </label>                              
                            <input type="text" placeholder="your Last Name" name="last_name" value="{{ isset($data->id) ? $data->last_name : Null }}" class="form-control"  >                        
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Password <span class="text-danger">{{ isset($data->id) ? Null : '*' }}</span></label>                                
                            <input type="password"  placeholder="Password" class="form-control password is-invalid" name="password" minlength="8" minlength="18" autocomplete="off" {{ isset($data->id) ? Null : 'required'}}>
                        </div>                        
                    </div>

                    <!-- Gender -->
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Gender<span class="text-danger">*</span> </label><br>
                            <label>
                                <input type="radio" name="gender" value="M" {{ isset($data->id) && $data->gender == 'M' ? 'checked' : Null }} > Male
                                <input type="radio" name="gender" value="F" {{ isset($data->id) && $data->gender == 'F' ? 'checked' : Null }} > Female
                            </label>
                            
                        </div>
                    </div>
                    

                    <!-- Date of birth -->
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Date of Birth <span class="text-danger">*</span> </label>                              
                            <input type="date" placeholder="Date of birth" name="date_of_birth" value="{{ isset($data->id) ? $data->date_of_birth : Carbon\Carbon::now()->subYears(18)->format('Y-m-d') }}" max="{{ Carbon\Carbon::now()->subYears(12)->format('Y-m-d')}}" class="form-control" required >                        
                        </div>
                    </div>

                    <!-- Religion -->
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Religion <span class="text-danger">*</span> </label>                                                        
                            <select name="religious_id" required class="form-control religion">
                                <option value="">Select Option</option>
                                @foreach($religions as $religion)
                                    <option value="{{$religion->id}}" {{ isset($data->id) && $data->religious_id == $religion->id ? 'selected' : Null }} > {{ ucfirst($religion->name.'-'.$religion->short_name) }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Religion Cast-->
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Religion Cast</label>                                                        
                            <select name="religious_cast_id" class="form-control religion-cast">
                                <option value="">Select Option</option>
                                @if( isset($data->id) && !empty($data->religious_cast_id) )
                                <option value="{{ $data->religious_cast_id }}" selected > {{ $data->religionCast->name}}</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <!-- County -->
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>County <span class="text-danger">*</span></label>                            
                            <select name="location_country" class="form-control" required >
                                <option value="">Select County</option>
                                @foreach($countries as $country)
                                <option value="{{ $country->country }}" {{ isset($data->id) && $country->country == $data->location_country ? 'selected' : Null }} >{{ ucfirst($country->country) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <!-- NID -->
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>NID</label>                              
                            <input type="text" placeholder="Your NID no" name="nid" value="{{ isset($data->id) ? $data->nid : Null }}" class="form-control"  >                        
                        </div>
                    </div>

                    <!-- NID -->
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Passport</label>                              
                            <input type="text" placeholder="Your Passport No" name="passport" value="{{ isset($data->id) ? $data->passport : Null }}" class="form-control"  >                        
                        </div>
                    </div>

                    <!-- Bio data -->
                    <div class="col-12 col-sm-6">
                        <div class="form-group"> 
                            <label>Bio Data</label><br>
                            <input type="file" name="user_bio_data_path" >
                        </div>
                    </div>

                </div>                
                <div class="modal-footer">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-end">                               
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                              </li>                   
                            <li class="page-item">
                                <button type="button" class="page-link next-page" > Next </button>
                            </li>
                            <li class="page-item">
                                <button type="button" class="btn btn-sm btn-danger float-left" data-dismiss="modal">Close</button>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

            <!-- second Page -->
            <div class="page d-none">
                <div class="row">
                    <div class="col-12">
                        <h3>Address</h3>
                        <hr />
                    </div>
                    <!-- Present Address -->
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Present Address</label>                              
                            <input type="text" placeholder="Your Present Address" name="user_present_address" value="{{ isset($data->id) ? $data->user_present_address : Null }}" class="form-control"  >                        
                        </div>
                    </div>
                    <!-- Present City -->
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Present City</label>                              
                            <input type="text" placeholder="Your Present City" name="user_present_city" value="{{ isset($data->id) ? $data->user_present_city : Null }}" class="form-control"  >                        
                        </div>
                    </div>
                    <!-- user_present_country -->
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Present County</label>                              
                            <select name="user_present_country" class="form-control" >
                                <option value="">Select County</option>
                                @foreach($countries as $country)
                                <option value="{{ $country->country }}" {{ isset($data->id) && $country->country == $data->user_present_country ? 'selected' : Null }} >{{ ucfirst($country->country) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <br>
                            <label> <input type="checkbox" id="same-address"> Same as Permanent</label>
                        </div>
                    </div>

                    <!-- Permanent Address -->
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Permanent Address</label>                              
                            <input type="text" placeholder="Your Permanent Address" name="user_permanent_address" value="{{ isset($data->id) ? $data->user_permanent_address : Null }}" class="form-control"  >                        
                        </div>
                    </div>
                    <!-- Permanent City -->
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Permanent City</label>                              
                            <input type="text" placeholder="Your Permanent City" name="user_permanent_city" value="{{ isset($data->id) ? $data->user_permanent_city : Null }}" class="form-control"  >                        
                        </div>
                    </div>
                    <!-- user_permanent_country -->
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Permanent County</label>                              
                            <select name="user_permanent_country" class="form-control" >
                                <option value="">Select County</option>
                                @foreach($countries as $country)
                                <option value="{{ $country->country }}" {{ isset($data->id) && $country->country == $data->user_permanent_country ? 'selected' : Null }} >{{ ucfirst($country->country) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>                
                <div class="modal-footer">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-end">                               
                            <li class="page-item">
                                <button type="button" class="page-link prev-page" > Previous </button>
                                </li>                   
                            <li class="page-item">
                                <button type="button" class="page-link next-page" > Next </button>
                            </li>
                            <li class="page-item">
                                <button type="button" class="btn btn-sm btn-danger float-left" data-dismiss="modal">Close</button>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

            <!-- Third Page -->
            <div class="page d-none">
                <div class="row">
                    <div class="col-12">
                        <h3>Career</h3>
                        <hr/>
                    </div>

                    <!-- career_working_name -->   
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Designation / Post</label>                              
                            <input type="text" placeholder="Working Name" name="career_working_name" value="{{ isset($data->id) ? $data->career_working_name : Null }}" class="form-control"  >                        
                        </div>
                    </div>

                    <!-- Organisation -->   
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Organisation name</label>                              
                            <input type="text" placeholder="Organisation name" name="organisation" value="{{ isset($data->id) ? $data->organisation : Null }}" class="form-control"  >                        
                        </div>
                    </div>

                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Working Profession</label>                              
                            <select name="career_working_profession_id" class="form-control" >
                                <option value="">Select Profession</option>
                                @foreach($professions as $profession)
                                <option value="{{ $profession->id }}" {{ isset($data->id) && $profession->id == $data->career_working_profession_id ? 'selected' : Null }} >{{ ucfirst($profession->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Monthly Income -->
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Monthly Income</label>                              
                            <select name="career_monthly_income_id" class="form-control" >
                                <option value="">Select Income Range</option>
                                @foreach($incomes as $income)
                                <option value="{{ $income->id }}" {{ isset($data->id) && $income->id == $data->career_monthly_income_id ? 'selected' : Null }} >{{ ucfirst($income->range) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <h3>Education</h3>
                        <hr/>
                    </div>

                    <!-- Education Level -->                    
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Education Lavel</label>                          
                            <select name="education_level_id" class="form-control" >
                                <option value="">Select Education</option>
                                @foreach($educations as $education)
                                <option value="{{ $education->id }}" {{ isset($data->id) && $education->id == $data->education_level_id ? 'selected' : Null }} >{{ ucfirst($education->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- edu_institute_name -->                    
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Institute Name</label>                          
                            <input type="text" placeholder="Institute Name" name="edu_institute_name" value="{{ isset($data->id) ? $data->edu_institute_name : Null }}" class="form-control"  >                        
                        </div>
                    </div>

                </div>                
                <div class="modal-footer">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-end">                               
                            <li class="page-item">
                                <button type="button" class="page-link prev-page" > Previous </button>
                                </li>                   
                            <li class="page-item">
                                <button type="button" class="page-link next-page" > Next </button>
                            </li>
                            <li class="page-item">
                                <button type="button" class="btn btn-sm btn-danger float-left" data-dismiss="modal">Close</button>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

            <!-- Fourth Page-->
            <div class="page d-none">
                <div class="row">
                    <div class="col-12">
                        <h3>Others</h3>
                        <hr/>
                    </div>
                    <!-- Height -->                    
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Height</label>                          
                            <input type="text" placeholder="Height" name="user_height" value="{{ isset($data->id) ? $data->user_height : Null }}" class="form-control"  >                        
                        </div>
                    </div>
                    <!-- Blood Group -->                    
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Blood Group</label>                          
                            <input type="text" placeholder="Blood Group" name="user_blood_group" value="{{ isset($data->id) ? $data->user_blood_group : Null }}" class="form-control"  >                        
                        </div>
                    </div>
                    <!-- user_body_weight -->                    
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Body Weight</label>                          
                            <input type="text" placeholder="Body Weight" name="user_body_weight" value="{{ isset($data->id) ? $data->user_body_weight : Null }}" class="form-control"  >                        
                        </div>
                    </div>

                    <!-- user_body_color -->                    
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Body color</label>                          
                            <input type="text" placeholder="Body color" name="user_body_color" value="{{ isset($data->id) ? $data->user_body_color : Null }}" class="form-control"  >                        
                        </div>
                    </div>
                    <!-- Number of Brother -->                    
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Number of Brother</label>                          
                            <input type="text" placeholder="Number of Brother" name="no_of_brother" value="{{ isset($data->id) ? $data->no_of_brother : Null }}" class="form-control"  >                        
                        </div>
                    </div>
                    <!-- Number of Sister -->                    
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Number of Sister</label>                          
                            <input type="text" placeholder="Number of Sister" name="no_of_sister" value="{{ isset($data->id) ? $data->no_of_sister : Null }}" class="form-control"  >                        
                        </div>
                    </div>

                    <!-- father_occupation -->                    
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Father's occupation</label>                          
                            <input type="text" placeholder="Father's occupation" name="father_occupation" value="{{ isset($data->id) ? $data->father_occupation : Null }}" class="form-control"  >                        
                        </div>
                    </div>
                    <!-- father_name -->                    
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Father's Name</label>                          
                            <input type="text" placeholder="Father's Name" name="father_name" value="{{ isset($data->id) ? $data->father_name : Null }}" class="form-control"  >                        
                        </div>
                    </div>

                    <!-- mother_namen -->                    
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Mother's Name</label>                          
                            <input type="text" placeholder="Mother's name" name="mother_name" value="{{ isset($data->id) ? $data->mother_name : Null }}" class="form-control"  >                        
                        </div>
                    </div>
                    <!-- mother_occupation -->                    
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Mother's occupation</label>                          
                            <input type="text" placeholder="Mother's occupation" name="mother_occupation" value="{{ isset($data->id) ? $data->mother_occupation : Null }}" class="form-control"  >                        
                        </div>
                    </div>

                    <!-- user_fitness_disabilities -->                    
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Fitness Disabilities</label>                          
                            <select name="user_fitness_disabilities" class="form-control" >
                                <option value="N" {{ isset($data->id) && $data->user_fitness_disabilities == "N" ? 'selected': Null }} >No</option>
                                <option value="Y" {{ isset($data->id) && $data->user_fitness_disabilities == "Y" ? 'selected': Null }} >Yes</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Status -->
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Smoke </label>                                                        
                            <select name="smoke" required class="form-control">
                                <option value="No" {{ isset($data->id) && !$data->smoke == "No" ? 'selected' : Null }} > No </option>
                                <option value="Yes" {{ isset($data->id) && $data->smoke == "Yes" ? 'selected' : Null }} > Yes </option>      
                            </select>
                        </div>
                    </div>

                    <!-- Email Validation -->
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="email_verified_at" value="1" {{ !empty($data->email_verified_at) ? 'checked' : Null }} >
                                Email Validation
                            </label>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span> </label>                                                        
                            <select name="user_status" required class="form-control">
                                <option value="1" {{ isset($data->id) && $data->user_status ? 'selected' : Null }} > Active </option>
                                <option value="0" {{ isset($data->id) && !$data->user_status ? 'selected' : Null }} > Dective </option>
                            </select>
                        </div>
                    </div> 

                    <div class="col-12">
                        <div class="form-group">
                            <label>Comments</label> 
                            <textarea name="comments" class="form-control">{!! isset($data->comments) ? $data->comments : Null !!}</textarea>                       
                        </div>
                    </div>

                    <!-- Profile Image -->
                    <div class="col-12 col-sm-6">
                        <div class="form-group"> 
                            <label>Profile Image</label><br>
                            <input type="file" name="image_path" accept="image/png,image/jpeg" >
                        </div>
                    </div>

                    <div class="col-12 col-sm-6">
                        <label>Uploading</label>
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"> 0% </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-end">
                            <li class="page-item">
                                <button type="button" class="btn btn-sm btn-danger float-left" data-dismiss="modal">Close</button>
                            </li>                      
                            <li class="page-item">
                                <button type="button" class="page-link prev-page" >Previous</button>
                            </li>
                            <li class="page-item">
                                <button type="submit" class="page-link btn-primary">Save</button>
                            </li>
                        </ul>
                    </nav>
                </div>   
            </div>

            {{-- <div class="modal-footer">
                
                <button type="button" class="btn btn-sm btn-danger float-left" data-dismiss="modal">Close</button>
                <button type="submit" name="btn" class="btn btn-sm btn-primary"> Save </button>
            </div> --}}
        </div>
    {!! Form::close() !!}
</div>

<script>
    $(document).on('click', '.next-page', function(){
        let current_page = $(this).parents('.page');
        current_page.addClass('d-none');        
        current_page.next().removeClass('d-none');
    });
    $(document).on('click', '.prev-page', function(){
        let current_page = $(this).parents('.page');
        current_page.addClass('d-none');        
        current_page.prev().removeClass('d-none');
    });


    $('input[type="password"]').keyup(function(){
        let text = $(this).val();
        if( text.length >= 8 && text.length <= 18){
            $(this).removeClass('is-invalid');
            $(this).addClass('is-valid');
        }else{
            $(this).removeClass('is-valid');
            $(this).addClass('is-invalid');
        }
    });

    $('#same-address').change(function(){
        if( $(this).is(':checked') ){
            $('input[name="user_permanent_city"]').val($('input[name="user_present_city"]').val());
            $('input[name="user_permanent_address"]').val($('input[name="user_present_address"]').val());
            $('select[name="user_permanent_country"]').val($('select[name="user_present_country"]').val());
        }else{
            $('input[name="user_permanent_city"]').val("");
            $('input[name="user_permanent_address"]').val("");
            $('select[name="user_permanent_country"]').val("");
        }
    });

    $('.religion').on('change', function(){
        let id = $(this).val();
        let old_val = $('.religion-cast').val();
        $.ajax({
            url : "{{ route('religious.cast.get')}}",
            data : { id : id},
            success : function(output){
                let option = `<option value="">Select Option</option>`;
                output.forEach( function(index){           
                    option += `<option value = "`+index.id+`"`;
                    option += index.id == old_val ? `selected` : ``;
                    option += `>` + index.name +`</option>`;
                });
                $('.religion-cast').html(option);
            },error : function(output){
                // console.log(output);
            }
        });
    });

    $(document).ready(function(){
        $('.religion').change();
    });

</script>