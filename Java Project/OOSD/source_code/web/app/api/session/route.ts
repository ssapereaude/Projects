import { query } from '@/lib/db'
import { NextRequest, NextResponse } from 'next/server'
import Stripe from 'stripe'

export async function GET(req: NextRequest) {
	try {
		const sessionId = req.nextUrl.searchParams.get('sessionId') as string

		const stripe = new Stripe(process.env.STRIPE_SECRET_KEY as string, {
			apiVersion: '2023-10-16',
		})

		const session = await stripe.checkout.sessions.retrieve(sessionId)

		const amount = Number(session['amount_total']) / 100
		const username = session.metadata!.username
		const timestamp = new Date(session.created * 1000)
			.toISOString()
			.slice(0, 19)
			.replace('T', ' ')

		await query(
			`UPDATE users SET balance = balance + '${amount}' WHERE username = '${username}'`
		)

		await query(
			`INSERT INTO payments (paymentID, username, timestamp, balanceUP, isSuccessfull) VALUES ('${sessionId}', '${username}', '${timestamp}', '${amount}','1')`
		)

		return NextResponse.json({ amount, username })
	} catch (error) {
		return NextResponse.error()
	}
}
