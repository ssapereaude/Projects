export function avatarUrl(seed: string) {
	return 'https://api.dicebear.com/8.x/micah/svg?seed=' + seed
}

export function round(num: number, places: number) {
	return Math.round(num * Math.pow(10, places)) / Math.pow(10, places)
}
