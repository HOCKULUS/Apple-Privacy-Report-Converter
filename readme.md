# Apple-Privacy-Report-Converter
## Easy Way to block In-App-Ads with Apple Privacy Report - Made for PiHole

### Export a Privacy Report on your iPhone:
Open the Settings app on your iPhone.\
Scroll down and tap on "Safari".\
Scroll down to the "Privacy & Security" section and tap on "Privacy Report".\
Tap on "Share".\
Choose a location to save the report (e.g. Files, Notes, etc.).\
The report will be saved as a CSV file that you can open and view on your device or computer.

### Convert NDJSON to CSV:
Copy ndjson_to_csv.php on your Webserver\
Browse to yourdomain.com/yourfolder/ndjson_to_csv.php\
Upload App_Privacy_Report_vX_XXXX-XX-XXXXX_XX_XX.ndjson with the HTML Form shown on the Page\
Open the ndjson.csv file and search for the app you want to block on your PiHole

![source](/ndjson-source.jpg)
![result](/csv-result.jpg)

### How it works:
This is a PHP script that converts NDJSON (Newline Delimited JSON) data to CSV (Comma Separated Values) format.\
It first checks if an NDJSON file is uploaded via a form and if there are no errors in the upload.\
It then reads the NDJSON file line by line, converts each line to a JSON object, and if the object has the necessary keys,\
it adds the corresponding values to a multidimensional array.\
Finally, it outputs the data in CSV format by setting the appropriate headers and using the fputcsv() function to write the data to the output stream.\
If no file is uploaded or there is an error in the upload, it displays an HTML form for file upload.
