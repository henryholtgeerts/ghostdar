const { registerPlugin } = wp.plugins;

import Render from './render';
 
export default registerPlugin('ghostdar-chapter', { 
    render: Render
} );