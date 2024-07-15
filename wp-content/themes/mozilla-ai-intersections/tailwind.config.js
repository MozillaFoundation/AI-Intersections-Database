/** @type {import('tailwindcss').Config} */
const themeScreens = {
	'2xl': { 
		max: '1400px'
	},
	'xl': {
		max: '1199px'
	},
	'lg': {
		max: '1024px'
	},
	'base': {
		max: '948px'
	},
	'md': {
		max: '768px'
	},
	'sm': {
		max: '640px'
	},
	'xs': {
		max: '480px'
	}
}

const themeColors = {
	blue: {
		5: `#E7E7FC`,
		10: `#D3D5FC`,
		20: `#B7B9FA`,
		40: `#595CF3`,
		60: `#3032D9`,
		80: `#0D10BF`,
		100: `#0003A6`
	},
	green: {
		5: `#D8FFF0`,
		10: `#ACFFE0`,
		20: `#80FFCE`,
		40: `#54FFBD`,
		60: `#2CC98E`,
		80: `#109462`,
		100: `#005E3A`
	},
	purple: {
		5: `#ECD8FE`,
		10: `#DEB8FE`,
		20: `#CD97FD`,
		40: `#8F14FB`,
		60: `#760BD4`,
		80: `#5E05AC`,
		100: `#470085`
	},
	cyan: {
		5: `#ACFFFF`,
		10: `#ACFFFF`,
		20: `#73FFFF`,
		40: `#00FFFF`,
		60: `#00C9C9`,
		80: `#009494`,
		100: `#005E5E`
	},
	grey: {
		5: `#FFFFFF`,
		10: `#F2F2F2`,
		20: `#CCCCCC`,
		40: `#999999`,
		60: `#666666`,
		80: `#333333`,
		100: `#000000`
	}
}

const themeFonts = {
	header: '"Zilla Slab", serif',
	body: '"Nunito Sans", sans-serif'
}

module.exports = {
	content: [
		'./**/*.php',
		'./assets/css/*.css',
		'./assets/js/*.js'
	],
	safelist: [
		'-ml-32',
		'order-1',
		'order-2',
		'order-3',
		'order-4',
		'order-5'
	],
	theme: {
		screens: themeScreens,
		extend: {
			colors: themeColors,
			fontFamily: themeFonts
		}
	}
}
