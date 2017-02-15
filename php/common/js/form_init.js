
(function(){

	// Will be used as lock to don't fire the initialization of the client until all scritps are loaded
	var fb_load_counter = 0;
	
	var data_name_fb = document.getElementById( "form_init_script" ).getAttribute( "data-name" );
	
	// jQuery file for the form
	var jQueryFile = data_name_fb + "common/libs_js/jquery-1.4.4.min.js";
	
	// Variable which will contain the jQuery version the FB will use
	var $fb;
	
	// Variable to control the the init of the resize event
	var fb_resize_init = false;
	
	// JS files the form needs
	var js_files = [
		data_name_fb + "common/libs_js/jquery-ui-1.8.9.custom.min.js",
		data_name_fb + "common/libs_js/jquery.ui.datepicker.js",
		data_name_fb + "common/libs_js/easyXDM/easyXDM.min.js",
		data_name_fb + "common/js/jquery.validate.js",
		data_name_fb + "common/libs_js/jquery.metadata.js",
		data_name_fb + "common/libs_js/jquery.placeholder.min.js",
		data_name_fb + "validation_data.js"+ '?' + Math.floor( Math.random()*1001 ),
		data_name_fb + "common/js/validation.js",
		data_name_fb + "common/js/conditionals.js",
		data_name_fb + "common/libs_js/jquery.signaturepad.min.js"
	];
	
	if( navigator.appName == 'Microsoft Internet Explorer' ) {
		// adds the JSON script if we are on IE browser
		js_files.splice( 0, 0, data_name_fb + "common/libs_js/json2.js" )
	}
	
	// CSS files needed to style the form
	var css_files = [
		data_name_fb + "common/css/jquery-ui-1.8.5.custom.css",
		data_name_fb + "common/css/normalize.css",
		data_name_fb + "common/css/jquery.signaturepad.css"
	];


	// Once the jQuery is loaded we launch our scripts to be loaded in parallel
	var fb_start_load = function ()
	{
		// Set the jquery form variable
	    $.noConflict();
	    $fb = jQuery;
	
		$fb(document).ready(function() {
		 	// Add the required JS files for the form once the doc is ready
			for( var i = 0; i < js_files.length; i++ )	{
				requireJS( js_files[i], fb_load_script );
			}
		});
		
		($fb).fb_resize = function() {
			
			// If colorbox nothing to do here
			if( $fb("#docContainer").attr('data-colorbox') ){
				return;
			}
			
			if( window.parent && window.parent.pSockets ) 
			{
				window.parent.pSockets.refresh_height();
			}
			else if( window.parent && window.parent.document && window.parent.document.getElementById('fb_iframe') )
			{
				if( !fb_resize_init ) {
					$fb(window.parent).resize( function(event) {
						window.parent.document.getElementById('fb_iframe').height = $fb('#docContainer').outerHeight(true) + 30;
					} );
						fb_resize_init = true;
				}
				window.parent.document.getElementById('fb_iframe').height = $fb('#docContainer').outerHeight(true) + 30;
			}
		}
	}

	
	// Function will be called with each js resource file
	var fb_load_script = function() {

		// We use the counter as lock to be sure all files needed are loaded
	    if( fb_load_counter < js_files.length - 1 )
	    {
	        fb_load_counter++;
	        return;
	    }
		else
		{
			fb_init_form()
		}
	}
	
	function fb_load_images_embedded(){

		// Treat <img> src to point to the data-name path of the project
		$fb.each($fb('#docContainer img'), function(key, element){
			var image = $fb(element).attr('src');
			var end = image.search("common");
			if( end == -1 ) {
				end = image.search("theme");
			}
			var strnew = image.substr(0, end);
			image = image.replace(strnew,"");
			
			$fb(element).attr('src', image );
		});
		
		// Treat background images inline
		$fb.each($fb('#docContainer, #docContainer *'), function(key, element){
			if( element.style.backgroundImage ){
				var bgImage = $fb(element).css('background-image');
				var begin= bgImage.search("http");
				if( begin == -1 ) {
					begin= bgImage.search("file");
				}
				var end = bgImage.search("common");
				if( end == -1 ) {
					end = bgImage.search("theme");
				}
				if(begin >=0) {
					var strnew = bgImage.substr(begin, end - begin);
					bgImage = bgImage.replace(strnew,"");
				}
				
				$fb(element).css('background-image', bgImage ) ;
			}
		});
		// Hover image is treated in validation data
		
	}
	
	function fb_custom_methods(){
		/**
		 * matches US phone number format 
		 * 
		 * where the area code may not start with 1 and the prefix may not start with 1 
		 * allows '-' or ' ' as a separator and allows parens around area code 
		 * some people may want to put a '1' in front of their number 
		 * 
		 * 1(212)-999-2345
		 * or
		 * 212 999 2344
		 * or
		 * 212-999-0983
		 * 
		 * but not
		 * 111-123-5434
		 * and not
		 * 212 123 4567
		 */
		jQuery.validator.addMethod("phoneUS", function(phone_number, element) {
		    phone_number = phone_number.replace(/[ext]{1,3}\.?\s*[\d]+$/, ""); 
			phone_number = phone_number.replace(/\s+/g, "");
			return this.optional(element) ||
				phone_number.match( /^\(\d{3}\)\d{3}-\d{4}$/ ) ||
				phone_number.match( /^1-[\d-]{10}$/ ) ||
				phone_number.match( /^[\d-.]{10}$/ );
		}, "Please specify a valid phone number");

		jQuery.validator.addMethod('phoneUK', function(phone_number, element) {
			phone_number = phone_number.replace(/[ext]{1,3}\.?\s*[\d]+$/, "");
			phone_number = phone_number.replace(/\s+/g, "");
			return this.optional(element) || 
				phone_number.match( /^\(0\d{2}\)\d{8}$/ ) ||
				phone_number.match( /^\(0\d{3}\)\d{7}$/ ) ||
				phone_number.match( /^\(0\d{4}\)\d{5,6}$/ ) ||
				phone_number.match( /^\(0\d{5}\)\d{4,5}$/ ) ||
				phone_number.match( /^0\d{9,10}$/ );
		}, 'Please specify a valid phone number');

		jQuery.validator.addMethod('mobileUK', function(phone_number, element) {
			phone_number = phone_number.replace(/[ext]{1,3}\.?\s*[\d]+$/, "");
			phone_number = phone_number.replace(/\s+/g, "");
			return this.optional(element) || 
				phone_number.match( /^07\d{9}$/ );
		}, 'Please specify a valid mobile number');
		
		jQuery.validator.addMethod('international', function(phone_number, element) {
			phone_number = phone_number.replace(/[ext]{1,3}\.?\s*[\d]+$/, "");
			phone_number = phone_number.replace(/\s+/g, "");
			phone_number = phone_number.replace(/[^\d+]/g, '');
			return this.optional(element) || 
				phone_number.match( /^\+?\d{9,15}$/ ); 
		}, 'Please enter a valid phone number');
		
		jQuery.validator.addMethod('regex_config', function(value, element, param) {
			try
			{
				var patt=/^(\W)([^\1]+)\1(.*)$/.exec( param );
				var regExpTest = new RegExp(patt[2], patt[3]);			
				return this.optional(element) || regExpTest.test(value);
			}
			catch(err){
				return false;
			}
		}, 'Please enter a value matching the regular expression');
		
		jQuery.validator.addMethod('decimals', function(value, element, param) {
			try
			{
				var tmp_decimal = param;
				// Zero is the special case as the number 0 is treated as false in the rules methods
				if(tmp_decimal == "zero")
					tmp_decimal = 0;
				var regExpTest = new RegExp("^-?\\d+\\.?\\d{0," + tmp_decimal + "}?$");
				return this.optional(element) || regExpTest.test(value);
			}
			catch(err){
				return false;
			}
		}, 'Please enter a valid number.');

		jQuery.validator.addMethod('minlength_checkbox', function(value, element, param) {
			try
			{
				return this.optional(element) || this.getLength(jQuery.trim(value), element) >= param;
			}
			catch(err){
				return false;
			}
		}, "Please select at least {0} options.");
		
	}
	
	function fb_apply_external_plugins()
	{
		var vJSPlugins = [];
		var vCSSPlugins = [];
		
		// Saves the lists of plugins in the config object
		if( data_jsplugins != undefined && data_jsplugins.length > 0 ) 		vJSPlugins = JSON.parse( data_jsplugins );
		if( data_cssplugins != undefined && data_cssplugins.length > 0 ) 	vCSSPlugins = JSON.parse( data_cssplugins );
		
		for( var i = 0; i < vJSPlugins.length; i++ )
		{
			var urlJS = vJSPlugins[i];
			if('https:' == document.location.protocol && urlJS.substr(0,5) != 'https')
			{
				urlJS = urlJS.replace( 'http', 'https' );
			}
			requireJS( urlJS );
		}
		
		for( var i = 0; i < vCSSPlugins.length; i++ )
		{
			var urlCSS = vCSSPlugins[i];
			if('https:' == document.location.protocol && urlCSS.substr(0,5) != 'https')
			{
				urlCSS = urlCSS.replace( 'http', 'https' );
			}
			requireCSS( urlCSS );
		}
		
	}
	
	function fb_ajax_payments () {
		$fb('#fb_paypalwps, #fb_authnet, #fb_2checkout').click( function(){
			$fb.ajax({
				url: '',
				data:{ action:'submitpayment', gateway:this.id },
				async: false
			});
		} );
	}
	
	function fb_init_form()
	{	
		// Checks the form really exists
		if(  (document.getElementById( "docContainer" ) == null)  
		     || (document.getElementById( "docContainer" ).tagName.toLowerCase() != "form") 
		  	 || $fb("#docContainer").attr('action') == undefined )
		{
			fb_apply_external_plugins();
			fb_ajax_payments();
			$fb.fb_resize();
			return;	
		}

		// Inits the hidden field to indate serve we got js!
		var hidden_js_enable = document.getElementById( "fb_js_enable" );
		if( hidden_js_enable != null && hidden_js_enable != undefined )
		{
			hidden_js_enable.setAttribute("value","1");
		}
		
		// Removes extra text nodes on the items
		$fb('#docContainer .column').contents().filter(function() { return this.nodeType === 3; }).remove();
		
		// Add our custom validation methods
		fb_custom_methods();

		// Checks if we are in the preview
		var isPreview = document.getElementById( "docContainer" ).getAttribute( "data-form" ) == 'preview';

		// To disable the date picker of the browser (see #1206, #1213 and #1274)
		$fb.each( $fb("input[type=date]") , function(key, element) {
			var date = $fb(element).wrap('<div></div>').parent().html().replace('type="date"','type="text"');
			$fb(element).replaceWith( date );
		});

				
		// Initializes the validation of the form
		var pValidateClient = new ValidateClient( $fb );
		pValidateClient.init_client( isPreview );

		// Initializes the conditionals of the form
		var pConditionalClient = new ConditionalClient( $fb );
		pConditionalClient.init_client();

		// If colorbox nothing to do here
		if( $fb("#docContainer").attr('data-colorbox') != "true" ) 
		{
			// Adds the location in case it is being embedded without iframe and it is not being shown on the sdrive page
			if( $fb('input[name="fb_form_custom_html"]').length && $fb("#docContainer").attr('data-form') == 'automated' && $fb("#docContainer").attr('action') != "./" )
			{
				$fb('input[name="fb_form_custom_html"]').get(0).value = parent.location.href;
			}
			
			// Adds the location in case it is being embedded with iframe
			if( $fb('input[name="fb_form_embedded"]').length && parent.frames.length != 0 && $fb("#docContainer").attr('data-form') == 'publish' )
			{
				$fb('input[name="fb_form_embedded"]').get(0).value = "1";
			}
			
			// Adds the url of the html page where its embedded
			if( $fb('input[name="fb_url_embedded"]').length && parent.frames.length != 0 && !window.parent.pSockets )
			{
				$fb('input[name="fb_url_embedded"]').get(0).value = encodeURIComponent( parent.location.href.split('?')[0] );
			}
			else if( $fb('input[name="fb_url_embedded"]').length && parent.frames.length != 0 && window.parent.pSockets )
			{
				// We will use in here the cross-domain methods
				window.parent.pSockets.get_location( function( location ){
					$fb('input[name="fb_url_embedded"]').get(0).value = encodeURIComponent( location );
				});
			}
			else if( $fb('input[name="fb_url_embedded"]').length && $fb("#docContainer").attr('data-form') == 'automated' )
			{
				$fb('input[name="fb_url_embedded"]').get(0).value = $('#docContainer').attr('action');
			}
			else if( $fb('input[name="fb_url_embedded"]').length )
			{
				$fb('input[name="fb_url_embedded"]').get(0).value = encodeURIComponent( window.location.href.split('?')[0] );
			}
		}		
		
		// Adds the url of the html page where its embedded
		if( $fb('input[name="fb_url_embedded"]').length && parent.frames.length != 0 && !window.parent.pSockets )
		{
			$fb('input[name="fb_url_embedded"]').get(0).value = encodeURIComponent( parent.location.href.split('?')[0] );
		}
		else if( $fb('input[name="fb_url_embedded"]').length && parent.frames.length != 0 && window.parent.pSockets )
		{
			// We will use in here the cross-domain methods
			window.parent.pSockets.get_location( function( location ){
				$fb('input[name="fb_url_embedded"]').get(0).value = encodeURIComponent( location );
			});
		}
		else if( $fb('input[name="fb_url_embedded"]').length && $fb("#docContainer").attr('data-form') == 'automated' )
		{
			$fb('input[name="fb_url_embedded"]').get(0).value = $('#docContainer').attr('action');
		}
		else if( $fb('input[name="fb_url_embedded"]').length )
		{
			$fb('input[name="fb_url_embedded"]').get(0).value = encodeURIComponent( window.location.href.split('?')[0] );
		}
		
		
		// In case we are on automated export and we are inside the slug we show also the images or in the colorbox iframe
		if( $fb("#docContainer").attr('data-form') == 'automated' && ( $fb("#docContainer").attr('action') ==  document.location.href || parent.frames.length != 0 ) ) {
			fb_load_images_embedded();
		}
		
		// If we are working on sdrive (publish or auto embedded), add the stats code see (empire:#1740)
		if( ( $fb("#docContainer").attr('data-form') == 'publish' 
			  || $fb("#docContainer").attr('data-form') == 'automated' ) && parent.frames.length != 0 
			  || $fb("#docContainer").attr('action').indexOf('http') != -1 
			  || $fb("#docContainer").attr('action') == "./" ) {
			$fb('#docContainer input[type!="submit"],#docContainer select,#docContainer textarea').change( function( event ) {
				$fb('#docContainer input[type!="submit"],#docContainer select,#docContainer textarea').unbind( event );
				var action = $fb('#docContainer').attr( 'action' );
				action = action.replace( /(?:\.php)|\/$/i , '/fbapp/api/formchangestats.php' );
				$fb.get( action );
				
				// Also resize for display errors
				$fb.fb_resize();
			});
		}
		
		// Adds the function for hiding the hints for checkboxes and radiobuttons
		$fb("#docContainer .fb-checkbox, #docContainer .fb-radio, #docContainer .fb-dropdown, #docContainer .fb-listbox").parent().mouseleave( function() {
			var hint_element = $fb(".showing_hint", this);
			if( hint_element != undefined )
				hint_element.removeClass("showing_hint").addClass("hidden_hint");
		} );

		$fb("#docContainer input:file").parent().parent().mouseleave( function() {
			var hint_element = $fb(".showing_hint", this);
			if( hint_element != undefined )
				hint_element.removeClass("showing_hint").addClass("hidden_hint");
		} );

		$fb("#docContainer input:checkbox, #docContainer input:radio").blur( function() {
			var hint_element = $fb(".showing_hint", $fb(this).parent().parent().parent() );
			if( hint_element != undefined )
				hint_element.removeClass("showing_hint").addClass("hidden_hint");
		} );

		$fb("#docContainer .column select, #docContainer .column input, #docContainer .column textarea").blur( function() {
			var hint_element = $fb(".showing_hint", $fb(this).parent().parent() ) ;
			if( hint_element != undefined )
				hint_element.removeClass("showing_hint").addClass("hidden_hint");
		});

		// Adds the function for showing the hints for checkboxes and radiobuttons
		$fb("#docContainer .fb-checkbox, #docContainer .fb-radio, #docContainer .fb-dropdown, #docContainer .fb-listbox").parent().mouseenter( function() {
			var hint_element = $fb(".hidden_hint", this);
			if( hint_element != undefined )
				hint_element.removeClass("hidden_hint").addClass("showing_hint");
		} );

		$fb("#docContainer input:file").parent().parent().mouseenter( function() {
			var hint_element = $fb(".hidden_hint", this);
			if( hint_element != undefined )
				hint_element.removeClass("hidden_hint").addClass("showing_hint");
		} );

		$fb("#docContainer input:checkbox, #docContainer input:radio").focus( function() {
			var hint_element = $fb(".hidden_hint", $fb(this).parent().parent().parent());
			if( hint_element != undefined )
				hint_element.removeClass("hidden_hint").addClass("showing_hint");
		} );

		$fb("#docContainer .column select, #docContainer .column input, #docContainer .column textarea").focus( function() {
			var hint_element = $fb(".hidden_hint", $fb(this).parent().parent() );
			if( hint_element != undefined) {
				hint_element.removeClass("hidden_hint").addClass("showing_hint");
		}
		});

		// Triggers the validation change on the files inputs
		$fb("input:file").change(function() {
	       	$fb("#docContainer").validate().element(this);
		} );
		
		// Triggers the validation change on the urls inputs
		$fb("input[type=url]").blur(function() {
	       	$fb("#docContainer").validate().element(this);
		} );
		
		// Triggers the validation change on the emails inputs
		$fb("input[type=email]").blur(function() {
	       	$fb("#docContainer").validate().element(this);
		} );
		
		// Triggers the validation change on the password inputs
		$fb("input[type=password]").blur(function() {
	       	$fb("#docContainer").validate().element(this);
		} );
		
		// Triggers the validation change on the tel inputs
		$fb("input[type=tel]").blur(function() {
	       	$fb("#docContainer").validate().element(this);
		} );

		// In case we are on IE, avoid the keyup validation (the 'type=tel' is treated as type=text)
		if( navigator.appName == 'Microsoft Internet Explorer') {
			$fb("input[type=tel]").keyup(function() {
		       	return false;
			} );
			var IEversion = parseFloat(navigator.appVersion.split("MSIE")[1]);
		            
			if(IEversion < 9){
				// Fix for the dropdowns get cut on IE
				$fb("#docContainer select").each(
					function(){
						var bFirstTime = true;
						$fb(this).mousedown(function(){
			                        if(bFirstTime)
			                        {
			                        	var actualWidth = parseInt( $fb(this).css("width") );
			                            var newWidth = parseInt( $fb(this).css("width","auto").css("width") );
			                            if( actualWidth > newWidth )
			                                $fb(this).css("width", "");
			                        }
			                        bFirstTime = false;
						})
						.blur(function(){
							$fb(this).css("width","");
							bFirstTime = true;
						})
						.change(function(){
							$fb(this).css("width","");
							bFirstTime = true;
					});
				});
			}
 
		}

		// Triggers the validation change on the fields numbers
		$fb("input[type=number]").keyup(function() {
				// Value of the default validation
				var pluginValidation = $fb('#docContainer').validate().element(this);

				// Checks if there is elements invalid on the browser so we show our custom error (only for non IE based)
				if( navigator.appName != 'Microsoft Internet Explorer' &&
				 		$fb( '#' + this.id + ':invalid').length > 0 && 
						( pluginValidation == undefined || pluginValidation == true ) ) {
					var name = this.name;
					var error = {};
					error[name] = 'Input must be a valid number'
					$fb('#docContainer').validate().showErrors( error );
				} else {
					// In case we have a default validation error we show that one
					$fb('label[for="' + this.id + '"]').remove();
					$fb('#docContainer').validate().element(this);
				}
			}).blur(function() {
				// After losing focus we reset the default validation
				$fb('label[for="' + this.id + '"]').remove();
				$fb('#docContainer').validate().element(this)
		});
		
		// Fallback to support the placeholders HTML5
		var isInputSupported = 'placeholder' in document.createElement('input');
	  	var isTextareaSupported = 'placeholder' in document.createElement('textarea');
		if( !isInputSupported )
		{
			$fb('#docContainer input').not('[type="password"]').placeholder();
		}

		if( !isTextareaSupported )
		{
			$fb('#docContainer textarea').placeholder();
		}
		
		// Applies the plugins loaded
		fb_apply_external_plugins();
		
		// We add the language files
		requireJS(data_name_fb + "common/js/lang/messages_validation.js");
		requireJS(data_name_fb + "common/js/lang/messages_datepicker.js");
		
		$fb(document).ready( function(){
			// Added a timeout of one sec to wait for the google fonts to be applied.
			setTimeout( $fb.fb_resize, 1000 );
		});
	 }

	// Function to load the resources javascripts
	var requireJS = function(jspath,callback) {
	  var fileref=document.createElement('script')
	  fileref.setAttribute("type","text/javascript")
	  fileref.setAttribute("src", jspath )
	  if( callback != undefined ) {
		if( fileref.addEventListener ) {
			fileref.addEventListener("load",callback,false);
		} else if( fileref.attachEvent ) {
			fileref.attachEvent(  "onreadystatechange",
				function() {
					if( fileref.readyState == "complete" || fileref.readyState == "loaded" )
						callback();
				}
			);
		}
	  }
	  
	  document.getElementsByTagName("head")[0].appendChild(fileref);
	}

	// Function to load the CSS files
	var requireCSS = function(csspath) {
	  var fileref=document.createElement("link")
	  fileref.setAttribute("rel", "stylesheet")
	  fileref.setAttribute("type", "text/css")
	  fileref.setAttribute("href", csspath )
	  document.getElementsByTagName("head")[0].appendChild(fileref);
	}

	// Request the css needed for the form
	for( var i = 0; i < css_files.length; i++ )	{
		requireCSS( css_files[i] );
	}
		
	// Request the load of jQuery
	requireJS( jQueryFile, fb_start_load );
})();
