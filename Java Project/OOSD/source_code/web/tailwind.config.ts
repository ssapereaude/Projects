import type { Config } from 'tailwindcss'

const config: Config = {
	content: [
		'./pages/**/*.{js,ts,jsx,tsx,mdx}',
		'./components/**/*.{js,ts,jsx,tsx,mdx}',
		'./app/**/*.{js,ts,jsx,tsx,mdx}',
	],
	theme: {
		extend: {
			colors: {
				'bg-dark': 'rgb(var(--bg-dark) / <alpha-value>)',
				'bg-light': 'rgb(var(--bg-light) / <alpha-value>)',
				'primary-light': 'rgb(var(--primary-light) / <alpha-value>)',
				'primary-dark': 'rgb(var(--primary-dark) / <alpha-value>)',
				backdrop: 'rgba(0,0,0,0.5)',
			},
			gridTemplateColumns: {
				table: '10% 10% 40% 40%',
			},
			keyframes: {
				appear: {
					'0%': { scale: '0.5', opacity: '0' },
					'100%': { scale: '1', opacity: '1' },
				},
				disappear: {
					'0%': { scale: '1', opacity: '1' },
					'100%': { scale: '0.5', opacity: '0' },
				},
			},
			animation: {
				appear: 'appear 200ms ease-out forwards',
				disappear: 'disappear 200ms ease-out forwards',
			},
		},
	},
	plugins: [],
}
export default config
