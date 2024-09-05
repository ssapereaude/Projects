'use client'
import { avatarUrl } from '@/lib/functions'
import { useEffect, useState } from 'react'

export default function Avatar({
	size,
	username,
}: {
	size: 'md' | 'lg' | 'xl'
	username: string
}) {
	const [url, setUrl] = useState('')

	useEffect(() => {
		if (username !== '') {
			setUrl(avatarUrl(username))
		}
	}, [username])

	return (
		<div
			className={`${
				size === 'md' ? 'w-12 h-12' : size === 'lg' ? 'w-16 h-16' : 'w-20 h-20'
			} bg-white/15 overflow-hidden rounded-full mx-auto`}
		>
			{url !== '' && <img src={url} className='w-full' alt={'Avatar'} />}
		</div>
	)
}
