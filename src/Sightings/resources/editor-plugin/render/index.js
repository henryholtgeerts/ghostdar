const { PluginDocumentSettingPanel } = wp.editPost;

const { TextControl } = wp.components;
const { useDispatch, useSelect } = wp.data;
const { __ } = wp.i18n;
const { useCallback } = wp.element;

const Render = () => {
    const { editPost } = useDispatch('core/editor');
    
    const meta = useSelect( ( select ) => {
        return select( 'core/editor' ).getEditedPostAttribute( 'meta' );
    }, [] );

    const {
        ghostdar_chapter_latitude,
        ghostdar_chapter_longitude,
        ghostdar_chapter_radius
    } = meta;

    const saveSetting = (key, value) => {
        editPost({
            meta: {
                [key]: value
            }
        });
    };

    return (
        <PluginDocumentSettingPanel
            name="ghostdar-location"
            title="Location"
            className="ghostdar-location"
            icon={() => <div/>}
        >
            <TextControl
                name="latitude"
                label={ __( 'Latitude', 'ghostdar' ) }
                type="text"
                onChange={ ( value ) => saveSetting( 'ghostdar_chapter_latitude', value ) }
                value={ ghostdar_chapter_latitude }
            />
            <TextControl
                name="longitude"
                label={ __( 'Longitude', 'ghostdar' ) }
                type="text"
                onChange={ ( value ) => saveSetting( 'ghostdar_chapter_longitude', value ) }
                value={ ghostdar_chapter_longitude }
            />
            <TextControl
                name="radius"
                label={ __( 'Radius', 'ghostdar' ) }
                type="text"
                onChange={ ( value ) => saveSetting( 'ghostdar_chapter_radius', value ) }
                value={ ghostdar_chapter_radius }
            />
        </PluginDocumentSettingPanel>
    )
}
export default Render;