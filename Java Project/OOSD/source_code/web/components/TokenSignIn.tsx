'use client'

import { useEffect, useState } from 'react'
import { RiLoader5Line } from 'react-icons/ri'
import Avatar from './Avatar'
import { FaCheck } from 'react-icons/fa'
import { MdErrorOutline } from 'react-icons/md'
import { useSearchParams } from 'next/navigation'
import { useUserContext } from '@/context/user'

enum State {
	processing,
	success,
	error,
}

export default function TokenSignIn() {
	const searchParams = useSearchParams()
	const { setUsername, setBalance } = useUserContext()

	const [showModal, setShowModal] = useState(false)
	const [state, setState] = useState(State.processing)
	const [user, setUser] = useState('')

	async function processLogIn(token: string) {
		setState(State.processing)
		setShowModal(true)

		const res = await fetch('/api/token', {
			method: 'POST',
			body: JSON.stringify({ token }),
		})

		if (res.ok) {
			const { username, balance } = await res.json()

			setUser(username)
			setState(State.success)

			setUsername(username)
			setBalance(Number(balance))
		} else {
			setState(State.error)
		}
	}

	useEffect(() => {
		const token = searchParams.get('token')

		if (token) {
			const nextSearchParams = new URLSearchParams(searchParams.toString())
			nextSearchParams.delete('token')
			processLogIn(token)
		}
	}, [])

	return (
		<>
			{showModal && (
				<div className='w-[100vw] h-[100vh] flex items-center justify-center bg-backdrop fixed top-0 left-0 z-40'>
					<div className='modal text-center'>
						{state === State.processing && (
							<RiLoader5Line className='animate-spin text-7xl' />
						)}
						{state === State.success && (
							<>
								<Avatar size='xl' username={user} />
								<p className='text-lg mt-2'>{user}</p>
								<p className='flex items-center gap-2 opacity-80'>
									<span>You are logged in</span>
									<FaCheck className='text-green-400' />
								</p>
								<button
									onClick={() => setShowModal(false)}
									className='w-full mt-4 bg-primary-light font-semibold text-bg-dark py-1 px-4 rounded'
								>
									OK
								</button>
							</>
						)}
						{state === State.error && (
							<>
								<MdErrorOutline className='text-3xl text-red-400 mx-auto' />
								<div className='flex flex-col items-center gap-8 mt-4 p-4'>
									<span className='text-3xl font-semibold'>Oooops</span>
									<span className='opacity-70'>Something went wrong</span>
								</div>
								<button
									onClick={() => setShowModal(false)}
									className='w-full mt-4 bg-primary-light font-semibold text-bg-dark py-1 px-4 rounded'
								>
									OK
								</button>
							</>
						)}
					</div>
				</div>
			)}
		</>
	)
}
