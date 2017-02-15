/// Conditional object for the client browser which will initializes the elements and the events needed for hiding/enabling the controls
function ConditionalClient( $, fb_socket ) {
	this.config = {};
	this.$fb = $;
}

// Helper for cloning object
ConditionalClient.prototype.clone = function(obj){
	
    if(obj == null || typeof(obj) != 'object')
        return obj;

    var temp = {};
    for(var key in obj)
        temp[key] = this.clone(obj[key]);

    return temp;
}

// Map with the current selected values of the elements:
ConditionalClient.prototype.selected_values = {}

// Elements already plugged to the event
ConditionalClient.prototype.initialized = {}

// Initializes the conditionals for the client
ConditionalClient.prototype.init_client = function() {	
	this.set_config_json( data_validation ); 
	this.apply_rules();  
	this.init_events( this.config );
}

// Initializes the conditionals for the client
ConditionalClient.prototype.init_events = function(object) {	
	var thisRef = this;
		
	for (var key in object) {

		// If the object doesn't has the property just continue
		if (!object.hasOwnProperty(key)) continue;

		switch(key){

			// If it is a set of rules we need to look at each rule and apply the logic operatior
			case 'name':
			case 'operator':
			case 'value':
				break;
			case 'element':
				if( !this.initialized.hasOwnProperty( object[key]['name'] ) )
				{
					this.initialized[ object[key]['name'] ] =  true;
					var elements = this.get_array_elements(object[key]['name']);
					this.$fb(elements).change( function(){
						thisRef.apply_rules();
						thisRef.$fb.fb_resize();
					});
					this.$fb(elements).keydown( function(e){
						if(e.keyCode == 13){
							thisRef.apply_rules();
							thisRef.$fb.fb_resize();
						}
					});
				}
				break;
			default:
				this.init_events( object[key] );
		}
	}
}


// Sets the rules for the conditionals client.
ConditionalClient.prototype.set_config = function( config )
{
	this.config = this.clone( config );	
};

// Sets the json configuration for the conditionals
ConditionalClient.prototype.set_config_json = function( json_config )
{
	// if its undefined or it is not a string do nothing
	if( typeof json_config == "undefined" || json_config === null || typeof json_config != "string" ) { return false; }
	
	// parses the json and set it
	var parsed = JSON.parse( json_config );
	if( !parsed.hasOwnProperty('conditionalRules') ) 
		return false;
	
	this.set_config( parsed['conditionalRules'] )
	
	return true;
};

// This method add all the rules existing in the conditionals config.
ConditionalClient.prototype.apply_rules = function()
{
	// Clean any previous selected values
	this.selected_values = {}
	
	// We loop through all the rule definitions
	for( var id in this.config )
	{
		if( this.config.hasOwnProperty(id) )
		{
			this.apply_rule_id( id );
		}
	}
	
	return true;
};

// This method add the rule to an specific element of the conditionals config.
ConditionalClient.prototype.apply_rule_id = function( id )
{
	// If the argument is not an id we do nothing
	if( arguments.length != 1 ) { return false; }

	// In case there is no config for that element do nothing
	if( typeof this.config[id] == 'undefined' || this.config[id] === null ) { return false; }
	
	if( !this.check_rule(this.config[id]) ) {
		this.$fb('#' + id).hide();
		this.$fb('#' + id).is( 'input, select, textarea' ) ? this.$fb('#' + id).attr( 'disabled', true ) : this.$fb( 'input, select, textarea','#' + id).attr( 'disabled', true );
		this.$fb('#' + id).is("#fb-submit-button") && this.$fb('input, select, button', '#docContainer').bind('keydown.fb_enter', function(e){ 
		  if(e.keyCode == 13){
		    e.preventDefault();
		    return false;
		  }
		});
	} else {
		this.$fb('#' + id).css('display','inline-block');
		this.$fb('#' + id).is( 'input, select, textarea' ) ? this.$fb('#' + id).removeAttr( 'disabled' ) : this.$fb( 'input, select, textarea','#' + id).removeAttr( 'disabled' );
		this.$fb('#' + id).is("#fb-submit-button") && this.$fb('input, select, button', '#docContainer').unbind('keydown.fb_enter');
		
	}
	
	return true;
};


// Check the rules for conditionals fields for a specific element.
ConditionalClient.prototype.check_rule = function (object) {
	for (var key in object) {

		// If the object doesn't has the property just continue
		if (!object.hasOwnProperty(key)) continue;

		switch(key){

			// If it is a set of rules we need to look at each rule and apply the logic operatior
			case 'set':
				if( object[key]['operator'] == 'and' )
					return this.check_rule( object[key]['rule1'] ) && this.check_rule( object[key]['rule2'] );
				else if( object[key]['operator'] == 'or' )
					return this.check_rule( object[key]['rule1'] ) || this.check_rule( object[key]['rule2'] );
			// If it is an element we need to check the value of the control name is correct with the proper operator
			case 'element':
					return this.check_value( object[key]['name'], object[key]['operator'], object[key]['value']);
			default:
				return true
		}
	}
};

// Checks the value of the rule is applied in the element based on the operator
ConditionalClient.prototype.check_value = function( name, operator, value ) {
	var values = this.get_array_values(name);
	var found = false;
	
	for( var i = 0; i < values.length; i++ ){
		if( values[i] == value ){
			found = true;
			break;
		}
	}
	
	
	if( operator == 'is' )
		return found;
	
	if( operator == 'is_not' )
		return !found;
		
	return true;		
};

// Returns the array of values selected in the control and sets the change event
ConditionalClient.prototype.get_array_values = function( name ) {
	
	if( this.selected_values.hasOwnProperty(name) )
	{
		return this.selected_values[name];
	}
	
	var elements = this.$fb('#docContainer').find('[name="' + name + '"]');
	var values = new Array();
	var thisRef = this;
	
	if( !elements.length ) {
		elements = this.$fb('#docContainer').find('[name="' + name + '[]"]');
	}
			
	if( elements.is('select') ) {
     	this.$fb.each( elements.find('option:selected'), function(key,element){
			values.push( thisRef.$fb(this).val() );
		});
	}
	else if( elements.is('input:checkbox') || elements.is('input:radio')  ) {
     	this.$fb.each( this.$fb(elements).parent().find('input:checked'), function(key,element){
			values.push( thisRef.$fb(this).val() );
		});
	}
	else {
		// In case placeholder plugin is set, its value is empty, otherwise is its content
		if(elements.hasClass("placeholder")) {
			values.push("");
		} else {
			values.push( elements.val() );
		}
	}
	
	// Updates the map with the selected values
	this.selected_values[name] = values;
	
	return values;
}


// Returns the array of values selected in the control and sets the change event
ConditionalClient.prototype.get_array_elements = function( name ) {
	
	var elements = this.$fb('#docContainer [name="' + name + '"]');
	
	if( !elements.length ) {
		elements = this.$fb('#docContainer [name="' + name + '[]"]');
	}
	
	return elements;
}
