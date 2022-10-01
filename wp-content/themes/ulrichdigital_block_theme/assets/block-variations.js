wp.blocks.registerBlockVariation(
	'core/group',
		{
			name: 'home-teaser-group',
			title: 'Home Teaser Group',
			innerBlocks: [
				['core/heading', { level: 2, placeholder: 'Mein Titel'}],
				['core/heading', { level: 3, placeholder: 'Mein Text'}]

			],
			attributes: {
				className: 'white_block'
			},
		}
);