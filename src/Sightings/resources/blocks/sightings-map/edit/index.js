/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const { Fragment, useEffect } = wp.element;

/**
 * Internal dependencies
 */
import SightingsMap from '../../../components/sightings-map'

const edit = ( { attributes, setAttributes, isSelected, clientId } ) => {

	return (
        <SightingsMap/>
	);

};

export default edit;