(function (blocks, element, components, blockEditor) {
    var el = element.createElement;
    var registerBlockType = blocks.registerBlockType;
    var InspectorControls = blockEditor.InspectorControls;
    var PanelBody = components.PanelBody;
    var ColorPalette = components.ColorPalette;
    var SelectControl = components.SelectControl;
    var ToggleControl = components.ToggleControl;
    var RangeControl = components.RangeControl;
    var TextControl = components.TextControl;
 
    registerBlockType('slots/slot-grid', {
        title: 'Slot Grid',
        icon: 'grid-view',
        category: 'widgets',

        attributes: {
            limit: { type: 'number', default: 9 },
            order_by: { type: 'string', default: 'recent' },
            backgroundColor: { type: 'string', default: '#e5ebee' },
            borderColor: { type: 'string', default: '#ddd' },
            borderRadius: { type: 'number', default: 20 },
            borderWidth: { type: 'number', default: 0 },
            boxShadowColor: { type: 'string', default: '#404040' },
            boxShadowBlur: { type: 'number', default: 20 },
            boxShadowSpread: { type: 'number', default: -10 },

            showRating: { type: 'boolean', default: true },
            showProvider: { type: 'boolean', default: true },
            showRTP: { type: 'boolean', default: true },
            showMinMaxWager: { type: 'boolean', default: true },
            
            titleFontSize: { type: 'number', default: 20 },
            titleColor: { type: 'string', default: '#000000' },
            textFontSize: { type: 'number', default: 15 },
            textColor: { type: 'string', default: '#333333' },
            
            buttonBackground: { type: 'string', default: '#303030' },
            buttonFontColor: { type: 'string', default: '#FFFFFF' },
            buttonBorderColor: { type: 'string', default: '#000000' },
            buttonBorderWidth: { type: 'number', default: 1 },
            buttonBorderRadius: { type: 'number', default: 5 },
            buttonFontSize: { type: 'number', default: 14 },
            buttonPadding: { type: 'string', default: '5px 16px' }
            
        },

        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;
            var placeholderImg = window.location.origin + '/wp-content/plugins/slots-pages/assets/img/default.png';

            // Side Panel styling elements
            return el('div', {},
                el(InspectorControls, {},
                    el(PanelBody, { title: 'Grid Settings' },
                        el(RangeControl, {
                            label: 'Number of Slots',
                            value: attributes.limit,
                            onChange: (value) => setAttributes({ limit: value }),
                            min: 1,
                            max: 20
                        }),
                        el(SelectControl, {
                            label: 'Sort By',
                            value: attributes.order_by,
                            options: [
                                { label: 'Recent', value: 'recent' },
                                { label: 'Last Updated', value: 'updated' },
                                { label: 'Random', value: 'random' }
                            ],
                            onChange: (value) => setAttributes({ order_by: value })
                        })
                    ),
                    el(PanelBody, { title: 'Wrapper Settings', initialOpen: false },
                        el(components.BaseControl, { label: 'Background Color' },
                            el(ColorPalette, {
                                value: attributes.backgroundColor,
                                onChange: (value) => setAttributes({ backgroundColor: value })
                            })
                        ),
                        el(components.BaseControl, { label: 'Border Color' },
                            el(ColorPalette, {
                                value: attributes.borderColor,
                                onChange: (value) => setAttributes({ borderColor: value })
                            })
                        ),
                        el(RangeControl, {
                            label: 'Border Thickness',
                            value: attributes.borderWidth,
                            min: 0,
                            max: 10,
                            onChange: (value) => setAttributes({ borderWidth: value })
                        }),
                        el(RangeControl, {
                            label: 'Border Radius',
                            value: attributes.borderRadius,
                            min: 0,
                            max: 50,
                            onChange: (value) => setAttributes({ borderRadius: value })
                        }),
                        el(components.BaseControl, { label: 'Box Shadow Color' },
                            el(ColorPalette, {
                                value: attributes.boxShadowColor,
                                onChange: (value) => setAttributes({ boxShadowColor: value })
                            })
                        ),
                        el(RangeControl, {
                            label: 'Box Shadow Blur',
                            value: attributes.boxShadowBlur,
                            min: 0,
                            max: 20,
                            onChange: (value) => setAttributes({ boxShadowBlur: value })
                        }),
                        el(RangeControl, {
                            label: 'Box Shadow Spread',
                            value: attributes.boxShadowSpread,
                            min: -10,
                            max: 10,
                            onChange: (value) => setAttributes({ boxShadowSpread: value })
                        })
                    ),
                    el(PanelBody, { title: 'Content Display', initialOpen: false },
                        el(ToggleControl, {
                            label: 'Show Star Rating',
                            checked: attributes.showRating,
                            onChange: (value) => setAttributes({ showRating: value })
                        }),
                        el(ToggleControl, {
                            label: 'Show Provider',
                            checked: attributes.showProvider,
                            onChange: (value) => setAttributes({ showProvider: value })
                        }),
                        el(ToggleControl, {
                            label: 'Show RTP',
                            checked: attributes.showRTP,
                            onChange: (value) => setAttributes({ showRTP: value })
                        }),
                        el(ToggleControl, {
                            label: 'Show Min & Max Wager',
                            checked: attributes.showMinMaxWager,
                            onChange: (value) => setAttributes({ showMinMaxWager: value })
                        })
                    ),
                    el(PanelBody, { title: 'Typography Settings', initialOpen: false },
                        el(RangeControl, {
                            label: 'Title Font Size',
                            value: attributes.titleFontSize,
                            min: 10,
                            max: 30,
                            onChange: (value) => setAttributes({ titleFontSize: value })
                        }),
                        el(components.BaseControl, { label: 'Title Color' },
                            el(ColorPalette, {
                                value: attributes.titleColor,
                                onChange: (value) => setAttributes({ titleColor: value })
                            })
                        ),
                        el(RangeControl, {
                            label: 'Text Font Size',
                            value: attributes.textFontSize,
                            min: 10,
                            max: 24,
                            onChange: (value) => setAttributes({ textFontSize: value })
                        }),
                        el(components.BaseControl, { label: 'Text Color' },
                            el(ColorPalette, {
                                value: attributes.textColor,
                                onChange: (value) => setAttributes({ textColor: value })
                            })
                        ),
                    ),
                    el(PanelBody, { title: 'Button Styling', initialOpen: false },
                        el(components.BaseControl, { label: 'Button Background Color' },
                            el(ColorPalette, {
                                value: attributes.buttonBackground,
                                onChange: (value) => setAttributes({ buttonBackground: value })
                            })
                        ),
                        el(components.BaseControl, { label: 'Button Border Color' },
                            el(ColorPalette, {
                                value: attributes.buttonBorderColor,
                                onChange: (value) => setAttributes({ buttonBorderColor: value })
                            })
                        ),                        
                        el(RangeControl, {
                            label: 'Button Border Radius',
                            value: attributes.buttonBorderRadius,
                            min: 0,
                            max: 50,
                            onChange: (value) => setAttributes({ buttonBorderRadius: value })
                        }),
                        el(RangeControl, {
                            label: 'Button Border Width',
                            value: attributes.buttonBorderWidth,
                            min: 0,
                            max: 10,
                            onChange: (value) => setAttributes({ buttonBorderWidth: value })
                        }),  
                        el(components.BaseControl, { label: 'Button Font Color' },
                            el(ColorPalette, {
                                value: attributes.buttonFontColor,
                                onChange: (value) => setAttributes({ buttonFontColor: value })
                            })
                        ),                      
                        el(RangeControl, {
                            label: 'Button Font Size',
                            value: attributes.buttonFontSize,
                            min: 10,
                            max: 24,
                            onChange: (value) => setAttributes({ buttonFontSize: value })
                        }),
                        el(TextControl, {
                            label: 'Button Padding',
                            value: attributes.buttonPadding,
                            onChange: (value) => setAttributes({ buttonPadding: value })
                        })
                    )
                ),
                // Create a block preview for the editor
                el('div', {
                    style: {
                        backgroundColor: attributes.backgroundColor,
                        border: attributes.borderWidth + 'px solid ' + attributes.borderColor,
                        borderRadius: attributes.borderRadius + 'px',
                        boxShadow: `0px 4px ${attributes.boxShadowBlur}px ${attributes.boxShadowSpread}px ${attributes.boxShadowColor}`,
                        padding: '20px',
                        textAlign: 'center'
                    }
                }, [
                    el('img', { src: placeholderImg, style: { width: '100%', borderRadius: attributes.borderRadius + 'px' } }),
                    el('h4', { 
                        style: { fontSize: attributes.titleFontSize + 'px', color: attributes.titleColor }
                    }, 'Slot Example'),
                    attributes.showRating ? el('p', { 
                        style: { fontSize: attributes.textFontSize + 'px', color: attributes.textColor }
                    }, '⭐ 4.5/5') : null,
                    attributes.showProvider ? el('p', { 
                        style: { fontSize: attributes.textFontSize + 'px', color: attributes.textColor }
                    }, 'Provider: NetEnt') : null,
                    attributes.showRTP ? el('p', { 
                        style: { fontSize: attributes.textFontSize + 'px', color: attributes.textColor }
                    }, 'RTP: 96.5%') : null,
                    attributes.showMinMaxWager ? el('p', { 
                        style: { fontSize: attributes.textFontSize + 'px', color: attributes.textColor }
                    }, 'Min-Max Wager: $0.10 - $100') : null,
                    el('a', { 
                        href: '#',
                        style: { 
                            display: 'inline-block',
                            marginTop: '10px',
                            padding: attributes.buttonPadding,
                            background: attributes.buttonBackground,
                            color: attributes.buttonFontColor,
                            textDecoration: 'none',
                            border: attributes.buttonBorderWidth + 'px solid ' + attributes.buttonBorderColor,
                            borderRadius: attributes.buttonBorderRadius + 'px',
                            fontSize: attributes.buttonFontSize + 'px'
                        } 
                    }, 'More Info')
                ])
            );
        },

        save: function () {
            return null; 
        }
    });
})(window.wp.blocks, window.wp.element, window.wp.components, window.wp.blockEditor);