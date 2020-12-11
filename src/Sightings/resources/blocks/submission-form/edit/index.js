/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const { Fragment, useEffect } = wp.element;

/**
 * Internal dependencies
 */
import SubmissionForm from '../../../components/submission-form'

const edit = ( { attributes, setAttributes, isSelected, clientId } ) => {

	return (
        <SubmissionForm/>
	);

};

export default edit;