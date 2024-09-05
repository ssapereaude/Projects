'use client'

import {
	Dispatch,
	SetStateAction,
	createContext,
	useContext,
	useState,
} from 'react'

interface UserProps {
	username: string
	balance: number
	avatarUrl: string
	isPlaying: boolean
	setUsername: Dispatch<SetStateAction<string>>
	setBalance: Dispatch<SetStateAction<number>>
	setAvatarUrl: Dispatch<SetStateAction<string>>
	setIsPlaying: Dispatch<SetStateAction<boolean>>
	logOut: () => void
}

const UserContext = createContext<UserProps>({
	username: '',
	balance: 0,
	avatarUrl: '',
	isPlaying: false,
	setUsername: (): string => '',
	setBalance: (): number => 0,
	setAvatarUrl: (): string => '',
	setIsPlaying: (): boolean => false,
	logOut: (): void => {},
})

export function UserContextProvider({
	children,
}: {
	children: React.ReactNode
}) {
	const [username, setUsername] = useState('')
	const [balance, setBalance] = useState(0)
	const [avatarUrl, setAvatarUrl] = useState('')
	const [isPlaying, setIsPlaying] = useState(false)

	function logOut() {
		setBalance(0)
		setAvatarUrl('')
		setIsPlaying(true)
		setUsername('')
	}

	return (
		<UserContext.Provider
			value={{
				username,
				avatarUrl,
				balance,
				isPlaying,
				setUsername,
				setAvatarUrl,
				setBalance,
				logOut,
				setIsPlaying,
			}}
		>
			{children}
		</UserContext.Provider>
	)
}

export const useUserContext = () => useContext(UserContext)
