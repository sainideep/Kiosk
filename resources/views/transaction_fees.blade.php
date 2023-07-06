@include('header')
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-1">
          <h3 class="content-header-title">Android App Version</h3>
        </div>
        <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
          <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a>
              </li>
             
              <li class="breadcrumb-item active"><a href="#">App Version</a>
              </li>
            </ol>
          </div>
        </div>
      </div>
       <div class="content-body">
        <!-- Striped row layout section start -->
        <section id="striped-row-form-layouts">
           <div class="row justify-content-md-center">
            <div class="col-md-6">
             
               <div class="card">
              <div class="card-header border-0-bottom">
                <h4 class="card-title" style="text-transform: none;">App Version
                </h4>
                 <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                  <div class="heading-elements">
                    <ul class="list-inline mb-0">
                      <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                      <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                      <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                      
                    </ul>
                  </div>
              </div>
              <div class="card-content">
                <div class="card-body">
                     @if(session('status'))                            

                        <div class="alert alert-success">
                           {{ session('status') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                  <div id="weekly-activity-chart" class="height-250">
                 
                    <form class="form form-horizontal striped-rows" action="{{url('/app_version_update')}}" method='post'>
                      @CSRF
                      <div class="form-body">
                        <div class="form-group row">
                          <label class="col-md-12 label-control" style="text-align: left; font-weight: 700;" for="eventRegInput1">Android App Version </label>
                          <div class="col-md-12">
                            <input type="number" id="name" class="form-control" step="any" placeholder="Enter app version value" required name="version" value="{{ $data->version ?? ''}}" >
                          </div>

                          
                        
                      </div>
                     
                      <div class="form-actions center">
                        
                        <button type="submit" class="btn btn-primary">
                          <i class="fa fa-check-square-o"></i> Update
                        </button>
                        
                      </div>
                    </form>                   

                  </div>
                </div>
              </div>
            </div>
            </div>
          </div>
        </section>
        <!-- // Striped row layout section end -->
    </div> 
    </div>
  </div>

@include('footer')

<script src="../../../app-assets/vendors/js/forms/validation/jqBootstrapValidation.js"
  type="text/javascript"></script>
  <script src="../../../app-assets/js/scripts/forms/validation/form-validation.js"
  type="text/javascript"></script>