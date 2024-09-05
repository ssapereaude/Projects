import { query } from '@/lib/db'
import { NextRequest, NextResponse } from 'next/server'

export async function GET(req: NextRequest) {
	try {
		const username = req.nextUrl.searchParams.get('username')

		const results = (await query(
			`SELECT * FROM users WHERE username = '${username}'`
		)) as any[]

		if (results.length > 0) {
			return NextResponse.json(results[0])
		} else {
			return NextResponse.json(null)
		}
	} catch (error) {
		return NextResponse.error()
	}
}
