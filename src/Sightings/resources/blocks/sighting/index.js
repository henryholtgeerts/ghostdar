/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

/**
 * Internal dependencies
 */
import edit from './edit';
import save from './save';
import { blockAttributes } from './utils';

/**
 * Register Block
 */

export default registerBlockType( 'ghostdar/sighting', {
	title: __( 'Sighting', 'Ghostdar' ),
	description: __( 'Used to control and display Sightings.', 'ghostdar' ),
	category: 'layout',
	icon: 'book-alt',
	keywords: [
		__( 'sighting', 'ghostdar' ),
	],
	attributes: blockAttributes,
	edit: edit,
	save: save,
} );