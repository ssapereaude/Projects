import { NextRequest, NextResponse } from 'next/server'
import bcrypt from 'bcrypt'

export async function GET(req: NextRequest) {
	try {
		const password = req.nextUrl.searchParams.get('password')

		if (!password || password.length === 0) {
			return new Response('Error', { status: 500 })
		}

		const hashedPassword = bcrypt.hashSync(
			password,
			Number(process.env.SALT_ROUNDS)
		)

		return NextResponse.json(hashedPassword)
	} catch (error) {
		return new Response('Error', { status: 500 })
	}
}
