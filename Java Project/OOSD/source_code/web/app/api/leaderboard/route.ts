import { query } from '@/lib/db'
import { NextRequest, NextResponse } from 'next/server'

export async function GET(req: NextRequest) {
	try {
		const results = (await query(
			`SELECT username, balance FROM users ORDER BY balance DESC`
		)) as any[]

		if (results.length > 0) {
			return NextResponse.json(results)
		} else {
			return NextResponse.json([])
		}
	} catch (error) {
		return NextResponse.error()
	}
}
