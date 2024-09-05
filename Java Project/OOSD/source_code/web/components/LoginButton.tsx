'use client'

import React, { MouseEvent, useState } from 'react'
import RegisterModal from './RegisterModal'
import LoginModal from './LoginModal'
import { useUserContext } from '@/context/user'

enum Modal {
	none,
	login,
	register,
}

export default function LoginButton({
	showBonusModal,
}: {
	showBonusModal: Function
}) {
	const { setUsername, setBalance } = useUserContext()
	const [modal, setModal] = useState(Modal.none)
	const [isProcessing, setIsProcessing] = useState(false)

	function handleBackdropClick(e: MouseEvent) {
		if (!isProcessing) {
			setModal(Modal.none)
		}
	}

	function handleLogIn(
		username: string,
		balance: number,
		hasRegistered: boolean
	) {
		if (hasRegistered) {
			showBonusModal()
		}
		setBalance(balance)
		setUsername(username)
		setModal(Modal.none)
	}

	return (
		<>
			<button
				onClick={() => setModal(Modal.login)}
				className='ml-8 bg-primary-light font-semibold text-bg-dark py-1 px-4 rounded'
			>
				Login
			</button>

			{modal !== Modal.none && (
				<div
					onClick={(e) => handleBackdropClick(e)}
					className='w-[100vw] h-[100vh] flex items-center justify-center bg-backdrop fixed top-0 left-0 z-40'
				>
					{modal === Modal.login ? (
						<LoginModal
							isProcessing={isProcessing}
							setIsProcessing={setIsProcessing}
							goToRegister={() => setModal(Modal.register)}
							handleLogIn={handleLogIn}
						/>
					) : (
						<RegisterModal
							goToLogin={() => setModal(Modal.login)}
							isProcessing={isProcessing}
							setIsProcessing={setIsProcessing}
							handleLogIn={handleLogIn}
						/>
					)}
				</div>
			)}
		</>
	)
}
