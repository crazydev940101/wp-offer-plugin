// Destructuring imports from wp.blocks and wp.components
const { registerBlockType } = wp.blocks;
const { TextControl, Notice } = wp.components;
const { useState } = wp.element;

// Registering a custom block called 'Offers Block'
registerBlockType('wp-offers/offers-block', {
    title: 'Offers Block',
    category: 'common',
    attributes: {
        apiUrl: {
            type: 'string',
            default: 'https://api.jsonbin.io/v3/b/65b7a4281f5677401f27c75b'
        }
    },
    edit: function(props) {
        const { attributes, setAttributes } = props;
        const [error, setError] = useState('');

        // Function to validate the URL
        const validateUrl = (url) => {
            return url.startsWith('https://api.jsonbin.io/');
        };

        // Function to handle URL changes
        const onUrlChange = (newUrl) => {
            if (validateUrl(newUrl)) {
                setAttributes({ apiUrl: newUrl });
                setError(''); // Clear any previous error
            } else {
                setError('Invalid URL. Please enter a valid API URL starting with "https://api.jsonbin.io".');
            }
        };
        
        return wp.element.createElement(
            'div',
            null,
            // Display error notice if there is an error
            error && wp.element.createElement(Notice, { status: 'error', isDismissible: false, children: error }),
            // Text input for API URL with onChange event
            wp.element.createElement(TextControl, {
                label: 'API URL',
                value: attributes.apiUrl,
                onChange: onUrlChange
            })
        );
    },
    save: function(props) {
        const { attributes } = props;
        return wp.element.createElement(
            'div',
            {
                'data-api-url': attributes.apiUrl,
                className: 'wp-block-wp-offers-offers-block'
            },
            null
        );
    }
})
