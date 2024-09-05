'use client'

import Image from 'next/image'
import Link from 'next/link'
import React, { FormEvent, useEffect, useState } from 'react'
import { FaCheck, FaLock, FaUser } from 'react-icons/fa'
import { IoMdClose } from 'react-icons/io'
import { MdEmail } from 'react-icons/md'
import { RiLoader5Line } from 'react-icons/ri'
import Avatar from './Avatar'
import { useUserContext } from '@/context/user'

enum UsernameStatus {
	default,
	checking,
	available,
	unavailable,
}

export default function RegisterModal({
	isProcessing,
	setIsProcessing,
	goToLogin,
	handleLogIn,
}: {
	goToLogin: () => void
	isProcessing: boolean
	setIsProcessing: Function
	handleLogIn: Function
}) {
	const [email, setEmail] = useState('')
	const [username, setUsername] = useState('')
	const [avatarUsername, setAvatarUsername] = useState('')
	const [usernameStatus, setUsernameStatus] = useState(UsernameStatus.default)
	const [isUsernameInvalid, setIsUsernameInvalid] = useState(false)
	const [password, setPassword] = useState('')
	const [repeatPassword, setRepeatPassword] = useState('')
	const [passwordsNotMatching, setPasswordsNotMatching] = useState(false)
	const [part, setPart] = useState(0)
	const [isOver18, setIsOver18] = useState(false)
	const [hasReadTerms, setHasReadTerms] = useState(false)

	function nextPart(e: FormEvent) {
		e.preventDefault()

		if (
			part === 0 &&
			email !== '' &&
			password !== '' &&
			repeatPassword !== ''
		) {
			setPasswordsNotMatching(false)
			if (password.localeCompare(repeatPassword) === 0) {
				setPart(1)
			} else {
				setPasswordsNotMatching(true)
			}
		}
	}

	async function handleSubmit(e: FormEvent) {
		e.preventDefault()

		setIsProcessing(true)

		const res = await fetch('/api/register', {
			method: 'POST',
			body: JSON.stringify({ username, password, email }),
		})

		if (res.ok) {
			handleLogIn(username, 20, true)
		}
	}

	async function checkAvailability() {
		const res = await fetch(`/api/user?username=${username}`)
		const user = await res.json()

		if (!user) {
			setUsernameStatus(UsernameStatus.available)
			setAvatarUsername(username)
		} else {
			setUsernameStatus(UsernameStatus.unavailable)
		}
	}

	useEffect(() => {
		if (username && !isUsernameInvalid) {
			setUsernameStatus(UsernameStatus.checking)

			const debounce = setTimeout(() => {
				checkAvailability()
			}, 1500)

			return () => clearTimeout(debounce)
		} else {
			setUsernameStatus(UsernameStatus.default)
		}
	}, [username])

	return (
		<div onClick={(e) => e.stopPropagation()} className='modal'>
			{part === 0 ? (
				<form onSubmit={(e) => nextPart(e)}>
					<h3 className='text-center text-2xl'>REGISTER</h3>
					<div>
						<label htmlFor='email' className='opacity-60 text-sm'>
							Email
						</label>
						<div className='border border-white/10 rounded flex items-center gap-4 py-2 px-4'>
							<MdEmail />
							<input
								autoFocus={true}
								type='email'
								className='bg-transparent outline-none'
								value={email}
								id='email'
								onChange={(e) => setEmail(e.target.value)}
							/>
						</div>
					</div>
					<div>
						<label htmlFor='password' className='opacity-60 text-sm'>
							Password
						</label>
						<div
							className={`border rounded flex items-center gap-4 py-2 px-4 ${
								passwordsNotMatching ? 'border-red-400' : 'border-white/10'
							}`}
						>
							<FaLock />
							<input
								type='password'
								className='bg-transparent outline-none'
								value={password}
								id='password'
								onChange={(e) => setPassword(e.target.value)}
							/>
						</div>
					</div>
					<div>
						<label htmlFor='repeatPassword' className='opacity-60 text-sm'>
							Repeat Password
						</label>
						<div
							className={`border rounded flex items-center gap-4 py-2 px-4 ${
								passwordsNotMatching ? 'border-red-400' : 'border-white/10'
							}`}
						>
							<FaLock />
							<input
								type='password'
								className='bg-transparent outline-none'
								value={repeatPassword}
								id='repeatPassword'
								onChange={(e) => setRepeatPassword(e.target.value)}
							/>
						</div>
					</div>
					<button
						type='submit'
						disabled={email === '' || password === '' || repeatPassword === ''}
						className='disabled:opacity-50 hover:shadow-xl transition-shadow w-full bg-primary-light font-semibold text-bg-dark py-2 px-4 rounded'
					>
						Next
					</button>
					<button onClick={goToLogin} className='mx-auto block opacity-70'>
						Login
					</button>
				</form>
			) : (
				<form onSubmit={(e) => handleSubmit(e)}>
					<h3 className='text-center text-2xl'>REGISTER</h3>
					<Avatar size='xl' username={avatarUsername} />

					<div>
						<label htmlFor='username' className='opacity-60 text-sm'>
							Username (letters and digits)
						</label>
						<div
							className={`border rounded flex items-center gap-4 py-2 px-4 ${
								isUsernameInvalid ||
								usernameStatus === UsernameStatus.unavailable
									? 'border-red-400'
									: 'border-white/10'
							}`}
						>
							<FaUser />
							<input
								autoComplete='off'
								autoFocus={true}
								type='text'
								className='bg-transparent outline-none'
								value={username}
								id='username'
								onChange={(e) => {
									setUsername(e.target.value)
									if (/^[a-zA-Z0-9]+$/.test(e.target.value)) {
										setIsUsernameInvalid(false)
									} else {
										setIsUsernameInvalid(true)
									}
								}}
							/>
							<div className='w-6 text-xl'>
								{usernameStatus === UsernameStatus.checking && (
									<RiLoader5Line className='animate-spin' />
								)}
								{usernameStatus === UsernameStatus.available && (
									<FaCheck className='text-green-400' />
								)}
								{usernameStatus === UsernameStatus.unavailable && (
									<IoMdClose className='text-red-300' />
								)}
							</div>
						</div>
					</div>

					<div className='mt-8'>
						<div className='flex items-center gap-2 w-fit mx-auto'>
							<button
								type='button'
								onClick={() => setIsOver18((current) => !current)}
								className='p-1'
							>
								<div
									className={`w-4 h-4 border border-white/30 text-xs rounded flex items-center justify-center ${
										isOver18 && 'bg-white/60 text-bg-dark'
									}`}
								>
									{isOver18 && <FaCheck />}
								</div>
							</button>
							<p className={isOver18 ? 'opacity-80' : 'opacity-50'}>
								I am over 18
							</p>
						</div>

						<div className='flex items-center gap-2 w-fit mx-auto mt-2'>
							<button
								type='button'
								onClick={() => setHasReadTerms((current) => !current)}
								className='p-1'
							>
								<div
									className={`w-4 h-4 border border-white/30 text-xs rounded flex items-center justify-center ${
										hasReadTerms && 'bg-white/60 text-bg-dark'
									}`}
								>
									{hasReadTerms && <FaCheck />}
								</div>
							</button>
							<p className={hasReadTerms ? 'opacity-80' : 'opacity-50'}>
								I agree to{' '}
								<Link
									href={'/terms'}
									target='_blank'
									className='underline underline-offset-2'
								>
									Terms & Conditions
								</Link>
							</p>
						</div>
					</div>

					<button
						type='submit'
						disabled={
							usernameStatus === UsernameStatus.unavailable ||
							!isOver18 ||
							!hasReadTerms ||
							isProcessing
						}
						className='disabled:opacity-50 hover:shadow-xl transition-shadow w-full bg-primary-light font-semibold text-bg-dark py-2 px-4 rounded'
					>
						{isProcessing ? (
							<RiLoader5Line className='animate-spin text-2xl mx-auto' />
						) : (
							<span>Register</span>
						)}
					</button>
					<button
						disabled={isProcessing}
						onClick={goToLogin}
						className='mx-auto block opacity-70'
					>
						Login
					</button>
				</form>
			)}
		</div>
	)
}
