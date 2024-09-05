export const dynamic = 'force-dynamic'

import Avatar from '@/components/Avatar'
import { FaCrown } from 'react-icons/fa'

export default async function Leaderboard() {
	const res = await fetch(process.env.URL + '/api/leaderboard')
	const data = (await res.json()) as { username: string; balance: number }[]

	return (
		<main>
			<section>
				<h1 className='text-center mt-12 text-xl opacity-50'>Leaderboard</h1>
				<div className='flex items-center gap-20 py-8'>
					<div className='flex-1 flex items-end gap-8'>
						{data[2] && (
							<div className='flex flex-col items-center gap-2'>
								<FaCrown className='text-3xl text-orange-400' />
								<span className='text-2xl font-semibold text-orange-400'>
									{`€ ${data[2].balance}`}
								</span>
								<div className='h-40 w- bg-white/10 rounded flex flex-col gap-4 items-center w-fit p-4 justify-start'>
									<Avatar size='xl' username={data[2].username} />
									<span>{data[2].username}</span>
								</div>
							</div>
						)}
						{data[0] && (
							<div className='flex flex-col items-center gap-2'>
								<FaCrown className='text-3xl text-yellow-400' />
								<span className='text-2xl font-semibold text-yellow-400'>
									{`€ ${data[0].balance}`}
								</span>
								<div className='h-64 bg-white/10 rounded flex flex-col gap-4 items-center w-fit p-4 justify-start'>
									<Avatar size='xl' username={data[0].username} />
									<span>{data[0].username}</span>
								</div>
							</div>
						)}
						{data[1] && (
							<div className='flex flex-col items-center gap-2'>
								<FaCrown className='text-3xl text-gray-400' />
								<span className='text-2xl font-semibold text-gray-400'>
									{`€ ${data[1].balance}`}
								</span>
								<div className='h-52 bg-white/10 rounded flex flex-col gap-4 items-center w-fit p-4 justify-start'>
									<Avatar size='xl' username={data[1].username} />
									<span>{data[1].username}</span>
								</div>
							</div>
						)}
					</div>
					<div className='flex-1'>
						<div className='flex text-lg flex-col h-[60vh] overflow-y-auto no-scrollbar overflow-x-hidden'>
							{data.map((entry, i) => (
								<div
									key={i}
									className={`rounded-lg p-4 grid gap-4 grid-cols-table items-center ${
										i % 2 === 0 ? 'bg-white/10' : 'bg-transparent'
									}`}
								>
									<span className='opacity-60'># {i + 1}</span>
									<Avatar size='md' username={entry.username} />
									<span>{entry.username}</span>
									<span>€ {entry.balance}</span>
								</div>
							))}
						</div>
					</div>
				</div>
			</section>
		</main>
	)
}
