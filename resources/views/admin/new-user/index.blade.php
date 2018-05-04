<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>trans("Rentling new user wizard")</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/gijgo@1.8.1/combined/css/gijgo.min.css" rel="stylesheet" type="text/css" />  
  <link rel="stylesheet" href="/new-user/css/style.css">
</head>

<body>

  <div class="info">
  <h1>{{trans("Rentling new user wizard")}}</h1>
  <!--<span>-->
    <!--Made with-->
    <!--<i class="fa fa-beer"></i>-->
    <!--by-->
    <!--<a href="">Super Man</a>-->
    <!--<div class="spoilers">-->
      <!--This is ...</a> -->
    <!--</div>-->
  <!--</span>-->
</div>

<div class="row new-user-wizard-step">
  <ul id="progressbar">
    <li class="active"></li>
    <li></li>
    <li></li>
    <li></li>
  </ul>
</div>

<form class="steps" accept-charset="UTF-8" enctype="multipart/form-data" novalidate="" id="NewUserWizardForm">

  <!-- WELCOME FIELD SET --> 
  <fieldset>
    <h2 class="fs-title text-left">trans("Rentling new user wizard")</h2>
      <input type="hidden" name="existUser" id="existUser" value="{{$existUser}}" />
      <input type="hidden" name="invitationID" id="invitationID" value="{{$invitationID}}" />
      <input type="hidden" name="invitationCheck" id="invitationCheck" value="{{$invitationCheck}}" />
    <div class="row mt-5">
      <div class="col-md-8" style="margin-top: 40px;">
        <div class="">
            {{'Short_welcome_key_i18n_test' | translate}}
            trans("Rentling new user wizard")
        </div>
      </div>
      <div class="col-md-4">
        <img src="https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/1stHomeLogo-body-only300.png" width="141" height="151">
      </div>
    </div>
    
    <input type="button" data-page="1" name="next" class="next action-button" value="Next" />    
  </fieldset>

  <!-- AGREEMENT FIELD SET -->  
  <fieldset>
    <h2 class="fs-title text-left">How will you use Rentling<span class="text-danger">*</span></h2>
    <h3 class="fs-subtitle"></h3>
      <div class="row">
          <!-- old version code -->
          <div class="col-md-6">
              <div class="form-control select-type" id="tenant-type">
                  <label class="step-container">
                      <span>As a tenant</span>
                      <input type="radio" name="select-type" value="tenant" onchange="changeUserType('tenant')" @if($existUser == 1 && $selectedType =='tenant') checked @endif>
                      <span class="checkmark"></span>
                  </label>
              </div>
          </div>
          <div class="col-md-6">
              <div class="form-control select-type" id="landlord-type">
                  <label class="step-container">
                      <span>As a landlord</span>
                      <input type="radio"  name="select-type" value="landlord" onchange="changeUserType('landlord')" @if($existUser == 1 && $selectedType =='landlord') checked @endif>
                      <span class="checkmark"></span>
                  </label>
              </div>
          </div>
          <!-- old version code -->
      </div>
    <input type="button" data-page="2" name="previous" class="previous action-button" value="Previous" />
    <input type="button" data-page="2" name="next" class="next action-button" value="Next" disabled="true" id="from-user-type-to"/>
  </fieldset>

  <!-- AGREEMENT FIELD SET -->  
  <fieldset id="landlordProperties">
    <p>Add your properties and their tenants. You can add multiple properties and tenants.</p>
    <h3 class="fs-subtitle"></h3>
      <div class="row"  id="property-rows">
          @if($existUser == 1 && $selectedType == 'landlord' && $invitationCheck == 1)
              <div class="col-md-12 addedDiv" id="property-row0">
                  <div class="row" >
                      <div class="col-md-3">
                          <input type="text" name="address[]" id="address0" readonly class="border-none" value="@if($invitationCheck == 1 && count($property) >0) {{$property->address}} @endif"/>
                      </div>
                      <div class="col-md-2">
                          <input type="text" name="emailTenant[]" id="emailTenant0" readonly class="border-none" value="@if($invitationCheck == 1){{$tenant->email}}@endif"/>
                      </div>
                      <div class="col-md-2">
                          <input type="text" name="nameTenant[]" id="nameTenant0" readonly class="border-none" value="@if($invitationCheck==1){{$tenant->name}}@endif"/>
                      </div>
                      <div class="col-md-3">
                          <input type="text" name="tenantRentList[]" id="tenantRent0" readonly class="border-none" value="@if($invitationCheck == 1 && count($property) >0 && ($property->parent_id)) Only a room @else Whole Apartment @endif"/>
                      </div>
                      <input type="hidden" name="zipCode[]" id="zipCode0" />
                      <input type="hidden" name="city[]" id="city0" />
                      <input type="hidden" name="state[]" id="state0" />
                      <input type="hidden" name="country[]" id="country0" />
                      <input type="hidden" name="street[]" id="street0" />
                      <input type="hidden" name="streetNo[]" id="streetNo0" />
                      <input type="hidden" name="lat[]" id="lat0" />
                      <input type="hidden" name="lng[]" id="lng0" />
                      <div class="col-md-2">
                          <button  type="button" class="btn btn-primary edit-details" onclick="editDetails(this)"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                          <button  type="button" class="btn btn-danger remove-details" onclick="removeDetails(this)"><i class="fa fa-times" aria-hidden="true"></i></button>
                      </div>
                  </div>
              </div>
          @endif
      </div>
    <div class="row">
        <div class="col-md-3">
            <input type="text"  placeholder="Address (Street, Number, City, Country and see the magic)" id="address" />
            <div class="alert alert-danger padding-5" role="alert" id="addressError" style="display: none;">
                <p class="bottom-p">Please enter address.</p>
            </div>
            <div class="alert alert-danger padding-5" role="alert" id="addressInvalidError" style="display: none;">
                <p class="bottom-p">Please enter correct address.</p>
            </div>
        </div>
        <div class="col-md-3">
            <input type="email"  placeholder="Email tenant" id="emailTenant" >
            <div class="alert alert-danger padding-5" role="alert" id="emailTenantError" style="display: none;">
                <p class="bottom-p">Please enter a email.</p>
            </div>
            <div class="alert alert-danger padding-5" role="alert" id="emailTenantIncorrectError" style="display: none;">
                <p class="bottom-p">Please enter a valid email.</p>
            </div>
        </div>
        <div class="col-md-3">
            <input type="text"  placeholder="Name tenant"  id="nameTenant">
            <div class="alert alert-danger padding-5" role="alert" id="nameTenantError" style="display: none;">
                <p class="bottom-p">Please enter a name.</p>
            </div>
        </div>
        <div class="col-md-3">
            <select name="tenantRent" id="tenantRent" >
                <option value="">Select Tenant Rent Type</option>
                <option value="apartment">Whole Apartment</option>
                <option value="room">Only a room</option>
            </select>
            <div class="alert alert-danger padding-5" role="alert" id="tenantRentError" style="display: none;">
                <p class="bottom-p">Please select tenant rent.</p>
            </div>
        </div>

    </div>
      <div class="row">
          <div class="col-md-12">
              <input type="button" class="action-button property-add" value="Save"  onclick="saveDetails()" data-page="3"/>
          </div>
      </div>
    <input type="button" data-page="3" name="previous" class="previous action-button" value="Previous" />
    <!--<input type="button" data-page="3" name="next" class="review wide-btn next action-button" value="Review and Submit"  id="review-next-landlord-action-button"  />-->
      <input type="button" data-page="3" name="next" class="next action-button" value="Next" id="next-landlord-action-button-step" />
  </fieldset>

  <!-- rentling for tenants -->
  <fieldset id="tenantRentlingLandlord">
    <h2 class="fs-title text-left">Rentling for tenants<span class="text-danger">*</span></h2>
    <h3 class="fs-subtitle text-left">
        We're glad you are trying Rentling, our system also makes your life as a tenant easier. To work effectively, Rentling also needs your landlord to signup. Please provide landlord contact details below and we'll invite them to Rentling. After landlord signs up, we'll then send you a message to login and install our App.
    </h3>
      <div class="row">
          <div class="col-md-12">
              <input class="form-control mb-0" id="tenant-address" name="tenant-address" required="required" data-rule-required="true" data-msg-required="Please enter a address you rent" type="text">
              <span class="error1 error1-short" style="display: none;">
                            <i class="error-log fa fa-exclamation-triangle"></i>
                        </span>
              <label class="below-description">Address you rent</label>
              <div class="alert alert-danger padding-5" role="alert" id="tenantAddressError" style="display: none;">
                  <p class="bottom-p">Please enter address.</p>
              </div>
              <div class="alert alert-danger padding-5" role="alert" id="tenantAddressInvalidError" style="display: none;">
                  <p class="bottom-p">Please enter correct address.</p>
              </div>
              <input type="hidden" name="tenant-address-city"  id="tenant-address-city"/>
              <input type="hidden" name="tenant-address-country"  id="tenant-address-country"/>
              <input type="hidden" name="tenant-address-state"  id="tenant-address-state"/>
              <input type="hidden" name="tenant-address-zipcode"  id="tenant-address-zipcode"/>
              <input type="hidden" name="tenant-address-street"  id="tenant-address-street"/>
              <input type="hidden" name="tenant-address-street-no"  id="tenant-address-street-no"/>
              <input type="hidden" name="tenant-address-lat"  id="tenant-address-lat"/>
              <input type="hidden" name="tenant-address-lng"  id="tenant-address-lng"/>
          </div>
      </div>
        <div class="row" style="margin-bottom: 30px;">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        {{--<input class="form-control mb-0" id="landlord-name" name="landlord-name" required="required" data-rule-required="true" data-msg-required="Please enter a landlord name" type="text" value="@if($existUser == 1 &&  $selectedType =='tenant') {{$landlord->name}} @endif">--}}
                        <input class="form-control mb-0" id="landlord-name" name="landlord-name" required="required" data-rule-required="true" data-msg-required="Please enter a landlord name" type="text">
                        <span class="error1 error2-short" style="display: none;">
                            <i class="error-log fa fa-exclamation-triangle"></i>
                        </span>
                        <label class="below-description">Landlord Name</label>
                    </div>
                    <div class="col-md-12">
                        {{--<input class="form-control mb-0" id="landlord-email" name="landlord-email" required="required" data-msg-required="Please enter a email" type="email" value="@if($existUser == 1 && $selectedType =='tenant') {{$landlord->email}} @endif">--}}
                        <input class="form-control mb-0" id="landlord-email" name="landlord-email" required="required" data-msg-required="Please enter a email" type="email" >
                        <span class="error1 error2-short" style="display: none;">
                          <i class="error-log fa fa-exclamation-triangle"></i>
                      </span>
                        <label class="below-description">Landlord Email</label>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <label class="below-description">How do you rent?</label>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="step-container">
                                    <span>A room in the house/apartment</span>
                                    <input type="radio" name="rent-type" value="room" checked>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="step-container">
                                    <span>The whole house/apartment</span>
                                    <input type="radio"  name="rent-type" value="apartment">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" style="margin-top:30px;">
                        <div class="calendar-wrapper" id="">
                            <input type="text" id="tenant-start-date" name="tenant-start-date"  placeholder="Start date of rental contract" class="datepicker-start-date"/>
                        </div>
                        <label class="below-description">Start Date</label>

                        <div class="alert alert-danger padding-5" role="alert" id="tenantStartDateError" style="display: none;">
                            <p class="bottom-p">Please enter start date.</p>
                        </div>
                        <div class="alert alert-danger padding-5" role="alert" id="tenantStartDateValidError" style="display: none;">
                            <p class="bottom-p">Please enter correct start date.</p>
                        </div>
                    </div>

                    {{--<div class="col-md-12">--}}
                        {{--<div class="form-control border-none">--}}
                            {{--<label class="step-container">--}}
                                {{--<span>A room in the house/apartment</span>--}}
                                {{--<input type="radio" name="rent-type" value="room" checked>--}}
                                {{--<span class="checkmark"></span>--}}
                            {{--</label>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="col-md-12">--}}
                        {{--<div class="form-control border-none">--}}
                            {{--<label class="step-container">--}}
                                {{--<span>The whole house/apartment</span>--}}
                                {{--<input type="radio"  name="rent-type" value="apartment">--}}
                                {{--<span class="checkmark"></span>--}}
                            {{--</label>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>
            </div>
        </div>
    <input type="button" data-page="4" name="previous" class="previous action-button" value="Previous" />
    <input type="button" data-page="4" name="next" class="review wide-btn next action-button" value="Review and Submit"  id="review-next-tenant-action-button" />
  </fieldset>
  <fieldset>
      <!--<h2 class="fs-title text-left"></h2>-->
      <h3 class="fs-subtitle text-left">
          We have found tenants below in Rentling with identical email as you supplied earlier. If this is your tenant, please enter the start date of the rental contract.
      </h3>
      <div class="row" id="foundTenantRows"></div>
      <input type="button" data-page="5" name="previous" class="previous action-button" value="Previous" />
      <input type="button" data-page="5" name="next" class="review wide-btn next action-button" value="Review and Submit" id="review-next-landlord-action-button" />
  </fieldset>
  <fieldset>
    <h2 class="fs-title text-left">Review<span class="text-danger"></span></h2>
    <h3 class="fs-subtitle text-left"></h3>
    <div class="" id="review-content">            
        
    </div>        
    <input type="button" data-page="6" name="previous" class="previous wide-btn backform action-button" value="Back To Form" />
    <input type="button" data-page="6" name="next" class="submit wide-btn action-button" value="Submit" />
  </fieldset>
</form>

  <div class="col-md-12 addedDiv" id="cloneObjectDiv" style="display: none">
      <div class="row" >
          <div class="col-md-3">
              <input type="text" name="address[]" id="cloneAddress" readonly class="border-none"/>
          </div>
          <div class="col-md-2">
              <input type="text" name="emailTenant[]" id="cloneEmailTenant" readonly class="border-none"/>
          </div>
          <div class="col-md-2">
              <input type="text" name="nameTenant[]" id="cloneNameTenant" readonly class="border-none"/>
          </div>
          <div class="col-md-3">
              <input type="text" name="tenantRentList[]" id="cloneTenantRent" readonly class="border-none"/>
          </div>
          <input type="hidden" name="zipCode[]" id="cloneZipCode" />
          <input type="hidden" name="city[]" id="cloneCity" />
          <input type="hidden" name="state[]" id="cloneState" />
          <input type="hidden" name="country[]" id="cloneCountry" />
          <input type="hidden" name="street[]" id="cloneStreet" />
          <input type="hidden" name="streetNo[]" id="cloneStreetNo" />
          <input type="hidden" name="lat[]" id="cloneLat" />
          <input type="hidden" name="lng[]" id="cloneLng" />
          <div class="col-md-2">
              <button  type="button" class="btn btn-primary edit-details" onclick="editDetails(this)"><i class="fa fa-pencil" aria-hidden="true"></i></button>
              <button  type="button" class="btn btn-danger remove-details" onclick="removeDetails(this)"><i class="fa fa-times" aria-hidden="true"></i></button>
          </div>
      </div>
  </div>

  <div class="col-md-12 tenantStartRentalDiv" id="cloneTenantStartRentalDiv" style="display:none">
      <div class="row">
          <div class="col-md-6 col-sm-6"><input type="text" readonly id="cloneTenantName" placeholder="Tenant Name" name="tenantName[]"/></div>
          <div class="col-md-6 col-sm-6">
              <div class="calendar-wrapper" id="">
                  <input type="text" id="cloneStartDate" placeholder="Start date of rental contract" class="clonedatepicker" name="startDate[]"/>
              </div>
          </div>
          <input type="hidden" id="cloneTenantID" name="tenantID[]" />
          <input type="hidden" id="cloneExistTenantEmail" name="exitTenantEmail[]">
      </div>
  </div>



<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js'></script>
<script src='https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/gijgo@1.8.1/combined/js/gijgo.min.js" type="text/javascript"></script>
<script  src="/new-user/js/index.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB2m82gD2lr_zNPDvAtAgjvPOKT411iHZc&libraries=places&callback=initAutocomplete" async defer></script>

</body>
</html>
