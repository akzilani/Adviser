@extends('backEnd.masterPage')
@section('mainPart')
<style>
    .input-range{width: 46%; float: left; margin-right: 2%;}
</style>

<div class="page-body">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="{{ isset($create) ? 'col-8' : 'col-12' }}" >
                    <h5>{{ ucfirst( str_replace('_', ' ', $pageTitle) ) }}</h5>
                </div>
                @if( isset($create) )
                    <div class="col-4 text-right">
                        <a class="ajax-click-page btn btn-primary btn-sm" href="{{ url($create) }}">Create new</a>
                    </div>
                @endif
            </div>
            
        </div>
        <div class="card-body">
            <div class="filter_input">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Profession</label>
                            <select name="profession_id[]" class="form-control select2" multiple  id="profession_id">
                                @foreach($professions as $profession)
                                    <option value="{{ $profession->id }}">{{ $profession->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Education</label>
                            <select name="education_id[]" class="form-control select2" multiple  id="education_id">
                                <option value="">Select from list</option>
                                @foreach($educations as $education)
                                    <option value="{{ $education->id }}">{{ $education->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Religion</label>
                            <select name="religious_id[]" class="form-control select2" multiple id="religious_id">
                                <option value="">Select from list</option>
                                @foreach($religious as $religion)
                                    <option value="{{ $religion->id }}">{{ $religion->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row">                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>County</label>
                            <select name="country[]" class="form-control select2" id="country" multiple>
                                <option value="">Select from list</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->country }}">{{ $country->country }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Division</label>
                            <select name="division[]" class="form-control select2" id="division" multiple >
                                <option value="">Select All</option>
                                @foreach($divisions as $division)
                                    <option value="{{ $division->id }}">{{ $division->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>District</label>
                            <select name="district[]" class="form-control select2" id="district" multiple>
                                <option value="">Select All</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district->id }}">{{ $district->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-2">
                        <div class="form-group">                            
                            <label>Partner Min Age</label><br>
                            <input type="number" class="form-control" step="1" id="partner_min_age" min="15" max="80" value="15">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">    
                            <label>Partner Max Age</label><br>
                            <input type="number" class="form-control" step="1" id="partner_max_age" min="15" max="100" value="80">                              
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Partnet Max. Height </label><br>
                            <div class="row" style="margin: 0px;">
                                <select class="form-control" style="width:47%;float:left" required name="part_min_feet" id="part_min_feet">
                                    <option value="" selected >All</option>
                                    <option value="3" >3 Feet</option>
                                    <option value="4" >4 Feet</option>
                                    <option value="5" >5 Feet</option>
                                    <option value="6" >6 Feet</option>
                                    <option value="7" >7 Feet</option>
                                    <option value="8" >8 Feet</option>
                                </select>
                                <select class="form-control" style="width:47%;float:left; margin-left:2%;" required name="part_min_inch" id="part_min_inch" >
                                    <option value="" selected >All</option>
                                    <option value="0" >0 Inch </option>
                                    <option value="1" >1 Inch </option>
                                    <option value="2" >2 Inch </option>
                                    <option value="3" >3 Inch </option>
                                    <option value="4" >4 Inch </option>
                                    <option value="5" >5 Inch </option>
                                    <option value="6" >6 Inch </option>
                                    <option value="7" >7 Inch </option>
                                    <option value="8" >8 Inch </option>
                                    <option value="9" >9 Inch </option>
                                    <option value="10" >10 Inch </option>
                                    <option value="11" >11 Inch </option>
                                    <option value="12" >12 Inch </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Partnet Max. Height </label>
                            <div class="row" style="margin: 0px;">
                                <select class="form-control" style="width:47%;float:left" required name="part_max_feet" id="part_max_feet">
                                    <option value="" selected >All</option>
                                    <option value="3"  >3 Feet</option>
                                    <option value="4"  >4 Feet</option>
                                    <option value="5"  >5 Feet</option>
                                    <option value="6" >6 Feet</option>
                                    <option value="7"  >7 Feet</option>
                                    <option value="8" >8 Feet</option>
                                </select>
                                <select class="form-control" style="width:47%;float:left; margin-left:2%;" required name="part_max_inch" id="part_max_inch" >
                                    <option value="" selected >All </option>
                                    <option value="0" >0 Inch </option>
                                    <option value="1" >1 Inch </option>
                                    <option value="2" >2 Inch </option>
                                    <option value="3" >3 Inch </option>
                                    <option value="4" >4 Inch </option>
                                    <option value="5" >5 Inch </option>
                                    <option value="6" >6 Inch </option>
                                    <option value="7" >7 Inch </option>
                                    <option value="8" >8 Inch </option>
                                    <option value="9" >9 Inch </option>
                                    <option value="10" >10 Inch </option>
                                    <option value="11" >11 Inch </option>
                                    <option value="12" >12 Inch </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Gender</label><br>
                            <select name="gender[]" class="form-control select2" id="gender" multiple>
                                <option value="">All</option>
                                <option value="M">Male</option>
                                <option value="F">FeMale</option>
                            </select>                           
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Marital Status</label><br>
                            <select name="marital_status[]" class="form-control select2" id="marital_status" multiple >
                                @foreach($maritalStatus as $mstatus)
                                    <option value="{{ $mstatus->name }}" {{ isset($data->id) && $data->marital_status == $mstatus->name ? 'selected' : Null }} > {{ ucfirst($mstatus->name ) }} </option>
                                @endforeach                               
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-12"> <hr> </div>
                </div>
            </div>

            <div class="dt-responsive table-responsive">
                <table id="table" class="table table-striped table-bordered nowrap">
                    <thead class="{{ isset($tableStyleClass) ? $tableStyleClass : 'bg-primary'}}">
                        <tr>
                            @foreach($tableColumns as $column)
                                <th> @lang('table.'.$column)</th>
                            @endforeach                                
                        </tr>
                    </thead>
                </table>
            </div>

        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog  modal-xl" role="document">
      <div class="modal-content">            
            <div class="modal-header">
                <h5 class="modal-title" > Loading... <img src="{{ asset('loading.svg') }}" width="50"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div> 
            <!--
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" name="btn" class="btn btn-sm btn-primary"> Save </button>
            </div>
            -->
      </div>
    </div>
</div>
  
  
                                                  
<script>
    let table, table2;
    $(function() {
        table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            "ajax" : {
                "url" : '{{ isset($dataTableUrl) && !empty($dataTableUrl) ? $dataTableUrl : URL::current() }}',
                "data" : function(filder_data){
                    filder_data.profession_id = $('#profession_id').val();                    
                    filder_data.education_id = $('#education_id').val();
                    filder_data.religious_id = $('#religious_id').val();
                    filder_data.country = $('#country').val();
                    filder_data.division = $('#division').val();
                    filder_data.district = $('#district').val();
                    filder_data.partner_min_age = $('#partner_min_age').val();
                    filder_data.partner_max_age = $('#partner_max_age').val();
                    filder_data.part_min_feet = $('#part_min_feet').val();
                    filder_data.part_min_inch = $('#part_min_inch').val();
                    filder_data.part_max_feet = $('#part_max_feet').val();
                    filder_data.part_max_inch = $('#part_max_inch').val();
                    filder_data.marital_status = $('#marital_status').val();
                    filder_data.gender = $('#gender').val();
                }
            },
            columns: [
                @foreach($dataTableColumns as $column)
                    { data: '{{ $column }}', name: '{{ $column }}' },
                @endforeach                
            ],
            "lengthMenu": [[25, 50, 100, 500,1000, -1], [25, 50, 100, 500,1000, "All"]],
        });

        $('.filter_input input, .filter_input select').change(function(){
            $('#table').DataTable().draw(true);
        });

        

    });
</script>
@endsection

