'use client'

import { FormEvent, useState } from 'react'
import { FaLock, FaUser } from 'react-icons/fa'
import { RiLoader5Line } from 'react-icons/ri'

export default function LoginModal({
	isProcessing,
	setIsProcessing,
	goToRegister,
	handleLogIn,
}: {
	isProcessing: boolean
	setIsProcessing: Function
	goToRegister: () => void
	handleLogIn: Function
}) {
	const [username, setUsername] = useState('')
	const [password, setPassword] = useState('')
	const [isWrong, setIsWrong] = useState(false)

	async function handleLogin(e: FormEvent) {
		e.preventDefault()

		setIsWrong(false)
		setIsProcessing(true)

		const res = await fetch(
			`/api/login?username=${username}&password=${password}`
		)
		const data = await res.json()

		if (!data) {
			setIsWrong(true)
			setIsProcessing(false)
		} else {
			handleLogIn(data.username, data.balance, false)
		}
	}

	return (
		<div onClick={(e) => e.stopPropagation()} className='modal'>
			<form onSubmit={(e) => handleLogin(e)}>
				<h3 className='text-center text-2xl'>LOGIN</h3>
				<div className='border border-white/10 rounded flex items-center gap-4 py-2 px-4'>
					<FaUser />
					<input
						autoFocus={true}
						type='text'
						className='bg-transparent outline-none'
						value={username}
						onChange={(e) => setUsername(e.target.value)}
					/>
				</div>
				<div className='border border-white/10 rounded flex items-center gap-4 py-2 px-4'>
					<FaLock />
					<input
						type='password'
						className='bg-transparent outline-none'
						value={password}
						onChange={(e) => setPassword(e.target.value)}
					/>
				</div>
				<p
					className={`text-center text-red-300 ${
						isWrong ? 'opacity-100' : 'opacity-0'
					}`}
				>
					Wrong username or password
				</p>
				<button
					type='submit'
					disabled={isProcessing}
					className='disabled:opacity-50 hover:shadow-xl transition-shadow w-full bg-primary-light font-semibold text-bg-dark py-2 px-4 rounded'
				>
					{isProcessing ? (
						<RiLoader5Line className='animate-spin text-2xl mx-auto' />
					) : (
						<span>Login</span>
					)}
				</button>
				<button
					type='button'
					onClick={goToRegister}
					className='mx-auto block opacity-70'
				>
					Register
				</button>
			</form>
		</div>
	)
}
