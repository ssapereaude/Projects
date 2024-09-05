import { query } from '@/lib/db'
import { NextRequest, NextResponse } from 'next/server'
import bcrypt from 'bcrypt'

export async function GET(req: NextRequest) {
	try {
		const username = req.nextUrl.searchParams.get('username')
		const password = req.nextUrl.searchParams.get('password')

		const results = (await query(
			`SELECT * FROM users WHERE username = '${username}'`
		)) as any[]

		if (results.length === 0) {
			return NextResponse.json(null)
		}

		const user = results[0]

		const res = await bcrypt.compare(password || '', user.password)

		if (res) {
			return NextResponse.json(user)
		} else {
			return NextResponse.json(null)
		}

		// return NextResponse.json(null)
	} catch (error) {
		return NextResponse.error()
	}
}
