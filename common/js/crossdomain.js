/// Cross-Domain communication object for the client browser to handle iframe's communication
function CrossDomain( $, socket ) {
	this.$fb = $;
	this.fb_sockets = socket;
}

CrossDomain.prototype.refresh_height = function(){
	this.fb_sockets.refresh_height( this.get_height() );
}


CrossDomain.prototype.get_height = function (){
	return parseInt( this.$fb('iframe').contents().find("#docContainer").outerHeight(true) ) + 30;
}


CrossDomain.prototype.get_location = function( callback ){
	this.fb_sockets.get_location( callback );
}

