import type { Metadata } from 'next'
import './globals.css'
import { UserContextProvider } from '@/context/user'
import Navbar from '@/components/Navbar'

export const metadata: Metadata = {
	title: 'Casino',
	description: 'Best casino online',
}

export default function RootLayout({
	children,
}: Readonly<{
	children: React.ReactNode
}>) {
	return (
		<html lang='en'>
			<UserContextProvider>
				<body className='bg-bg-dark text-bg-light'>
					<Navbar />
					{children}
				</body>
			</UserContextProvider>
		</html>
	)
}
