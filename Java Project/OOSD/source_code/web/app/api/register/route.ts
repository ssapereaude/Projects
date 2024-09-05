import { query } from '@/lib/db'
import { NextRequest, NextResponse } from 'next/server'
import bcrypt from 'bcrypt'
import { User } from '@/lib/interfaces'

export async function POST(req: NextRequest) {
	try {
		const { username, email, password } = await req.json()
		const hashedPassword = bcrypt.hashSync(
			password,
			Number(process.env.SALT_ROUNDS)
		)

		await query(
			`INSERT INTO users (username, email, balance, password) VALUES ('${username}','${email}','20','${hashedPassword}')`
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
