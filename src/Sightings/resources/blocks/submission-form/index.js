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

export default registerBlockType( 'ghostdar/submission-form', {
	title: __( 'Submission Form', 'Ghostdar' ),
	description: __( 'Used to submit Sightings.', 'ghostdar' ),
	category: 'layout',
	icon: 'book-alt',
	keywords: [
		__( 'submission', 'ghostdar' ),
	],
	attributes: blockAttributes,
	edit: edit,
	save: save,
} );