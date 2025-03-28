(function (blocks, element) {
    var el = element.createElement;
    var registerBlockType = blocks.registerBlockType;

    registerBlockType('slots/slot-details', {
        title: 'Slot Details',
        icon: 'star-filled',
        category: 'widgets',
        
        edit: function(props) {
            var postType = wp.data.select('core/editor').getCurrentPostType();          
            // If not a slot post type, show a message
            if (postType !== 'slot') {
                return el('div', { 
                    className: 'slot-details-block-preview',
                    style: { 
                            padding: '1px 20px',
                            background: '#e5a7a7',
                        } 
                    }, [
                    el('p', {}, 'This block can only be used on Slot posts.')
                ]);
            }
            // Create a block preview for the editor
            return el('div', { className: 'slot-details-block-preview' }, [
                el('h4', {}, 'Slot Details Preview'),
                el('p', {}, el('strong', {}, 'Star Rating: '), '3'),
                el('p', {}, el('strong', {}, 'Provider: '), 'Example Provider'),
                el('p', {}, el('strong', {}, 'RTP: '), '98%'),
                el('p', {}, el('strong', {}, 'Min Wager: '), '$5'),
                el('p', {}, el('strong', {}, 'Max Wager: '), '$200')
            ]);
        },

        save: function () {
            return null; 
        }
        
    });
})(window.wp.blocks,window.wp.element);