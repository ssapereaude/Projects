'use client'

import { AnimationEvent, useState } from 'react'
import { PiConfettiBold } from 'react-icons/pi'

export default function BonusModal({ close }: { close: Function }) {
	const [isClosing, setIsClosing] = useState(false)

	function handleClose(e: AnimationEvent) {
		if (e.animationName === 'disappear') {
			close()
		}
	}

	return (
		<div
			className={`bg-white fixed bottom-24 right-24 rounded-lg p-8 text-black/80 flex flex-col min-w-64 items-center ${
				isClosing ? 'animate-disappear' : 'animate-appear'
			}`}
			onAnimationEnd={(e) => handleClose(e)}
		>
			<div className='w-12 h-12 rounded-full bg-primary-light/30 flex items-center justify-center text-3xl text-primary-dark'>
				<PiConfettiBold />
			</div>
			<span className='opacity-100'>Welcome Bonus</span>
			<span className='text-3xl font-semibold mb-4 mt-2'>€20</span>
			<button
				onClick={() => setIsClosing(true)}
				className='w-full  rounded-full bg-primary-light font-semibold text-bg-dark py-1 px-4'
			>
				OK
			</button>
		</div>
	)
}
