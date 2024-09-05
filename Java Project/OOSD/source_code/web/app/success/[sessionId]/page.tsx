export const dynamic = 'force-dynamic'

import Avatar from '@/components/Avatar'
import Link from 'next/link'
import { FaCheck } from 'react-icons/fa'
import { MdErrorOutline } from 'react-icons/md'

export default async function Success({
	params,
}: {
	params: { sessionId: string }
}) {
	const sessionId = params.sessionId

	const res = await fetch(
		process.env.URL + '/api/session?sessionId=' + sessionId
	)

	if (res.ok) {
		const { amount, username } = await res.json()

		return (
			<main>
				<section>
					<div className='mx-auto my-20 rounded-lg overflow-hidden w-80 bg-black/20'>
						<div className='bg-green-400 flex items-center justify-center p-4'>
							<FaCheck className='text-xl' />
						</div>
						<div className='flex flex-col items-center gap-8 mt-4 p-4'>
							<Avatar size='xl' username={username} />
							<span className='text-3xl font-semibold'>+ € {amount}</span>
							<Link
								href='/'
								className='w-full text-center bg-primary-light font-semibold text-bg-dark py-1 px-4 rounded'
							>
								OK
							</Link>
						</div>
					</div>
				</section>
			</main>
		)
	}

	return (
		<main>
			<section>
				<div className='mx-auto my-20 rounded-lg overflow-hidden w-80 bg-black/20'>
					<div className='bg-red-400 flex items-center justify-center p-4'>
						<MdErrorOutline className='text-3xl' />
					</div>
					<div className='flex flex-col items-center gap-8 mt-4 p-4'>
						<span className='text-3xl font-semibold'>Oooops</span>
						<span className='opacity-70'>Something went wrong</span>
						<Link
							href='/'
							className='w-full text-center bg-primary-light font-semibold text-bg-dark py-1 px-4 rounded'
						>
							OK
						</Link>
					</div>
				</div>
			</section>
		</main>
	)
}
