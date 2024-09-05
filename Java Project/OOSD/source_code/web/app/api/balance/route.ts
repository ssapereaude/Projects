import { query } from '@/lib/db'
import { NextRequest, NextResponse } from 'next/server'

export async function POST(req: NextRequest) {
	try {
		const { username, balance } = await req.json()

		await query(
			`UPDATE users SET balance = '${balance}' WHERE username = '${username}'`
		)

		return NextResponse.json({ ok: true })
	} catch (error) {
		return new Response('Error', { status: 500 })
	}
}
