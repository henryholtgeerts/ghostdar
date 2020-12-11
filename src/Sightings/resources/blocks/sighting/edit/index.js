/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const { Fragment, useEffect } = wp.element;

/**
 * Internal dependencies
 */
import MapControl from '../../../components/map-control'

/**
 * Vendor dependencies
 */

const edit = ( { attributes, setAttributes, isSelected, clientId } ) => {

        const { latitude, longitude } = attributes;

	const saveSetting = ( name, value ) => {
		setAttributes( {
			[ name ]: JSON.stringify(value),
		} );
        };

	return (
        <Fragment>
                <div className="ghostdar-sighting-editor">
                        <h2>Sighting Editor!</h2>
                </div>
                <MapControl 
                        value={{lat: Number(latitude), lng: Number(longitude)}}
                        onChange={(value) => {
                                saveSetting('latitude', value.lat)
                                saveSetting('longitude', value.lng)
                        }}
                />
        </Fragment>
	);

};

export default edit;