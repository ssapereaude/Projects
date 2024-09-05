'use client'

import { useUserContext } from '@/context/user'
import Link from 'next/link'
import LoginButton from './LoginButton'
import Avatar from './Avatar'
import { useEffect, useState } from 'react'
import BonusModal from './BonusModal'
import { round } from '@/lib/functions'
import AddFundsButton from './AddFundsButton'
import TokenSignIn from './TokenSignIn'
import Image from 'next/image'

export default function Navbar() {
	const { username, balance, isPlaying, logOut, setUsername, setBalance } =
		useUserContext()

	const [showBonus, setShowBonus] = useState(false)

	async function logUserIn(username: string) {
		const res = await fetch('/api/user?username=' + username)
		const data = await res.json()

		if (data) {
			setBalance(data.balance)
			setUsername(username)
		}
	}

	useEffect(() => {
		if (sessionStorage.getItem('username') !== null) {
			logUserIn(sessionStorage.getItem('username') as string)
			sessionStorage.clear()
		}
	}, [])

	return (
		<>
			<nav className='bg-bg-dark z-30 flex justify-between h-20 items-center border-b border-b-bg-light/10 px-[10%] fixed top-0 left-0 w-[100vw]'>
				<h1 className='text-primary-dark flex items-center gap-4 text-2xl font-bold'>
					<Image src={'/logo.png'} width='50' height='50' alt='logo' />
					Casino
				</h1>
				<div className='flex items-center gap-8'>
					<Link href={'/'}>Games</Link>
					<Link href={'/leaderboard'}>Leaderboard</Link>
					{username !== '' ? (
						<>
							<AddFundsButton />
							<div className='flex items-center gap-4 bg-black/30 rounded-full p-1'>
								<Avatar size='md' username={username} />
								<span className='text-xl pr-4'>€ {round(balance, 2)}</span>
							</div>
							<button
								onClick={logOut}
								disabled={isPlaying}
								className='disabled:opacity-70 ml-8 bg-primary-light font-semibold text-bg-dark py-1 px-4 rounded'
							>
								Log Out
							</button>
						</>
					) : (
						<LoginButton
							showBonusModal={() =>
								setTimeout(() => {
									setShowBonus(true)
								}, 1500)
							}
						/>
					)}
				</div>
			</nav>

			{showBonus && <BonusModal close={() => setShowBonus(false)} />}
			<TokenSignIn />
		</>
	)
}
