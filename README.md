# Import Excel in PHP

This project demonstrates how to import Excel (`.xlsx` or `.xls`) files into a MySQL database using PHP. All the logic is written in a single `index.php` file. It is a simple and effective tool for uploading and inserting spreadsheet data into a MySQL table.

---

## 🧰 Prerequisites

Make sure the following software is installed:

- [XAMPP](https://www.apachefriends.org/index.html) (includes Apache, PHP, and MySQL)
- Web browser (Chrome, Firefox, etc.)
- [Git](https://git-scm.com/) (optional, for cloning)

---

## 🚀 Installation Steps

### 1. Clone or Download the Repository

#### Option A: Clone with Git

```bash
git clone https://github.com/your-username/import-excel-in-php.git
Option B: Manual Download
Download the ZIP from the GitHub repository

Extract the ZIP file

Move the project folder to your XAMPP htdocs directory:

cpp
Copy
Edit
C:\xampp\htdocs\import-excel-in-php
2. Start Apache and MySQL via XAMPP
Open XAMPP Control Panel and start:

Apache

MySQL

3. Import the Database
Open http://localhost/phpmyadmin

Create a new database (e.g., excel_import)

Click on the database name → go to the Import tab

Select the file:
import_excel_using_in_php.sql (located in the root of the project folder)

Click Go to import the tables and structure

4. Configure the Database Connection
Open the file:

arduino
Copy
Edit
config/connection.php
Update the following lines if needed:

php
Copy
Edit
$mysql_user     = "root";
$mysql_password = "";
$mysql_database = "import_excel_using_in_php"; // Make sure it matches the DB name you created
$mysql_host     = "localhost";
5. Run the Application
In your browser, go to:

arduino
Copy
Edit
http://localhost/import-excel-in-php/
You will see the interface where you can upload and import an Excel file.

📁 File Structure
pgsql
Copy
Edit
import-excel-in-php/
│
├── config/
│   └── connection.php
│
├── index.php                # Main application file (upload + import logic)
├── import_excel_using_in_php.sql   # SQL dump file to create database/tables
├── README.md
✅ Features
Upload .xls or .xlsx files

Parse and insert Excel data into MySQL

Single-page logic (index.php)

Minimal and clean structure

🛠️ Troubleshooting
Ensure Apache and MySQL are running

Make sure PHP extensions like php_zip, php_xml, and php_gd2 are enabled in php.ini if using PhpSpreadsheet

Set the correct permissions on the uploads/ directory (if used)

Check PHP errors in the browser or error logs in xampp/php/logs/php_error_log

📄 License
This project is open-source and available under the MIT License.

🙋‍♂️ Support
For issues or suggestions, please create a GitHub Issue.

👨‍💻 Author
Developed by Aftab Tunio
CTO – AMIZ Private Limited
GitHub Profile