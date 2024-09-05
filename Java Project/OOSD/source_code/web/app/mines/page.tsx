'use client'

import { useUserContext } from '@/context/user'
import { round } from '@/lib/functions'
import { useEffect, useState } from 'react'
import { FaBomb, FaLock, FaStar } from 'react-icons/fa'
import { RiLoader5Line } from 'react-icons/ri'

const betAmountOptions = [5, 8, 10, 25, 50, 75]
const noOfBombsOptions = [
	{
		bombs: 1,
		multiplier: 1.01,
	},
	{
		bombs: 3,
		multiplier: 1.05,
	},
	{
		bombs: 5,
		multiplier: 1.1,
	},
	{
		bombs: 10,
		multiplier: 1.5,
	},
	{
		bombs: 15,
		multiplier: 2,
	},
	{
		bombs: 20,
		multiplier: 3,
	},
]

interface Tile {
	isBomb: boolean
	isUncovered: boolean
}

export default function Mines() {
	const { username, balance, isPlaying, setBalance, setIsPlaying } =
		useUserContext()

	const [betAmount, setBetAmount] = useState(5)
	const [noOfBombs, setNoOfBombs] = useState(noOfBombsOptions[0].bombs)
	const [multiplier, setMultiplier] = useState(noOfBombsOptions[0].multiplier)
	const [checkoutAmount, setCheckoutAmount] = useState(0)
	const [noOfUncovered, setNoOfUncovered] = useState(0)
	const [isProcessingBet, setIsProcessingBet] = useState(false)
	const [isProcessingCheckout, setIsProcessingCheckout] = useState(false)
	const [grid, setGrid] = useState<Tile[]>(createGrid(0))

	function shuffle(array: any[]) {
		for (var i = array.length - 1; i > 0; i--) {
			var j = Math.floor(Math.random() * (i + 1))
			var temp = array[i]
			array[i] = array[j]
			array[j] = temp
		}
	}

	function createGrid(noOfBombs: number) {
		const grid = []
		for (let i = 0; i < noOfBombs; i++) {
			grid.push({
				isBomb: true,
				isUncovered: false,
			})
		}
		for (let i = noOfBombs; i < 25; i++) {
			grid.push({
				isBomb: false,
				isUncovered: false,
			})
		}

		shuffle(grid)

		return grid
	}

	async function handleStart() {
		setIsProcessingBet(true)

		const newBalance = balance - betAmount

		const res = await fetch('/api/balance', {
			method: 'POST',
			body: JSON.stringify({ balance: newBalance, username }),
		})

		setIsProcessingBet(false)

		if (res.ok) {
			setNoOfUncovered(0)
			setBalance(newBalance)
			setGrid(createGrid(noOfBombs))
			setIsPlaying(true)
		}
	}

	function handleClick(index: number) {
		if (grid[index].isBomb) {
			setIsPlaying(false)
			fetch('/api/results', {
				method: 'POST',
				body: JSON.stringify({
					game: 'mines',
					username,
					bet: betAmount,
					multiplier: 0,
				}),
			})
		} else {
			setNoOfUncovered((currentCount) => currentCount + 1)
		}

		setGrid((currentGrid) => {
			const newGrid = [...currentGrid]

			newGrid[index].isUncovered = true

			return newGrid
		})
	}

	useEffect(() => {
		setCheckoutAmount(round(Math.pow(multiplier, noOfUncovered) * betAmount, 2))

		console.log(betAmount)
	}, [noOfUncovered])

	useEffect(() => {
		if (username === '') {
			setCheckoutAmount(0)
			setNoOfUncovered(0)
			setIsProcessingBet(false)
			setIsProcessingCheckout(false)
			setIsPlaying(false)
			setGrid(createGrid(0))
		}
	}, [username])

	async function handleCheckout() {
		setIsProcessingCheckout(true)

		fetch('/api/results', {
			method: 'POST',
			body: JSON.stringify({
				game: 'mines',
				username,
				bet: betAmount,
				multiplier: Math.pow(multiplier, noOfUncovered),
			}),
		})

		const newBalance = round(balance + checkoutAmount, 2)

		const res = await fetch('/api/balance', {
			method: 'POST',
			body: JSON.stringify({ balance: newBalance, username }),
		})

		setIsPlaying(false)
		setIsProcessingCheckout(false)

		if (res.ok) {
			setBalance(newBalance)
		}
	}

	return (
		<main>
			<section className='flex gap-16 py-20'>
				<div className='flex-1 flex flex-col justify-between'>
					<div>
						<span className='text-sm opacity-50'>Bet Amount</span>
						<div className='grid grid-cols-3 gap-4 mt-2'>
							{betAmountOptions.map((amount) => (
								<button
									key={amount}
									disabled={username === '' || balance < amount || isPlaying}
									onClick={() => setBetAmount(amount)}
									className={`disabled:opacity-60 bg-white/5 text-lg text-center p-1 border rounded ${
										amount === betAmount && username !== ''
											? 'text-primary-light border-primary-light'
											: 'text-white/70 border-white/5'
									}`}
								>
									€ {amount}
								</button>
							))}
						</div>
					</div>
					<div>
						<span className='text-sm opacity-50'>Number of Bombs</span>
						<div className='grid grid-cols-3 gap-4 mt-2'>
							{noOfBombsOptions.map((option) => (
								<button
									key={option.bombs}
									disabled={username === '' || isPlaying}
									onClick={() => {
										setNoOfBombs(option.bombs)
										setMultiplier(option.multiplier)
									}}
									className={`disabled:opacity-60 bg-white/5 text-lg text-center p-1 border rounded ${
										noOfBombs === option.bombs && username !== ''
											? 'text-primary-light border-primary-light'
											: 'text-white/70 border-white/5'
									}`}
								>
									{option.bombs}
								</button>
							))}
						</div>
					</div>
					<button
						disabled={username === '' || isPlaying || balance < betAmount}
						onClick={handleStart}
						className={`w-full text-lg bg-primary-light font-semibold text-bg-dark py-1 px-4 rounded ${
							isPlaying ? 'opacity-0' : 'opacity-100'
						}`}
					>
						{username === '' ? (
							<span className='flex items-center justify-center gap-2'>
								You must be logged in <FaLock />
							</span>
						) : isProcessingBet ? (
							<span className='flex items-center justify-center gap-2'>
								Processing
								<RiLoader5Line className='animate-spin text-2xl' />
							</span>
						) : (
							<span>Play</span>
						)}
					</button>
				</div>

				<div className='flex-1'>
					<div
						className={`flex flex-col w-fit mx-auto gap-8 ${
							isPlaying ? 'opacity-100' : 'opacity-70'
						}`}
					>
						<div className='grid grid-cols-5 gap-4 w-fit'>
							{grid.map((tile, i) => (
								<button
									key={i}
									disabled={
										!isPlaying || isProcessingCheckout
										/* || tile.isUncovered */
									}
									onClick={() => handleClick(i)}
									className={`w-12 h-12 text-2xl rounded flex items-center justify-center ${
										!tile.isUncovered
											? 'bg-primary-dark'
											: tile.isBomb
											? 'bg-red-400'
											: 'bg-green-500'
									}`}
								>
									{!tile.isUncovered ? (
										<span className='font-bold'>?</span>
									) : tile.isBomb ? (
										<FaBomb />
									) : (
										<FaStar />
									)}
								</button>
							))}
						</div>
						<button
							disabled={!isPlaying}
							onClick={handleCheckout}
							className='disabled:opacity-0 text-lg bg-primary-light font-semibold text-bg-dark py-1 px-4 rounded'
						>
							{isProcessingCheckout ? (
								<span className='flex items-center justify-center gap-2'>
									Processing
									<RiLoader5Line className='animate-spin text-2xl' />
								</span>
							) : (
								<span>Checkout €{checkoutAmount}</span>
							)}
						</button>
					</div>
				</div>
			</section>
		</main>
	)
}
