<?php
session_start();

    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        header("location: index.php");
        exit;
    }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Bubbly - Boootstrap 5 Admin template by Bootstrapious.com</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Google fonts - Popppins for copy-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&amp;display=swap" rel="stylesheet">
    <!-- Prism Syntax Highlighting-->
    <link rel="stylesheet" href="vendor/back/prismjs/plugins/toolbar/prism-toolbar.css">
    <link rel="stylesheet" href="vendor/back/prismjs/themes/prism-okaidia.css">
    <!-- The Main Theme stylesheet (Contains also Bootstrap CSS)-->
    <link rel="stylesheet" href="css/back/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="css/back/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/back/favicon.png">
    <!-- Captcha Script -->
    <script src="https://www.google.com/recaptcha/api.js?render=6LeWZNocAAAAANfVdnLWMk38kUMamH2l1zHIzkhv"></script>
  </head>
  <body>
    <div class="container-fluid px-0">
      <div class="row gx-0 min-vh-100">
        <div class="col-md-9 col-lg-6 col-xl-4 px-5 d-flex align-items-center shadow">
          <div class="w-100 py-5">
            <div class="text-center"><img class="img-fluid mb-4" src="img/back/brand/brand-1.svg" alt="..." style="max-width: 6rem;">
              <h1 class="h4 text-uppercase mb-3">Register</h1>
            </div>
            <p class="text-muted text-sm mb-4">The bedding was hardly able to cover it and seemed ready to slide off any moment. His many legs, pitifully thin compared with the size of the rest of him, waved about helplessly as he looked. &quot;What's happened to me?&quot; he thought. It wasn't a dream.</p>
            <form id="registerForm" class="needs-validation" method="post"
                  oninput='confirmPassword.setCustomValidity(confirmPassword.value != password.value ? "Passwords do not match." : "")' novalidate>
              <div class="mb-4">
                <label class="form-label" for="validationCustom01">First name</label>
                <input class="form-control" id="fname" type="text" name="fname" value="" required="">
                <div class="valid-feedback">Looks good!</div>
                <div class="invalid-feedback">Please enter your first name.</div>
              </div>
              <div class="mb-4">
                <label class="form-label" for="validationCustom02">Last name</label>
                <input class="form-control" id="lname" type="text" name="lname" value="" required="">
                <div class="valid-feedback">Looks good!</div>
                <div class="invalid-feedback">Please enter your last name.</div>
              </div>
              <div class="mb-4">
                <label class="form-label" for="validationCustomUsername">Username</label>
                <div class="input-group has-validation"><span class="input-group-text" id="inputGroupPrepend">@</span>
                  <input class="form-control" id="username" type="text" minlength=4 maxlength=16 name="username" aria-describedby="inputGroupPrepend" required="">
                  <div class="valid-feedback">Looks good!</div>
                  <div class="invalid-feedback">Please choose a valid 4-16 lengthed username</div>
                </div>
              </div>
              <div class="mb-4">
                <label class="form-label" for="validationCustom03">City</label>
                <input class="form-control" id="city" type="text" name="city" required="">
                <div class="valid-feedback">Looks good!</div>
                <div class="invalid-feedback">Please provide a valid city.</div>
              </div>
              <div class="mb-4">
                <label class="form-label" for="validationCustom04">Country</label>
                <select class="form-select" id="country" required="" name="country">
                  <option selected="" disabled="" value="">Choose...</option>
                  <option value="AF">Afghanistan</option>
                  <option value="AX">Åland Islands</option>
                  <option value="AL">Albania</option>
                  <option value="DZ">Algeria</option>
                  <option value="AS">American Samoa</option>
                  <option value="AD">AndorrA</option>
                  <option value="AO">Angola</option>
                  <option value="AI">Anguilla</option>
                  <option value="AQ">Antarctica</option>
                  <option value="AG">Antigua and Barbuda</option>
                  <option value="AR">Argentina</option>
                  <option value="AM">Armenia</option>
                  <option value="AW">Aruba</option>
                  <option value="AU">Australia</option>
                  <option value="AT">Austria</option>
                  <option value="AZ">Azerbaijan</option>
                  <option value="BS">Bahamas</option>
                  <option value="BH">Bahrain</option>
                  <option value="BD">Bangladesh</option>
                  <option value="BB">Barbados</option>
                  <option value="BY">Belarus</option>
                  <option value="BE">Belgium</option>
                  <option value="BZ">Belize</option>
                  <option value="BJ">Benin</option>
                  <option value="BM">Bermuda</option>
                  <option value="BT">Bhutan</option>
                  <option value="BO">Bolivia</option>
                  <option value="BA">Bosnia and Herzegovina</option>
                  <option value="BW">Botswana</option>
                  <option value="BV">Bouvet Island</option>
                  <option value="BR">Brazil</option>
                  <option value="IO">British Indian Ocean Territory</option>
                  <option value="BN">Brunei Darussalam</option>
                  <option value="BG">Bulgaria</option>
                  <option value="BF">Burkina Faso</option>
                  <option value="BI">Burundi</option>
                  <option value="KH">Cambodia</option>
                  <option value="CM">Cameroon</option>
                  <option value="CA">Canada</option>
                  <option value="CV">Cape Verde</option>
                  <option value="KY">Cayman Islands</option>
                  <option value="CF">Central African Republic</option>
                  <option value="TD">Chad</option>
                  <option value="CL">Chile</option>
                  <option value="CN">China</option>
                  <option value="CX">Christmas Island</option>
                  <option value="CC">Cocos (Keeling) Islands</option>
                  <option value="CO">Colombia</option>
                  <option value="KM">Comoros</option>
                  <option value="CG">Congo</option>
                  <option value="CD">Congo, The Democratic Republic of the</option>
                  <option value="CK">Cook Islands</option>
                  <option value="CR">Costa Rica</option>
                  <option value="CI">Cote D'Ivoire</option>
                  <option value="HR">Croatia</option>
                  <option value="CU">Cuba</option>
                  <option value="CY">Cyprus</option>
                  <option value="CZ">Czech Republic</option>
                  <option value="DK">Denmark</option>
                  <option value="DJ">Djibouti</option>
                  <option value="DM">Dominica</option>
                  <option value="DO">Dominican Republic</option>
                  <option value="EC">Ecuador</option>
                  <option value="EG">Egypt</option>
                  <option value="SV">El Salvador</option>
                  <option value="GQ">Equatorial Guinea</option>
                  <option value="ER">Eritrea</option>
                  <option value="EE">Estonia</option>
                  <option value="ET">Ethiopia</option>
                  <option value="FK">Falkland Islands (Malvinas)</option>
                  <option value="FO">Faroe Islands</option>
                  <option value="FJ">Fiji</option>
                  <option value="FI">Finland</option>
                  <option value="FR">France</option>
                  <option value="GF">French Guiana</option>
                  <option value="PF">French Polynesia</option>
                  <option value="TF">French Southern Territories</option>
                  <option value="GA">Gabon</option>
                  <option value="GM">Gambia</option>
                  <option value="GE">Georgia</option>
                  <option value="DE">Germany</option>
                  <option value="GH">Ghana</option>
                  <option value="GI">Gibraltar</option>
                  <option value="GR">Greece</option>
                  <option value="GL">Greenland</option>
                  <option value="GD">Grenada</option>
                  <option value="GP">Guadeloupe</option>
                  <option value="GU">Guam</option>
                  <option value="GT">Guatemala</option>
                  <option value="GG">Guernsey</option>
                  <option value="GN">Guinea</option>
                  <option value="GW">Guinea-Bissau</option>
                  <option value="GY">Guyana</option>
                  <option value="HT">Haiti</option>
                  <option value="HM">Heard Island and Mcdonald Islands</option>
                  <option value="VA">Holy See (Vatican City State)</option>
                  <option value="HN">Honduras</option>
                  <option value="HK">Hong Kong</option>
                  <option value="HU">Hungary</option>
                  <option value="IS">Iceland</option>
                  <option value="IN">India</option>
                  <option value="ID">Indonesia</option>
                  <option value="IR">Iran, Islamic Republic Of</option>
                  <option value="IQ">Iraq</option>
                  <option value="IE">Ireland</option>
                  <option value="IM">Isle of Man</option>
                  <option value="IL">Israel</option>
                  <option value="IT">Italy</option>
                  <option value="JM">Jamaica</option>
                  <option value="JP">Japan</option>
                  <option value="JE">Jersey</option>
                  <option value="JO">Jordan</option>
                  <option value="KZ">Kazakhstan</option>
                  <option value="KE">Kenya</option>
                  <option value="KI">Kiribati</option>
                  <option value="KP">Korea, Democratic People'S Republic of</option>
                  <option value="KR">Korea, Republic of</option>
                  <option value="KW">Kuwait</option>
                  <option value="KG">Kyrgyzstan</option>
                  <option value="LA">Lao People'S Democratic Republic</option>
                  <option value="LV">Latvia</option>
                  <option value="LB">Lebanon</option>
                  <option value="LS">Lesotho</option>
                  <option value="LR">Liberia</option>
                  <option value="LY">Libyan Arab Jamahiriya</option>
                  <option value="LI">Liechtenstein</option>
                  <option value="LT">Lithuania</option>
                  <option value="LU">Luxembourg</option>
                  <option value="MO">Macao</option>
                  <option value="MK">Macedonia, The Former Yugoslav Republic of</option>
                  <option value="MG">Madagascar</option>
                  <option value="MW">Malawi</option>
                  <option value="MY">Malaysia</option>
                  <option value="MV">Maldives</option>
                  <option value="ML">Mali</option>
                  <option value="MT">Malta</option>
                  <option value="MH">Marshall Islands</option>
                  <option value="MQ">Martinique</option>
                  <option value="MR">Mauritania</option>
                  <option value="MU">Mauritius</option>
                  <option value="YT">Mayotte</option>
                  <option value="MX">Mexico</option>
                  <option value="FM">Micronesia, Federated States of</option>
                  <option value="MD">Moldova, Republic of</option>
                  <option value="MC">Monaco</option>
                  <option value="MN">Mongolia</option>
                  <option value="MS">Montserrat</option>
                  <option value="MA">Morocco</option>
                  <option value="MZ">Mozambique</option>
                  <option value="MM">Myanmar</option>
                  <option value="NA">Namibia</option>
                  <option value="NR">Nauru</option>
                  <option value="NP">Nepal</option>
                  <option value="NL">Netherlands</option>
                  <option value="AN">Netherlands Antilles</option>
                  <option value="NC">New Caledonia</option>
                  <option value="NZ">New Zealand</option>
                  <option value="NI">Nicaragua</option>
                  <option value="NE">Niger</option>
                  <option value="NG">Nigeria</option>
                  <option value="NU">Niue</option>
                  <option value="NF">Norfolk Island</option>
                  <option value="MP">Northern Mariana Islands</option>
                  <option value="NO">Norway</option>
                  <option value="OM">Oman</option>
                  <option value="PK">Pakistan</option>
                  <option value="PW">Palau</option>
                  <option value="PS">Palestinian Territory, Occupied</option>
                  <option value="PA">Panama</option>
                  <option value="PG">Papua New Guinea</option>
                  <option value="PY">Paraguay</option>
                  <option value="PE">Peru</option>
                  <option value="PH">Philippines</option>
                  <option value="PN">Pitcairn</option>
                  <option value="PL">Poland</option>
                  <option value="PT">Portugal</option>
                  <option value="PR">Puerto Rico</option>
                  <option value="QA">Qatar</option>
                  <option value="RE">Reunion</option>
                  <option value="RO">Romania</option>
                  <option value="RU">Russian Federation</option>
                  <option value="RW">RWANDA</option>
                  <option value="SH">Saint Helena</option>
                  <option value="KN">Saint Kitts and Nevis</option>
                  <option value="LC">Saint Lucia</option>
                  <option value="PM">Saint Pierre and Miquelon</option>
                  <option value="VC">Saint Vincent and the Grenadines</option>
                  <option value="WS">Samoa</option>
                  <option value="SM">San Marino</option>
                  <option value="ST">Sao Tome and Principe</option>
                  <option value="SA">Saudi Arabia</option>
                  <option value="SN">Senegal</option>
                  <option value="CS">Serbia and Montenegro</option>
                  <option value="SC">Seychelles</option>
                  <option value="SL">Sierra Leone</option>
                  <option value="SG">Singapore</option>
                  <option value="SK">Slovakia</option>
                  <option value="SI">Slovenia</option>
                  <option value="SB">Solomon Islands</option>
                  <option value="SO">Somalia</option>
                  <option value="ZA">South Africa</option>
                  <option value="GS">South Georgia and the South Sandwich Islands</option>
                  <option value="ES">Spain</option>
                  <option value="LK">Sri Lanka</option>
                  <option value="SD">Sudan</option>
                  <option value="SR">Suriname</option>
                  <option value="SJ">Svalbard and Jan Mayen</option>
                  <option value="SZ">Swaziland</option>
                  <option value="SE">Sweden</option>
                  <option value="CH">Switzerland</option>
                  <option value="SY">Syrian Arab Republic</option>
                  <option value="TW">Taiwan, Province of China</option>
                  <option value="TJ">Tajikistan</option>
                  <option value="TZ">Tanzania, United Republic of</option>
                  <option value="TH">Thailand</option>
                  <option value="TL">Timor-Leste</option>
                  <option value="TG">Togo</option>
                  <option value="TK">Tokelau</option>
                  <option value="TO">Tonga</option>
                  <option value="TT">Trinidad and Tobago</option>
                  <option value="TN">Tunisia</option>
                  <option value="TR">Turkey</option>
                  <option value="TM">Turkmenistan</option>
                  <option value="TC">Turks and Caicos Islands</option>
                  <option value="TV">Tuvalu</option>
                  <option value="UG">Uganda</option>
                  <option value="UA">Ukraine</option>
                  <option value="AE">United Arab Emirates</option>
                  <option value="GB">United Kingdom</option>
                  <option value="US">United States</option>
                  <option value="UM">United States Minor Outlying Islands</option>
                  <option value="UY">Uruguay</option>
                  <option value="UZ">Uzbekistan</option>
                  <option value="VU">Vanuatu</option>
                  <option value="VE">Venezuela</option>
                  <option value="VN">Viet Nam</option>
                  <option value="VG">Virgin Islands, British</option>
                  <option value="VI">Virgin Islands, U.S.</option>
                  <option value="WF">Wallis and Futuna</option>
                  <option value="EH">Western Sahara</option>
                  <option value="YE">Yemen</option>
                  <option value="ZM">Zambia</option>
                  <option value="ZW">Zimbabwe</option>
                </select>
                <div class="valid-feedback">Looks good!</div>
                <div class="invalid-feedback">Please select a country.</div>
              </div>
              <div class="mb-4">
                <label class="form-label" for="validationCustom05">Zip</label>
                <input class="form-control" id="zip" type="text" name="zip" required="">
								<div class="valid-feedback">Looks good!</div>
                <div class="invalid-feedback">Please provide a valid zip.</div>
              </div>
              <div class="mb-4">
                <label class="form-label" for="registerEmail">Email Address</label>
                <input class="form-control" id="registerEmail" type="email" pattern="[a-zA-Z0-9._-]{2,}@[a-zA-Z0-9.-]{2,}\.[a-zA-Z]{2,}" name="email" required>
								<div class="valid-feedback">Looks good!</div>
				<div class="invalid-feedback"></div>
              </div>
              <div class="mb-4">
                <label class="form-label" for="registerPassword">Password</label>
                <input class="form-control" id="registerPassword" type="password" name="password" required>
				<div class="valid-feedback">Looks good!</div>
              </div>
              <div class="mb-4">
                <label class="form-label" for="confirmPassword">Confirm Password</label>
                <input class="form-control" id="confirmPassword" type="password" name="confirmPassword" required>
				<div class="valid-feedback">Looks good!</div>
                <div class="invalid-feedback">Passwords do not match.</div>
              </div>
              <div class="form-check mb-4">
                <input class="form-check-input me-2" id="registerAgree" type="checkbox" value="" required>
                <label class="form-check-label" for="registerAgree">I agree with the terms and policy                          </label>
              </div>
              <!-- Submit-->
              <div class="d-grid mb-5">
                <button id="registerButton" name="register" class="btn btn-primary text-uppercase">Register</button>
              </div>


              <!-- Link-->
              <p class="text-center"><small class="text-muted text-center">Already have an account? <a href="login.html">Log in</a>.</small></p>

            </form>
          </div>
        </div>
        <div class="col-md-3 col-lg-6 col-xl-8 d-none d-md-block">
          <!-- Image-->
          <div class="bg-cover h-100 me-n3" style="background-image: url(img/back/photos/victor-ene-1301123-unsplash.jpg);"></div>
        </div>
      </div>
    </div>

    <div class="modal"><!-- Place at bottom of page --></div>
    <!-- JavaScript files-->
    <script src="vendor/back/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
    <!-- Main Theme JS File-->
    <script src="js/back/theme.js"></script>
    <!-- Form Validation JS -->
    <script src="js/back/forms-validation.js"></script>
    <!-- Prism for syntax highlighting-->
    <script src="vendor/back/prismjs/prism.js"></script>
    <script src="vendor/back/prismjs/plugins/normalize-whitespace/prism-normalize-whitespace.min.js"></script>
    <script src="vendor/back/prismjs/plugins/toolbar/prism-toolbar.min.js"></script>
    <script src="vendor/back/prismjs/plugins/copy-to-clipboard/prism-copy-to-clipboard.min.js"></script>
    <script src="vendor/front/jquery/jquery.js"></script>
    <script type="text/javascript">
      // Optional
      Prism.plugins.NormalizeWhitespace.setDefaults({
      'remove-trailing': true,
      'remove-indent': true,
      'left-trim': true,
      'right-trim': true,
      });

    </script>

    <script>
        $(document).ready(function() {

            $('#registerButton').click(function(event) {

                if($('#registerForm')[0].checkValidity()) {

                    event.preventDefault();

                    grecaptcha.ready(function() {
                        $("body").addClass("loading");

                        grecaptcha.execute('6LeWZNocAAAAANfVdnLWMk38kUMamH2l1zHIzkhv', {action: 'register'}).then(function(token) {
                            $('#registerForm').prepend('<input type="hidden" name="token" value="' + token + '">');
                            $('#registerForm').prepend('<input type="hidden" name="action" value="register">');

                            $.ajax({
                                url: "controllers/register.php",
                                type: "POST",
                                data: {
                                    'fname': $('#fname').val(),
                                    'lname': $('#lname').val(),
                                    'username': $('#username').val(),
                                    'city': $('#city').val(),
                                    'country': $('#country').val(),
                                    'zip': $('#zip').val(),
                                    'email': $('#registerEmail').val(),
                                    'password': $('#registerPassword').val(),
                                    'confirmPassword': $('#confirmPassword').val(),
                                    'token': token,
                                    'action': 'register'
                                },
                                dataType: 'json',
                                complete: function() { $("body").removeClass("loading"); },
                                success: function(dataResult) {

                                    console.log(dataResult);
                                    if(dataResult.success) {
                                        alert('nigger just registered');
                                    } else {
                                        $('input[name=' + dataResult.name + ']').addClass('is-invalid');
                                        $('input[name=' + dataResult.name + ']').next().next().html(dataResult.message);
                                        $('input[name=' + dataResult.name + ']')[0].setCustomValidity(dataResult.message);
                                        $('input[name=' + dataResult.name + ']').focus();
                                    }

                                }
                            });
                        });;
                    });


                }

            });

			$("#registerEmail").keydown(function() {
				$(this).removeClass('is-invalid');
				$(this)[0].setCustomValidity("");
				$(this).next().html("");
			});

			$("#username").keydown(function() {
				$(this).removeClass('is-invalid');
				$(this)[0].setCustomValidity("");
				$(this).next().html("");
			});
        });
    </script>
    <!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  </body>
</html>
