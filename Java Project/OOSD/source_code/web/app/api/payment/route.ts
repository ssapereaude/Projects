import { NextRequest, NextResponse } from 'next/server'
import Stripe from 'stripe'

export async function POST(req: NextRequest) {
	const stripe = new Stripe(process.env.STRIPE_SECRET_KEY as string, {
		apiVersion: '2023-10-16',
	})
	const { username } = await req.json()

	const session = await stripe.checkout.sessions.create({
		line_items: [
			{
				price: process.env.STRIPE_PRICE_ID,
				quantity: 1,
			},
		],

		mode: 'payment',
		metadata: {
			username,
		},
		success_url: process.env.URL + '/success/{CHECKOUT_SESSION_ID}',
		cancel_url: process.env.URL,
	})

	return NextResponse.json(session.url)
}
