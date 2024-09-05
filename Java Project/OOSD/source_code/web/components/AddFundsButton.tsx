'use client'

import { useUserContext } from '@/context/user'
import { useState } from 'react'
import { RiLoader5Line } from 'react-icons/ri'

export default function AddFundsButton() {
	const { username, balance } = useUserContext()

	const [isProcessing, setIsProcessing] = useState(false)

	async function handleClick() {
		setIsProcessing(true)

		const res = await fetch('/api/payment', {
			method: 'POST',
			body: JSON.stringify({ username }),
			headers: {
				'Content-Type': 'application/json',
			},
		})

		const checkoutURL = await res.json()

		sessionStorage.setItem('username', username)
		sessionStorage.setItem('balance', balance.toString())

		window.location.assign(checkoutURL)
	}

	return (
		<button
			onClick={handleClick}
			disabled={isProcessing}
			className='disabled:opacity-70 flex items-center gap-2 text-primary-light border border-primary-light rounded py-1 px-4'
		>
			Add Funds
			{isProcessing && (
				<RiLoader5Line className='animate-spin text-2xl mx-auto' />
			)}
		</button>
	)
}
