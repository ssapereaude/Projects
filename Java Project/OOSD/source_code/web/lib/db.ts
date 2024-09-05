import mysql from 'mysql2/promise'

export async function query(query: string) {
	// create the connection to database
	const connection = await mysql.createConnection({
		host: 'localhost',
		user: 'root',
		database: process.env.DATABASE,
	})

	try {
		const [results] = await connection.query(query)

		// close the connection to database
		connection.end()

		return results
	} catch (error: any) {
		throw Error(error.message)
	}
}
