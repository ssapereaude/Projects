import { query } from '@/lib/db'
import { NextRequest, NextResponse } from 'next/server'

export async function POST(req: NextRequest) {
	try {
		const { token } = await req.json()

		const res = (await query(
			`SELECT username FROM tokens WHERE token = '${token}'`
		)) as { username: string }[]

		if (res.length === 0) {
			return new Response('Error', { status: 500 })
		}

		const username = res[0].username

		await query(`DELETE FROM tokens WHERE token = '${token}'`)

		const userRes = await fetch(
			process.env.URL + '/api/user?username=' + username
		)

		if (!userRes.ok) {
			return new Response('Error', { status: 500 })
		}

		const user = await userRes.json()

		return NextResponse.json({ username: user.username, balance: user.balance })
	} catch (error) {
		return new Response('Error', { status: 500 })
	}
}
