/// Validation object which constructs the properties needed for each element the jquery validation plugin
function ValidateClient( $ ) {
	this.config = {};
	this.$fb = $;
	this.maxnumerrors = -1;
}

// Helper for cloning object
ValidateClient.prototype.clone = function(obj){
	
    if(obj == null || typeof(obj) != 'object')
        return obj;

    var temp = {};
    for(var key in obj)
        temp[key] = this.clone(obj[key]);

    return temp;
}

// Initializes the validation for the editor
ValidateClient.prototype.init_editor = function()
{	
	// Disables the submit of the form
	this.$fb("#fb-submit-button").click( function(){return false;}  );
};


// Initializes the validation for the client
ValidateClient.prototype.init_client = function( isPreview ) {
	
	var thisRef = this;
	
	// Removes the placeholder fallback in case existings
	this.$fb("#docContainer input:submit, #docContainer button:submit").click(function(event) {
		thisRef.$fb("#docContainer .placeholder").val("");
		
		// If we are working on sdrive (iframe or auto embedded), add the stats code see (empire:#1740)
		if( thisRef.$fb("#docContainer").attr('data-form') == 'automated' || thisRef.$fb("#docContainer").attr('data-form') == 'publish' ){

			// send the statistics when there are errors in the form
			if( !thisRef.$fb( '#docContainer' ).valid() ) {
				var action = thisRef.$fb('#docContainer').attr( 'action' );
				var numErrors = thisRef.$fb('#docContainer').validate().numberOfInvalids()
				action = action.replace( /(?:\.php)|\/$/i , '/fbapp/api/formchangestats.php?error=' + numErrors );
				thisRef.$fb.get( action );
			}
		}

		// Only prevent double submission when we are not on preview
		if( thisRef.$fb("#docContainer").attr('data-form') != 'preview' )
		{
			// This will prevent double submissions see (#895)		
			if( thisRef.$fb(this).attr('data-disabled')  )
			{
				event.preventDefault();
				event.stopPropagation();
				return false; 
			}

			if( thisRef.$fb( '#docContainer' ).valid() ) {
				thisRef.$fb(this).attr('data-disabled','disabled');
				
				// In case we are on a manual iframe, as we are on the same domain, when submitting is correct we scroll to the top of the page
				if(window.parent && window.parent.document && window.parent.document.getElementById('fb_iframe') && thisRef.$fb("#docContainer").attr('data-form') == 'manual_iframe')
					thisRef.$fb("body", window.parent.document ).scrollTop( thisRef.$fb("iframe", window.parent.document ).position().top );
			}
		}
		thisRef.$fb.fb_resize();
		return true;
	});

	if( isPreview ) {
		this.$fb.validator.setDefaults({
			submitHandler: function( form ) {
				if( thisRef.$fb(form).valid() ) {
					alert("Submitted!");
				}
			} 
		});
	}
	
	
	this.$fb("#docContainer").validate({
		errorPlacement: function(error, element) {
			
					if( thisRef.maxnumerrors != -1 ) {
						var countVisible = 0;
						thisRef.$fb.each( thisRef.$fb('#docContainer label.error'), function(key,element) {
							if(thisRef.$fb(element).css('display') != 'none')
								countVisible++;
						});
						
						if( countVisible >= thisRef.maxnumerrors )
							return;
					}
					
		            offset = element.offset();
		            //error.insertBefore( element.parent().childNodes[0] )
					if( thisRef.$fb(element).attr( "type" ) == "checkbox" || thisRef.$fb(element).attr( "type" ) == "radio" )
					{
						// Override the width to display it in the full div elements div
						thisRef.$fb(error).css('width','100%');
						thisRef.$fb(element).parent().parent().append( thisRef.$fb(error) );
					}
					else if( thisRef.$fb(element).attr( "id" ) == "recaptcha_response_field" )
					{
						thisRef.$fb("#fb-captcha_control").append( thisRef.$fb(error) );
					}
					else
					{
						thisRef.$fb(error).insertAfter( thisRef.$fb(element) );
					}					
					
		            error.addClass('message');  // add a class to the wrapper
		        }
	});
	
	this.set_config( JSON.parse( data_validation ) ); 
	this.add_rules();  

}

// Sets the rules for the validation client.
ValidateClient.prototype.set_config = function( config )
{
	this.config = this.clone( config );	
};

// Sets the json configuration for the validation
ValidateClient.prototype.set_config_json = function( json_config )
{
	// if its undefined or it is not a string do nothing
	if( typeof json_config == "undefined" || json_config === null || typeof json_config != "string" ) { return false; }
	
	// parses the json and set it
	this.config = JSON.parse( json_config );
	return true;
};

// Adds the rule to the element
ValidateClient.prototype.add_rule_type = function( id, type )
{
	// If the argument is not an id we do nothing
	if( arguments.length != 2 ) { return false; }

	// In case there is no config for that element do nothing
	if( typeof this.config[id] == 'undefined' || this.config[id] === null ) { return false; }
	
	// In case there is no config or is empty for that element do nothing
	if( typeof this.config[id][type] == 'undefined' || this.config[id][type] === null || this.config[id][type] == "" ) { return false; }
	
	// Checks if the element really exists in the html and it is not the captcha
	if( id != 'sigpad' && id != 'reCaptcha' && id !='_special' && ! this.$fb(  '#' + id ).length ) { return false; }
	
	var thisRef = this;
	if( type == 'date_config' )
	{
		// We init the object as a datepicker, triggering the change each time a new date is selected
		this.$fb('#' + id ).attr('id', '').removeClass('hasDatepicker').removeData('datepicker').unbind().attr('id',id).datepicker({
			onClose: function(){
				thisRef.$fb("#docContainer").validate().element(this);
			},
			showAnim:''
		});
		
		// We loop through all the date rule definitions
		for( var date_type in this.config[id][type] )
		{
			// We check the type is really an element of the object
			if ( this.config[id][type].hasOwnProperty( date_type ) ) 
			{
				var daterule_obj = {};
				
				// adds the date picker rule for that element
				if( date_type == "minDate" || date_type == "maxDate" )
				{
					if( this.config[id][type][date_type] != "" )
						daterule_obj[ date_type ] = new Date( this.config[id][type][date_type] );
				}
				else
				{
					daterule_obj[ date_type ] = this.config[id][type][date_type];
				}
				this.$fb( '#' + id ).datepicker("option", date_type, daterule_obj[ date_type ] );
			}
		}		
	}
	// We set the hover style
	else if( type == 'hover' ) {
		var data_name_fb = document.getElementById( "form_init_script" ).getAttribute( "data-name" );
		var url_sep_index = 4;
		if( navigator.appName == 'Microsoft Internet Explorer' ) {
			url_sep_index = 5;
		}
		
		// We loop through all the hover rule definitions
		for( var hover_rule in this.config[id][type] )
		{
			var default_value = this.$fb( '#' + id ).css(hover_rule);
			var hover_val = thisRef.config[id][type][hover_rule];
			// Here we treat the path for hover in case we are on automated export
			if( ( this.$fb("#docContainer").attr('data-form') == 'automated' && this.$fb("#docContainer").attr('action') != "./" ) || 
				( this.$fb("#docContainer").attr('data-form') == 'manual_iframe' && this.$fb("#docContainer").attr('action') != "../" + data_name_fb +".php" ) ) {
				hover_val = hover_val != '' ? hover_val.substr(0,4) + data_name_fb + hover_val.substr(4,hover_val.length) : hover_val;
			}
			
			// Preload the img jquery way if it is established
			if (hover_val != 'none' && hover_val != '')
			{
				var tmphover = hover_val.substr( hover_val.indexOf('(') + 1, hover_val.indexOf(')') - hover_val.indexOf('(') -1 );
				var tmpdefault = default_value.substr( default_value.indexOf('(') + 1, default_value.indexOf(')') - default_value.indexOf('(') -1 )
				this.$fb('<img/>').attr('src', tmphover);
				this.$fb('<img/>').attr('src', tmpdefault);
			}
			
			
			var thisRef = this;
			this.$fb( '#' + id ).hover(
				function(){
					if(hover_val != 'none' && hover_val != '')
						thisRef.$fb(this).css("background-image", hover_val );
					else if( hover_val == 'none' )
						thisRef.$fb(this).css("background-image", default_value );
					else
						thisRef.$fb(this).css("background-image", '' );
				},
				function(){
					thisRef.$fb(this).css("background-image", default_value )
				}
			);
		}
	}
	// We save the max num of errors in case exists
	else if ( type == 'maxnumerrors' ) {
		if(this.config[id][type] != undefined && this.config[id][type] != '' )
			this.maxnumerrors = this.config[id][type];
	}
	// We set the captcha as a required value
	else if( type == 'captcha' )
	{
		if( this.config[id][type] && this.$fb( '#recaptcha_response_field' ).length )
		{
			var rule_obj = {};
			rule_obj[ 'required' ] = true;

			// We add the messages in case existing
			if( typeof( this.config[id].messages ) == 'string' )
			{
				var msg_obj = {};
				msg_obj['required'] = this.config[id].messages;
				rule_obj.messages = msg_obj;
			}
			
			this.$fb( '#recaptcha_response_field' ).rules( "add", rule_obj );
		}
	}
	// We set the sigpad validations and initializations
	else if( type == 'sigpad' )
	{
			// Sets the sizes
			this.$fb('#fb-sigpad_control canvas').attr('width', parseInt(this.$fb('#fb-sigpad_control canvas').css('width')));
			this.$fb('#fb-sigpad_control .sigpad-width').val(parseInt(this.$fb('#fb-sigpad_control canvas').css('width')));
			this.$fb('#fb-sigpad_control .sigpad-height').val(parseInt(this.$fb('#fb-sigpad_control canvas').css('height')));
			this.$fb('#fb-sigpad_control .sigpad-prefix').val(this.config[id]['prefix'] || 'sigpad');

			// Inits the sigpad
			this.$fb('#docContainer').signaturePad({
				drawOnly:true,
				output:'.sigpad-output',
				clear:'.sigPad_clear',
				errorClass: 'sigpad-error',
				lineTop: parseInt(this.$fb('#fb-sigpad_control .sigWrapper').css('height')) -20,
				errorMessageDraw: this.config[id]['messages'],
				bgColour: this.config[id]['sigpad_canvas_color'] || '#ffffff',
				penColour: this.config[id]['sigpad_pen_color'] || '#145394',
				lineColour: this.config[id]['sigpad_line_color'] || '#cccccc',
				onFormError: function (errors, context, settings) {
					if( errors.drawInvalid ){
						if( thisRef.$fb('.sigpad-error').length === 0 ) {
							thisRef.$fb('.sigWrapper').append('<label class="sigpad-error error"/>');
						}
						thisRef.$fb('.sigpad-error').text(settings.errorMessageDraw);
					}
					// Removes the disabling of double submit in case signing failed
					if( thisRef.$fb("#fb-submit-button").attr('data-disabled') === 'disabled' ) {
						thisRef.$fb("#fb-submit-button").removeAttr('data-disabled');
					}
				}
			});
	}
	// We don't treat label items as they are not part of validation for the client or any other unexisting item
	else if( this.$fb(  '#' + id ).length > 0 && type.indexOf('sigpad_') === -1 )
	{
		var rule_obj = {};
		rule_obj[ type ] = this.config[id][type];

		// We add the messages in case existing
		if( typeof( this.config[id].messages ) == 'string' )
		{
			var msg_obj = {};
			msg_obj[type] = this.config[id].messages;
			
			if( type == 'range' )
			{
				msg_obj['max'] = this.config[id].messages;
				msg_obj['min'] = this.config[id].messages;
			}
			
			rule_obj.messages = msg_obj;
		}
		
		if( type == 'equalTo')
		{
			//We get the id of the associated element	
			var equalToElementId = this.config[id].equalTo.substring(1, this.config[id].equalTo.length);

			//If it has a customized error message we apply it to the verification field
			if(typeof( this.config[equalToElementId].messages ) == 'string' )	
			{
				var msg_obj = {};		
				msg_obj[type] = this.config[equalToElementId].messages;						
				rule_obj.messages = msg_obj;				
			}			

		}
	
		// adds the rule for that element
		this.$fb(  '#' + id ).rules( "add", rule_obj );
	}
	
	return true;	
};


// Adds the rules for a specific element 
ValidateClient.prototype.add_rule_id = function( id ) 
{
	// If the argument is not an id we do nothing
	if( arguments.length != 1 ) { return false; }
	
	// In case there is no config for that element do nothing
	if( typeof this.config[id] == 'undefined' || this.config[id] === null ) { return false; }

	// We loop through all the rule definitions
	for( var type in this.config[id] )
	{
		// We check the type is really an element of the object
		if ( this.config[id].hasOwnProperty(type) ) 
		{
			// We treat the rules per ID
			this.add_rule_type( id, type  );
		}
	}
	return true;
};


// This method add all the rules existing in the validation config.
ValidateClient.prototype.add_rules = function()
{
	// We loop through all the rule definitions
	for( var id in this.config )
	{
		if( this.config.hasOwnProperty(id) )
		{
			this.add_rule_id( id );
		}
	}
	
	return true;
};
