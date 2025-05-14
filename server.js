import express from 'express'
import mysql from 'mysql2'
import fs from 'fs'
import dotenv from 'dotenv'
import morgan from 'morgan'

dotenv.config()

const app = express()
const port = process.env.PORT || 1234
app.use(morgan('dev'))

const db = mysql.createConnection({
    host: process.env.DB_HOST,
    user: process.env.DB_USERNAME,
    password: process.env.DB_PASSWORD,
    database: process.env.DB_DATABASE
})

db.connect((err) => {
    if (err) {
        console.error('Database connection error: ' + err.stack)
        return
    }
    console.log('Connected to MySQL database')
})

app.get('/reports/:report_id', (req, res) => {
    const reportId = req.params.report_id

    db.query(
        'SELECT * FROM reports WHERE id = ?',
        [reportId],
        (err, results) => {
            if (err) {
                console.error('Database query error: ' + err)
                return res.status(500).send('Database error')
            }

            if (results.length === 0) {
                return res.status(404).send('Report not found')
            }

            const report = results[0]

            const filePath = `storage/app/reports/${report.fileId}.${report.ext}`

            if (!fs.existsSync(filePath)) {
                return res.status(404).send('File not found')
            }

            const filename = `${report.title}.${report.ext}`

            res.download(filePath, filename, (err) => {
                if (err) {
                    console.error('Error sending file: ' + err)
                    res.status(500).send('Error sending file')
                }
            })
        }
    )
})

app.listen(port, () => {
    console.log(`Server running at http://localhost:${port}`)
})
