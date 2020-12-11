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

export default registerBlockType( 'ghostdar/sightings-map', {
	title: __( 'Sightings Map', 'Ghostdar' ),
	description: __( 'Used to control and display Sightings.', 'ghostdar' ),
	category: 'layout',
	icon: 'book-alt',
	keywords: [
		__( 'sighting', 'ghostdar' ),
	],
	supports: {
		align: ['wide']
	},
	attributes: blockAttributes,
	edit: edit,
	save: save,
} );