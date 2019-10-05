( function( api ) {

	// Extends our custom "idyllic" section.
	api.sectionConstructor['idyllic'] = api.Section.extend( {

		// No idyllics for this type of section.
		attachIdyllics: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );
