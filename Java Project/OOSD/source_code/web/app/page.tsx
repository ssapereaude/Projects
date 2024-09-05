'use client'

import Image from 'next/image'
import Link from 'next/link'
import { FaStar } from 'react-icons/fa'

export default function Home() {
	return (
		<main>
			<section className='py-24 min-h-[calc(100vh-5rem)]'>
				<div className='flex gap-32'>
					<div className='flex-1 flex flex-col justify-between'>
						<div>
							<h3 className='text-3xl font-bold'>Mines</h3>
							<p className='opacity-80 mt-4'>
								The rules are simple - you will be presented with a grid of 25
								tiles. One by one, you will start uncovering these squares. With
								every tile you uncover, the amount you can checkout increases.
								Just be careful, if you uncover a mine, you lose...
							</p>
						</div>
						<div className='flex justify-stretch items-center gap-8 w-full'>
							<Link
								className='bg-primary-light text-bg-dark py-2 flex-1 text-center font-semibold rounded'
								href='/mines'
							>
								Play
							</Link>
							<span className='opacity-70'>Min bet € 5</span>
						</div>
					</div>
					<div className='flex-1 flex justify-center'>
						<div className='grid grid-cols-5 gap-4'>
							{[
								0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 0,
								0, 0, 0, 0,
							].map((isStar, i) => (
								<div
									key={'s' + i}
									className={`w-12 h-12 text-white flex items-center justify-center text-2xl font-semibold rounded ${
										isStar === 1 ? 'bg-green-400' : 'bg-primary-dark'
									}`}
								>
									{isStar === 1 ? <FaStar /> : '?'}
								</div>
							))}
						</div>
					</div>
				</div>
			</section>
			<section className='py-24 min-h-[calc(100vh-5rem)] bg-bg-light text-bg-dark'>
				<div className='flex gap-32 flex-row-reverse'>
					<div className='flex-1 flex flex-col justify-between'>
						<div>
							<h3 className='text-3xl font-bold'>Slots</h3>
							<p className='opacity-70 mt-4'>
								Try your luck in this classic casino game. The goal is to line
								up the symbols across the paylines to win prizes.
							</p>
						</div>
						<div className='flex justify-stretch items-center gap-8 w-full'>
							<div className='opacity-70 bg-primary-light text-bg-dark py-2 flex-1 text-center font-semibold rounded'>
								Coming Soon
							</div>
							<span className='opacity-50'>Min bet € 5</span>
						</div>
					</div>
					<div className='flex-1'>
						<div className='flex gap-8'>
							{[
								[1, 2, 4],
								[3, 2, 5],
								[6, 2, 3],
							].map((reel, r) => (
								<div key={'r' + r} className='bg-black/5 py-2 rounded-lg'>
									{reel.map((symbol, c) => (
										<div
											key={'r' + r + 'c' + c}
											className={`px-8 py-6 ${c === 1 && 'bg-primary-dark/30'}`}
										>
											<Image
												src={`/reels/symbol${symbol}.png`}
												width={60}
												height={60}
												alt='Symbol'
											/>
										</div>
									))}
								</div>
							))}
						</div>
					</div>
				</div>
			</section>
		</main>
	)
}
