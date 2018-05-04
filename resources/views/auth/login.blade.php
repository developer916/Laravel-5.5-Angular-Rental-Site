@extends('admin.layouts.login')


{{-- Web site Title --}}
@section('title') {{{ trans('login.login_title') }}} :: @parent @stop

{{-- Content --}}
@section('content')
    <form class="login-form" role="form" method="POST" action="{!! URL::to('/auth/login') !!}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="form-title">
            <span class="form-title">{{{ trans('login.welcome') }}}</span>
            <span class="form-subtitle">{{{ trans('login.please_login') }}}</span>
        </div>
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
			<span>
			{{{ trans('login.enter_password') }}}</span>
        </div>

        @if(Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif

        @if(Session::has('message'))
            <div class="alert alert-success">
                {{ Session::get('message') }}
            </div>
        @endif

        @if(Session::has('set_password'))
            <div class="alert alert-success">
                {{ Session::get('set_password') }}
            </div>
        @endif

        <?php if($errors->first('email')) { ?>
        <div class="alert alert-danger">
            <button data-close="alert" class="close"></button>
			<span>
			{{ $errors->first('email', ':message') }}</span>
        </div>
        <?php } ?>

        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">{{{ trans('login.username') }}}</label>

            <div class="input-icon">
                <i class="fa fa-envelope"></i>
                <input class="form-control placeholder-no-fix" type="email" autocomplete="off"
                       placeholder="{{{ trans('login.username') }}}" name="email" value="{{ old('email') }}"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">{{{ trans('login.password') }}}</label>

            <div class="input-icon">
                <i class="fa fa-lock"></i>
                <input class="form-control placeholder-no-fix" type="password" autocomplete="off"
                       placeholder="{{{ trans('login.password') }}}" name="password"/>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary btn-block uppercase margin-bottom-s">
                {{{ trans('login.login') }}} <i class="m-icon-swapright m-icon-white"></i>
            </button>
            <div class="pull-left md-checkbox rememberme">

                {{--<select class="form-control login-language" name="lang" id="lang">--}}
                {{--<option value="en">English</option>--}}
                {{--<option value="nl">Nederlandse</option>--}}
                {{--</select>--}}
                {{--<select name="locale" class="form-control login-language">--}}
                {{--<option value="en">English</option>--}}
                {{--<option value="nl">Nederlandse</option>--}}
                {{--</select>--}}
                {{--<input type="checkbox" id="rememberme" name="remember" class="md-check" value="1"/>--}}
                {{--<label for="rememberme">--}}
                {{--{{trans('Remember me')}}--}}
                {{--<span></span>--}}
                {{--<span class="check"></span>--}}
                {{--<span class="box"></span>--}}
                {{--</label>--}}
            </div>
            <div class="pull-right forget-password-block">
                <a href="javascript:;" id="forget-password">{{{ trans('login.forgot_password') }}}</a>
            </div>
        </div>
        {{--<div class="login-options">--}}
        {{--<h4>Or login with</h4>--}}
        {{--<ul class="social-icons">--}}
        {{--<li>--}}
        {{--<a class="facebook" data-original-title="facebook" href="javascript:;">--}}
        {{--</a>--}}
        {{--</li>--}}
        {{--<li>--}}
        {{--<a class="twitter" data-original-title="Twitter" href="javascript:;">--}}
        {{--</a>--}}
        {{--</li>--}}
        {{--<li>--}}
        {{--<a class="googleplus" data-original-title="Goole Plus" href="javascript:;">--}}
        {{--</a>--}}
        {{--</li>--}}
        {{--<li>--}}
        {{--<a class="linkedin" data-original-title="Linkedin" href="javascript:;">--}}
        {{--</a>--}}
        {{--</li>--}}
        {{--</ul>--}}
        {{--</div>--}}
        <div class="create-account">
            <span class="form-subtitle">{{{  trans('login.signup_notice') }}}</span>
            <a href="{{ route('register') }}" class="btn btn-signup btn-block uppercase margin-top-m" id="register-btn">
                {{{ trans('login.signup') }}} </a>
            {{--<a href="javascript:void(0)" class="btn btn-signup btn-block uppercase margin-top-m" id="register-btn">--}}
                {{--{{{ trans('login.signup') }}} </a>--}}
        </div>
    </form>
    <form class="forget-form" action="" method="post">
        <h3>{{{ trans('login.forgot_password') }}}</h3>

        <div class="alert alert-success forgot-status" style="display:none">
            <strong>{{{ trans('login.success') }}}</strong> {{{ trans('login.success_notice') }}}
        </div>

        <div class="alert alert-warning forgot-status-not-found" style="display:none">
            <strong>{{{ trans('login.warning') }}}</strong> {{{ trans('login.email_not_found') }}}
        </div>

        <p>
            {{{ trans('login.reset_notice') }}}
        </p>

        <div class="form-group">
            <div class="input-icon">
                <i class="fa fa-envelope"></i>
                <input class="form-control placeholder-no-fix" type="text" autocomplete="off" id="email"
                       placeholder="Email" name="email"/>
            </div>
        </div>
        <div class="form-actions">
            <button type="button" id="back-btn" class="btn btn-link">
                <i class="m-icon-swapleft"></i> {{{ trans('login.back') }}}
            </button>
            <button type="button" class="btn pull-right btn-signup forgot-password">
                {{{ trans('login.submit') }}} <i class="m-icon-swapright m-icon-white"></i>
            </button>
        </div>
    </form>
    {{--<form class="register-form" id="register-form" action="user/register" method="post">--}}
        {{--<h3>{{{ trans('login.singup') }}}</h3>--}}

        {{--<div class="alert alert-success register-status" style="display:none">--}}
            {{--<strong>{{{ trans('login.success') }}}</strong> {{{ trans('login.confirm_email') }}}--}}
        {{--</div>--}}

        {{--<div class="alert alert-warning register-status-error " style="display:none">--}}
            {{--<strong>{{trans('Error!')}}</strong> <span id="response-messsage"></span>--}}
        {{--</div>--}}

        {{--<p>--}}
            {{--{{{ trans('login.enter_info') }}}--}}
        {{--</p>--}}

        {{--<div class="row">--}}
            {{--<div class="form-group form-md-radios">--}}
                {{--<div class="col-md-12">--}}
                    {{--<div class="md-radio-inline">--}}
                        {{--<div class="md-radio">--}}
                            {{--<input type="radio" id="acc-type-tenant" value="tenant" name="acc" class="md-radiobtn acc">--}}
                            {{--<label for="acc-type-tenant">--}}
                                {{--<span></span>--}}
                                {{--<span class="check"></span>--}}
                                {{--<span class="box"></span>--}}
                                {{--{{{ trans('login.tenant') }}} </label>--}}
                        {{--</div>--}}
                        {{--<div class="md-radio">--}}
                            {{--<input type="radio" id="acc-type-landlord" value="landlord" name="acc"--}}
                                   {{--class="md-radiobtn acc">--}}
                            {{--<label for="acc-type-landlord">--}}
                                {{--<span></span>--}}
                                {{--<span class="check"></span>--}}
                                {{--<span class="box"></span>--}}
                                {{--{{{ trans('login.landlord') }}} </label>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}

        {{--</div>--}}
        {{--<div class="form-group">--}}
            {{--<label class="control-label visible-ie8 visible-ie9">{{{ trans('login.full_name') }}}</label>--}}

            {{--<div class="input-icon">--}}
                {{--<i class="fa fa-font"></i>--}}
                {{--<input class="form-control placeholder-no-fix" type="text"--}}
                       {{--placeholder="{{{ trans('login.full_name') }}}" id="name" name="fullname"/>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="form-group">--}}
            {{--<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->--}}
            {{--<label class="control-label visible-ie8 visible-ie9">{{{ trans('login.email') }}}</label>--}}

            {{--<div class="input-icon">--}}
                {{--<i class="fa fa-envelope"></i>--}}
                {{--<input class="form-control placeholder-no-fix" type="text" placeholder="Email" id="reg-email"--}}
                       {{--name="email"/>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="form-group">--}}
            {{--<label class="control-label visible-ie8 visible-ie9">{{{ trans('login.country') }}}</label>--}}
            {{--<select name="country" id="country" class="form-control">--}}
                {{--<option value="">{{{ trans('login.country') }}}</option>--}}
                {{--<option value="AF">Afghanistan</option>--}}
                {{--<option value="AL">Albania</option>--}}
                {{--<option value="DZ">Algeria</option>--}}
                {{--<option value="AS">American Samoa</option>--}}
                {{--<option value="AD">Andorra</option>--}}
                {{--<option value="AO">Angola</option>--}}
                {{--<option value="AI">Anguilla</option>--}}
                {{--<option value="AR">Argentina</option>--}}
                {{--<option value="AM">Armenia</option>--}}
                {{--<option value="AW">Aruba</option>--}}
                {{--<option value="AU">Australia</option>--}}
                {{--<option value="AT">Austria</option>--}}
                {{--<option value="AZ">Azerbaijan</option>--}}
                {{--<option value="BS">Bahamas</option>--}}
                {{--<option value="BH">Bahrain</option>--}}
                {{--<option value="BD">Bangladesh</option>--}}
                {{--<option value="BB">Barbados</option>--}}
                {{--<option value="BY">Belarus</option>--}}
                {{--<option value="BE">Belgium</option>--}}
                {{--<option value="BZ">Belize</option>--}}
                {{--<option value="BJ">Benin</option>--}}
                {{--<option value="BM">Bermuda</option>--}}
                {{--<option value="BT">Bhutan</option>--}}
                {{--<option value="BO">Bolivia</option>--}}
                {{--<option value="BA">Bosnia and Herzegowina</option>--}}
                {{--<option value="BW">Botswana</option>--}}
                {{--<option value="BV">Bouvet Island</option>--}}
                {{--<option value="BR">Brazil</option>--}}
                {{--<option value="IO">British Indian Ocean Territory</option>--}}
                {{--<option value="BN">Brunei Darussalam</option>--}}
                {{--<option value="BG">Bulgaria</option>--}}
                {{--<option value="BF">Burkina Faso</option>--}}
                {{--<option value="BI">Burundi</option>--}}
                {{--<option value="KH">Cambodia</option>--}}
                {{--<option value="CM">Cameroon</option>--}}
                {{--<option value="CA">Canada</option>--}}
                {{--<option value="CV">Cape Verde</option>--}}
                {{--<option value="KY">Cayman Islands</option>--}}
                {{--<option value="CF">Central African Republic</option>--}}
                {{--<option value="TD">Chad</option>--}}
                {{--<option value="CL">Chile</option>--}}
                {{--<option value="CN">China</option>--}}
                {{--<option value="CX">Christmas Island</option>--}}
                {{--<option value="CC">Cocos (Keeling) Islands</option>--}}
                {{--<option value="CO">Colombia</option>--}}
                {{--<option value="KM">Comoros</option>--}}
                {{--<option value="CG">Congo</option>--}}
                {{--<option value="CD">Congo, the Democratic Republic of the</option>--}}
                {{--<option value="CK">Cook Islands</option>--}}
                {{--<option value="CR">Costa Rica</option>--}}
                {{--<option value="CI">Cote d'Ivoire</option>--}}
                {{--<option value="HR">Croatia (Hrvatska)</option>--}}
                {{--<option value="CU">Cuba</option>--}}
                {{--<option value="CY">Cyprus</option>--}}
                {{--<option value="CZ">Czech Republic</option>--}}
                {{--<option value="DK">Denmark</option>--}}
                {{--<option value="DJ">Djibouti</option>--}}
                {{--<option value="DM">Dominica</option>--}}
                {{--<option value="DO">Dominican Republic</option>--}}
                {{--<option value="EC">Ecuador</option>--}}
                {{--<option value="EG">Egypt</option>--}}
                {{--<option value="SV">El Salvador</option>--}}
                {{--<option value="GQ">Equatorial Guinea</option>--}}
                {{--<option value="ER">Eritrea</option>--}}
                {{--<option value="EE">Estonia</option>--}}
                {{--<option value="ET">Ethiopia</option>--}}
                {{--<option value="FK">Falkland Islands (Malvinas)</option>--}}
                {{--<option value="FO">Faroe Islands</option>--}}
                {{--<option value="FJ">Fiji</option>--}}
                {{--<option value="FI">Finland</option>--}}
                {{--<option value="FR">France</option>--}}
                {{--<option value="GF">French Guiana</option>--}}
                {{--<option value="PF">French Polynesia</option>--}}
                {{--<option value="TF">French Southern Territories</option>--}}
                {{--<option value="GA">Gabon</option>--}}
                {{--<option value="GM">Gambia</option>--}}
                {{--<option value="GE">Georgia</option>--}}
                {{--<option value="DE">Germany</option>--}}
                {{--<option value="GH">Ghana</option>--}}
                {{--<option value="GI">Gibraltar</option>--}}
                {{--<option value="GR">Greece</option>--}}
                {{--<option value="GL">Greenland</option>--}}
                {{--<option value="GD">Grenada</option>--}}
                {{--<option value="GP">Guadeloupe</option>--}}
                {{--<option value="GU">Guam</option>--}}
                {{--<option value="GT">Guatemala</option>--}}
                {{--<option value="GN">Guinea</option>--}}
                {{--<option value="GW">Guinea-Bissau</option>--}}
                {{--<option value="GY">Guyana</option>--}}
                {{--<option value="HT">Haiti</option>--}}
                {{--<option value="HM">Heard and Mc Donald Islands</option>--}}
                {{--<option value="VA">Holy See (Vatican City State)</option>--}}
                {{--<option value="HN">Honduras</option>--}}
                {{--<option value="HK">Hong Kong</option>--}}
                {{--<option value="HU">Hungary</option>--}}
                {{--<option value="IS">Iceland</option>--}}
                {{--<option value="IN">India</option>--}}
                {{--<option value="ID">Indonesia</option>--}}
                {{--<option value="IR">Iran (Islamic Republic of)</option>--}}
                {{--<option value="IQ">Iraq</option>--}}
                {{--<option value="IE">Ireland</option>--}}
                {{--<option value="IL">Israel</option>--}}
                {{--<option value="IT">Italy</option>--}}
                {{--<option value="JM">Jamaica</option>--}}
                {{--<option value="JP">Japan</option>--}}
                {{--<option value="JO">Jordan</option>--}}
                {{--<option value="KZ">Kazakhstan</option>--}}
                {{--<option value="KE">Kenya</option>--}}
                {{--<option value="KI">Kiribati</option>--}}
                {{--<option value="KP">Korea, Democratic People's Republic of</option>--}}
                {{--<option value="KR">Korea, Republic of</option>--}}
                {{--<option value="KW">Kuwait</option>--}}
                {{--<option value="KG">Kyrgyzstan</option>--}}
                {{--<option value="LA">Lao People's Democratic Republic</option>--}}
                {{--<option value="LV">Latvia</option>--}}
                {{--<option value="LB">Lebanon</option>--}}
                {{--<option value="LS">Lesotho</option>--}}
                {{--<option value="LR">Liberia</option>--}}
                {{--<option value="LY">Libyan Arab Jamahiriya</option>--}}
                {{--<option value="LI">Liechtenstein</option>--}}
                {{--<option value="LT">Lithuania</option>--}}
                {{--<option value="LU">Luxembourg</option>--}}
                {{--<option value="MO">Macau</option>--}}
                {{--<option value="MK">Macedonia, The Former Yugoslav Republic of</option>--}}
                {{--<option value="MG">Madagascar</option>--}}
                {{--<option value="MW">Malawi</option>--}}
                {{--<option value="MY">Malaysia</option>--}}
                {{--<option value="MV">Maldives</option>--}}
                {{--<option value="ML">Mali</option>--}}
                {{--<option value="MT">Malta</option>--}}
                {{--<option value="MH">Marshall Islands</option>--}}
                {{--<option value="MQ">Martinique</option>--}}
                {{--<option value="MR">Mauritania</option>--}}
                {{--<option value="MU">Mauritius</option>--}}
                {{--<option value="YT">Mayotte</option>--}}
                {{--<option value="MX">Mexico</option>--}}
                {{--<option value="FM">Micronesia, Federated States of</option>--}}
                {{--<option value="MD">Moldova, Republic of</option>--}}
                {{--<option value="MC">Monaco</option>--}}
                {{--<option value="MN">Mongolia</option>--}}
                {{--<option value="MS">Montserrat</option>--}}
                {{--<option value="MA">Morocco</option>--}}
                {{--<option value="MZ">Mozambique</option>--}}
                {{--<option value="MM">Myanmar</option>--}}
                {{--<option value="NA">Namibia</option>--}}
                {{--<option value="NR">Nauru</option>--}}
                {{--<option value="NP">Nepal</option>--}}
                {{--<option value="NL">Netherlands</option>--}}
                {{--<option value="AN">Netherlands Antilles</option>--}}
                {{--<option value="NC">New Caledonia</option>--}}
                {{--<option value="NZ">New Zealand</option>--}}
                {{--<option value="NI">Nicaragua</option>--}}
                {{--<option value="NE">Niger</option>--}}
                {{--<option value="NG">Nigeria</option>--}}
                {{--<option value="NU">Niue</option>--}}
                {{--<option value="NF">Norfolk Island</option>--}}
                {{--<option value="MP">Northern Mariana Islands</option>--}}
                {{--<option value="NO">Norway</option>--}}
                {{--<option value="OM">Oman</option>--}}
                {{--<option value="PK">Pakistan</option>--}}
                {{--<option value="PW">Palau</option>--}}
                {{--<option value="PA">Panama</option>--}}
                {{--<option value="PG">Papua New Guinea</option>--}}
                {{--<option value="PY">Paraguay</option>--}}
                {{--<option value="PE">Peru</option>--}}
                {{--<option value="PH">Philippines</option>--}}
                {{--<option value="PN">Pitcairn</option>--}}
                {{--<option value="PL">Poland</option>--}}
                {{--<option value="PT">Portugal</option>--}}
                {{--<option value="PR">Puerto Rico</option>--}}
                {{--<option value="QA">Qatar</option>--}}
                {{--<option value="RE">Reunion</option>--}}
                {{--<option value="RO">Romania</option>--}}
                {{--<option value="RU">Russian Federation</option>--}}
                {{--<option value="RW">Rwanda</option>--}}
                {{--<option value="KN">Saint Kitts and Nevis</option>--}}
                {{--<option value="LC">Saint LUCIA</option>--}}
                {{--<option value="VC">Saint Vincent and the Grenadines</option>--}}
                {{--<option value="WS">Samoa</option>--}}
                {{--<option value="SM">San Marino</option>--}}
                {{--<option value="ST">Sao Tome and Principe</option>--}}
                {{--<option value="SA">Saudi Arabia</option>--}}
                {{--<option value="SN">Senegal</option>--}}
                {{--<option value="SC">Seychelles</option>--}}
                {{--<option value="SL">Sierra Leone</option>--}}
                {{--<option value="SG">Singapore</option>--}}
                {{--<option value="SK">Slovakia (Slovak Republic)</option>--}}
                {{--<option value="SI">Slovenia</option>--}}
                {{--<option value="SB">Solomon Islands</option>--}}
                {{--<option value="SO">Somalia</option>--}}
                {{--<option value="ZA">South Africa</option>--}}
                {{--<option value="GS">South Georgia and the South Sandwich Islands</option>--}}
                {{--<option value="ES">Spain</option>--}}
                {{--<option value="LK">Sri Lanka</option>--}}
                {{--<option value="SH">St. Helena</option>--}}
                {{--<option value="PM">St. Pierre and Miquelon</option>--}}
                {{--<option value="SD">Sudan</option>--}}
                {{--<option value="SR">Suriname</option>--}}
                {{--<option value="SJ">Svalbard and Jan Mayen Islands</option>--}}
                {{--<option value="SZ">Swaziland</option>--}}
                {{--<option value="SE">Sweden</option>--}}
                {{--<option value="CH">Switzerland</option>--}}
                {{--<option value="SY">Syrian Arab Republic</option>--}}
                {{--<option value="TW">Taiwan, Province of China</option>--}}
                {{--<option value="TJ">Tajikistan</option>--}}
                {{--<option value="TZ">Tanzania, United Republic of</option>--}}
                {{--<option value="TH">Thailand</option>--}}
                {{--<option value="TG">Togo</option>--}}
                {{--<option value="TK">Tokelau</option>--}}
                {{--<option value="TO">Tonga</option>--}}
                {{--<option value="TT">Trinidad and Tobago</option>--}}
                {{--<option value="TN">Tunisia</option>--}}
                {{--<option value="TR">Turkey</option>--}}
                {{--<option value="TM">Turkmenistan</option>--}}
                {{--<option value="TC">Turks and Caicos Islands</option>--}}
                {{--<option value="TV">Tuvalu</option>--}}
                {{--<option value="UG">Uganda</option>--}}
                {{--<option value="UA">Ukraine</option>--}}
                {{--<option value="AE">United Arab Emirates</option>--}}
                {{--<option value="GB">United Kingdom</option>--}}
                {{--<option value="US">United States</option>--}}
                {{--<option value="UM">United States Minor Outlying Islands</option>--}}
                {{--<option value="UY">Uruguay</option>--}}
                {{--<option value="UZ">Uzbekistan</option>--}}
                {{--<option value="VU">Vanuatu</option>--}}
                {{--<option value="VE">Venezuela</option>--}}
                {{--<option value="VN">Viet Nam</option>--}}
                {{--<option value="VG">Virgin Islands (British)</option>--}}
                {{--<option value="VI">Virgin Islands (U.S.)</option>--}}
                {{--<option value="WF">Wallis and Futuna Islands</option>--}}
                {{--<option value="EH">Western Sahara</option>--}}
                {{--<option value="YE">Yemen</option>--}}
                {{--<option value="ZM">Zambia</option>--}}
                {{--<option value="ZW">Zimbabwe</option>--}}
            {{--</select>--}}
        {{--</div>--}}
        {{--<p>--}}
            {{--{{{ trans('login.choose_password') }}}--}}
        {{--</p>--}}

        {{--<div class="form-group">--}}
            {{--<label class="control-label visible-ie8 visible-ie9">{{{ trans('login.password') }}}</label>--}}

            {{--<div class="input-icon">--}}
                {{--<i class="fa fa-lock"></i>--}}
                {{--<input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="register_password"--}}
                       {{--placeholder="{{{ trans('login.password') }}}" id="password" name="password"/>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="form-group">--}}
            {{--<label class="control-label visible-ie8 visible-ie9">{{{ trans('login.retype_password') }}}</label>--}}

            {{--<div class="controls">--}}
                {{--<div class="input-icon">--}}
                    {{--<i class="fa fa-check"></i>--}}
                    {{--<input class="form-control placeholder-no-fix" type="password" autocomplete="off"--}}
                           {{--placeholder="{{{ trans('login.retype_password') }}}" id="rpassword" name="rpassword"/>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="form-group md-checkbox">--}}
            {{--<input type="checkbox" id="agreement" name="tnc" class="md-check"/>--}}
            {{--<label for="agreement">--}}
                {{--{{{ trans('login.i_agree') }}} <a href="https://www.rentling.group/terms-and-conditions" target="_blank">--}}
                    {{--{{{ trans('login.terms') }}} </a> <br>--}}
                {{--{{{ trans('login.and') }}} <a href="https://www.rentling.group/privacy-policy" target="_blank">--}}
                    {{--{{{ trans('login.policy') }}} </a>--}}
                {{--<span></span>--}}
                {{--<span class="check"></span>--}}
                {{--<span class="box"></span>--}}
            {{--</label>--}}

            {{--<div id="register_tnc_error">--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="form-actions">--}}
            {{--<button id="register-back-btn" type="button" class="btn btn-link">--}}
                {{--<i class="m-icon-swapleft"></i> {{{ trans('login.back') }}}--}}
            {{--</button>--}}
            {{--<button type="submit" id="register-submit-btn" class="btn btn-signup pull-right">--}}
                {{--{{{ trans('login.signup') }}} <i class="m-icon-swapright m-icon-white"></i>--}}
            {{--</button>--}}
        {{--</div>--}}
    {{--</form>--}}



@endsection
