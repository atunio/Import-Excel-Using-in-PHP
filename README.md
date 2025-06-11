# Import Excel in PHP

This project demonstrates how to import Excel (.xlsx or .xls) files into a MySQL database using PHP. It is built to help developers quickly integrate Excel upload functionality into their web applications. The project uses XAMPP, PHP, and MySQL as its stack.

---

## 🧰 Prerequisites

Make sure you have the following software installed:

- [XAMPP](https://www.apachefriends.org/index.html) (includes Apache, PHP, and MySQL)
- [Git](https://git-scm.com/) (optional, if cloning via Git)
- PHP version 7.0 or later
- Composer (optional, if using libraries like PhpSpreadsheet)

---

## 🚀 Installation Steps

### 1. Clone the Repository

If using Git:

```bash
git clone https://github.com/your-username/import-excel-in-php.git
Or download the ZIP file from GitHub and extract it.

Move the project folder to your XAMPP htdocs directory:

bash
Copy
Edit
C:\xampp\htdocs\
Your folder path should look like:

cpp
Copy
Edit
C:\xampp\htdocs\import-excel-in-php
2. Start XAMPP Services
Open XAMPP Control Panel and start the following:

Apache

MySQL

3. Import the Database
Open your browser and go to http://localhost/phpmyadmin

Create a new database (e.g., excel_import)

Click on the new database and go to the Import tab

Select the .sql file included in the project directory (/db/import_excel.sql)

Click Go to import the database structure and sample data

4. Configure Database Connection
Navigate to the file:

arduino
Copy
Edit
config/connection.php
Make sure the following settings are correct:

php
Copy
Edit
$mysql_user     = "root";
$mysql_password = "";
Update the database name and host if necessary:

php
Copy
Edit
$mysql_database = "excel_import"; // or your chosen DB name
$mysql_host     = "localhost";
💡 How It Works
Upload an Excel file using the provided HTML form.

The PHP script reads the Excel file (using PhpSpreadsheet or similar library).

Data is parsed and inserted into a MySQL table.

Note: You may need to install PhpSpreadsheet using Composer if the project depends on it.

bash
Copy
Edit
composer require phpoffice/phpspreadsheet
📂 File Structure
pgsql
Copy
Edit
import-excel-in-php/
│
├── config/
│   └── connection.php
│
├── db/
│   └── import_excel.sql
│
├── uploads/
│   └── (uploaded Excel files)
│
├── index.php
├── upload.php
├── README.md
✅ Features
Upload .xls or .xlsx files

Parses Excel files and imports data into MySQL

Simple UI with status messages

Modular code structure

🛠️ Troubleshooting
If Excel is not being read, ensure php_zip, php_xml, and php_gd2 extensions are enabled in php.ini

Make sure the uploads/ directory is writable

Check Apache and MySQL logs if any errors occur

Use developer tools (F12 in browser) for debugging form submission

📄 License
This project is open-source and available under the MIT License.

🙋‍♂️ Support
If you have any issues or suggestions, feel free to create an Issue or submit a pull request.

👨‍💻 Author
Developed by Aftab Tunio
CTO – AMIZ Private Limited