/**
 * Block Attributes
*/

export const blockAttributes = {
	latitude: {
		type: 'string',
		default: null,
		source: 'meta',
		meta: 'ghostdar_sighting_latitude'
	},
	longitude: {
		type: 'string',
		default: null,
		source: 'meta',
		meta: 'ghostdar_sighting_longitude'
    },
    ghostId: {
		type: 'string',
		default: null,
		source: 'meta',
		meta: 'ghostdar_sighting_ghost_id'
	},
};