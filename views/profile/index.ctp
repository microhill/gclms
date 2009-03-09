<?
$html->css('edit_profile', null, null, false);

$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'gclms',
	'popup',
	'edit_profile'
), false);
?>
<div class="gclms-content">
	<?= $this->element('notifications'); ?>
	<h1><? echo sprintf(__("%s's Profile",true),$this->data['User']['username']) ?></h1>    
	<?	
	echo $form->create('User', array('url' => '/profile','type' => 'file'));
	/*
	echo $form->input('username',array(
		'label' =>  __('Username', true),
		'disabled'=>'disabled',
		'between' => '<br/>',
		'autocomplete' => 'off'
	));
	*/
	?>
	<p class="gclms-profile">
	<?
	if(empty($this->data['User']['avatar']) || $this->data['User']['avatar'] == 'default') {
		?><img src="/img/icons/oxygen_refit/96x96/actions/stock_people.png" /><?
	} else if ($this->data['User']['avatar'] == 'gravatar'){
		?><img src="http://www.gravatar.com/avatar.php?gravatar_id=<?= md5($this->data['User']['email']) ?>&size=96" /><?
	} else if ($this->data['User']['avatar'] == 'upload'){
		?><img src="http://<?= $bucket ?>.s3.amazonaws.com/avatars/<?= $this->data['User']['id'] ?>.jpg" /><?
	}
	?> <button id="gclms-change-picture"><? __('Change Picture') ?></button>
	</p>
	<fieldset id="gclms-avatar-chooser" class="gclms-hidden">
		<legend><? __('Change Picture') ?></legend>
		<p>
			<?
			$this->data['User']['avatar'] = empty($this->data['User']['avatar']) ? 'default' : $this->data['User']['avatar'];
			echo $form->radio('avatar',array('upload' => __('Upload an image', true)),array(
				'name' => 'data[User][avatar]',
				'value' => $this->data['User']['avatar']
			)); ?>
			<div>
				<? echo $form->file('avatar_file'); ?><br/>
				<span><? __('Image will be downsized to have a maximum dimension of 96 pixels.') ?></span>
			</div>
		</p>
		
		<p>
			<? echo $form->radio('avatar',array('gravatar' => __('Gravatar', true)),array(
				'name' => 'data[User][avatar]',
				'value' => $this->data['User']['avatar']
			)); ?>
			<div>
				<label for="UserAvatarGravatar"><img src="http://www.gravatar.com/avatar.php?gravatar_id=<?= md5($this->data['User']['email']) ?>&size=96" /></label><br/>
				<span><? __('You can update your gravatar at <a href="http://www.gravatar.com/">gravatar.com</a>.') ?></span>
			</div>
		</p>
		
		<p>
			<? echo $form->radio('avatar',array('default' => __('Use default image', true)),array(
				'name' => 'data[User][avatar]',
				'value' => $this->data['User']['avatar']
			)); ?>
			<div>
				<label for="UserAvatarDefault"><img src="/img/icons/oxygen_refit/96x96/actions/stock_people.png" /></label>
			</div>
		</p>
	</fieldset>
	<?
	echo $form->input('first_name',array(
		'label' =>  __('First name', true),
		'between' => '<br/>',
		'autocomplete' => 'off'
	));
	echo $form->input('last_name',array(
		'label' =>  __('Last name', true),
		'between' => '<br/>'
	));
	echo $form->input('display_full_name',array(
		'label' =>  __('Display full name', true),
		'between' => ''
	));
	echo $form->input('new_password',array(
		'label' =>  __('New password', true),
		'between' => '<br/>',
		'value' => @$this->data['User']['new_password']
	));
	echo $form->input('repeat_new_password',array(
		'label' =>  __('Repeat new password', true),
		'between' => '<br/>',
		'value' => @$this->data['User']['repeat_new_password']
	));
	/*
	echo $form->input('address_1',array(
		'label' =>  __('Address 1', true),
		'between' => '<br/>'
	));
	echo $form->input('address_2',array(
		'label' =>  __('Address 2', true),
		'between' => '<br/>'
	));
	*/
	echo $form->input('city',array(
		'label' =>  __('City', true),
		'between' => '<br/>'
	));
	echo $form->input('state',array(
		'label' =>  __('State', true),
		'between' => '<br/>'
	));
	/*
	echo $form->input('postal_code',array(
		'label' =>  __('Postal code', true),
		'between' => '<br/>'
	));
	*/
	?>
	<select name="country" id="country">
		<option/>
			<option value="AF">Afghanistan</option>
			<option value="AX">Aland Islands</option>
			<option value="AL">Albania</option>
			<option value="DZ">Algeria</option>
			<option value="AS">American Samoa</option>
			<option value="AD">Andorra</option>
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
			<option value="VG">British Virgin Islands</option>
			<option value="BN">Brunei</option>
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
			<option value="CD">Congo - Democratic Republic of</option>
			<option value="CK">Cook Islands</option>
			<option value="CR">Costa Rica</option>
			<option value="CI">Cote d'Ivoire</option>
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
			<option value="FK">Falkland Islands (Islas Malvinas)</option>
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
			<option value="HM">Heard Island and McDonald Islands</option>
			<option value="VA">Holy See (Vatican City State)</option>
			<option value="HN">Honduras</option>
			<option value="HK">Hong Kong</option>
			<option value="HU">Hungary</option>
			<option value="IS">Iceland</option>
			<option value="IN">India</option>
			<option value="ID">Indonesia</option>
			<option value="IR">Iran</option>
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
			<option value="KW">Kuwait</option>
			<option value="KG">Kyrgyzstan</option>
			<option value="LA">Laos</option>
			<option value="LV">Latvia</option>
			<option value="LB">Lebanon</option>
			<option value="LS">Lesotho</option>
			<option value="LR">Liberia</option>
			<option value="LY">Libya</option>
			<option value="LI">Liechtenstein</option>
			<option value="LT">Lithuania</option>
			<option value="LU">Luxembourg</option>
			<option value="MO">Macao</option>
			<option value="MK">Macedonia - The Former Yugoslav Republic of</option>
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
			<option value="FM">Micronesia - Federated States of</option>
			<option value="MD">Moldova</option>
			<option value="MC">Monaco</option>
			<option value="MN">Mongolia</option>
			<option value="ME">Montenegro</option>
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
			<option value="KP">North Korea</option>
			<option value="NO">Norway</option>
			<option value="OM">Oman</option>
			<option value="PK">Pakistan</option>
			<option value="PW">Palau</option>
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
			<option value="RU">Russia</option>
			<option value="RW">Rwanda</option>
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
			<option value="RS">Serbia</option>
			<option value="SC">Seychelles</option>
			<option value="SL">Sierra Leone</option>
			<option value="SG">Singapore</option>
			<option value="SK">Slovakia</option>
			<option value="SI">Slovenia</option>
			<option value="SB">Solomon Islands</option>
			<option value="SO">Somalia</option>
			<option value="ZA">South Africa</option>
			<option value="GS">South Georgia and the South Sandwich Islands</option>
			<option value="KR">South Korea</option>
			<option value="ES">Spain</option>
			<option value="LK">Sri Lanka</option>
			<option value="SD">Sudan</option>
			<option value="SR">Suriname</option>
			<option value="SJ">Svalbard and Jan Mayen</option>
			<option value="SZ">Swaziland</option>
			<option value="SE">Sweden</option>
			<option value="CH">Switzerland</option>
			<option value="SY">Syria</option>
			<option value="TW">Taiwan</option>
			<option value="TJ">Tajikistan</option>
			<option value="TZ">Tanzania</option>
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
			<option selected="" value="US">United States</option>
			<option value="UM">United States Minor Outlying Islands</option>
			<option value="VI">United States Virgin Islands</option>
			<option value="UY">Uruguay</option>
			<option value="UZ">Uzbekistan</option>
			<option value="VU">Vanuatu</option>
			<option value="VE">Venezuela</option>
			<option value="VN">Vietnam</option>
			<option value="WF">Wallis and Futuna</option>
			<option value="PS">West Bank</option>
			<option value="EH">Western Sahara</option>
			<option value="YE">Yemen</option>
			<option value="ZM">Zambia</option>
			<option value="ZW">Zimbabwe</option>
	</select>
	<?
	echo $form->input('mailing_list',array(
		'label' =>  __('Add me to the InternetSeminary.org mailing list', true),
		'between' => ''
	));
	
	echo $form->end('Save');
	?>
</div>