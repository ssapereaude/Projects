import { query } from '@/lib/db'
import { NextRequest, NextResponse } from 'next/server'
import { User } from '@/lib/interfaces'

export async function POST(req: NextRequest) {
	try {
		const { game, username, bet, multiplier } = await req.json()
		const timestamp = new Date().toISOString().slice(0, 19).replace('T', ' ')

		await query(
			`INSERT INTO results (game, username, timestamp, bet, multiplier) VALUES ('${game}','${username}','${timestamp}','${bet}','${multiplier}')`
		)

		const user: User = {
			username,
			balance: 20,
		}

		return NextResponse.json(user)
	} catch (error) {
		return new Response('Error', { status: 500 })
	}
}
